<?php 
include '../includes/db.php';
include '../control/check_session.php';

// Inicializar variables
$nombre_persona = $imagen_url = $testimonio = $programa_cursado = $pais = $estado = '';
$id = null;
$isEdit = false;

// Verificar si es una edición (se pasó ID por GET)
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;
    
    // Obtener datos del testimonio
    try {
        $stmt = $conn->prepare("SELECT * FROM data_testimonios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $testimonio_data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a las variables
            $nombre_persona = $testimonio_data['nombre_persona'];
            $imagen_url = $testimonio_data['imagen_url'];
            $testimonio = $testimonio_data['testimonio'];
            $programa_cursado = $testimonio_data['programa_cursado'];
            $pais = $testimonio_data['pais'];
            $estado = $testimonio_data['estado'];
            
        } else {
            header("Location: gestion_testimonios.php?error=Testimonio no encontrado");
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
    $nombre_persona = trim($_POST['nombre_persona']);
    $imagen_url = trim($_POST['imagen_url']);
    $testimonio = trim($_POST['testimonio']);
    $programa_cursado = trim($_POST['programa_cursado']);
    $pais = trim($_POST['pais']);
    $estado = trim($_POST['estado']);
    $user_encargado = $_SESSION['username']; // Obtener el usuario de la sesión
    
    // Validación del lado del servidor
    $errors = [];
    
    // Campos requeridos
    $requiredFields = [
        'nombre_persona' => 'Nombre de la persona',
        'imagen_url' => 'URL de la imagen',
        'testimonio' => 'Testimonio',
        'programa_cursado' => 'Programa cursado',
        'pais' => 'País',
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
                $stmt = $conn->prepare("UPDATE data_testimonios SET 
                    nombre_persona = :nombre_persona,
                    imagen_url = :imagen_url,
                    testimonio = :testimonio,
                    programa_cursado = :programa_cursado,
                    pais = :pais,
                    estado = :estado,
                    user_encargado = :user_encargado,
                    fecha_modificacion = NOW()
                    WHERE id = :id");
                    
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                // Insertar nuevo registro
                $stmt = $conn->prepare("INSERT INTO data_testimonios (
                    nombre_persona, imagen_url, testimonio, programa_cursado, 
                    pais, estado, user_encargado, fecha_creacion, fecha_modificacion
                ) VALUES (
                    :nombre_persona, :imagen_url, :testimonio, :programa_cursado,
                    :pais, :estado, :user_encargado, NOW(), NOW()
                )");
            }
            
            // Bind parameters
            $stmt->bindParam(':nombre_persona', $nombre_persona);
            $stmt->bindParam(':imagen_url', $imagen_url);
            $stmt->bindParam(':testimonio', $testimonio);
            $stmt->bindParam(':programa_cursado', $programa_cursado);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':user_encargado', $user_encargado);
            
            // Ejecutar
            if($stmt->execute()) {
                $msg = $isEdit ? "Testimonio actualizado correctamente" : "Testimonio registrado correctamente";
                header("Location: gestion_testimonios.php?success=" . urlencode($msg));
                exit();
            } else {
                $error = $isEdit ? "Error al actualizar el testimonio" : "Error al registrar el testimonio";
                header("Location: registrar_testimonio.php?id=$id&error=" . urlencode($error));
                exit();
            }
        } catch(PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
            header("Location: registrar_testimonio.php?id=$id&error=" . urlencode($error));
            exit();
        }
        
    } else {
        $error = implode("<br>", $errors);
        header("Location: registrar_testimonio.php?id=$id&error=" . urlencode($error));
        exit();
    }
}

// Incluir el header
include '../includes/header.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">
        Testimonios / 
        <a href="../pages/gestion_testimonios.php" class=" text-primary text-decoration-none">Registros</a> / 
    </span>
    <?php echo $isEdit ? 'Editar Testimonio' : 'Agregar Nuevo Testimonio'; ?>
</h4>
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    
    <div class="card">
      <h5 class="card-header">Información del Testimonio</h5>
      <div class="card-body">
      <form class="needs-validation" id="formTestimonio" method="POST" novalidate>
        <!-- Campo oculto para el ID en caso de edición -->
        <?php if($isEdit): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>
        
        <!-- Fila 1 - ID y Estado -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="testimonio-id">ID</label>
                <input type="text" class="form-control" name="testimonio-id" id="testimonio-id" 
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

        <!-- Fila 2 - Nombre de la persona y País -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="nombre_persona">Nombre de la persona*</label>
                <input type="text" class="form-control" name="nombre_persona" id="nombre_persona" 
                       placeholder="Nombre completo" value="<?php echo htmlspecialchars($nombre_persona); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el nombre</div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="pais">País*</label>
                <input type="text" class="form-control" name="pais" id="pais" 
                       placeholder="País de origen" value="<?php echo htmlspecialchars($pais); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el país</div>
            </div>
            </div>
        </div>

        <!-- Fila 3 - Programa cursado y Imagen URL -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="programa_cursado">Programa cursado*</label>
                <input type="text" class="form-control" name="programa_cursado" id="programa_cursado" 
                       placeholder="Nombre del programa" value="<?php echo htmlspecialchars($programa_cursado); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el programa cursado</div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="imagen_url">Imagen URL*</label>
                <input type="url" class="form-control" name="imagen_url" id="imagen_url" 
                       placeholder="https://ejemplo.com/imagen.jpg" value="<?php echo htmlspecialchars($imagen_url); ?>" required>
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

        <!-- Fila 4 - Testimonio -->
        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="testimonio">Testimonio*</label>
                <textarea class="form-control" name="testimonio" id="testimonio" 
                          rows="5" required><?php echo htmlspecialchars($testimonio); ?></textarea>
                <div class="invalid-feedback">Por favor ingrese el testimonio</div>
            </div>
            </div>
        </div>

        <!-- Fila 5 - Usuario Encargado -->
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
                <a href="gestion_testimonios.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <?php echo $isEdit ? 'Actualizar Testimonio' : 'Guardar Testimonio'; ?>
                </button>
            </div>
            </div>
        </div>
        </form>

      </div>
    </div>
</div>
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
   <!-- DataTables JS -->
   <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
        // Validación de formulario
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formTestimonio');
            
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
            if ($('#tabla-testimonios').length) {
                $('#tabla-testimonios').DataTable({
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