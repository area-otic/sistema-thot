<?php 
include '../includes/db.php';

// Verificar si se recibió el ID
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // Primero verificar si el usuario a eliminar es el admin
        $check_stmt = $conn->prepare("SELECT nombreusuario FROM data_usuarios WHERE id = :id");
        $check_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $check_stmt->execute();
        $user = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
        if($user && $user['nombreusuario'] === 'admin') {
            header("Location: ../pages/gestion_usuarios.php?error=No se puede eliminar al usuario administrador");
            exit();
        }
        
        // Preparar la consulta SQL para eliminar
        $stmt = $conn->prepare("DELETE FROM data_usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        if($stmt->execute()) {
            // Redireccionar con mensaje de éxito
            header("Location: ../pages/gestion_usuarios.php?success=Usuario eliminado correctamente");
            exit();
        } else {
            header("Location: ../pages/gestion_usuarios.php?error=Error al eliminar el usuario");
            exit();
        }
    } catch(PDOException $e) {
        // En caso de error, redireccionar con mensaje
        header("Location: ../pages/gestion_usuarios.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Si no hay ID, redireccionar
    header("Location: ../pages/gestion_usuarios.php?error=ID no proporcionado");
    exit();
}
?>