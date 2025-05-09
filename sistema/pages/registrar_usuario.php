<?php 
include '../includes/db.php';
include '../control/check_session.php';

// Inicializar variables
$username = $nombre = $apellido = $email = $tipousuario = $estado = $password = '';
$id = null;
$isEdit = false;
$isAdminUser = false; // Bandera para identificar si es el usuario admin

// Verificar si es una edición (se pasó ID por GET)
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;
    
    // Obtener datos del usuario
    try {
        $stmt = $conn->prepare("SELECT * FROM data_usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a las variables
            $username = $usuario['nombreusuario'];
            $nombre = $usuario['nombre'];
            $apellido = $usuario['apellido'];
            $email = $usuario['email'];
            $tipousuario = $usuario['tipousuario'];
            $estado = $usuario['estado'];
            
            // Verificar si es el usuario admin
            if($username === 'admin') {
                $isAdminUser = true;
            }
            
        } else {
            header("Location: gestion_usuarios.php?error=Usuario no encontrado");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: gestion_usuarios.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Procesar el formulario cuando se envía
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y sanitizar los datos del formulario
    $username = trim($_POST['username']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $tipousuario = trim($_POST['tipousuario']);
    $estado = trim($_POST['estado']);
    $password = trim($_POST['password']);
    
    // Verificar si es admin y prevenir cambios no permitidos
    if($isAdminUser) {
        // Mantener los valores originales para campos protegidos
        $username = 'admin';
        $tipousuario = 'Administrador';
        $estado = 'Activo';
    }
    
    try {
        if($isEdit) {
            // Actualizar registro existente
            $sql = "UPDATE data_usuarios SET 
                nombre = :nombre,
                apellido = :apellido,
                email = :email";
            
            // Solo actualizar estos campos si no es el admin
            if(!$isAdminUser) {
                $sql .= ", nombreusuario = :username,
                        tipousuario = :tipousuario,
                        estado = :estado";
            }
            
            // Agregar contraseña solo si se proporcionó
            if(!empty($password)) {
                $sql .= ", contraseña = :password";
            }
            
            $sql .= " WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            // Insertar nuevo registro
            $stmt = $conn->prepare("INSERT INTO data_usuarios (
                nombreusuario, contraseña, nombre, apellido, email, 
                tipousuario, estado, fecha_creacion, fecha_modificacion
            ) VALUES (
                :username, :password, :nombre, :apellido, :email,
                :tipousuario, :estado, NOW(), NOW()
            )");
        }
        
        // Bind parameters
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        
        // Solo bindear estos si no es el admin
        if(!$isAdminUser || !$isEdit) {
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':tipousuario', $tipousuario);
            $stmt->bindParam(':estado', $estado);
        }
        
        // Bind password si se proporcionó o es nuevo usuario
        if(!empty($password) || !$isEdit) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);
        }
        
        // Ejecutar
        if($stmt->execute()) {
            $msg = $isEdit ? "Usuario actualizado correctamente" : "Usuario registrado correctamente";
            header("Location: gestion_usuarios.php?success=" . urlencode($msg));
            exit();
        } else {
            $error = $isEdit ? "Error al actualizar el usuario" : "Error al registrar el usuario";
            header("Location: registrar_usuario.php?id=$id&error=" . urlencode($error));
            exit();
        }
    } catch(PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
        header("Location: registrar_usuario.php?id=$id&error=" . urlencode($error));
        exit();
    }
}

// Incluir el header
include '../includes/header.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">
        Usuarios / 
        <a href="../pages/gestion_usuarios.php" class=" text-primary text-decoration-none">Registros</a> / 
    </span>
    <?php echo $isEdit ? 'Editar Usuario' : 'Agregar Nuevo Usuario'; ?>
