<?php 
include '../includes/db.php';
include '../control/check_session.php';

// Inicializar variables
$nombreuniversidad = $descripcion = $imagen_url = $pais = $sitio_web = $tipo_institucion = $convenio = $estado = '';
$id = null;
$isEdit = false;

// Verificar si es una edición (se pasó ID por GET)
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;
    
    // Obtener datos de la universidad
    try {
        $stmt = $conn->prepare("SELECT * FROM data_universidades WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $universidad = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a las variables
            $nombreuniversidad = $universidad['nombreuniversidad'];
            $descripcion = $universidad['descripcion'];
            $imagen_url = $universidad['imagen_url'];
            $pais = $universidad['pais'];
            $sitio_web = $universidad['sitio_web'];
            $tipo_institucion = $universidad['tipo_institucion'];
            $convenio = $universidad['convenio'];
            $estado = $universidad['estado'];
            
        } else {
            header("Location: gestion_testimonios.php?error=Universidad no encontrada");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: gestion_testimonios.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Procesar el formulario cuando se envía
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y sanitizar los datos del formulario
    $nombreuniversidad = trim($_POST['nombreuniversidad']);
    $descripcion = trim($_POST['descripcion']);
    $imagen_url = trim($_POST['imagen_url']);
    $pais = trim($_POST['pais']);
    $sitio_web = trim($_POST['sitio_web']);
    $tipo_institucion = trim($_POST['tipo_institucion']);
    $convenio = trim($_POST['convenio']);
    $estado = trim($_POST['estado']);
    $user_encargado = $_SESSION['username']; // Obtener el usuario de la sesión
    
    // Validación del lado del servidor
    $errors = [];
    
    // Campos requeridos
    $requiredFields = [
        'nombreuniversidad' => 'Nombre de la universidad',
        'descripcion' => 'Descripción',
        'pais' => 'País',
        'tipo_institucion' => 'Tipo de institución',
        'estado' => 'Estado'
    ];
    
    foreach ($requiredFields as $field => $name) {
        if (empty(trim($_POST[$field]))) {
            $errors[] = "El campo $name es requerido";
        }
    }
    
    // Validar URL de imagen si se proporcionó
    if (!empty($imagen_url)) {
        if (!filter_var($imagen_url, FILTER_VALIDATE_URL)) {
            $errors[] = "La URL de la imagen no es válida";
        }
    }
    
    // Si no hay errores, procesar
    if (empty($errors)) {
        try {
            if($isEdit) {
                // Actualizar registro existente
                $stmt = $conn->prepare("UPDATE data_universidades SET 
                    nombreuniversidad = :nombreuniversidad,
                    descripcion = :descripcion,
                    imagen_url = :imagen_url,
                    pais = :pais,
                    sitio_web = :sitio_web,
                    tipo_institucion = :tipo_institucion,
                    convenio = :convenio,
                    estado = :estado,
                    user_encargado = :user_encargado,
                    fecha_modificada = NOW()
                    WHERE id = :id");
                    
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                // Insertar nuevo registro
                $stmt = $conn->prepare("INSERT INTO data_universidades (
                    nombreuniversidad, descripcion, imagen_url, pais, sitio_web, 
                    tipo_institucion, convenio, estado, user_encargado, fecha_creacion, fecha_modificada
                ) VALUES (
                    :nombreuniversidad, :descripcion, :imagen_url, :pais, :sitio_web,
                    :tipo_institucion, :convenio, :estado, :user_encargado, NOW(), NOW()
                )");
            }
            
            // Bind parameters
            $stmt->bindParam(':nombreuniversidad', $nombreuniversidad);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':imagen_url', $imagen_url);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':sitio_web', $sitio_web);
            $stmt->bindParam(':tipo_institucion', $tipo_institucion);
            $stmt->bindParam(':convenio', $convenio);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':user_encargado', $user_encargado);
            
            // Ejecutar
            if($stmt->execute()) {
                $msg = $isEdit ? "Universidad actualizada correctamente" : "Universidad registrada correctamente";
                header("Location: gestion_universidades.php?success=" . urlencode($msg));
                exit();
            } else {
                $error = $isEdit ? "Error al actualizar la universidad" : "Error al registrar la universidad";
                header("Location: registrar_universidad.php?id=$id&error=" . urlencode($error));
                exit();
            }
        } catch(PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
            header("Location: registrar_universidad.php?id=$id&error=" . urlencode($error));
            exit();
        }
        
    } else {
        $error = implode("<br>", $errors);
        header("Location: registrar_universidad.php?id=$id&error=" . urlencode($error));
        exit();
    }
}

// Incluir el header
include '../includes/header.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">
        Universidades / 
        <a href="../pages/gestion_universidades.php" class=" text-primary text-decoration-none">Registros</a> / 
    </span>
    <?php echo $isEdit ? 'Editar Universidad' : 'Agregar Nueva Universidad'; ?>
