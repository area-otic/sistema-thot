<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Recoger datos del formulario
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $tipousuario = $_POST['tipousuario'];
        $estado = $_POST['estado'];

        // Insertar en la base de datos
        $stmt = $conn->prepare("INSERT INTO data_usuarios 
                              (nombreusuario, contraseña, nombre, apellido, email, tipousuario, estado) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $nombre, $apellido, $email, $tipousuario, $estado]);

        // Redirigir con mensaje de éxito
        header('Location: ../pages/gestion_usuarios.php?success=Usuario agregado correctamente');
        exit();
    } catch (PDOException $e) {
        // Redirigir con mensaje de error
        header('Location: ../pages/gestion_usuarios.php?error=Error al agregar usuario: ' . $e->getMessage());
        exit();
    }
} else {
    header('Location: ../pages/gestion_usuarios.php');
    exit();
}
?>