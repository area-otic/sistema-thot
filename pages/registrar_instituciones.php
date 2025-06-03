<?php 
include '../includes/db.php';
include '../control/check_session.php';

// Inicializar variables
$nombre = $descripcion = $imagen_url = $pais = $ciudad = $tipo = $convenio = $url = $estado = '';
$id = null;
$isEdit = false;

// Verificar si es una edición (se pasó ID por GET)
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;
    
    // Obtener datos de la institución
    try {
        $stmt = $conn->prepare("SELECT * FROM data_instituciones WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $institucion = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a las variables
            $nombre = $institucion['nombre'];
            $descripcion = $institucion['descripcion'];
            $imagen_url = $institucion['imagen_url'];
            $pais = $institucion['pais'];
            $ciudad = $institucion['ciudad'];
            $tipo = $institucion['tipo'];
            $convenio = $institucion['convenio'];
            $url = $institucion['url'];
            $estado = $institucion['estado'];
            
        } else {
            header("Location: gestion_instituciones.php?error=Institución no encontrada");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: gestion_instituciones.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Procesar el formulario cuando se envía
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y sanitizar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $imagen_url = trim($_POST['imagen_url']);
    $pais = trim($_POST['pais']);
    $ciudad = trim($_POST['ciudad']);
    $tipo = trim($_POST['tipo']);
    $convenio = trim($_POST['convenio']);
    $url = trim($_POST['url']);
    $estado = trim($_POST['estado']);
    $user_encargado = $_SESSION['username']; // Obtener el usuario de la sesión
    
    // Validación del lado del servidor
    $errors = [];
    
    // Campos requeridos
    $requiredFields = [
        'nombre' => 'Nombre de la institución',
        'pais' => 'País',
        'tipo' => 'Tipo de institución',
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
                $stmt = $conn->prepare("UPDATE data_instituciones SET 
                    nombre = :nombre,
                    descripcion = :descripcion,
                    imagen_url = :imagen_url,
                    pais = :pais,
                    ciudad = :ciudad,
                    tipo = :tipo,
                    convenio = :convenio,
                    url = :url,
                    estado = :estado,
                    user_encargado = :user_encargado,
                    fecha_modificada = NOW()
                    WHERE id = :id");
                    
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                // Insertar nuevo registro
                $stmt = $conn->prepare("INSERT INTO data_instituciones (
                    nombre, descripcion, imagen_url, pais, ciudad, tipo, 
                    convenio, url, estado, user_encargado, fecha_creacion, fecha_modificada
                ) VALUES (
                    :nombre, :descripcion, :imagen_url, :pais, :ciudad, :tipo,
                    :convenio, :url, :estado, :user_encargado, NOW(), NOW()
                )");
            }
            
            // Bind parameters
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':imagen_url', $imagen_url);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':convenio', $convenio);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':user_encargado', $user_encargado);
            
            // Ejecutar
            if($stmt->execute()) {
                $msg = $isEdit ? "Institución actualizada correctamente" : "Institución registrada correctamente";
                header("Location: gestion_instituciones.php?success=" . urlencode($msg));
                exit();
            } else {
                $error = $isEdit ? "Error al actualizar la institución" : "Error al registrar la institución";
                header("Location: registrar_instituciones.php?id=$id&error=" . urlencode($error));
                exit();
            }
        } catch(PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
            header("Location: registrar_instituciones.php?id=$id&error=" . urlencode($error));
            exit();
        }
        
    } else {
        $error = implode("<br>", $errors);
        header("Location: registrar_instituciones.php?id=$id&error=" . urlencode($error));
        exit();
    }
}

// Incluir el header
include '../includes/header.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">
        Instituciones / 
        <a href="../pages/gestion_instituciones.php" class=" text-primary text-decoration-none">Registros</a> / 
    </span>
    <?php echo $isEdit ? 'Editar Institución' : 'Agregar Nueva Institución'; ?>
