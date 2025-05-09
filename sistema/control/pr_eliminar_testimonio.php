<?php 
include '../includes/db.php';

// Verificar si se recibió el ID
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // Preparar la consulta SQL para eliminar
        $stmt = $conn->prepare("DELETE FROM data_testimonios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        if($stmt->execute()) {
            // Redireccionar con mensaje de éxito
            header("Location: ../pages/gestion_testimonios.php?success=Testimonio eliminada correctamente");
            exit();
        } else {
            header("Location: ../pages/gestion_testimonios.php?error=Error al eliminar el testimonio.");
            exit();
        }
    } catch(PDOException $e) {
        // En caso de error, redireccionar con mensaje
        header("Location: ../pages/gestion_testimonios.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Si no hay ID, redireccionar
    header("Location: ../pages/gestion_testimonios.php?error=ID no proporcionado");
    exit();
}
?>