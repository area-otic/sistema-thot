
<?php
include 'includes/db.php'; // Ajusta según tu estructura

// 2. Obtener el ID de la URL y validarlo
$id_maestria = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 3. Consultar la maestría específica
$stmt = $conn->prepare("SELECT * FROM data_maestrias WHERE id = ? AND estado_programa = 'Publicado'");
$stmt->execute([$id_maestria]);
$maestria = $stmt->fetch(PDO::FETCH_ASSOC);

// 4. Si no existe la maestría, redirigir
if(!$maestria) {
    header("Location: programas.php"); // O página de error 404
    exit;
}
?>

<!doctype html>
<html
  lang="es"
  class=" layout-navbar-fixed layout-wide "
  dir="ltr" data-skin="default" data-bs-theme="light"
  data-assets-path="assets/"
  data-template="front-pages">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    
    <title><?php echo htmlspecialchars($maestria['titulo']); ?> | Thoth</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="assets/pages-front/iconify-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/pages-front/pickr-themes.css" />
    <link rel="stylesheet" href="assets/pages-front/core.css" />
    <link rel="stylesheet" href="assets/pages-front/demo.css" />

    <link rel="stylesheet" href="assets/pages-front/front-page.css" />

    <!-- Helpers -->
    <script src="assets/pages-front/helpers.js"></script>
    <script src="assets/pages-front/template-customizer.js"></script>
    <script src="assets/pages-front/front-config.js"></script>
    
  </head>

<body>

<script src="assets/pages-front/dropdown-hover.js"></script>
<script src="assets/pages-front/mega-dropdown.js"></script>

<!-- Navbar: Start -->
<nav class="layout-navbar shadow-none py-0">
  <div class="container-fluid">
    <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">

      <div class="navbar-brand app-brand demo d-flex py-0 me-4 me-xl-8">

        <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="icon-base bx bx-menu icon-lg align-middle text-heading fw-medium"></i>
        </button>

        <a class="navbar-brand" href="landing-nav.php">
        <i class="icon-base-xl bx bx-graduation"></i>
        Thoth<span style="color: #E74C3C">Education</span></a>
      </div>

      <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
        <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2" 
        type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="icon-base bx bx-x icon-lg"></i>
        </button>
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link fw-medium" aria-current="page" href="landing-nav.php">Inicio</a>
          </li>
          <li class="nav-item mega-dropdown">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle navbar-ex-14-mega-dropdown mega-dropdown fw-medium" aria-expanded="false" data-bs-toggle="mega-dropdown" data-trigger="hover">
              <span data-i18n="Pages">Programas</span>
            </a>
            <div class="dropdown-menu p-4 p-xl-8">
              <div class="row gy-4">
                <div class="col-12 col-lg">
                  <div class="h6 d-flex align-items-center mb-3 mb-lg-4">
                    <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-grid-alt"></i></span>
                    </div>
                    <span class="ps-1">Categorías</span>
                  </div>
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="#">
                        <i class="icon-base bx bx-radio-circle me-1"></i>
                        <span data-i18n="Pricing">Humanidades</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="#">
                        <i class="icon-base bx bx-radio-circle me-1"></i>
                        <span data-i18n="Payment">Educacion</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="col-12 col-lg">
                  <div class="h6 d-flex align-items-center mb-3 mb-lg-4">
                    <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-lock-open icon-lg"></i></span>
                    </div>
                    <span class="ps-1">Auth Demo</span>
                  </div>
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="#" target="_blank">
                        <i class="icon-base bx bx-radio-circle me-1"></i>
                        Login (Basic)
                      </a>
                    </li>                    
                  </ul>
                </div>
                <div class="col-12 col-lg">
                  <div class="h6 d-flex align-items-center mb-3 mb-lg-4">
                    <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-image-alt icon-lg"></i></span>
                    </div>
                    <span class="ps-1">Other</span>
                  </div>
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/pages-misc-error.html" target="_blank">
                        <i class="icon-base bx bx-radio-circle me-1"></i>
                        Error
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-two-steps-basic.html" target="_blank">
                        <i class="icon-base bx bx-radio-circle me-1"></i>
                        Two Steps (Basic)
                      </a>
                    </li>                    
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium" href="landing-page.html#landingFeatures">Universidades Convenio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium" href="landing-page.html#landingContact">Contáctanos</a>
          </li>          
          <li class="nav-item">
            <a class="nav-link fw-medium" href="../vertical-menu-template/index.html" target="_blank">Admin</a>
          </li>
        </ul>
      </div>
      <!-- Menu wrapper: End -->
      <ul class="navbar-nav flex-row align-items-center ms-auto">
        
          <!-- Style Switcher -->
          <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
            <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown">
              <i class="icon-base bx bx-sun icon-lg theme-icon-active"></i>
              <span class="d-none ms-2" id="nav-theme-text">Tema</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
              <li>
                <button type="button" class="dropdown-item align-items-center active" data-bs-theme-value="light" aria-pressed="false">
                  <span><i class="icon-base bx bx-sun icon-md me-3" data-icon="sun"></i>Claro</span>
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark" aria-pressed="true">
                  <span><i class="icon-base bx bx-moon icon-md me-3" data-icon="moon"></i>Oscuro</span>
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system" aria-pressed="false">
                  <span><i class="icon-base bx bx-desktop icon-md me-3" data-icon="desktop"></i>Sistema</span>
                </button>
              </li>
            </ul>
          </li>        
        <!-- navbar button: Start 
        <li>
          <a href="../vertical-menu-template/auth-login-cover.html" class="btn btn-primary" target="_blank"><span class="tf-icons icon-base bx bx-log-in-circle scaleX-n1-rtl me-md-1"></span><span class="d-none d-md-block">Login/Register</span></a>
        </li>-->
        <!-- navbar button: End -->
      </ul>

    </div>
  </div>
