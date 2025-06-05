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

function procesarFecha2($fecha_csv, $valor_por_defecto) {
    if (empty(trim($fecha_csv))) {
        return $valor_por_defecto;
    }
    
    // Intentar varios formatos comunes
    $formatos = ['d/m/Y', 'Y-m-d', 'm/d/Y', 'Y-m-d H:i:s'];
    
    foreach ($formatos as $formato) {
        $date = DateTime::createFromFormat($formato, trim($fecha_csv));
        if ($date) {
            return $date->format('Y-m-d H:i:s');
        }
    }
    
    error_log("Error formato fecha: $fecha_csv");
    return $valor_por_defecto;
}

function normalizarDecimalCSV($valor) {
    // Elimina todos los caracteres no numéricos excepto coma y punto
    $limpio = preg_replace('/[^0-9,\.]/', '', trim($valor));
    
    // Caso 1: Si tiene coma y punto (ej: 1.500,00)
    if (strpos($limpio, ',') !== false && strpos($limpio, '.') !== false) {
        // Elimina puntos de miles y convierte coma en punto decimal
        return (float) str_replace(',', '.', str_replace('.', '', $limpio));
    }
    // Caso 2: Solo tiene coma (ej: 1500,00)
    elseif (strpos($limpio, ',') !== false) {
        // Reemplaza coma por punto decimal
        return (float) str_replace(',', '.', $limpio);
    }
    // Caso 3: Solo tiene punto (ej: 1500.00)
    else {
        // Lo deja tal cual (ya está en formato correcto)
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
    foreach (['titulo', 'descripcion', 'tipo', 'universidad', 'pais', 'id_num'] as $campo) {
        if (!in_array($campo, $encabezados)) {
            fclose($handle);
            throw new Exception("Falta el campo requerido: $campo");
        }
    }
    
    $contador_nuevos = 0;
    $contador_actualizados = 0;
    $tipo_programa = '';
    
    while (($data = fgetcsv($handle, 0, ",", '"', '\\')) !== FALSE) {
        if (count(array_filter($data)) === 0) continue;
        
        if (count($data) !== count($encabezados)) {
            error_log("Fila con columnas incorrectas. Esperadas: ".count($encabezados).", Obtenidas: ".count($data));
            continue;
        }
        
        $fila = array_combine($encabezados, $data);
        
        // Verificar si existe id_num
        $id_num = trim($fila['id_num'] ?? '');
        if (empty($id_num)) {
            error_log("Fila omitida - Falta id_num");
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
                    'Activo',    // Estado por defecto
                    'No',        // Convenio por defecto
                    $fecha_actual,
                    $fecha_actual
                ]);
                $id_universidad = $conn->lastInsertId();
                
                error_log("Nueva institución creada: $universidad (ID: $id_universidad)");
            } catch (PDOException $e) {
                error_log("Error al crear nueva institución: " . $e->getMessage());
                // Puedes opcionalmente continuar o lanzar la excepción
            }
        }
    }
        

        // Preparar datos
        $datos = [
            'id_num' => $id_num,
            'titulo' => trim($fila['titulo'] ?? ''),
            'descripcion' => trim($fila['descripcion'] ?? ''),
            'tipo' => trim($fila['tipo'] ?? ''),
            'categoria' => trim($fila['categoria'] ?? ''),
            'id_universidad' => $id_universidad,
            'universidad' => trim($fila['universidad'] ?? ''),
            'pais' => trim($fila['pais'] ?? ''),
            'modalidad' => trim($fila['modalidad'] ?? 'Presencial'),
            'duracion' => trim($fila['duracion'] ?? ''),
            'imagen_url' => trim($fila['imagen_url'] ?? ''),
            'objetivos' => trim($fila['objetivos'] ?? ''),
            'plan_estudios' => trim($fila['plan_estudios'] ?? ''),
            'url' => trim($fila['url'] ?? ''),
            'estado_programa' => trim($fila['estado_programa'] ?? 'Publicado'),
            'precio_monto' => normalizarDecimalCSV($fila['precio_monto'] ?? '0'),
            'precio_moneda' => trim($fila['precio_moneda'] ?? 'USD'),
            'idioma' => trim($fila['idioma'] ?? 'Español'),
            'ciudad_universidad' => trim($fila['ciudad_universidad'] ?? ''),
            'titulo_grado' => trim($fila['titulo_grado'] ?? ''),
            'requisitos' => trim($fila['requisitos'] ?? ''),
            'fecha_admision' => procesarFecha($fila['fecha_admision'] ?? '', null),
            'url_brochure' => trim($fila['url_brochure'] ?? ''),
            'user_encargado' => !empty(trim($fila['user_encargado'] ?? '')) 
            ? trim($fila['user_encargado']) 
            : $_SESSION['username'],
            'fecha_creacion' => procesarFecha($fila['fecha_creacion'] ?? '', $fecha_actual),
            'fecha_modificada' => $fecha_actual
        ];
        
        if (empty($datos['titulo']) || empty($datos['universidad']) || empty($datos['pais'])) {
            error_log("Fila omitida - Faltan datos requeridos");
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
            // ACTUALIZAR REGISTRO EXISTENTE
            try {
                $sql_update = "UPDATE data_programas SET
                    titulo = :titulo,
                    descripcion = :descripcion,
                    tipo = :tipo,
                    categoria = :categoria,
                    id_universidad = :id_universidad,
                    universidad = :universidad,
                    pais = :pais,
                    modalidad = :modalidad,
                    duracion = :duracion,
                    imagen_url = :imagen_url,
                    objetivos = :objetivos,
                    plan_estudios = :plan_estudios,
                    url = :url,
                    estado_programa = :estado_programa,
                    precio_monto = :precio_monto,
                    precio_moneda = :precio_moneda,
                    idioma = :idioma,
                    ciudad_universidad = :ciudad_universidad,
                    titulo_grado = :titulo_grado,
                    requisitos = :requisitos,
                    fecha_admision = :fecha_admision,
                    url_brochure = :url_brochure,
                    user_encargado = :user_encargado,
                    fecha_modificada = :fecha_modificada
                WHERE id_num = :id_num";
                
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->execute($datos);
                $contador_actualizados++;
            } catch (PDOException $e) {
                error_log("Error actualizando fila: " . $e->getMessage());
            }
        } else {
            // INSERTAR NUEVO REGISTRO
            try {
                $sql_insert = "INSERT INTO data_programas (
                    id_num, titulo, descripcion, tipo, categoria, id_universidad, universidad, 
                    pais, modalidad, duracion, imagen_url, objetivos, plan_estudios, url, 
                    estado_programa, precio_monto, precio_moneda, idioma, ciudad_universidad,
                    titulo_grado, requisitos, fecha_admision, url_brochure, user_encargado, 
                    fecha_creacion, fecha_modificada
                ) VALUES (
                    :id_num, :titulo, :descripcion, :tipo, :categoria, :id_universidad, :universidad, 
                    :pais, :modalidad, :duracion, :imagen_url, :objetivos, :plan_estudios, :url, 
                    :estado_programa, :precio_monto, :precio_moneda, :idioma, :ciudad_universidad,
                    :titulo_grado, :requisitos, :fecha_admision, :url_brochure, :user_encargado, 
                    :fecha_creacion, :fecha_modificada
                )";
                
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->execute($datos);
                $contador_nuevos++;
            } catch (PDOException $e) {
                error_log("Error insertando fila: " . $e->getMessage());
            }
        }
    }
    
    fclose($handle);
    return [
        'nuevos' => $contador_nuevos,
        'actualizados' => $contador_actualizados,
        'tipo_programa' => $tipo_programa
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