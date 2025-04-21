<?php 
include '../includes/db.php';
include '../control/check_session.php';

// Inicializar variables
$titulo = $descripcion = $tipo = $categoria = $universidad = $pais = $modalidad = $duracion = $imagen_url = $objetivos = $plan_estudios = $url = $estado_programa = '';
$id = null;
$isEdit = false;

// Verificar si es una edición (se pasó ID por GET)
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;
    
    // Obtener datos del Doctorado
    try {
        $stmt = $conn->prepare("SELECT * FROM data_doctorados WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $doctorado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a las variables
            $titulo = $doctorado['titulo'];
            $descripcion = $doctorado['descripcion'];
            $tipo = $doctorado['tipo'];
            $categoria = $doctorado['categoria'];
            $universidad = $doctorado['universidad'];
            $pais = $doctorado['pais'];
            $modalidad = $doctorado['modalidad'];
            $duracion = $doctorado['duracion'];
            $imagen_url = $doctorado['imagen_url'];
            $objetivos = $doctorado['objetivos'];
            $plan_estudios = $doctorado['plan_estudios'];
            $url = $doctorado['url'];
            $estado_programa = $doctorado['estado_programa'];
            
            
        } else {
            header("Location: gestion_doctorado.php?error=Doctorado no encontrada");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: gestion_doctorado.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Procesar el formulario cuando se envía
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y sanitizar los datos del formulario
    $titulo = trim($_POST['doctorado-titulo']);
    $descripcion = trim($_POST['doctorado-descripcion']);
    $tipo = trim($_POST['doctorado-tipo']);
    $categoria = trim($_POST['doctorado-categoria']);
    $universidad = trim($_POST['doctorado-universidad']);
    $pais = trim($_POST['doctorado-pais']);
    $modalidad = trim($_POST['doctorado-modalidad']);
    $duracion = trim($_POST['doctorado-duracion']);
    $imagen_url = trim($_POST['doctorado-imagen']);
    $objetivos = trim($_POST['doctorado-objetivos']);
    $plan_estudios = trim($_POST['doctorado-plan']);
    $url = trim($_POST['doctorado-url']);
    $estado_programa = trim($_POST['doctorado-estado']);
    $user_encargado = $_SESSION['username']; // Obtener el usuario de la sesión
    
    // Validación del lado del servidor
    $errors = [];
    // Si no hay errores, procesar
    if (empty($errors)) {
        try {
            if($isEdit) {
                // Actualizar registro existente
                $stmt = $conn->prepare("UPDATE data_doctorados SET 
                    titulo = :titulo,
                    descripcion = :descripcion,
                    tipo = :tipo,
                    categoria = :categoria,
                    universidad = :universidad,
                    pais = :pais,
                    modalidad = :modalidad,
                    duracion = :duracion,
                    imagen_url = :imagen_url,
                    objetivos = :objetivos,
                    plan_estudios = :plan_estudios,
                    url = :url,
                    estado_programa = :estado_programa,
                    user_encargado = :user_encargado,
                    fecha_modificada = NOW()
                    WHERE id = :id");
                    
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                // Insertar nuevo registro
                $stmt = $conn->prepare("INSERT INTO data_doctorados (
                    titulo, descripcion, tipo, categoria, universidad, pais, 
                    modalidad, duracion, imagen_url, objetivos, plan_estudios, 
                    url, estado_programa, user_encargado, fecha_creacion, fecha_modificada
                ) VALUES (
                    :titulo, :descripcion, :tipo, :categoria, :universidad, :pais,
                    :modalidad, :duracion, :imagen_url, :objetivos, :plan_estudios,
                    :url, :estado_programa, :user_encargado, NOW(), NOW()
                )");
            }
            
            // Bind parameters
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':universidad', $universidad);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':modalidad', $modalidad);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->bindParam(':imagen_url', $imagen_url);
            $stmt->bindParam(':objetivos', $objetivos);
            $stmt->bindParam(':plan_estudios', $plan_estudios);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':estado_programa', $estado_programa);
            $stmt->bindParam(':user_encargado', $user_encargado);
            
            // Ejecutar
            if($stmt->execute()) {
                $msg = $isEdit ? "Doctorado actualizada correctamente" : "Doctorado registrada correctamente";
                header("Location: gestion_doctorado.php?success=" . urlencode($msg));
                exit();
            } else {
                $error = $isEdit ? "Error al actualizar la doctorado" : "Error al registrar el doctorado";
                header("Location: registrar_doctorado.php?id=$id&error=" . urlencode($error));
                exit();
            }
        } catch(PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
            header("Location: registrar_doctorado.php?id=$id&error=" . urlencode($error));
            exit();
        }

    } else {
        $error = implode("<br>", $errors);
        header("Location: registrar_doctorado.php?id=$id&error=" . urlencode($error));
        exit();
    }

}

// Incluir el header
include '../includes/header.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">
       Doctorado / 
        <a href="../pages/gestion_doctorado.php" class=" text-primary text-decoration-none">Registros</a> / 
    </span>
    <?php echo $isEdit ? 'Editar Doctorado' : 'Agregar Nueva Doctorado'; ?>