</nav>
<!-- Navbar: End -->

<section class="hero-section position-relative" style="background: linear-gradient(135deg, #001f3f 0%, #003366 50%, #00509e 100%); overflow: hidden;">
    <!-- Imagen de fondo con overlay dinámica -->
    <div class="position-absolute w-100 h-100" style="top: 0; left: 0; z-index: 0; background-image: url('<?php echo htmlspecialchars($maestria['imagen_url'] ?? 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); ?>'); background-size: cover; background-position: center; opacity: 0.15;">
    </div>
    
    <div id="landingHero" class="section-py landing-hero position-relative">
      <div class="container">
        <div class="d-flex justify-content-between flex-column-reverse flex-lg-row align-items-center pt-12 pb-10">
          <div class="text-lg-start text-white">
          <h1 class="mb-3" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"> <?php echo htmlspecialchars($maestria['titulo']); ?></h1>
            <p class="lead mb-6 mb-md-11" style="color: #e6f0ff;">Adquiere conocimientos avanzados y desarrolla habilidades de liderazgo con nuestro prestigioso programa de posgrado.</p>
            
            <div class="d-flex gap-3 justify-content-lg-start">
              <a href="#inscripcion" class="btn btn-primary btn-lg" style="background-color: #4dabf7; border-color: #4dabf7; box-shadow: 0 4px 12px rgba(77, 171, 247, 0.4);">Postular ahora</a>
              <a href="#programa" class="btn btn-outline-light btn-lg">Conocer más</a>
            </div>
            
            <div class="mt-4">
              <span class="badge bg-light-primary me-2" style="background-color: rgba(255,255,255,0.15); color: #ffffff;">⭐ Acreditada internacionalmente</span>
              <span class="badge bg-light-primary" style="background-color: rgba(255,255,255,0.15); color: #ffffff;">🏆 Top 5 en rankings académicos</span>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

  <section class="section-py bg-body first-section-p3">
    <div class="container">
      <div class="row g-6">
        <div class="col-lg-8">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mb-2">
              <li class="breadcrumb-item">
                <a href="javascript:void(0);"><?php echo htmlspecialchars($maestria['tipo']); ?></a>
              </li>
              <li class="breadcrumb-item active">Programa</li>
            </ol>
          </nav>
          <h4 class="mb-2">Conoce un poco más del programa</h4>
          <hr class="my-6" />
          <p><?php echo nl2br(htmlspecialchars($maestria['descripcion'] ?? 'Descripción del programa no disponible.')); ?></p>

          <div class="row mt-6">
            <!-- Navigation -->
            <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-4">
              <div class="d-flex justify-content-between flex-column nav-align-left mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment">
                    <i class="icon-base bx bx-cube faq-nav-icon me-1_5"></i>
                      <span class="align-middle">Información</span>
                    </button>
                  </li>
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivery">
                    <i class="bx bx-bullseye faq-nav-icon me-1_5"></i>
                      <span class="align-middle">Objetivos</span>
                    </button>
                  </li>                
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#orders">
                    <i class="bx bx-book-open faq-nav-icon me-1_5"></i>
                      <span class="align-middle">Plan de Estudio</span>
                    </button>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /Navigation -->

            <!-- FAQ's -->
            <div class="col-lg-9 col-md-8 col-12">
              <div class="tab-content p-0">

                <div class="tab-pane fade show active" id="payment" role="tabpanel">
                  <div class="d-flex mb-4 gap-4 align-items-center">
                    <div>
                      <span class="badge bg-label-primary rounded w-px-50 py-2">
                        <i class="icon-base bx bx-cube  icon-26px mt-50"></i>
                      </span>
                    </div>
                    <div>
                      <h5 class="mb-0">
                        <span class="align-middle">Información</span>
                      </h5>
                      <span>Conoce sobre el programa</span>
                    </div>
                  </div>
                  <div id="accordionPayment" class="accordion">
                    <div class="card accordion-item active">

                      <div id="accordionPayment-1" class="accordion-body">
                        <div class="accordion-body">
                          País: <?php echo nl2br(htmlspecialchars($maestria['pais'] ?? 'País del programa no disponible.')); ?>
                          <br><br>
                          Universidad: <?php echo nl2br(htmlspecialchars($maestria['universidad'] ?? 'Universidad no disponible.')); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="tab-pane fade" id="delivery" role="tabpanel">
                  <div class="d-flex mb-4 gap-4">
                    <div>
                      <span class="badge bg-label-primary rounded w-px-50 py-2">
                        <i class="icon-base bx bx-detail icon-26px mt-50"></i>
                      </span>
                    </div>
                    <div>
                      <h5 class="mb-0">
                        <span class="align-middle">Objetivos</span>
                      </h5>
                      <span>Lo que lograrás con este programa</span>
                    </div>
                  </div>
                  <div id="accordionDelivery" class="accordion">
                  <div class="card accordion-item active">
                    <div class="accordion-body">
                      <?php 
                      if(!empty($maestria['objetivos'])) {
                          echo '<ul>';
                          $objetivos = explode("\n", $maestria['objetivos']);
                          foreach($objetivos as $objetivo) {
                              if(trim($objetivo)) {
                                  echo '<li>'.htmlspecialchars(trim($objetivo)).'</li>';
                              }
                          }
                          echo '</ul>';
                      } else {
                          echo '<p>Objetivos no disponibles.</p>';
                      }
                      ?>
                    </div>
                  </div>

                  </div>
                </div>

                <div class="tab-pane fade" id="orders" role="tabpanel">
                  <div class="d-flex mb-4 gap-4">
                    <div>
                      <span class="badge bg-label-primary rounded w-px-50 py-2">
                        <i class="icon-base bx bx-box icon-26px mt-50"></i>
                      </span>
                    </div>
                    <div>
                      <h5 class="mb-0">
                        <span class="align-middle">Plan de estudios</span>
                      </h5>
                      <span>Estructura académica del programa</span>
                    </div>
                  </div>
                  <div id="accordionOrders" class="accordion">
                  <div class="card accordion-item active">
                    <div class="accordion-body">
                      <?php
                      if(!empty($maestria['plan_estudios'])) {
                          echo '<div class="row">';
                          $modulos = json_decode($maestria['plan_estudios'], true) ?? explode("\n", $maestria['plan_estudios']);
                          
                          if(is_array($modulos)) {
                              foreach($modulos as $modulo) {
                                  if(is_array($modulo)) {
                                      // Si es un array (JSON decodificado)
                                      echo '<div class="col-md-6 mb-3">';
                                      echo '<h6>'.htmlspecialchars($modulo['nombre'] ?? '').'</h6>';
                                      if(isset($modulo['cursos']) && is_array($modulo['cursos'])) {
                                          echo '<ul>';
                                          foreach($modulo['cursos'] as $curso) {
                                              echo '<li>'.htmlspecialchars($curso).'</li>';
                                          }
                                          echo '</ul>';
                                      }
                                      echo '</div>';
                                  } else {
                                      // Si es texto plano separado por saltos de línea
                                      echo '<div class="col-12 mb-2">';
                                      echo '<li>'.htmlspecialchars(trim($modulo)).'</li>';
                                      echo '</div>';
                                  }
                              }
                          }
                          echo '</div>';
                      } else {
                          echo '<p>Plan de estudios no disponible.</p>';
                      }
                      ?>
                    </div>
                  </div>

                  </div>
                </div>

              </div>
            </div>
            <!-- /FAQ's -->
          </div>

        </div>

        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4">Información del programa</h5>
              <ul class="list-unstyled">
                <li class="mb-3 d-flex">
                  <i class="icon-base bx bx-time me-2"></i>
                  <div>
                    <strong>Duración:</strong><br>
                    <?php echo htmlspecialchars($maestria['duracion'] ?? 'No especificado'); ?>
                  </div>
                </li>
                <li class="mb-3 d-flex">
                  <i class="icon-base bx bx-calendar me-2"></i>
                  <div>
                    <strong>Inicio:</strong><br>
                    <?php echo htmlspecialchars($maestria['fecha_inicio'] ?? 'Por definir'); ?>
                  </div>
                </li>
                <li class="mb-3 d-flex">
                  <i class="icon-base bx bx-building me-2"></i>
                  <div>
                    <strong>Universidad:</strong><br>
                    <?php echo htmlspecialchars($maestria['universidad'] ?? 'No especificada'); ?>
                  </div>
                </li>
                <li class="mb-3 d-flex">
                  <i class="icon-base bx bx-map me-2"></i>
                  <div>
                    <strong>Modalidad:</strong><br>
                    <?php echo htmlspecialchars($maestria['modalidad'] ?? 'No especificada'); ?>
                  </div>
                </li>
                <li class="mb-3 d-flex">
                  <i class="icon-base bx bx-certification me-2"></i>
                  <div>
                    <strong>Título:</strong><br>
                    <?php echo htmlspecialchars($maestria['titulo_otorga'] ?? $maestria['titulo'] ?? 'No especificado'); ?>
                  </div>
                </li>
              </ul>
              <a href="#inscripcion" class="btn btn-primary w-100 mt-3">Conoce más</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<!-- / Sections:End -->

