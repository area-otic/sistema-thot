<?php 
include '../control/check_session.php';
include '../includes/header.php';
include '../includes/db.php'; // Asegúrate de incluir tu conexión a DB

// Consulta para obtener el conteo de maestrías por categoría
$stmt = $conn->query("SELECT pais, COUNT(*) as total FROM data_programas GROUP BY pais");
$categorias = [];
$totales = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categorias[] = $row['pais'];
    $totales[] = $row['total'];
}

// Consulta para obtener el conteo de maestrías (data_programas)
$stmt_programas = $conn->query("SELECT COUNT(*) as total FROM data_programas");
$total_programas = $stmt_programas->fetch(PDO::FETCH_ASSOC)['total'];

// Consulta para obtener el conteo de universidades (data_instituciones)
$stmt_instituciones = $conn->query("SELECT COUNT(*) as total FROM data_instituciones");
$total_instituciones = $stmt_instituciones->fetch(PDO::FETCH_ASSOC)['total'];

// Consulta para obtener el conteo de testimonios (data_testimonios)
$stmt_testimonios = $conn->query("SELECT COUNT(*) as total FROM data_testimonios");
$total_testimonios = $stmt_testimonios->fetch(PDO::FETCH_ASSOC)['total'];
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
                        Sistema de Gestión de THOT.
                        Almacena y gestiona toda la documentación de la plataforma de THOT.
                      </p>
                      <a href="https://thoth.education/" class="btn btn-sm btn-outline-primary">Ver Página de Thot</a>
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
                <!--<small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>-->
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
                <!--<small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>-->
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
                <!--<small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>-->
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
                <h5 class="card-header m-0 me-2 pb-3">Total Registros de Maestrías subidos</h5>
                <div id="incomeChart" class="px-2"></div> <!-- Aquí movemos el incomeChart -->
              </div>
              <!--<div class="col-md-4">
                <div class="card-body">
                  <div class="text-center">
                    <div class="dropdown">
                      <button
                        class="btn btn-sm btn-outline-primary dropdown-toggle"
                        type="button"
                        id="growthReportId"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        2022
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                        <a class="dropdown-item" href="javascript:void(0);">2021</a>
                        <a class="dropdown-item" href="javascript:void(0);">2020</a>
                        <a class="dropdown-item" href="javascript:void(0);">2019</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="growthChart"></div>
                <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

                <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                  <div class="d-flex">
                    <div class="me-2">
                      <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                      <small>2022</small>
                      <h6 class="mb-0">$32.5k</h6>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="me-2">
                      <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                      <small>2021</small>
                      <h6 class="mb-0">$41.2k</h6>
                    </div>
                  </div>
                </div>
              </div>-->
            </div>
          </div>
    </div>

    <!-- Order Statistics 
    <div class="col-6 col-lg-4 order-4 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between pb-0">
              <div class="card-title mb-0">
                <h5 class="m-0 me-2">Order Statistics</h5>
                <small class="text-muted">42.82k Total Sales</small>
              </div>
              <div class="dropdown">
                <button
                  class="btn p-0"
                  type="button"
                  id="orederStatistics"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                  <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                  <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                  <a class="dropdown-item" href="javascript:void(0);">Share</a>
                </div>
              </div>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex flex-column align-items-center gap-1">
                <h2 class="mb-2">8,258</h2>
                <span>Total Orders</span>
              </div>
              <div id="orderStatisticsChart"></div>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"
                    ><i class="bx bx-mobile-alt"></i
                  ></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Electronic</h6>
                    <small class="text-muted">Mobile, Earbuds, TV</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">82.5k</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Fashion</h6>
                    <small class="text-muted">T-shirt, Jeans, Shoes</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">23.8k</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Decor</h6>
                    <small class="text-muted">Fine Art, Dining</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">849k</small>
                  </div>
                </div>
              </li>
              <li class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-secondary"
                    ><i class="bx bx-football"></i
                  ></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Sports</h6>
                    <small class="text-muted">Football, Cricket Kit</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">99</small>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
    </div>-->

  </div>
</div>
<!--Vendors JS -->
<script src="../assets/apex-charts/apexcharts.js"></script>
<script src="../assets/js/dashboards-analytics.js"></script>

<?php include '../includes/footer.php'; ?>