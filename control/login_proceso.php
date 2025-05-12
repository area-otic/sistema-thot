<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obtener datos del formulario
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Validar campos
        if (empty($username) || empty($password)) {
            header('Location: ../iniciosesion.php?error=campos_vacios');
            exit();
        }

        // Consulta preparada con PDO
        $stmt = $conn->prepare("SELECT id, nombreusuario, contraseña, nombre, apellido, tipousuario, estado 
                               FROM data_usuarios 
                               WHERE nombreusuario = :username");
        
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar contraseña (compatible con texto plano y hash)
            if (password_verify($password, $user['contraseña'])) {
                if ($user['estado'] === 'Activo') {
                    // Crear sesión
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['nombreusuario'];
                    $_SESSION['nombre'] = $user['nombre'];
                    $_SESSION['apellido'] = $user['apellido'];
                    $_SESSION['tipo_usuario'] = $user['tipousuario'];
                    
                    header('Location: ../pages/dashboard.php');
                    exit();
                } else {
                    header('Location: ../iniciosesion.php?error=cuenta_inactiva');
                    exit();
                }
            } else {
                header('Location: ../iniciosesion.php?error=credenciales_incorrectas');
                exit();
            }
        } else {
            header('Location: ../iniciosesion.php?error=usuario_no_encontrado');
            exit();
        }
        
    } catch (PDOException $e) {
        error_log("Error en el login: " . $e->getMessage());
        header('Location: ../iniciosesion.php?error=error_bd');
        exit();
    }
} else {
    header('Location: ../iniciosesion.php');
    exit();
}
?>