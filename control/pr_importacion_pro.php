<?php
include '../includes/db.php';
date_default_timezone_set('America/Lima');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    try {
        $archivo = $_FILES['archivo'];
        $fecha_actual = date('Y-m-d H:i:s');
        
        if (strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION)) !== 'csv') {
            throw new Exception("Solo se permiten archivos CSV");
        }
        $resultado = procesarCSV($archivo['tmp_name'], $fecha_actual);
        
        $pagina_destino = (isset($_SESSION['origen_importacion']) && $_SESSION['origen_importacion'] === 'maestria') 
            ? 'gestion_maestrias.php' 
            : 'gestion_doctorado.php';

        if (isset($_SESSION['origen_importacion'])) {
            unset($_SESSION['origen_importacion']);
        }

        header('Location: ../pages/'.$pagina_destino.'?success='.urlencode("Archivo importado. Registros nuevos: ".$resultado['nuevos']." | Actualizados: ".$resultado['actualizados']));
        exit();
        
    } catch (Exception $e) {
        error_log('Error al importar: ' . $e->getMessage());
        header('Location: ../pages/importar_pro.php?error=1&msg=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: ../pages/importar_pro.php?error=1&msg=No se subió ningún archivo');
    exit();
}

function normalizarDecimalCSV($valor) {
    $limpio = preg_replace('/[^0-9,\.]/', '', trim($valor));
    
    if (strpos($limpio, ',') !== false && strpos($limpio, '.') !== false) {
        return (float) str_replace(',', '.', str_replace('.', '', $limpio));
    } elseif (strpos($limpio, ',') !== false) {
        return (float) str_replace(',', '.', $limpio);
    } else {
        return (float) $limpio;
    }
}

