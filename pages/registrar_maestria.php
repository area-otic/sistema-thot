<?php 
include '../includes/db.php';
include '../control/check_session.php';

// Obtener categorías de la base de datos
try {
    $stmtCategorias = $conn->query("SELECT id, nombre FROM data_categorias_programas ORDER BY nombre");
    $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $categorias = [];
    error_log("Error al obtener categorías: " . $e->getMessage());
}

// Obtener universidades de la base de datos
try {
    $stmtUniversidades = $conn->query("SELECT id, nombre, pais, ciudad FROM data_instituciones ORDER BY nombre");
    $universidades = $stmtUniversidades->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $universidades = [];
    $error = "Error al obtener universidades: " . $e->getMessage();
}

// Inicializar variables
$titulo = $descripcion = $tipo = $categoria = $universidad = $pais = $modalidad = $duracion = $imagen_url = $objetivos = $plan_estudios = $url = $estado_programa = '';
$precio_monto = $precio_moneda = $idioma = $fecha_admision = $titulo_grado = $ciudad_universidad = $requisitos = $url_brochure = '';
$id = null;
$isEdit = false;

// Verificar si es una edición (se pasó ID por GET)
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;
    
    // Obtener datos de la maestría
    try {
        $stmt = $conn->prepare("SELECT 
            p.*, 
            i.nombre as universidad_nombre,
            i.pais as universidad_pais,
            i.ciudad as universidad_ciudad
            FROM data_programas p
            LEFT JOIN data_instituciones i ON p.id_universidad = i.id
            WHERE p.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        
        if($stmt->rowCount() > 0) {
            $maestria = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a las variables
            $id_num = $maestria['id_num'];
            $titulo = $maestria['titulo'];
            $descripcion = $maestria['descripcion'];
            $tipo = $maestria['tipo'];
            $categoria = $maestria['categoria'];
            $universidad = $maestria['id_universidad']; // ID de la universidad
            $universidad_nombre = $maestria['universidad_nombre']; // Nombre de la universidad
            $pais = $maestria['pais'];
            $modalidad = $maestria['modalidad'];
            $duracion = $maestria['duracion'];
            $imagen_url = $maestria['imagen_url'];
            $objetivos = $maestria['objetivos'];
            $plan_estudios = $maestria['plan_estudios'];
            $url = $maestria['url'];
            $estado_programa = $maestria['estado_programa'];
            $precio_monto = $maestria['precio_monto'];
            $precio_moneda = $maestria['precio_moneda'];
            $idioma = $maestria['idioma'];
            $fecha_admision = $maestria['fecha_admision'];
            $titulo_grado = $maestria['titulo_grado'];
            $ciudad_universidad = $maestria['ciudad_universidad'];
            $requisitos = $maestria['requisitos'];
            $url_brochure = $maestria['url_brochure'];
            
        } else {
            header("Location: gestion_maestrias.php?error=Maestría no encontrada");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: gestion_maestrias.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Procesar el formulario cuando se envía
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y sanitizar los datos del formulario
    $id_num = trim($_POST['maestria-idnum']);
    $titulo = trim($_POST['maestria-titulo']);
    $descripcion = trim($_POST['maestria-descripcion']);
    $tipo = trim($_POST['maestria-tipo']);
    $categoria = trim($_POST['maestria-categoria']);

    $id_universidad = trim($_POST['maestria-id_universidad']);
    $universidad_nombre = trim($_POST['universidad-nombre']); // Campo oculto
    $pais = trim($_POST['maestria-pais']);
    $ciudad_universidad = trim($_POST['maestria-ciudad']);

    $modalidad = trim($_POST['maestria-modalidad']);
    $duracion = trim($_POST['maestria-duracion']);
    $imagen_url = trim($_POST['maestria-imagen']);
    $objetivos = trim($_POST['maestria-objetivos']);
    $plan_estudios = trim($_POST['maestria-plan']);
    $url = trim($_POST['maestria-url']);
    $estado_programa = trim($_POST['maestria-estado']);
    $precio_monto = trim($_POST['maestria-precio-monto']);
    $precio_moneda = trim($_POST['maestria-precio-moneda']);
    $idioma = trim($_POST['maestria-idioma']);
    $fecha_admision = trim($_POST['maestria-fecha-admision']);
    $titulo_grado = trim($_POST['maestria-titulo-grado']);
    $requisitos = trim($_POST['maestria-requisitos']);
    $url_brochure = trim($_POST['maestria-url-brochure']);
    $user_encargado = $_SESSION['username']; // Obtener el usuario de la sesión
    
    // Validación del lado del servidor
    $errors = [];

    // Validar si id_num ya existe (solo para nuevos registros)
    if (!$isEdit) {
        try {
            $stmtCheckId = $conn->prepare("SELECT COUNT(*) FROM data_programas WHERE id_num = :id_num");
            $stmtCheckId->bindParam(':id_num', $id_num);
            $stmtCheckId->execute();
            $count = $stmtCheckId->fetchColumn();
            
            if ($count > 0) {
                $errors[] = 'El ID NUM ya existe en la base de datos. Por favor, use un número diferente.';
            }
        } catch(PDOException $e) {
            $errors[] = "Error al verificar ID NUM: " . $e->getMessage();
        }
    }
    
    // Si no hay errores, procesar
    if (empty($errors)) {
        try {
            if($isEdit) {
                // Actualizar registro existente
                $stmt = $conn->prepare("UPDATE data_programas SET
                    id_num = :id_num,
                    titulo = :titulo,
                    descripcion = :descripcion,
                    tipo = :tipo,
                    categoria = :categoria,
                    
                    id_universidad = :id_universidad,
                    universidad = :universidad,
                    pais = :pais,
                    ciudad_universidad = :ciudad_universidad,
                    
                    modalidad = :modalidad,
                    duracion = :duracion,
                    imagen_url = :imagen_url,
                    objetivos = :objetivos,
                    plan_estudios = :plan_estudios,
                    url = :url,
                    estado_programa = :estado_programa,
                    precio_monto = :precio_monto,
                    precio_moneda = :precio_moneda,
                    idioma = :idioma,
                    fecha_admision = :fecha_admision,
                    titulo_grado = :titulo_grado,
                    requisitos = :requisitos,
                    url_brochure = :url_brochure,
                    user_encargado = :user_encargado,
                    fecha_modificada = NOW()
                    WHERE id = :id");
                    
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                // Insertar nuevo registro
                $stmt = $conn->prepare("INSERT INTO data_programas (
                    id_num, titulo, descripcion, tipo, categoria, id_universidad, universidad, pais, 
                    modalidad, duracion, imagen_url, objetivos, plan_estudios, 
                    url, estado_programa, precio_monto, precio_moneda, idioma,
                    fecha_admision, titulo_grado, ciudad_universidad, requisitos,
                    url_brochure, user_encargado, fecha_creacion, fecha_modificada
                ) VALUES (
                    :id_num,:titulo, :descripcion, :tipo, :categoria, :id_universidad, :universidad, :pais,
                    :modalidad, :duracion, :imagen_url, :objetivos, :plan_estudios,
                    :url, :estado_programa, :precio_monto, :precio_moneda, :idioma,
                    :fecha_admision, :titulo_grado, :ciudad_universidad, :requisitos,
                    :url_brochure, :user_encargado, NOW(), NOW()
                )");
            }
            
            // Bind parameters
            $stmt->bindParam(':id_num', $id_num);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':categoria', $categoria);

            $stmt->bindParam(':id_universidad', $id_universidad);
            $stmt->bindParam(':universidad', $universidad_nombre);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':ciudad_universidad', $ciudad_universidad);

            $stmt->bindParam(':modalidad', $modalidad);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->bindParam(':imagen_url', $imagen_url);
            $stmt->bindParam(':objetivos', $objetivos);
            $stmt->bindParam(':plan_estudios', $plan_estudios);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':estado_programa', $estado_programa);
            $stmt->bindParam(':precio_monto', $precio_monto);
            $stmt->bindParam(':precio_moneda', $precio_moneda);
            $stmt->bindParam(':idioma', $idioma);
            $stmt->bindParam(':fecha_admision', $fecha_admision);
            $stmt->bindParam(':titulo_grado', $titulo_grado);
            $stmt->bindParam(':requisitos', $requisitos);
            $stmt->bindParam(':url_brochure', $url_brochure);
            $stmt->bindParam(':user_encargado', $user_encargado);
            
            // Ejecutar
            if($stmt->execute()) {
                $msg = $isEdit ? "Maestría actualizada correctamente" : "Maestría registrada correctamente";
                header("Location: gestion_maestrias.php?success=" . urlencode($msg));
                exit();
            } else {
                $error = $isEdit ? "Error al actualizar la maestría" : "Error al registrar la maestría";
                header("Location: registrar_maestria.php?id=$id&error=" . urlencode($error));
                exit();
            }
        } catch(PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
            header("Location: registrar_maestria.php?id=$id&error=" . urlencode($error));
            exit();
        }
        
    } else {
        $error = implode("<br>", $errors);
    }
}
// Incluir el header
include '../includes/header.php';
?>