</h4>
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    
    <div class="card">
      <h5 class="card-header">Información de Doctorado</h5>
      <div class="card-body">
      <form class="needs-validation" id="formDoctorado" method="POST" novalidate>
        <!-- Campo oculto para el ID en caso de edición -->
        <?php if($isEdit): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>
        
        <!-- Fila 1 - ID y Modalidad -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="doctorado-id">ID</label>
                <input type="text" class="form-control" name="doctorado-id" id="doctorado-id" 
                       value="<?php echo $isEdit ? $id : 'Generado automáticamente'; ?>" readonly>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="doctorado-modalidad">Modalidad*</label>
                <select class="form-select" name="doctorado-modalidad" id="doctorado-modalidad" required>
                <option value="">Seleccionar modalidad</option>
                <option value="Presencial" <?php echo ($modalidad == 'Presencial') ? 'selected' : ''; ?>>Presencial</option>
                <option value="Online" <?php echo ($modalidad == 'Online') ? 'selected' : ''; ?>>Online</option>
                <option value="Semipresencial" <?php echo ($modalidad == 'Semipresencial') ? 'selected' : ''; ?>>Semipresencial</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione la modalidad</div>
            </div>
            </div>
        </div>

        <!-- Fila 2 - Título y Tipo -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="doctorado-titulo">Título*</label>
                <input type="text" class="form-control" name="doctorado-titulo" id="doctorado-titulo" 
                       placeholder="Nombre del Doctorado" value="<?php echo htmlspecialchars($titulo); ?>" required>
                <div class="invalid-feedback">Por favor ingrese el título</div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="doctorado-tipo">Tipo*</label>
                <select class="form-select" name="doctorado-tipo" id="doctorado-tipo" required>
                <option value="">Seleccionar tipo</option>
                <option value="Maestría" <?php echo ($tipo == 'Maestría') ? 'selected' : ''; ?>>Maestría</option>
                <option value="Posgrado" <?php echo ($tipo == 'Posgrado') ? 'selected' : ''; ?>>Posgrado</option>
                <option value="Diplomado" <?php echo ($tipo == 'Diplomado') ? 'selected' : ''; ?>>Diplomado</option>
                <option value="Doctorado" <?php echo ($tipo == 'Doctorado') ? 'selected' : ''; ?>>Doctorado</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione el tipo</div>
            </div>
            </div>
        </div>

        <!-- Fila 3 - Universidad y Categoría -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="doctorado-universidad">Universidad*</label>
                <input type="text" class="form-control" name="doctorado-universidad" id="doctorado-universidad" 
                       placeholder="Nombre de la universidad" value="<?php echo htmlspecialchars($universidad); ?>" required>
                <div class="invalid-feedback">Por favor ingrese la universidad</div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="doctorado-categoria">Categoría*</label>
                <input type="text" class="form-control" name="doctorado-categoria" id="doctorado-categoria" 
                       placeholder="Área de conocimiento" value="<?php echo htmlspecialchars($categoria); ?>" required>
                <div class="invalid-feedback">Por favor ingrese la categoría</div>
            </div>
            </div>
        </div>

        <!-- Fila 4 - País y Duración -->
        <div class="row mb-2">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="doctorado-pais">País*</label>
                <input type="text" class="form-control" name="doctorado-pais" id="doctorado-pais" 
                       placeholder="Ej: Perú" value="<?php echo htmlspecialchars($pais); ?>" required>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="doctorado-duracion">Duración*</label>
                <input type="text" class="form-control" name="doctorado-duracion" id="doctorado-duracion" 
                       placeholder="Ej: 2 años, 6 meses" value="<?php echo htmlspecialchars($duracion); ?>" required>
                <div class="invalid-feedback">Por favor ingrese la duración</div>
            </div>
            </div>
        </div>

        <!-- Fila 5 - Imagen URL y URL del programa -->
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="doctorado-imagen">Imagen URL*</label>
                    <input type="url" class="form-control" name="doctorado-imagen" id="doctorado-imagen" 
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
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="doctorado-url">URL del programa*</label>
                    <input type="url" class="form-control" name="doctorado-url" id="doctorado-url" 
                        placeholder="https://" value="<?php echo htmlspecialchars($url); ?>" required>
                    <div class="invalid-feedback">Por favor ingrese una URL válida</div>
                </div>
            </div>
        </div>
        <!-- Fila 6 - Estado y Usuario Encargado -->
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="doctorado-estado">Estado*</label>
                    <select class="form-select" name="doctorado-estado" id="doctorado-estado" required>
                        <option value="Oculto" <?php echo ($estado_programa == 'Oculto') ? 'selected' : ''; ?>>Oculto</option>
                        <option value="Publicado" <?php echo ($estado_programa == 'Publicado') ? 'selected' : ''; ?>>Publicado</option>
                    </select>
                    <div class="invalid-feedback">Por favor seleccione el estado</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="doctorado-encargado">
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

        <!-- Textareas (ocuparán fila completa) -->
        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="doctorado-descripcion">Descripción*</label>
                <textarea class="form-control" name="doctorado-descripcion" id="doctorado-descripcion" 
                          rows="3" required><?php echo htmlspecialchars($descripcion); ?></textarea>
                <div class="invalid-feedback">Por favor ingrese la descripción</div>
            </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="doctorado-objetivos">Objetivos*</label>
                <textarea class="form-control" name="doctorado-objetivos" id="doctorado-objetivos" 
                          rows="3" required><?php echo htmlspecialchars($objetivos); ?></textarea>
                <div class="invalid-feedback">Por favor ingrese los objetivos</div>
            </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
            <div class="mb-3">
                <label class="form-label" for="doctorado-plan">Plan de Estudios*</label>
                <textarea class="form-control" name="doctorado-plan" id="doctorado-plan" 
                          rows="5" required><?php echo htmlspecialchars($plan_estudios); ?></textarea>
                <div class="invalid-feedback">Por favor ingrese el plan de estudios</div>
            </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="row">
            <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="gestion_doctorado.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <?php echo $isEdit ? 'Actualizar Doctorado' : 'Guardar Doctorado'; ?>
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
            const form = document.getElementById('formDoctorado');
            
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
  </script>

<?php include '../includes/footer.php'; ?>