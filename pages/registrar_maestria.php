<?php 
include '../includes/db.php';
include '../control/check_session.php';

// Obtener categorías de la base de datos
try {
    $stmtCategorias = $conn->query("SELECT id, nombre FROM categorias_programas ORDER BY nombre");
    $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $categorias = [];
    error_log("Error al obtener categorías: " . $e->getMessage());
}

// Obtener universidades de la base de datos
try {
    $stmtUniversidades = $conn->query("SELECT id, nombre, pais, ciudad FROM data_instituciones WHERE estado = 'Activo' ORDER BY nombre");
    $universidades = $stmtUniversidades->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $universidades = [];
    error_log("Error al obtener universidades: " . $e->getMessage());
}

// Inicializar variables
$titulo = $descripcion = $tipo = $categoria = $universidad = $pais = $modalidad = $duracion = $imagen_url = $objetivos = $plan_estudios = $url = $estado_programa = '';
$precio_monto = $precio_moneda = $idioma = $fecha_admision = $titulo_grado = $ciudad_universidad = $docentes = $url_brochure = '';
$id = null;
$isEdit = false;

// Verificar si es una edición (se pasó ID por GET)
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;
    
    // Obtener datos de la maestría
    try {
        $stmt = $conn->prepare("SELECT * FROM data_programas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $maestria = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a las variables
            $titulo = $maestria['titulo'];
            $descripcion = $maestria['descripcion'];
            $tipo = $maestria['tipo'];
            $categoria = $maestria['categoria'];
            $universidad = $maestria['universidad'];
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
            $docentes = $maestria['docentes'];
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
    $titulo = trim($_POST['maestria-titulo']);
    $descripcion = trim($_POST['maestria-descripcion']);
    $tipo = trim($_POST['maestria-tipo']);
    $categoria = trim($_POST['maestria-categoria']);
    $universidad = trim($_POST['maestria-universidad']);
    $pais = trim($_POST['maestria-pais']);
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
    $ciudad_universidad = trim($_POST['maestria-ciudad-universidad']);
    $docentes = trim($_POST['maestria-docentes']);
    $url_brochure = trim($_POST['maestria-url-brochure']);
    $user_encargado = $_SESSION['username']; // Obtener el usuario de la sesión
    
    // Validación del lado del servidor
    $errors = [];
    
    // Si no hay errores, procesar
    if (empty($errors)) {
        try {
            if($isEdit) {
                // Actualizar registro existente
                $stmt = $conn->prepare("UPDATE data_programas SET 
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
                    precio_monto = :precio_monto,
                    precio_moneda = :precio_moneda,
                    idioma = :idioma,
                    fecha_admision = :fecha_admision,
                    titulo_grado = :titulo_grado,
                    ciudad_universidad = :ciudad_universidad,
                    docentes = :docentes,
                    url_brochure = :url_brochure,
                    user_encargado = :user_encargado,
                    fecha_modificada = NOW()
                    WHERE id = :id");
                    
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                // Insertar nuevo registro
                $stmt = $conn->prepare("INSERT INTO data_programas (
                    titulo, descripcion, tipo, categoria, universidad, pais, 
                    modalidad, duracion, imagen_url, objetivos, plan_estudios, 
                    url, estado_programa, precio_monto, precio_moneda, idioma,
                    fecha_admision, titulo_grado, ciudad_universidad, docentes,
                    url_brochure, user_encargado, fecha_creacion, fecha_modificada
                ) VALUES (
                    :titulo, :descripcion, :tipo, :categoria, :universidad, :pais,
                    :modalidad, :duracion, :imagen_url, :objetivos, :plan_estudios,
                    :url, :estado_programa, :precio_monto, :precio_moneda, :idioma,
                    :fecha_admision, :titulo_grado, :ciudad_universidad, :docentes,
                    :url_brochure, :user_encargado, NOW(), NOW()
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
            $stmt->bindParam(':precio_monto', $precio_monto);
            $stmt->bindParam(':precio_moneda', $precio_moneda);
            $stmt->bindParam(':idioma', $idioma);
            $stmt->bindParam(':fecha_admision', $fecha_admision);
            $stmt->bindParam(':titulo_grado', $titulo_grado);
            $stmt->bindParam(':ciudad_universidad', $ciudad_universidad);
            $stmt->bindParam(':docentes', $docentes);
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
        header("Location: registrar_maestria.php?id=$id&error=" . urlencode($error));
        exit();
    }
}

// Incluir el header
include '../includes/header.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            Maestrías / 
            <a href="../pages/gestion_maestrias.php" class=" text-primary text-decoration-none">Registros</a> / 
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
                        <div class="col-md-4">
                            <label class="form-label">ID</label>
                            <input type="text" class="form-control" value="<?php echo $isEdit ? $id : 'Generado automáticamente'; ?>" readonly>
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
                            <select class="form-select" name="maestria-tipo" required>
                                <option value="">Seleccionar...</option>
                                <option value="Maestría" <?= ($tipo == 'Maestría') ? 'selected' : '' ?>>Maestría</option>
                                <option value="Doctorado" <?= ($tipo == 'Doctorado') ? 'selected' : '' ?>>Doctorado</option>
                                <option value="Diplomado" <?= ($tipo == 'Diplomado') ? 'selected' : '' ?>>Diplomado</option>
                                
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
                        <!-- En la sección del formulario, modificar el campo de universidad: -->
                        <div class="col-md-6">
                            <label class="form-label">Universidad*</label>
                            <select class="form-select select2-universidad" id="maestria-universidad" name="maestria-universidad" required>
                                <option value="">Seleccionar universidad...</option>
                                <?php foreach($universidades as $uni): ?>
                                    <option value="<?= htmlspecialchars($uni['nombre']) ?>" 
                                        <?= ($universidad == $uni['nombre']) ? 'selected' : '' ?>
                                        data-pais="<?= htmlspecialchars($uni['pais']) ?>"
                                        data-ciudad="<?= htmlspecialchars($uni['ciudad']) ?>">
                                        <?= htmlspecialchars($uni['nombre']) ?> (<?= htmlspecialchars($uni['ciudad']) ?>, <?= htmlspecialchars($uni['pais']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una universidad</div>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">País*</label>
                            <select class="form-select select2" id="select-pais" name="maestria-pais" required>
                                <option value="">Cargando países...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Ciudad</label>
                            <input type="text" class="form-control" name="maestria-ciudad-universidad" value="<?= htmlspecialchars($ciudad_universidad) ?>" >
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
                            <input type="date" class="form-control" name="maestria-fecha-admision" value="<?= htmlspecialchars($fecha_admision) ?>" >
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
                            <label class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" name="maestria-precio-monto" value="<?= htmlspecialchars($precio_monto) ?>">
                                <select class="form-select" id="select-moneda" name="maestria-precio-moneda" style="max-width: 80%;">
                                    <option value="">Cargando monedas...</option>
                                </select>
                            </div>
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
                            <label class="form-label">Docentes</label>
                            <textarea class="form-control" name="maestria-docentes" rows="2"><?= htmlspecialchars($docentes) ?></textarea>
                            <small class="text-muted">Separar nombres con comas</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descripción*</label>
                            <textarea class="form-control" name="maestria-descripcion" rows="3" required><?= htmlspecialchars($descripcion) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Objetivos*</label>
                            <textarea class="form-control" name="maestria-objetivos" rows="3" required><?= htmlspecialchars($objetivos) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Plan de Estudios*</label>
                            <textarea class="form-control" name="maestria-plan" rows="5" required><?= htmlspecialchars($plan_estudios) ?></textarea>
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
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
   <!-- Select2 para búsqueda de países -->
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Validación de formulario
    document.addEventListener('DOMContentLoaded', function() {
        fetch('https://restcountries.com/v3.1/all')
        .then(res => res.json())
        .then(data => {
            const paisSelect = document.getElementById('select-pais');
            const monedaSelect = document.getElementById('select-moneda');
            const monedasUnicas = new Set();

            // Ordenar países por nombre en español
            const paisesOrdenados = data.sort((a, b) => {
                const nombreA = a.translations?.spa?.common || a.name.common;
                const nombreB = b.translations?.spa?.common || b.name.common;
                return nombreA.localeCompare(nombreB, 'es');
            });

            paisSelect.innerHTML = '<option value="">Seleccionar país...</option>';
            monedaSelect.innerHTML = '<option value=""<?= htmlspecialchars($precio_moneda) ?>>Seleccionar moneda...</option>';

            // Diccionario de monedas en español
            const monedasES = {
                USD: "Dólar estadounidense",
                EUR: "Euro",
                MXN: "Peso mexicano",
                ARS: "Peso argentino",
                COP: "Peso colombiano",
                PEN: "Sol peruano",
                CLP: "Peso chileno",
                BRL: "Real brasileño",
                UYU: "Peso uruguayo",
                PYG: "Guaraní paraguayo",
                BOB: "Boliviano",
                GTQ: "Quetzal guatemalteco",
                DOP: "Peso dominicano",
                CRC: "Colón costarricense",
                HNL: "Lempira hondureño",
                NIO: "Córdoba nicaragüense",
                SVC: "Colón salvadoreño",
                VES: "Bolívar venezolano",
                GBP: "Libra esterlina",
                JPY: "Yen japonés",
                CNY: "Yuan chino",
                KRW: "Won surcoreano",
                INR: "Rupia india",
                CAD: "Dólar canadiense",
                AUD: "Dólar australiano",
                CHF: "Franco suizo",
                SEK: "Corona sueca",
                NOK: "Corona noruega",
                DKK: "Corona danesa",
                RUB: "Rublo ruso",
                TRY: "Lira turca",
                ZAR: "Rand sudafricano"
                // Agrega más si lo necesitas
            };

            paisesOrdenados.forEach(pais => {
                const nombrePais = pais.translations?.spa?.common || pais.name.common;
                const monedas = pais.currencies;

                // País
                const optionPais = document.createElement('option');
                optionPais.value = nombrePais;
                optionPais.textContent = nombrePais;
                paisSelect.appendChild(optionPais);

                // Monedas únicas
                if (monedas) {
                    for (const codigo in monedas) {
                        if (!monedasUnicas.has(codigo)) {
                            monedasUnicas.add(codigo);
                            const optionMoneda = document.createElement('option');
                            const nombreMoneda = monedasES[codigo] || monedas[codigo].name;
                            optionMoneda.value = codigo;
                            optionMoneda.textContent = `${codigo} - ${nombreMoneda}`;
                            monedaSelect.appendChild(optionMoneda);
                        }
                    }
                }
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
</script>

<?php include '../includes/footer.php'; ?>