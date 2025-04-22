<?php 
include '../includes/db.php';
include '../control/check_session.php';
include '../includes/header.php';

// Obtener datos del usuario actual
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM data_usuarios WHERE id = :id");
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Procesar actualización si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = $_POST['firstName'];
        $apellido = $_POST['lastName'];
        $email = $_POST['email'];
        $nombreusuario = $_POST['nombreusuario'];
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
        
        // Construir la consulta SQL
        $sql = "UPDATE data_usuarios SET 
                nombre = :nombre,
                apellido = :apellido,
                email = :email,
                nombreusuario = :nombreusuario";
        
        // Agregar contraseña solo si se proporcionó
        if ($password) {
            $sql .= ", password = :password";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nombreusuario', $nombreusuario);
        $stmt->bindParam(':id', $user_id);
        
        if ($password) {
            $stmt->bindParam(':password', $password);
        }
        
        if ($stmt->execute()) {
            // Actualizar datos en sesión
            $_SESSION['nombre'] = $nombre;
            $_SESSION['email'] = $email;
            $_SESSION['nombreusuario'] = $nombreusuario;
            
            echo '<script>
                Swal.fire({
                    title: "¡Éxito!",
                    text: "Datos actualizados correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                });
            </script>';
        }
    } catch (PDOException $e) {
        echo '<script>
            Swal.fire({
                title: "Error",
                text: "'.str_replace("'", "\'", $e->getMessage()).'",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        </script>';
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
   
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Configuración /</span> Cuenta</h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Cuenta</a>
                </li>
            </ul>
            <div class="card mb-4">
            <h5 class="card-header">Detalles del Perfil</h5>

            <hr class="my-0" />
                <div class="card-body">
                    <form id="formcuentausuario" method="POST">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Nombre</label>
                                <input class="form-control" type="text" id="firstName" name="firstName" 
                                    value="<?php echo htmlspecialchars($user_data['nombre'] ?? ''); ?>" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">Apellido</label>
                                <input class="form-control" type="text" name="lastName" id="lastName" 
                                        value="<?php echo htmlspecialchars($user_data['apellido'] ?? ''); ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="email" id="email" name="email" 
                                    value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" placeholder="ejemplo@dominio.com" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nombreusuario" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="nombreusuario" name="nombreusuario" 
                                    value="<?php echo htmlspecialchars($user_data['nombreusuario'] ?? ''); ?>" />
                            </div>
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Contraseña</label>                
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <small class="text-muted">Dejar en blanco si no desea cambiar la contraseña</small>
                            </div>
                                
                            <div class="mb-3 col-md-6">
                                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                                <input type="text" class="form-control" id="tipo_usuario" 
                                    value="<?php echo htmlspecialchars($user_data['tipousuario'] ?? ''); ?>" readonly />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="estado" class="form-label">Estado de Usuario</label>
                                <input type="text" class="form-control" id="estado" 
                                        value="<?php echo htmlspecialchars($user_data['estado'] ?? ''); ?>" readonly />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Guardar cambios</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Validación del formulario
    $('#formcuentausuario').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas guardar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar formulario si se confirma
                this.submit();
            }
        });
    });
});
</script>

<?php include '../includes/footer.php'; ?>