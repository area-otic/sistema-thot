<?php
include '../includes/db.php';
date_default_timezone_set('America/Lima');

// Verificar si se subió un archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    try {
        $archivo = $_FILES['archivo'];
        $fecha_actual = date('Y-m-d H:i:s');
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        
        $extensiones_permitidas = ['csv', 'xls', 'xlsx'];
        if (!in_array($extension, $extensiones_permitidas)) {
            throw new Exception("Formato de archivo no permitido. Use CSV, XLS o XLSX.");
        }
        
        if ($extension === 'csv') {
            $registros = procesarCSV($archivo['tmp_name'], $fecha_actual);
        } else {
            $registros = procesarExcel($archivo['tmp_name'], $fecha_actual);
        }
        
        header('Location: ../pages/gestion_maestrias.php?success='.urlencode("Archivo importado correctamente. Registros procesados: $registros"));
        exit();
        
    } catch (Exception $e) {
        error_log('Error al importar: ' . $e->getMessage());
        header('Location: ../pages/importar_maestrias.php?error=1&msg=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: ../pages/importar_maestrias.php?error=1&msg=No se subió ningún archivo');
    exit();
}

function procesarCSV($ruta_archivo, $fecha_actual) {
    global $conn;
    
    if (($handle = fopen($ruta_archivo, "r")) === FALSE) {
        throw new Exception("No se pudo abrir el archivo CSV");
    }
    
    // Leer encabezados
    $encabezados = fgetcsv($handle, 1000, ",");
    if ($encabezados === FALSE) {
        fclose($handle);
        throw new Exception("No se pudieron leer los encabezados del CSV");
    }
    
    // Limpiar y normalizar encabezados
    $encabezados = array_map('trim', $encabezados);
    $encabezados = array_map('strtolower', $encabezados);
    
    // Validar encabezados mínimos
    $campos_requeridos = ['titulo', 'descripcion', 'tipo', 'universidad', 'pais'];
    foreach ($campos_requeridos as $campo) {
        if (!in_array($campo, $encabezados)) {
            fclose($handle);
            throw new Exception("El archivo CSV no contiene el campo requerido: $campo");
        }
    }
    
    // Preparar consulta SQL
    $sql = "INSERT INTO data_maestrias (
        titulo, descripcion, tipo, categoria, universidad, pais, 
        modalidad, duracion, imagen_url, objetivos, plan_estudios, url, 
        estado_programa, user_encargado, fecha_creacion, fecha_modificada
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $contador = 0;
    
    // Procesar cada fila
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Saltar filas vacías
        if (count(array_filter($data)) === 0) continue;
        
        // Asegurar que el número de elementos coincida con los encabezados
        if (count($data) !== count($encabezados)) {
            error_log("Advertencia: Fila con número incorrecto de columnas. Esperadas: ".count($encabezados).", Obtenidas: ".count($data));
            continue;
        }
        
        // Combinar encabezados con datos
        $fila = array_combine($encabezados, $data);
        
        // Limpiar y validar datos
        $datos = [
            'titulo' => trim($fila['titulo'] ?? 'hola'),
            'descripcion' => trim($fila['descripcion'] ?? ''),
            'tipo' => trim($fila['tipo'] ?? ''),
            'categoria' => trim($fila['categoria'] ?? ''),
            'universidad' => trim($fila['universidad'] ?? ''),
            'pais' => trim($fila['pais'] ?? ''),
            'modalidad' => trim($fila['modalidad'] ?? 'Presencial'),
            'duracion' => trim($fila['duracion'] ?? ''),
            'imagen_url' => trim($fila['imagen_url'] ?? ''),
            'objetivos' => trim($fila['objetivos'] ?? ''),
            'plan_estudios' => trim($fila['plan_estudios'] ?? ''),
            'url' => trim($fila['url'] ?? ''),
            'estado_programa' => trim($fila['estado'] ?? 'Publicado'),
            'user_encargado' => trim($fila['encargado'] ?? ''),
            'fecha_creacion' => trim($fila['fecha_creado'] ?? ''),
            'fecha_modificada' => $fecha_actual
        ];
        
        // Validar campos obligatorios
        if (empty($datos['titulo']) || empty($datos['universidad']) || empty($datos['pais'])) {
            error_log("Advertencia: Fila $contador omitida - Faltan campos requeridos");
            continue;
        }
        
        try {
            $stmt->execute(array_values($datos));
            $contador++;
        } catch (PDOException $e) {
            error_log("Error al insertar fila $contador: " . $e->getMessage());
            continue;
        }
    }
    
    fclose($handle);
    return $contador;
}

