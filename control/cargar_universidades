<?php
include '../includes/db.php';

header('Content-Type: application/json');

try {
    // Consulta para obtener universidades con convenio activo y publicadas
    $sql = "SELECT * FROM data_universidades 
            WHERE convenio = 'Si' AND estado = 'Publicado'
            ORDER BY nombreuniversidad ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $universidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'universidades' => $universidades
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al cargar universidades: ' . $e->getMessage()
    ]);
}