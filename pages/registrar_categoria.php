<?php 
include '../includes/db.php';
include '../control/check_session.php';

// Inicializar variables
$nombre = $descripcion = $estado = '';
$id = null;
$isEdit = false;

// Verificar si es una edición (se pasó ID por GET)
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;
    
    // Obtener datos de la categoría
    try {
        $stmt = $conn->prepare("SELECT * FROM data_categorias_programas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $categoria_data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a las variables
            $nombre = $categoria_data['nombre'];
            $descripcion = $categoria_data['descripcion'];
            $estado = $categoria_data['estado'];
            
        } else {
            header("Location: gestion_categorias.php?error=Categoría no encontrada");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: gestion_categorias.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Procesar el formulario cuando se envía
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y sanitizar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $estado = trim($_POST['estado']);
    $user_encargado = $_SESSION['username']; // Obtener el usuario de la sesión
    
    // Validación del lado del servidor
    $errors = [];
    
    // Campos requeridos
    $requiredFields = [
        'nombre' => 'Nombre de la categoría',
        'estado' => 'Estado'
    ];
    
    foreach ($requiredFields as $field => $name) {
        if (empty(trim($_POST[$field]))) {
            $errors[] = "El campo $name es requerido";
        }
    }
    
    // Si no hay errores, procesar
    if (empty($errors)) {
        try {
            if($isEdit) {
                // Actualizar registro existente
                $stmt = $conn->prepare("UPDATE data_categorias_programas SET 
                    nombre = :nombre,
                    descripcion = :descripcion,
                    estado = :estado,
                    user_encargado = :user_encargado,
                    fecha_modificada = NOW()
                    WHERE id = :id");
                    
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                // Insertar nuevo registro
                $stmt = $conn->prepare("INSERT INTO data_categorias_programas (
                    nombre, descripcion, estado, user_encargado, fecha_creacion, fecha_modificada
                ) VALUES (
                    :nombre, :descripcion, :estado, :user_encargado, NOW(), NOW()
                )");
            }
            
            // Bind parameters
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':user_encargado', $user_encargado);
            
            // Ejecutar
            if($stmt->execute()) {
                $msg = $isEdit ? "Categoría actualizada correctamente" : "Categoría registrada correctamente";
                header("Location: gestion_categorias.php?success=" . urlencode($msg));
                exit();
            } else {
                $error = $isEdit ? "Error al actualizar la categoría" : "Error al registrar la categoría";
                header("Location: registrar_categoria.php?id=$id&error=" . urlencode($error));
                exit();
            }
        } catch(PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
            header("Location: registrar_categoria.php?id=$id&error=" . urlencode($error));
            exit();
        }
        
    } else {
        $error = implode("<br>", $errors);
        header("Location: registrar_categoria.php?id=$id&error=" . urlencode($error));
        exit();
    }
}

include '../includes/header.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">
        Categorías / 
        <a href="gestion_categorias.php" class="text-primary text-decoration-none">Registros</a> / 
    </span>
    <?php echo $isEdit ? 'Editar Categoría' : 'Agregar Nueva Categoría'; ?>
</h4>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    
    <div class="card">
      <h5 class="card-header">Información de la Categoría</h5>
      <div class="card-body">
      <form class="needs-validation" id="formCategoria" method="POST" novalidate>
        <!-- Campo oculto para el ID en caso de edición -->
        <?php if($isEdit): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>
        
        <!-- Fila 1 - ID y Estado -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="categoria-id">ID</label>
                <input type="text" class="form-control" name="categoria-id" id="categoria-id" 
                       value="<?php echo $isEdit ? $id : 'Generado automáticamente'; ?>" readonly>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="estado">Estado*</label>
                <select class="form-select" name="estado" id="estado" required>
                <option value="">Seleccionar estado</option>
                <option value="Activo" <?php echo ($estado == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                <option value="Inactivo" <?php echo ($estado == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione el estado</div>
            </div>
            </div>
        </div>

        <!-- Fila 2 - Nombre -->
        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="nombre">Nombre de la categoría*</label>
                <input type="text" class="form-control" name="nombre" id="nombre" 
                       placeholder="Nombre de la categoría" value="<?php echo htmlspecialchars($nombre); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el nombre</div>
            </div>
            </div>
        </div>

        <!-- Fila 3 - Descripción -->
        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" 
                          rows="5"><?php echo htmlspecialchars($descripcion); ?></textarea>
            </div>
            </div>
        </div>

        <!-- Fila 4 - Usuario Encargado -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label" for="user_encargado">
                        <?php echo $isEdit ? 'Modificado por' : 'Registrado por'; ?>
                    </label>
                    <input type="text" class="form-control" 
                        value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" 
                        readonly>
                    <!-- Campo oculto para guardar el nombreusuario -->
                    <input type="hidden" name="user_encargado" 
                        value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="row">
            <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="gestion_categorias.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <?php echo $isEdit ? 'Actualizar Categoría' : 'Guardar Categoría'; ?>
                </button>
            </div>
            </div>
        </div>
        </form>

      </div>
    </div>
</div>

<script>
    // Validación de formulario
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formCategoria');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        }
    });
</script>

<?php include '../includes/footer.php'; ?>