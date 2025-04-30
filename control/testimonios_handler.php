<?php
include '../includes/db.php';

header('Content-Type: application/json');

try {
    // Consulta para testimonios publicados
    $stmt = $conn->query("SELECT * FROM data_testimonios 
                         WHERE estado = 'Publicado' 
                         ORDER BY id DESC");
    
    $testimonios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'testimonios' => $testimonios,
        'count' => count($testimonios)
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al cargar los testimonios: ' . $e->getMessage()
    ]);
}
?>