</h4>
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    
    <div class="card">
      <h5 class="card-header">Información de la Universidad</h5>
      <div class="card-body">
      <form class="needs-validation" id="formUniversidad" method="POST" novalidate>
        <!-- Campo oculto para el ID en caso de edición -->
        <?php if($isEdit): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>
        
        <!-- Fila 1 - ID y Estado -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="universidad-id">ID</label>
                <input type="text" class="form-control" name="universidad-id" id="universidad-id" 
                       value="<?php echo $isEdit ? $id : 'Generado automáticamente'; ?>" readonly>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="estado">Estado*</label>
                <select class="form-select" name="estado" id="estado" required>
                <option value="">Seleccionar estado</option>
                <option value="Publicado" <?php echo ($estado == 'Publicado') ? 'selected' : ''; ?>>Publicado</option>
                <option value="Oculto" <?php echo ($estado == 'Oculto') ? 'selected' : ''; ?>>Oculto</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione el estado</div>
            </div>
            </div>
        </div>

        <!-- Fila 2 - Nombre de la universidad y País -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="nombreuniversidad">Nombre de la Universidad*</label>
                <input type="text" class="form-control" name="nombreuniversidad" id="nombreuniversidad" 
                       placeholder="Nombre completo de la universidad" value="<?php echo htmlspecialchars($nombreuniversidad); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el nombre de la universidad</div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="pais">País*</label>
                <input type="text" class="form-control" name="pais" id="pais" 
                       placeholder="País donde se encuentra" value="<?php echo htmlspecialchars($pais); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el país</div>
            </div>
            </div>
        </div>

        <!-- Fila 3 - Tipo de institución y Convenio -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="tipo_institucion">Tipo de Institución*</label>
                <select class="form-select" name="tipo_institucion" id="tipo_institucion" required>
                <option value="">Seleccionar tipo</option>
                <option value="Pública" <?php echo ($tipo_institucion == 'Pública') ? 'selected' : ''; ?>>Pública</option>
                <option value="Privada" <?php echo ($tipo_institucion == 'Privada') ? 'selected' : ''; ?>>Privada</option>
                <option value="Mixta" <?php echo ($tipo_institucion == 'Mixta') ? 'selected' : ''; ?>>Mixta</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione el tipo de institución</div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="convenio">Convenio</label>
                <select class="form-select" name="convenio" id="convenio">
                <option value="">Seleccionar estado de convenio</option>
                <option value="Si" <?php echo ($convenio == 'Si') ? 'selected' : ''; ?>>Sí</option>
                <option value="No" <?php echo ($convenio == 'No') ? 'selected' : ''; ?>>No</option>
                <option value="En proceso" <?php echo ($convenio == 'En proceso') ? 'selected' : ''; ?>>En proceso</option>
                </select>
            </div>
            </div>
        </div>

        <!-- Fila 4 - Sitio web y Imagen URL -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="sitio_web">Sitio Web</label>
                <input type="text" class="form-control" name="sitio_web" id="sitio_web" 
                       placeholder="www.universidad.edu" value="<?php echo htmlspecialchars($sitio_web); ?>">
                <small class="text-muted">Ingrese el sitio web sin http:// o https://</small>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="imagen_url">Imagen URL</label>
                <input type="url" class="form-control" name="imagen_url" id="imagen_url" 
                       placeholder="https://ejemplo.com/imagen.jpg" value="<?php echo htmlspecialchars($imagen_url); ?>">
                <div class="invalid-feedback">Por favor ingrese una URL válida de imagen</div>
                <?php if($isEdit && !empty($imagen_url)): ?>
                <div class="mt-2">
                    <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="Imagen actual" style="max-height: 100px;" class="img-thumbnail">
                    <small class="text-muted d-block">Vista previa de la imagen actual</small>
                </div>
                <?php endif; ?>
            </div>
            </div>
        </div>

        <!-- Fila 5 - Descripción -->
        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="descripcion">Descripción*</label>
                <textarea class="form-control" name="descripcion" id="descripcion" 
                          rows="5" required><?php echo htmlspecialchars($descripcion); ?></textarea>
                <div class="invalid-feedback">Por favor ingrese la descripción</div>
            </div>
            </div>
        </div>

        <!-- Fila 6 - Usuario Encargado -->
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
                <a href="gestion_universidades.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <?php echo $isEdit ? 'Actualizar Universidad' : 'Guardar Universidad'; ?>
                </button>
            </div>
            </div>
        </div>
        </form>

      </div>
    </div>

   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
   <!-- DataTables JS -->
   <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
        // Validación de formulario
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formUniversidad');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            }
            
            // Configuración de DataTable si existe la tabla
            if ($('#tabla-universidades').length) {
                $('#tabla-universidades').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    },
                    responsive: true,
                    ordering: true,
                    searching: true,
                    paging: true,
                    lengthMenu: [15, 20, 30, 50]
                });
            }
        });
</script>

<?php include '../includes/footer.php'; ?>