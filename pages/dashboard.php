<?php 
include '../control/check_session.php';
include '../includes/header.php';
include '../includes/db.php';

// Consultas para estadísticas resumidas
$stmt_programas = $conn->query("SELECT COUNT(*) as total FROM data_programas");
$total_programas = $stmt_programas->fetch(PDO::FETCH_ASSOC)['total'];

$stmt_instituciones = $conn->query("SELECT COUNT(*) as total FROM data_instituciones");
$total_instituciones = $stmt_instituciones->fetch(PDO::FETCH_ASSOC)['total'];

$stmt_testimonios = $conn->query("SELECT COUNT(*) as total FROM data_testimonios");
$total_testimonios = $stmt_testimonios->fetch(PDO::FETCH_ASSOC)['total'];


// Consulta para obtener datos para el gráfico
$stmt_temporal = $conn->query("SELECT 
    DATE_FORMAT(fecha_creacion, '%b') AS mes,
    COUNT(*) AS total,
    SUM(CASE WHEN tipo = 'maestria' THEN 1 ELSE 0 END) AS maestrias,
    SUM(CASE WHEN tipo = 'doctorado' THEN 1 ELSE 0 END) AS doctorados
FROM data_programas
WHERE fecha_creacion >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
GROUP BY MONTH(fecha_creacion), mes
ORDER BY MONTH(fecha_creacion) ASC");

$meses = [];
$totales_mensuales = [];
$maestrias_mensuales = [];
$doctorados_mensuales = [];

while ($row = $stmt_temporal->fetch(PDO::FETCH_ASSOC)) {
    $meses[] = $row['mes'];
    $totales_mensuales[] = $row['total'];
    $maestrias_mensuales[] = $row['maestrias'];
    $doctorados_mensuales[] = $row['doctorados'];
}

// Convertir a JSON para JavaScript
$chartData = [
    'meses' => $meses,
    'totales' => $totales_mensuales,
    'maestrias' => $maestrias_mensuales,
    'doctorados' => $doctorados_mensuales
];




// Convertir a JSON para JavaScript
$meses_json = json_encode($meses);
$totales_mensuales_json = json_encode($totales_mensuales);
$maestrias_mensuales_json = json_encode($maestrias_mensuales);
$doctorados_mensuales_json = json_encode($doctorados_mensuales);
?>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <!--/ Bienvenida -->
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
              <div class="col-sm-7">
                  <div class="card-body">
                      <h5 class="card-title text-primary">Bienvenido <?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']); ?>! 🎉</h5>
                      <p class="mb-4">
                        Sistema de Gestión de THOTH.
                        Almacena y gestiona toda la documentación de la plataforma de THOTH.
                      </p>
                      <a href="https://thoth.education/" class="btn btn-sm btn-outline-primary">Ver Página de Thoth</a>
                  </div>
              </div>
              <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img src="../assets/img/bienvenida-img.svg" height="160" alt="View Badge User" />
                </div>
              </div>
          </div>
        </div>
    </div>
    
    <!--/ Cards -->
    <div class="col-12 col-md-9 col-lg-8 order-1 order-md-2">
      <div class="row">
          <div class="col-4 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                  <span class="avatar-initial rounded bg-label-secondary">
                    <i class="bx bx-book-alt"></i>
                  </span>                    
                  </div>                  
                </div>
                <span class="d-block mb-1">Programas</span>
                <h3 class="card-title text-nowrap mb-2"><?php echo $total_programas; ?></h3>
              </div>
            </div>
          </div>
          <div class="col-4 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                  <span class="avatar-initial rounded bg-label-info">
                  <i class="bx bx-building-house"></i>
                  </span> 
                  </div>                
                </div>
                <span class="fw-semibold d-block mb-1">Universidades</span>
                <h3 class="card-title mb-2"><?php echo $total_instituciones; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-4 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                  <span class="avatar-initial rounded bg-label-info">
                  <i class="bx bx-comment-detail"></i>
                  </span> 
                  </div>                  
                </div>
                <span class="fw-semibold d-block mb-1">Testimonios</span>
                <h3 class="card-title mb-2"><?php echo $total_testimonios; ?></h3>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!--/ Profile Report -->
    <div class="col-lg-4 col-md-3 order-2">
      <div class="row">
        <div class="col-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                  <div class="card-title">
                    <h5 class="text-nowrap mb-2">Visitas</h5>
                    <span class="badge bg-label-warning rounded-pill">Año 2025</span>
                  </div>
                  <div class="mt-sm-auto">
                    <small class="text-success text-nowrap fw-semibold"
                      ><i class="bx bx-chevron-up"></i> 10</small
                    >
                    <h3 class="mb-0">152</h3>
                  </div>
                </div>
                <div id="profileReportChart"></div>
              </div>
            </div>
          </div>
        </div>                   
      </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-12 col-lg-8 order-3 order-md-3 order-lg-2 mb-4">
        <div class="card">
            <div class="row row-bordered g-0">
              <div class="col-md-12">
                <h5 class="card-header m-0 me-2 pb-3">Total Registros de Programas subidos</h5>
                <div id="incomeChart" class="px-2"></div>
              </div>              
            </div>
          </div>
    </div>
  </div>
</div>

<script>
  // Pasa los datos PHP a JavaScript
  window.chartData = <?php echo json_encode($chartData); ?>;
</script>
<!--Vendors JS -->
<script src="../assets/apex-charts/apexcharts.js"></script>
<script src="../assets/js/dashboards-analytics.js"></script>

<?php include '../includes/footer.php'; ?>