</h4>
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    
    <div class="card">
      <h5 class="card-header">Información de la Institución</h5>
      <div class="card-body">
      <form class="needs-validation" id="formInstitucion" method="POST" novalidate>
        <!-- Campo oculto para el ID en caso de edición -->
        <?php if($isEdit): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>
        
        <!-- Fila 1 - ID y Estado -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="institucion-id">ID</label>
                <input type="text" class="form-control" name="institucion-id" id="institucion-id" 
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

        <!-- Fila 2 - Nombre de la institución y País -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="nombre">Nombre de la Institución*</label>
                <input type="text" class="form-control" name="nombre" id="nombre" 
                       placeholder="Nombre completo de la institución" value="<?php echo htmlspecialchars($nombre); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el nombre de la institución</div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">País*</label>
                <select class="form-select select2" id="pais" name="pais" required>
                    <option value="">Cargando países...</option>
                </select>
                <div class="invalid-feedback">Por favor ingrese el país</div>
            </div>
            </div>
        </div>

        <!-- Fila 3 - Ciudad y Tipo -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="ciudad">Ciudad</label>
                <input type="text" class="form-control" name="ciudad" id="ciudad" 
                       placeholder="Ciudad donde se encuentra" value="<?php echo htmlspecialchars($ciudad); ?>">
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="tipo">Tipo de Institución*</label>
                <select class="form-select" name="tipo" id="tipo" required>
                <option value="">Seleccionar tipo</option>
                <option value="Educativa" <?php echo ($tipo == 'Educativa') ? 'selected' : ''; ?>>Educativa</option>
                <option value="Pública" <?php echo ($tipo == 'Pública') ? 'selected' : ''; ?>>Pública</option>
                <option value="Privada" <?php echo ($tipo == 'Privada') ? 'selected' : ''; ?>>Privada</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione el tipo de institución</div>
            </div>
            </div>
        </div>

        <!-- Fila 4 - Convenio y URL -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="convenio">Convenio*</label>
                <select class="form-select" name="convenio" id="convenio" required>
                <option value="">Seleccionar estado de convenio</option>
                <option value="Si" <?php echo ($convenio == 'Si') ? 'selected' : ''; ?>>Sí</option>
                <option value="No" <?php echo ($convenio == 'No') ? 'selected' : ''; ?>>No</option>
                <option value="En proceso" <?php echo ($convenio == 'En proceso') ? 'selected' : ''; ?>>En proceso</option>
                </select>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="url">URL</label>
                <input type="text" class="form-control" name="url" id="url" 
                       placeholder="www.institucion.com" value="<?php echo htmlspecialchars($url); ?>">
                <small class="text-muted">Ingrese el sitio web sin http:// o https://</small>
            </div>
            </div>
        </div>

        <!-- Fila 5 - Imagen URL -->
        <div class="row mb-2">
            <div class="col-12">
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

        <!-- Fila 6 - Descripción -->
        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="5">
                    <?php echo htmlspecialchars($descripcion); ?></textarea>
                <div class="invalid-feedback">Por favor ingrese la descripción</div>
            </div>
            </div>
        </div>

        <!-- Fila 7 - Usuario Encargado -->
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
                <a href="gestion_instituciones.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <?php echo $isEdit ? 'Actualizar Institución' : 'Guardar Institución'; ?>
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
        
        document.addEventListener('DOMContentLoaded', function() {
        fetch('https://restcountries.com/v3.1/all')
        .then(res => res.json())
        .then(data => {
            const paisSelect = document.getElementById('pais');

            // Ordenar países por nombre en español
            const paisesOrdenados = data.sort((a, b) => {
                const nombreA = a.translations?.spa?.common || a.name.common;
                const nombreB = b.translations?.spa?.common || b.name.common;
                return nombreA.localeCompare(nombreB, 'es');
            });

            paisSelect.innerHTML = '<option value="">Seleccionar país...</option>';
           
            paisesOrdenados.forEach(pais => {
                const nombrePais = pais.translations?.spa?.common || pais.name.common;
                const monedas = pais.currencies;

                // País
                const optionPais = document.createElement('option');
                optionPais.value = nombrePais;
                optionPais.textContent = nombrePais;
                paisSelect.appendChild(optionPais);
            });
        })
        .catch(err => {
            console.error('Error al cargar países/monedas', err);
        });

        const form = document.getElementById('formMaestria');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    form.classList.add('was-validated');
                }
            });
        }
    });

    // Validación de formulario
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formInstitucion');
        
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