<?php
include '../includes/db.php';
date_default_timezone_set('America/Lima');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    try {
        $archivo = $_FILES['archivo'];
        $fecha_actual = date('Y-m-d H:i:s');
        
        // Validar extensión
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

        header('Location: ../pages/'.$pagina_destino.'?success='.urlencode("Archivo importado. Registros: ".$resultado['registros']));
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

function procesarCSV($ruta_archivo, $fecha_actual) {
    global $conn;
    
    if (($handle = fopen($ruta_archivo, "r")) === FALSE) {
        throw new Exception("No se pudo abrir el archivo CSV");
    }
    
    $encabezados = array_map('strtolower', array_map('trim', fgetcsv($handle, 1000, ",")));
    if ($encabezados === FALSE) {
        fclose($handle);
        throw new Exception("No se pudieron leer los encabezados");
    }
    
    // Validar campos requeridos
    foreach (['titulo', 'descripcion', 'tipo', 'universidad', 'pais'] as $campo) {
        if (!in_array($campo, $encabezados)) {
            fclose($handle);
            throw new Exception("Falta el campo requerido: $campo");
        }
    }
    
    $sql = "INSERT INTO data_programas (
        id, titulo, descripcion, tipo, categoria, id_universidad, universidad, 
        pais, modalidad, duracion, imagen_url, objetivos, plan_estudios, url, 
        estado_programa, precio_monto, precio_moneda, idioma, ciudad_universidad,
        titulo_grado, docentes, fecha_admision, url_brochure, user_encargado, 
        fecha_creacion, fecha_modificada
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";
    
    $stmt = $conn->prepare($sql);
    $contador = 0;
    $tipo_programa = '';
    
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (count(array_filter($data)) === 0) continue;
        
        if (count($data) !== count($encabezados)) {
            error_log("Fila con columnas incorrectas. Esperadas: ".count($encabezados).", Obtenidas: ".count($data));
            continue;
        }
        
        $fila = array_combine($encabezados, $data);
        
        // OBTENER ID UNIVERSIDAD (NUEVO CÓDIGO)
        $universidad = trim($fila['universidad'] ?? '');
        $pais = trim($fila['pais'] ?? '');
        $id_universidad = 0; // Valor por defecto
        
        if (!empty($universidad) && !empty($pais)) {
            $stmt_id = $conn->prepare("SELECT id FROM data_instituciones 
                                     WHERE nombre = ? AND pais = ? LIMIT 1");
            $stmt_id->execute([$universidad, $pais]);
            
            if ($row = $stmt_id->fetch()) {
                $id_universidad = $row['id'];
            } else {
                // Intentar búsqueda aproximada si no encuentra exacto
                $stmt_like = $conn->prepare("SELECT id FROM data_instituciones 
                                            WHERE nombre LIKE ? AND pais LIKE ? LIMIT 1");
                $stmt_like->execute(["%$universidad%", "%$pais%"]);
                
                if ($row = $stmt_like->fetch()) {
                    $id_universidad = $row['id'];
                }
            }
        }
        
        // Preparar datos para inserción
        $datos = [
            'id' => trim($fila['id'] ?? null),
            'titulo' => trim($fila['titulo'] ?? ''),
            'descripcion' => trim($fila['descripcion'] ?? ''),
            'tipo' => trim($fila['tipo'] ?? ''),
            'categoria' => trim($fila['categoria'] ?? ''),
            'id_universidad' => $id_universidad, // Usamos el ID encontrado o 0
            'universidad' => trim($fila['universidad'] ?? ''),
            'pais' => trim($fila['pais'] ?? ''),
            'modalidad' => trim($fila['modalidad'] ?? 'Presencial'),
            'duracion' => trim($fila['duracion'] ?? ''),
            'imagen_url' => trim($fila['imagen_url'] ?? ''),
            'objetivos' => trim($fila['objetivos'] ?? ''),
            'plan_estudios' => trim($fila['plan_estudios'] ?? ''),
            'url' => trim($fila['url'] ?? ''),
            'estado_programa' => trim($fila['estado_programa'] ?? 'Publicado'),
            'precio_monto' => floatval(str_replace(',', '', $fila['precio_monto'] ?? 0)),
            'precio_moneda' => trim($fila['precio_moneda'] ?? 'USD'),
            'idioma' => trim($fila['idioma'] ?? 'Español'),
            'ciudad_universidad' => trim($fila['ciudad_universidad'] ?? ''),
            'titulo_grado' => trim($fila['titulo_grado'] ?? ''),
            'docentes' => trim($fila['docentes'] ?? ''),
            'fecha_admision' => procesarFecha($fila['fecha_admision'] ?? '', null),
            'url_brochure' => trim($fila['url_brochure'] ?? ''),
            'user_encargado' => trim($fila['user_encargado'] ?? ''),
            'fecha_creacion' => procesarFecha($fila['fecha_creacion'] ?? '', $fecha_actual),
            'fecha_modificada' => $fecha_actual
        ];
        
        if (empty($datos['titulo']) || empty($datos['universidad']) || empty($datos['pais'])) {
            error_log("Fila omitida - Faltan datos requeridos");
            continue;
        }
        
        if ($contador === 0) {
            $tipo_programa = $datos['tipo'];
        }
        
        try {
            $stmt->execute(array_values($datos));
            $contador++;
        } catch (PDOException $e) {
            error_log("Error insertando fila: " . $e->getMessage());
            continue;
        }
    }
    
    fclose($handle);
    return ['registros' => $contador, 'tipo_programa' => $tipo_programa];
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
?>