<!-- Footer: Start -->
<footer class="landing-footer footer-text">
  <div class="footer-top position-relative overflow-hidden z-1">
    <div class="container">
      <div class="row gx-0 gy-6 g-lg-10">
        <div class="col-lg-5">
          <a class="navbar-brand" href="#">
          <i class="icon-base-xl bx bx-graduation"></i>
          Thoth<span style="color: #E74C3C">Education</span></a>
          <a href="landing-page.html" class="app-brand-link"></a>
          <p class="footer-text footer-logo-description mb-6">
            Conectando estudiantes con las mejores oportunidades educativas en todo el mundo.</p>
          <!--<form class="footer-form">
            <label for="footer-email" class="small">Subscribe to newsletter</label>
            <div class="d-flex mt-1">
              <input type="email" class="form-control rounded-0 rounded-start-bottom rounded-start-top" id="footer-email" placeholder="Your email" />
              <button type="submit" class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">Subscribe</button>
            </div>
          </form>-->
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
          <h6 class="footer-title mb-6">Enlaces Rápidos</h6>
          <ul class="list-unstyled">
            <li class="mb-4">
              <a href="#" target="_blank" class="footer-link">Inicio</a>
            </li>
            <li class="mb-4">
              <a href="#" target="_blank" class="footer-link">Programas</a>
            </li>
            <li>
              <a href="#" target="_blank" class="footer-link">Contacto</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
          <!--<h6 class="footer-title mb-6">Pages</h6>
          <ul class="list-unstyled">
            <li class="mb-4">
              <a href="pricing-page.html" class="footer-link">Pricing</a>
            </li>
            <li class="mb-4">
              <a href="help-center-landing.html" class="footer-link">Help Center</a>
            </li>
            <li>
              <a href="../vertical-menu-template/auth-login-cover.html" target="_blank" class="footer-link">Login/Register</a>
            </li>-->
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom py-3 py-md-5">
    <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
      <div class="mb-2 mb-md-0">
        <span class="footer-bottom-text"
          >©
          <script>
            document.write(new Date().getFullYear());
          </script>
        </span>
        <span class="text-white">Todos lo derechos reservados.</span>
        <span class="footer-bottom-text">  Desarrollado por SSB.</span>
      </div>
      <div>        
        <!--<a href="https://www.facebook.com/ThemeSelections/" class="me-4 text-white" target="_blank">
          <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.8609 18.0262V11.1962H14.1651L14.5076 8.52204H11.8609V6.81871C11.8609 6.04704 12.0759 5.51871 13.1834 5.51871H14.5868V3.13454C13.904 3.06136 13.2176 3.02603 12.5309 3.02871C10.4943 3.02871 9.09593 4.27204 9.09593 6.55454V8.51704H6.80676V11.1912H9.10093V18.0262H11.8609Z" fill="currentColor" />
          </svg>
        </a>
        <a href="https://x.com/Theme_Selection" class="me-4 text-white" target="_blank">
          <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M17.0576 7.19293C17.0684 7.33876 17.0684 7.48376 17.0684 7.62876C17.0684 12.0663 13.6909 17.1796 7.5184 17.1796C5.61674 17.1796 3.85007 16.6288 2.3634 15.6721C2.6334 15.7029 2.8934 15.7138 3.17424 15.7138C4.68506 15.7174 6.15311 15.2122 7.34174 14.2796C6.64125 14.2669 5.96222 14.0358 5.39943 13.6185C4.83665 13.2013 4.41822 12.6187 4.20257 11.9521C4.41007 11.9829 4.6184 12.0038 4.83674 12.0038C5.13757 12.0038 5.44007 11.9621 5.7209 11.8896C4.9607 11.7361 4.27713 11.3241 3.78642 10.7235C3.29571 10.1229 3.02815 9.37097 3.02924 8.59543V8.55376C3.47674 8.80293 3.9959 8.95876 4.5459 8.9796C4.08514 8.67342 3.70734 8.25795 3.44619 7.77026C3.18504 7.28256 3.04866 6.73781 3.04924 6.1846C3.04924 5.56126 3.21507 4.9896 3.5059 4.49126C4.34935 5.52878 5.40132 6.37756 6.59368 6.98265C7.78604 7.58773 9.0922 7.93561 10.4276 8.00376C10.3759 7.75376 10.3442 7.4946 10.3442 7.2346C10.344 6.79373 10.4307 6.35715 10.5993 5.9498C10.7679 5.54245 11.0152 5.17233 11.3269 4.86059C11.6386 4.54885 12.0088 4.30161 12.4161 4.133C12.8235 3.96438 13.26 3.87771 13.7009 3.87793C14.6676 3.87793 15.5401 4.28293 16.1534 4.93793C16.9049 4.79261 17.6255 4.51828 18.2834 4.1271C18.0329 4.90278 17.5082 5.56052 16.8076 5.9771C17.4741 5.90108 18.1254 5.72581 18.7401 5.4571C18.281 6.12635 17.7122 6.71322 17.0576 7.19293Z"
              fill="currentColor" />
          </svg>
        </a>
        <a href="https://www.instagram.com/themeselection/" class="text-white" target="_blank">
          <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_1833_185630)">
              <path
                d="M17.5869 6.33973C17.5774 5.62706 17.444 4.9215 17.1926 4.25456C16.9747 3.69202 16.6418 3.18112 16.2152 2.75453C15.7886 2.32793 15.2776 1.995 14.7151 1.77703C14.0568 1.5299 13.3613 1.39627 12.6582 1.38183C11.753 1.34137 11.466 1.33008 9.16819 1.33008C6.87039 1.33008 6.57586 1.33008 5.67725 1.38183C4.97451 1.39637 4.27932 1.53 3.62127 1.77703C3.05863 1.99485 2.54765 2.32772 2.12103 2.75434C1.69442 3.18096 1.36155 3.69193 1.14373 4.25456C0.896101 4.91242 0.76276 5.60776 0.749471 6.31056C0.70901 7.2167 0.696777 7.50368 0.696777 9.8015C0.696777 12.0993 0.696777 12.3928 0.749471 13.2924C0.763585 13.9963 0.89626 14.6907 1.14373 15.3503C1.36192 15.9128 1.69503 16.4236 2.1218 16.85C2.54855 17.2765 3.05957 17.6091 3.6222 17.8269C4.27846 18.084 4.97377 18.2272 5.67819 18.2504C6.58433 18.2908 6.87133 18.303 9.16913 18.303C11.4669 18.303 11.7615 18.303 12.6601 18.2504C13.3632 18.2365 14.0587 18.1032 14.717 17.8561C15.2794 17.6378 15.7902 17.3048 16.2167 16.8782C16.6433 16.4517 16.9763 15.941 17.1945 15.3785C17.442 14.7198 17.5746 14.0254 17.5888 13.3207C17.6293 12.4155 17.6414 12.1285 17.6414 9.82973C17.6396 7.53191 17.6396 7.24021 17.5869 6.33973ZM9.16255 14.1468C6.75935 14.1468 4.81251 12.2 4.81251 9.79679C4.81251 7.39359 6.75935 5.44676 9.16255 5.44676C10.3163 5.44676 11.4227 5.90506 12.2385 6.72085C13.0543 7.53664 13.5126 8.64309 13.5126 9.79679C13.5126 10.9505 13.0543 12.057 12.2385 12.8727C11.4227 13.6885 10.3163 14.1468 9.16255 14.1468ZM13.6857 6.3002C13.5525 6.30033 13.4206 6.27417 13.2974 6.22325C13.1743 6.17231 13.0624 6.09759 12.9682 6.00338C12.874 5.90917 12.7992 5.79729 12.7483 5.67417C12.6974 5.55105 12.6712 5.41909 12.6713 5.28585C12.6713 5.15271 12.6976 5.02087 12.7485 4.89786C12.7994 4.77485 12.8742 4.66308 12.9683 4.56893C13.0625 4.47479 13.1743 4.4001 13.2973 4.34915C13.4202 4.2982 13.5521 4.27197 13.6853 4.27197C13.8184 4.27197 13.9503 4.2982 14.0732 4.34915C14.1962 4.4001 14.3081 4.47479 14.4022 4.56893C14.4963 4.66308 14.571 4.77485 14.622 4.89786C14.6729 5.02087 14.6991 5.15271 14.6991 5.28585C14.6991 5.84666 14.2456 6.3002 13.6857 6.3002Z"
                fill="currentColor" />
              <path d="M9.16296 12.6226C10.7236 12.6226 11.9887 11.3575 11.9887 9.79688C11.9887 8.23629 10.7236 6.97119 9.16296 6.97119C7.60238 6.97119 6.33728 8.23629 6.33728 9.79688C6.33728 11.3575 7.60238 12.6226 9.16296 12.6226Z" fill="currentColor" />
            </g>
            <defs>
              <clipPath id="clip0_1833_185630">
                <rect width="16.9412" height="18" fill="currentColor" transform="translate(0.696777 0.528809)" />
              </clipPath>
            </defs>
          </svg>
        </a>-->
      </div>
    </div>
  </div>
</footer>
<!-- Footer: End -->
    <script src="assets/pages-front/popper.js"></script>
    <script src="assets/pages-front/bootstrap.js"></script>
    <script src="assets/pages-front/autocomplete-js.js"></script>
    <script src="assets/pages-front/pickr.js"></script>
    <script src="assets/pages-front/front-main.js"></script>

    <script src="assets/pages-front/front-page-landing.js"></script>

  </body>
</html>