<style>
    /* Contenedor principal - Ajustes responsivos */
    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection {
        border: 1px solid #d9d9d9 !important;
        border-radius: 4px !important;
        padding: 0.475rem 0.75rem !important;
        height: auto !important;
        font-size: 14px !important;
        background-color: #fff !important;
        width: 100% !important;
    }

    /* Dropdown responsivo */
    .select2-container--default .select2-dropdown {
        border: 1px solid #d9d9d9 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        min-width: 70% !important;
        width: auto !important;
        max-width: 70% !important;
    }

    /* Ajustes para pantallas pequeñas */
    @media (max-width: 768px) {
        .select2-container--default .select2-dropdown {
            width: 100% !important;
            left: 0 !important;
        }
        
        .col-md-6 {
            width: 100% !important;
        }
    }

    /* Mantén tus otros estilos existentes */
    .select2-container--default .select2-results__option {
        padding: 8px 12px !important;
        white-space: normal !important; /* Permite que el texto se ajuste */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #333 !important;
        line-height: 1.5 !important;
        word-wrap: break-word !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        top: 0 !important;
    }

    .select2-container--default .select2-results__option--highlighted {
        background-color: #f8f9fa !important;
        color: #333 !important;
    }

    .select2-container--default .select2-results__option--selected {
        background-color: #e9ecef !important;
        color: #333 !important;
    }
    /* Estilo para el botón de limpieza */
    .select2-container--default .select2-selection--single .select2-selection__clear {
        color: #999;
        font-size: 1.2em;
        margin-right: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__clear:hover {
        color: #333;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            Maestrías / 
            <a href="../pages/gestion_maestrias.php" class="text-primary text-decoration-none">Registros</a> / 
        </span>
        <?php echo $isEdit ? 'Editar Maestría' : 'Agregar Nueva Maestría'; ?>
    </h4>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <div class="card">
        <h5 class="card-header">Información de Maestría</h5>
        <div class="card-body">
            <form class="needs-validation" id="formMaestria" method="POST" novalidate>
                <?php if($isEdit): ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <?php endif; ?>
                
                <!-- SECCIÓN 1: INFORMACIÓN BÁSICA -->
                <div class="mb-4">
                    <h6 class="mb-3 text-primary"><i class="bx bx-info-circle me-2"></i>Información Básica</h6>
                    <div class="row g-3">
                        <!-- Fila 1 -->
                        <div class="col-md-2">
                            <label class="form-label">ID</label>
                            <input type="text" class="form-control" value="<?php echo $isEdit ? $id : 'Generado automáticamente'; ?>" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">ID NUM</label>
                            <input type="text" class="form-control" name="maestria-idnum" value="<?php echo $isEdit ? $id_num : ''; ?>" required>

                            <div class="invalid-feedback">Por favor ingrese un ID NUM válido</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Modalidad*</label>
                            <select class="form-select" name="maestria-modalidad" required>
                                <option value="">Seleccionar...</option>
                                <option value="Presencial" <?= ($modalidad == 'Presencial') ? 'selected' : '' ?>>Presencial</option>
                                <option value="Online" <?= ($modalidad == 'Online') ? 'selected' : '' ?>>Online</option>
                                <option value="Semipresencial" <?= ($modalidad == 'Semipresencial') ? 'selected' : '' ?>>Semipresencial</option>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione la modalidad</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo*</label>
                            <select class="form-select" name="maestria-tipo" required readonly> 
                                <option value="Maestría" <?= ($tipo == 'Maestría') ? 'selected' : '' ?>>Maestría</option>
                                
                            </select>
                            <div class="invalid-feedback">Por favor seleccione el tipo</div>
                        </div>
                        
                        <!-- Fila 2 -->
                        <div class="col-md-8">
                            <label class="form-label">Título*</label>
                            <input type="text" class="form-control" name="maestria-titulo" value="<?= htmlspecialchars($titulo) ?>" required>
                            <div class="invalid-feedback">Por favor ingrese el título</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Categoría*</label>
                            <select class="form-select" name="maestria-categoria" required>
                                <option value="">Seleccionar categoría...</option>
                                <?php foreach($categorias as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['nombre']) ?>" 
                                        <?= ($categoria == $cat['nombre']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una categoría</div>
                        </div>
                    </div>
                </div>
                
                <!-- SECCIÓN 2: INSTITUCIÓN Y UBICACIÓN -->
                <div class="mb-4">
                    <h6 class="mb-3 text-primary"><i class="bx bx-building-house me-2"></i>Institución y Ubicación</h6>
                    <div class="row g-3">
                        <!-- Universidad -->
                        <div class="col-md-6">
                            <label class="form-label">Universidad*</label>
                            <select class="form-select select2-universidad" id="maestria-universidad" name="maestria-id_universidad" required>
                                <option value="">Seleccionar universidad...</option>
                                <?php foreach($universidades as $uni): ?>
                                    <option 
                                        value="<?php echo htmlspecialchars($uni['id']); ?>" 
                                        data-nombre="<?php echo htmlspecialchars($uni['nombre']); ?>"
                                        data-pais="<?php echo htmlspecialchars($uni['pais']); ?>"
                                        data-ciudad="<?php echo htmlspecialchars($uni['ciudad']); ?>"
                                        <?= ($universidad == $uni['id']) ? 'selected' : '' ?>
                                    >
                                        <?php echo htmlspecialchars($uni['nombre']); ?> (<?php echo htmlspecialchars($uni['ciudad'] ?? ''); ?>, <?php echo htmlspecialchars($uni['pais'] ?? ''); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una universidad</div>
                        </div>

                        <!-- País (solo lectura) -->
                        <div class="col-md-3">
                            <label class="form-label">País*</label>
                            <input type="text" class="form-control" id="select-pais" name="maestria-pais" readonly required>
                            <div class="invalid-feedback">El país es obligatorio</div>
                        </div>
                        <input type="hidden" id="universidad-nombre" name="universidad-nombre" value="">

                        <!-- Ciudad (solo lectura) -->
                        <div class="col-md-3">
                            <label class="form-label">Ciudad*</label>
                            <input type="text" class="form-control" id="maestria-ciudad" name="maestria-ciudad" readonly required>
                            <div class="invalid-feedback">La ciudad es obligatoria</div>
                        </div>
                    </div>
                </div>
                
                <!-- SECCIÓN 3: DETALLES ACADÉMICOS -->
                <div class="mb-4">
                    <h6 class="mb-3 text-primary"><i class="bx bx-book-open me-2"></i>Detalles Académicos</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Duración*</label>
                            <input type="text" class="form-control" placeholder="Ej: 2 años, 6 meses"  name="maestria-duracion" value="<?= htmlspecialchars($duracion) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Admisión</label>
                            <input type="text" class="form-control" name="maestria-fecha-admision" value="<?= htmlspecialchars($fecha_admision) ?>" >
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Idioma</label>
                            <select class="form-select" name="maestria-idioma" >
                                <option value="">Seleccionar...</option>
                                <option value="Español" <?= ($idioma == 'Español') ? 'selected' : '' ?>>Español</option>
                                <option value="Inglés" <?= ($idioma == 'Inglés') ? 'selected' : '' ?>>Inglés</option>
                                <option value="Portugués" <?= ($idioma == 'Portugués') ? 'selected' : '' ?>>Portugués</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Título Grado</label>
                            <input type="text" class="form-control" name="maestria-titulo-grado" value="<?= htmlspecialchars($titulo_grado) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="precio-input" class="form-label">Precio</label>
                            <div class="input-group has-validation"> <!-- Agregado has-validation para validación -->
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio-input" name="maestria-precio-monto" 
                                    value="<?= htmlspecialchars($precio_monto) ?>"
                                    min="0"  step="0.01" placeholder="0.00"  required aria-describedby="moneda-help">
                                
                                <select class="form-select" id="select-moneda" name="maestria-precio-moneda" required aria-label="Seleccione moneda">
                                    <option value="" disabled selected>Seleccione moneda</option>
                                    <!-- Las opciones se cargarán via JavaScript -->
                                </select>
                            </div>
                            <div id="moneda-help" class="form-text">Ingrese el monto y seleccione la moneda</div>
                        </div>
                    </div>
                </div>
                                
                <!-- SECCIÓN 5: RECURSOS DIGITALES -->
                <div class="mb-4">
                    <h6 class="mb-3 text-primary"><i class="bx bx-link me-2"></i>Recursos Digitales</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Imagen Web URL*</label>
                            <input type="url" class="form-control" name="maestria-imagen" placeholder="https://ejemplo.com/imagen.jpg" value="<?= htmlspecialchars($imagen_url) ?>" required>
                            <?php if($isEdit && !empty($imagen_url)): ?>
                            <div class="mt-2">
                                <img src="<?= htmlspecialchars($imagen_url) ?>" alt="Imagen actual" style="max-height: 80px;" class="img-thumbnail">
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">URL Programa*</label>
                            <input type="url" class="form-control" placeholder="https://" name="maestria-url" value="<?= htmlspecialchars($url) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">URL Brochure</label>
                            <input type="url" class="form-control" placeholder="https://" name="maestria-url-brochure" value="<?= htmlspecialchars($url_brochure) ?>">
                        </div>
                    </div>
                </div>
                
                <!-- SECCIÓN 6: CONTENIDO ACADÉMICO -->
                <div class="mb-4">
                    <h6 class="mb-3 text-primary"><i class="bx bx-book-content me-2"></i>Contenido Académico</h6>
                    <div class="row g-3">                        
                        <div class="col-12">
                            <label class="form-label">Descripción*</label>
                            <textarea class="form-control" name="maestria-descripcion" rows="3" required><?= htmlspecialchars($descripcion) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Objetivos*</label>
                            <textarea class="form-control" name="maestria-objetivos" rows="3" ><?= htmlspecialchars($objetivos) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Plan de Estudios*</label>
                            <textarea class="form-control" name="maestria-plan" rows="5" ><?= htmlspecialchars($plan_estudios) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Requisitos</label>
                            <textarea class="form-control" name="maestria-requisitos" rows="2"><?= htmlspecialchars($requisitos) ?></textarea>
                            <small class="text-muted">Separar nombres con comas</small>
                        </div>
                    </div>
                </div>
                
                <!-- SECCIÓN 7: CONFIGURACIÓN -->
                <div class="mb-4">
                    <h6 class="mb-3 text-primary"><i class="bx bx-cog me-2"></i>Configuración</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Estado*</label>
                            <select class="form-select" name="maestria-estado" required>
                                <option value="Oculto" <?= ($estado_programa == 'Oculto') ? 'selected' : '' ?>>Oculto</option>
                                <option value="Publicado" <?= ($estado_programa == 'Publicado') ? 'selected' : '' ?>>Publicado</option>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione el estado</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= $isEdit ? 'Modificado por' : 'Registrado por' ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['nombre']) ?>" readonly>
                            <input type="hidden" name="user_encargado" value="<?= htmlspecialchars($_SESSION['username']) ?>">
                        </div>
                    </div>
                </div>
                 <!-- BOTONES DE ACCIÓN -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="gestion_maestrias.php" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Actualizar Maestría' : 'Guardar Maestría' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Inicializar Select2 para el campo de universidad
    $('#maestria-universidad').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Seleccionar universidad...',
        allowClear: true
    });
   
    // Si estamos en modo edición, cargar los datos de la universidad
    <?php if($isEdit && !empty($universidad)): ?>
        setTimeout(function() {
            $('#maestria-universidad').val('<?php echo $universidad; ?>').trigger('change');
            const selectedOption = $('#maestria-universidad').find('option:selected');
            $('#select-pais').val(selectedOption.data('pais') || '<?php echo $pais; ?>');
            $('#maestria-ciudad').val(selectedOption.data('ciudad') || '<?php echo $ciudad_universidad; ?>');
            $('#universidad-nombre').val(selectedOption.data('nombre') || '');
        }, 100);
    <?php endif; ?>

    // Manejo de cambio de universidad
    $('#maestria-universidad').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        $('#select-pais').val(selectedOption.data('pais') || '');
        $('#maestria-ciudad').val(selectedOption.data('ciudad') || '');
        $('#universidad-nombre').val(selectedOption.data('nombre') || '');
    });

    // Lista estática de monedas en español
    const monedas = [
        { codigo: 'USD', nombre: 'Dólar estadounidense' },
        { codigo: 'EUR', nombre: 'Euro' },
        { codigo: 'MXN', nombre: 'Peso mexicano' },
        { codigo: 'ARS', nombre: 'Peso argentino' },
        { codigo: 'COP', nombre: 'Peso colombiano' },
        { codigo: 'PEN', nombre: 'Sol peruano' },
        { codigo: 'CLP', nombre: 'Peso chileno' },
        { codigo: 'BRL', nombre: 'Real brasileño' },
        { codigo: 'UYU', nombre: 'Peso uruguayo' },
        { codigo: 'PYG', nombre: 'Guaraní paraguayo' },
        { codigo: 'BOB', nombre: 'Boliviano' },
        { codigo: 'GTQ', nombre: 'Quetzal guatemalteco' },
        { codigo: 'DOP', nombre: 'Peso dominicano' },
        { codigo: 'CRC', nombre: 'Colón costarricense' },
        { codigo: 'HNL', nombre: 'Lempira hondureño' },
        { codigo: 'NIO', nombre: 'Córdoba nicaragüense' },
        { codigo: 'SVC', nombre: 'Colón salvadoreño' },
        { codigo: 'VES', nombre: 'Bolívar venezolano' },
        { codigo: 'GBP', nombre: 'Libra esterlina' },
        { codigo: 'JPY', nombre: 'Yen japonés' },
        { codigo: 'CNY', nombre: 'Yuan chino' },
        { codigo: 'KRW', nombre: 'Won surcoreano' },
        { codigo: 'INR', nombre: 'Rupia india' },
        { codigo: 'CAD', nombre: 'Dólar canadiense' },
        { codigo: 'AUD', nombre: 'Dólar australiano' },
        { codigo: 'CHF', nombre: 'Franco suizo' },
        { codigo: 'SEK', nombre: 'Corona sueca' },
        { codigo: 'NOK', nombre: 'Corona noruega' },
        { codigo: 'DKK', nombre: 'Corona danesa' },
        { codigo: 'RUB', nombre: 'Rublo ruso' },
        { codigo: 'TRY', nombre: 'Lira turca' },
        { codigo: 'ZAR', nombre: 'Rand sudafricano' }
    ];

    // Obtener la moneda guardada (si estamos en edición)
    const monedaGuardada = '<?php echo $precio_moneda; ?>';

    // Poblar el dropdown de monedas
    const monedaSelect = $('#select-moneda');
    monedaSelect.empty().append('<option value="">Seleccionar moneda...</option>');
    monedas.sort((a, b) => a.nombre.localeCompare(b.nombre)).forEach(moneda => {
        const isSelected = moneda.codigo === monedaGuardada ? 'selected' : '';
        monedaSelect.append(
            `<option value="${moneda.codigo}" ${isSelected}>${moneda.codigo} - ${moneda.nombre}</option>`
        );
    });

    // Asegurar que Select2 refleje la selección
    if (monedaGuardada) {
        monedaSelect.val(monedaGuardada).trigger('change');
    }

    // Configurar validación para Select2
    $('.select2-universidad, #select-moneda').on('change', function() {
        $(this).valid();
    });

    // Validación del formulario
    const form = document.getElementById('formMaestria');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                $(form).addClass('was-validated');
                $('.select2-universidad, #select-moneda').each(function() {
                    if (!$(this).val()) {
                        $(this).siblings('.select2-container').addClass('is-invalid');
                    } else {
                        $(this).siblings('.select2-container').removeClass('is-invalid');
                    }
                });
            } else {
                console.log('Formulario válido, enviando datos...');
            }
        }, false);

        $('input[required], textarea[required]').on('input', function() {
            $(this).removeClass('is-invalid');
            if (this.checkValidity()) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        });
    }

    // Mostrar SweetAlert2 si hay un error de id_num
    <?php if (isset($error) && !empty($errors)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: '<?php echo addslashes($error); ?>',
            confirmButtonText: 'Aceptar'
        });
    <?php endif; ?>

});
</script>