function procesarExcel($ruta_archivo, $fecha_actual) {
    global $conn;
    
    require '../vendor/autoload.php';
    
    try {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($ruta_archivo);
        $spreadsheet = $reader->load($ruta_archivo);
    } catch (Exception $e) {
        throw new Exception("Error al leer el archivo Excel: " . $e->getMessage());
    }
    
    $worksheet = $spreadsheet->getActiveSheet();
    
    // Obtener encabezados
    $encabezados = [];
    foreach ($worksheet->getRowIterator(1, 1) as $row) {
        foreach ($row->getCellIterator() as $cell) {
            $encabezados[] = strtolower(trim($cell->getValue()));
        }
    }
    
    // Validar encabezados
    $campos_requeridos = ['titulo', 'descripcion', 'tipo', 'universidad', 'pais'];
    foreach ($campos_requeridos as $campo) {
        if (!in_array($campo, $encabezados)) {
            throw new Exception("El archivo Excel no contiene el campo requerido: $campo");
        }
    }
    
    // Preparar consulta SQL
    $sql = "INSERT INTO data_maestrias (
        titulo, descripcion, tipo, categoria, universidad, pais, 
        modalidad, duracion, imagen_url, objetivos, plan_estudios, url, 
        estado_programa, user_encargado, fecha_creacion, fecha_modificada
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?)";
    
    $stmt = $conn->prepare($sql);
    $contador = 0;
    
    // Procesar filas
    foreach ($worksheet->getRowIterator(2) as $row) {
        $fila = [];
        foreach ($row->getCellIterator() as $cell) {
            $fila[] = $cell->getValue();
        }
        
        // Saltar filas vacías
        if (count(array_filter($fila)) === 0) continue;
        
        // Verificar coincidencia de columnas
        if (count($fila) !== count($encabezados)) {
            error_log("Advertencia: Fila con número incorrecto de columnas. Esperadas: ".count($encabezados).", Obtenidas: ".count($fila));
            continue;
        }
        
        $datos_fila = array_combine($encabezados, $fila);
        
        $datos = [
            'titulo' => trim($datos_fila['titulo'] ?? ''),
            'descripcion' => trim($datos_fila['descripcion'] ?? ''),
            'tipo' => trim($datos_fila['tipo'] ?? ''),
            'categoria' => trim($datos_fila['categoria'] ?? ''),
            'universidad' => trim($datos_fila['universidad'] ?? ''),
            'pais' => trim($datos_fila['pais'] ?? ''),
            'modalidad' => trim($datos_fila['modalidad'] ?? 'Presencial'),
            'duracion' => trim($datos_fila['duracion'] ?? ''),
            'imagen_url' => trim($datos_fila['imagen_url'] ?? ''),
            'objetivos' => trim($datos_fila['objetivos'] ?? ''),
            'plan_estudios' => trim($datos_fila['plan_estudios'] ?? ''),
            'url' => trim($datos_fila['url'] ?? ''),
            'estado_programa' => trim($datos_fila['estado'] ?? 'Publicado'),
            'user_encargado' => trim($datos_fila['encargado'] ?? ''),
            'fecha_creacion' => $fecha_actual,
            'fecha_modificada' => $fecha_actual
        ];
        
        // Validar campos obligatorios
        if (empty($datos['titulo']) || empty($datos['universidad']) || empty($datos['pais'])) {
            error_log("Advertencia: Fila omitida - Faltan campos requeridos");
            continue;
        }
        
        try {
            $stmt->execute(array_values($datos));
            $contador++;
        } catch (PDOException $e) {
            error_log("Error al insertar fila: " . $e->getMessage());
            continue;
        }
    }
    
    return $contador;
}
?>