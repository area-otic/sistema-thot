<?php
// Incluir conexión a la base de datos
include '../includes/db.php';

// Obtener universidades de la base de datos
try {
    $stmtUniversidades = $conn->query("SELECT id, nombre, pais, ciudad FROM data_instituciones WHERE estado = 'Activo' ORDER BY nombre");
    $universidades = $stmtUniversidades->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $universidades = [];
    $error = "Error al obtener universidades: " . $e->getMessage();
}

// Definir $precio_moneda para evitar errores
$precio_moneda = '';
?>

<!DOCTYPE html>
<html 
    lang="es"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Prueba</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- DataTables and Extensions CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="../assets/vendor/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/buttons.bootstrap5.css" />

    <!-- Other Third-Party CSS -->
    <link rel="stylesheet" href="../assets/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="../assets/apex-charts/apex-charts.css" />

    <!-- Core Theme CSS -->
    <link rel="stylesheet" href="../assets/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Helpers JS (with defer) -->
    <script src="../assets/js/helpers.js" defer></script>
    <script src="../assets/js/config.js" defer></script>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Formulario de Prueba: Universidad y Moneda</h4>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php elseif (isset($_GET['error'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <form class="needs-validation" id="formUniversidad" method="POST" novalidate>
                                <div class="row g-3">
                                    <!-- Universidad -->
                                    <div class="col-md-3">
                                        <label class="form-label">Universidad*</label>
                                        <select class="form-select select2-universidad" id="maestria-universidad" name="maestria-universidad" required>
                                            <option value="">Seleccionar universidad...</option>
                                            <?php foreach($universidades as $uni): ?>
                                                <option 
                                                    value="<?php echo htmlspecialchars($uni['id']); ?>" 
                                                    data-pais="<?php echo htmlspecialchars($uni['pais']); ?>"
                                                    data-ciudad="<?php echo htmlspecialchars($uni['ciudad']); ?>"
                                                >
                                                    <?php echo htmlspecialchars($uni['nombre']); ?> (<?php echo htmlspecialchars($uni['ciudad']); ?>, <?php echo htmlspecialchars($uni['pais']); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Por favor seleccione una universidad</div>
                                    </div>

                                    <!-- País -->
                                    <div class="col-md-3">
                                        <label class="form-label">País*</label>
                                        <input type="text" class="form-control" id="select-pais" name="maestria-pais" readonly required>
                                        <div class="invalid-feedback">El país es obligatorio</div>
                                    </div>

                                    <!-- Ciudad -->
                                    <div class="col-md-3">
                                        <label class="form-label">Ciudad*</label>
                                        <input type="text" class="form-control" id="maestria-ciudad" name="maestria-ciudad" readonly required>
                                        <div class="invalid-feedback">La ciudad es obligatoria</div>
                                    </div>

                                    <!-- Moneda -->
                                    <div class="col-md-3">
                                        <label class="form-label">Moneda*</label>
                                        <select class="form-select select2-moneda" id="select-moneda" name="maestria-moneda" required>
                                            <option value="">Seleccionar moneda...</option>
                                        </select>
                                        <div class="invalid-feedback">Por favor seleccione una moneda</div>
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i> Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- / Content -->

                <!-- Include footer.php -->
                <?php include '../includes/footer.php'; ?>

                <!-- Form-specific JavaScript -->
                <script>
                    $(document).ready(function() {
                        // Inicializar Select2 para universidades
                        $('.select2-universidad').select2({
                            placeholder: "Seleccionar universidad...",
                            allowClear: true
                        });

                        // Inicializar Select2 para moneda
                        $('.select2-moneda').select2({
                            placeholder: "Seleccionar moneda...",
                            allowClear: true
                        });

                        // Manejar cambio de universidad
                        $('#maestria-universidad').on('change', function() {
                            const selectedOption = $(this).find('option:selected');
                            const pais = selectedOption.data('pais') || '';
                            const ciudad = selectedOption.data('ciudad') || '';

                            $('#select-pais').val(pais);
                            $('#maestria-ciudad').val(ciudad);
                            $('#select-pais').trigger('change');
                            $('#maestria-ciudad').trigger('change');
                        });

                        // Poblar el dropdown de monedas
                        fetch('https://restcountries.com/v3.1/all')
                            .then(res => res.json())
                            .then(data => {
                                const monedaSelect = document.getElementById('select-moneda');
                                const monedasUnicas = new Set();
                                monedaSelect.innerHTML = '<option value="">Seleccionar moneda...</option>';
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
                                };
                                data.forEach(pais => {
                                    const monedas = pais.currencies;
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
                                console.error('Error al cargar monedas:', err);
                                const monedaSelect = document.getElementById('select-moneda');
                                monedaSelect.innerHTML = '<option value="">Seleccionar moneda...</option>';
                                const monedasDefault = {
                                    USD: "Dólar estadounidense",
                                    EUR: "Euro",
                                    MXN: "Peso mexicano"
                                };
                                for (const [codigo, nombre] of Object.entries(monedasDefault)) {
                                    const option = document.createElement('option');
                                    option.value = codigo;
                                    option.textContent = `${codigo} - ${nombre}`;
                                    monedaSelect.appendChild(option);
                                }
                            });

                        // Validación del formulario
                        const form = document.getElementById('formUniversidad');
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                if (!form.checkValidity()) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    form.classList.add('was-validated');
                                } else {
                                    console.log('Formulario válido, enviando datos...');
                                }
                            });
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</body>
</html>