function procesarCSV($ruta_archivo, $fecha_actual) {
    global $conn;
    
    if (($handle = fopen($ruta_archivo, "r")) === FALSE) {
        throw new Exception("No se pudo abrir el archivo CSV");
    }
    
    $encabezados = array_map('strtolower', array_map('trim', fgetcsv($handle, 0, ",", '"', '\\')));
    if ($encabezados === FALSE) {
        fclose($handle);
        throw new Exception("No se pudieron leer los encabezados");
    }
    
    // Validar campos requeridos
    $campos_requeridos = ['titulo', 'descripcion', 'tipo', 'universidad', 'pais', 'id_num'];
    foreach ($campos_requeridos as $campo) {
        if (!in_array($campo, $encabezados)) {
            fclose($handle);
            throw new Exception("Falta el campo requerido: $campo");
        }
    }
    
    $contador_nuevos = 0;
    $contador_actualizados = 0;
    $tipo_programa = '';
    $errores = [];
    
    // Campos posibles en la tabla data_programas
    $campos_disponibles = [
        'id_num', 'titulo', 'descripcion', 'tipo', 'categoria', 'id_universidad', 'universidad',
        'pais', 'modalidad', 'duracion', 'imagen_url', 'objetivos', 'plan_estudios', 'url',
        'estado_programa', 'precio_monto', 'precio_moneda', 'idioma', 'ciudad_universidad',
        'titulo_grado', 'requisitos', 'fecha_admision', 'url_brochure', 'user_encargado',
        'fecha_creacion', 'fecha_modificada'
    ];
    
    while (($data = fgetcsv($handle, 0, ",", '"', '\\')) !== FALSE) {
        if (count(array_filter($data)) === 0) continue;
        
        if (count($data) !== count($encabezados)) {
            $errores[] = "Fila con columnas incorrectas. Esperadas: ".count($encabezados).", Obtenidas: ".count($data);
            continue;
        }
        
        $fila = array_combine($encabezados, $data);
        
        // Validar y limpiar id_num
        $id_num = trim($fila['id_num'] ?? '');
        if (empty($id_num)) {
            $errores[] = "Fila omitida - Falta id_num";
            continue;
        }
        
        // OBTENER ID UNIVERSIDAD - CREAR SI NO EXISTE
        $universidad = trim($fila['universidad'] ?? '');
        $pais = trim($fila['pais'] ?? '');
        $ciudad_universidad = trim($fila['ciudad_universidad'] ?? '');
        $id_universidad = 0;

        if (!empty($universidad) && !empty($pais)) {
            $stmt_id = $conn->prepare("SELECT id FROM data_instituciones 
                                    WHERE nombre = ? AND pais = ? LIMIT 1");
            $stmt_id->execute([$universidad, $pais]);
            
            if ($row = $stmt_id->fetch()) {
                $id_universidad = $row['id'];
            } else {
                try {
                    $stmt_insert = $conn->prepare("INSERT INTO data_instituciones 
                                                (nombre, pais, ciudad, estado, convenio, fecha_creacion, fecha_modificada) 
                                                VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt_insert->execute([
                        $universidad, 
                        $pais, 
                        $ciudad_universidad,
                        'Activo',
                        'No',
                        $fecha_actual,
                        $fecha_actual
                    ]);
                    $id_universidad = $conn->lastInsertId();
                } catch (PDOException $e) {
                    $errores[] = "Error al crear nueva institución: " . $e->getMessage();
                }
            }
        }

        // Preparar datos solo para los campos presentes en el CSV
        $datos = [];
        foreach ($encabezados as $header) {
            if (in_array($header, $campos_disponibles)) {
                switch ($header) {
                    case 'precio_monto':
                        $datos[$header] = normalizarDecimalCSV($fila[$header] ?? '0');
                        break;
                    case 'precio_moneda':
                        $datos[$header] = trim($fila[$header] ?? 'USD');
                        break;
                    case 'fecha_creacion':
                        $datos[$header] = procesarFecha($fila[$header] ?? '', $fecha_actual);
                        break;
                    default:
                        // Para fecha_admision y otros campos, guardar el valor tal cual
                        $datos[$header] = trim($fila[$header] ?? '');
                        break;
                }
            }
        }
        
        // Agregar campos obligatorios que no vienen del CSV
        $datos['id_universidad'] = $id_universidad;
        $datos['user_encargado'] = !empty(trim($fila['user_encargado'] ?? '')) 
            ? trim($fila['user_encargado']) 
            : $_SESSION['username'];
        $datos['fecha_modificada'] = $fecha_actual;

        // Validar datos requeridos
        if (empty($datos['titulo']) || empty($datos['universidad']) || empty($datos['pais'])) {
            $errores[] = "Fila omitida - Faltan datos requeridos para id_num: $id_num";
            continue;
        }
        
        if ($contador_nuevos === 0 && $contador_actualizados === 0) {
            $tipo_programa = $datos['tipo'];
        }

        // Verificar si el registro ya existe
        $stmt_check = $conn->prepare("SELECT id FROM data_programas WHERE id_num = ? LIMIT 1");
        $stmt_check->execute([$id_num]);
        $existe = $stmt_check->fetch();

        if ($existe) {
            // ACTUALIZAR REGISTRO EXISTENTE - Solo los campos presentes en el CSV
            try {
                // Construir la consulta UPDATE dinámicamente
                $set_clause = [];
                $params = [];
                foreach ($datos as $key => $value) {
                    if ($key !== 'id_num') { // Excluir id_num del SET
                        $set_clause[] = "$key = :$key";
                        $params[":$key"] = $value;
                    }
                }
                $params[':id_num'] = $id_num;
                
                $sql_update = "UPDATE data_programas SET " . implode(', ', $set_clause) . " WHERE id_num = :id_num";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->execute($params);
                
                if ($stmt_update->rowCount() > 0) {
                    $contador_actualizados++;
                } else {
                    $errores[] = "No se actualizó ningún registro para id_num: $id_num (posiblemente los datos son iguales)";
                }
            } catch (PDOException $e) {
                $errores[] = "Error actualizando registro id_num $id_num: " . $e->getMessage();
            }
        } else {
            // INSERTAR NUEVO REGISTRO
            try {
                $datos['estado_programa'] = 'Publicado';
                $campos = array_keys($datos);
                $placeholders = array_map(function($campo) { return ":$campo"; }, $campos);
                
                $sql_insert = "INSERT INTO data_programas (" . implode(', ', $campos) . ") 
                            VALUES (" . implode(', ', $placeholders) . ")";
                
                $stmt_insert = $conn->prepare($sql_insert);
                $params = [];
                foreach ($datos as $key => $value) {
                    $params[":$key"] = $value;
                }
                $stmt_insert->execute($params);
                $contador_nuevos++;
            } catch (PDOException $e) {
                $errores[] = "Error insertando nuevo registro id_num $id_num: " . $e->getMessage();
            }
        }
    }
    
    fclose($handle);
    
    if (!empty($errores)) {
        error_log("Errores durante la importación:");
        foreach ($errores as $error) {
            error_log($error);
        }
    }
    
    return [
        'nuevos' => $contador_nuevos,
        'actualizados' => $contador_actualizados,
        'tipo_programa' => $tipo_programa,
        'errores' => $errores
    ];
}

function procesarFecha($fecha_csv, $valor_por_defecto) {
    if (empty(trim($fecha_csv))) {
        return $valor_por_defecto;
    }
    
    try {
        $date = DateTime::createFromFormat('d/m/Y', trim($fecha_csv));
        return $date ? $date->format('Y-m-d H:i:s') : $valor_por_defecto;
    } catch (Exception $e) {
        error_log("Error formato fecha: $fecha_csv");
        return $valor_por_defecto;
    }
}