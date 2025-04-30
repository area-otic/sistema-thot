<?php
include '../includes/db.php';

header('Content-Type: application/json');

try {
    // Consulta para universidades con convenio
    $stmt = $conn->query("SELECT * FROM data_universidades 
                         WHERE convenio = 'Si' AND estado = 'Publicado'
                         ORDER BY nombreuniversidad ASC");
    
    $universidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'universidades' => $universidades,
        'count' => count($universidades)
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al cargar las universidades: ' . $e->getMessage()
    ]);
}
?>