</h4>
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    
    <div class="card">
      <h5 class="card-header">Información del Usuario</h5>
      <div class="card-body">
      <form class="needs-validation" id="formUsuario" method="POST" novalidate>
        <!-- Campo oculto para el ID en caso de edición -->
        <?php if($isEdit): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>
        
        <!-- Fila 1 - ID y Estado -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="usuario-id">ID</label>
                <input type="text" class="form-control" name="usuario-id" id="usuario-id" 
                       value="<?php echo $isEdit ? $id : 'Generado automáticamente'; ?>" readonly>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="usuario-estado">Estado*</label>
                <select class="form-select" name="estado" id="usuario-estado" <?php echo $isAdminUser ? 'disabled' : 'required'; ?>>
                <option value="">Seleccionar estado</option>
                <option value="Activo" <?php echo ($estado == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                <option value="Inactivo" <?php echo ($estado == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                </select>
                <?php if($isAdminUser): ?>
                    <input type="hidden" name="estado" value="Activo">
                    <small class="text-muted">El estado del administrador no puede cambiarse</small>
                <?php else: ?>
                    <div class="invalid-feedback">Por favor seleccione el estado</div>
                <?php endif; ?>
            </div>
            </div>
        </div>

        <!-- Fila 2 - Nombre de usuario y Tipo de usuario -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="username">Nombre de Usuario*</label>
                <?php if($isAdminUser): ?>
                    <input type="text" class="form-control" value="admin" readonly>
                    <input type="hidden" name="username" value="admin">
                    <small class="text-muted">El nombre de usuario admin no puede modificarse</small>
                <?php else: ?>
                    <input type="text" class="form-control" name="username" id="username" 
                           placeholder="Nombre de usuario" value="<?php echo htmlspecialchars($username); ?>" required>
                    <div class="invalid-feedback">Por favor ingrese el nombre de usuario</div>
                <?php endif; ?>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="tipousuario">Tipo de Usuario*</label>
                <?php if($isAdminUser): ?>
                    <input type="text" class="form-control" value="Administrador" readonly>
                    <input type="hidden" name="tipousuario" value="Administrador">
                    <small class="text-muted">El tipo de usuario admin no puede modificarse</small>
                <?php else: ?>
                    <select class="form-select" name="tipousuario" id="tipousuario" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="Administrador" <?php echo ($tipousuario == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                    <option value="Gestor" <?php echo ($tipousuario == 'Gestor') ? 'selected' : ''; ?>>Gestor</option>
                    <option value="Suscriptor" <?php echo ($tipousuario == 'Suscriptor') ? 'selected' : ''; ?>>Suscriptor</option>
                    </select>
                    <div class="invalid-feedback">Por favor seleccione el tipo de usuario</div>
                <?php endif; ?>
            </div>
            </div>
        </div>

        <!-- Resto del formulario permanece igual -->
        <!-- Fila 3 - Contraseña (solo para nuevos o si se quiere cambiar) -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="password">Contraseña<?php echo $isEdit ? ' (Dejar en blanco para no cambiar)' : '*'; ?></label>
                <input type="password" class="form-control" name="password" id="password" 
                       placeholder="<?php echo $isEdit ? '············' : 'Contraseña'; ?>" <?php echo !$isEdit ? 'required' : ''; ?>>
                <?php if(!$isEdit): ?>
                <div class="invalid-feedback">Por favor ingrese la contraseña</div>
                <?php endif; ?>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="confirm-password">Confirmar Contraseña<?php echo $isEdit ? ' (Si desea cambiar)' : '*'; ?></label>
                <input type="password" class="form-control" name="confirm-password" id="confirm-password" 
                       placeholder="<?php echo $isEdit ? '············' : 'Confirmar contraseña'; ?>" <?php echo !$isEdit ? 'required' : ''; ?>>
                <div class="invalid-feedback">Las contraseñas no coinciden</div>
            </div>
            </div>
        </div>

        <!-- Fila 4 - Nombre y Apellido -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="nombre">Nombre*</label>
                <input type="text" class="form-control" name="nombre" id="nombre" 
                       placeholder="Nombre(s)" value="<?php echo htmlspecialchars($nombre); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el nombre</div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="apellido">Apellido*</label>
                <input type="text" class="form-control" name="apellido" id="apellido" 
                       placeholder="Apellido(s)" value="<?php echo htmlspecialchars($apellido); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el apellido</div>
            </div>
            </div>
        </div>

        <!-- Fila 5 - Email -->
        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="email">Email*</label>
                <input type="email" class="form-control" name="email" id="email" 
                       placeholder="correo@ejemplo.com" value="<?php echo htmlspecialchars($email); ?>" required>
                <div class="invalid-feedback">Por favor ingrese un email válido</div>
            </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="row">
            <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="gestion_usuarios.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <?php echo $isEdit ? 'Actualizar Usuario' : 'Registrar Usuario'; ?>
                </button>
            </div>
            </div>
        </div>
        </form>

      </div>
    </div>

   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

   <script>
        // Validación de formulario
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formUsuario');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm-password');
            
            if (form) {
                // Validación personalizada para contraseñas
                function validatePassword() {
                    if (password.value !== confirmPassword.value) {
                        confirmPassword.setCustomValidity("Las contraseñas no coinciden");
                    } else {
                        confirmPassword.setCustomValidity("");
                    }
                }
                
                password.onchange = validatePassword;
                confirmPassword.onkeyup = validatePassword;
                
                form.addEventListener('submit', function(e) {
                    // Solo validar contraseña si es nuevo usuario o si se está cambiando
                    if (!<?php echo $isEdit ? 'true' : 'false'; ?> || password.value) {
                        validatePassword();
                    }
                    
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                        form.classList.add('was-validated');
                    }
                });
            }
        });
</script>

<?php include '../includes/footer.php'; ?>