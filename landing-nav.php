<?php 
include 'includes/db.php'; ?>
<!doctype html>
<html
  lang="es"
  class=" layout-navbar-fixed layout-wide "
  dir="ltr"
  data-template="front-pages"
  data-bs-theme="light">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex" />
    <title>Thot</title>
 
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/pages-front/iconify-icons.css" />

    <link rel="stylesheet" href="assets/pages-front/pickr-themes.css" />
    
    <link rel="stylesheet" href="assets/pages-front/core.css" />
    <link rel="stylesheet" href="assets/pages-front/demo.css" />

    <!-- Nav de esta pagina -->
    <link rel="stylesheet" href="assets/pages-front/front-page.css" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/pages-front/nouislider.css" />
    <link rel="stylesheet" href="assets/pages-front/swiper.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="assets/pages-front/front-page-landing.css" />

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

        <a class="navbar-brand" href="#">
        <i class="icon-base-xl bx bx-graduation"></i>
        Thoth<span style="color: #E74C3C">Education</span></a>
        <a href="landing-page.html" class="app-brand-link"></a>
      </div>

      <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
        <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2" 
        type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="icon-base bx bx-x icon-lg"></i>
        </button>
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link fw-medium" aria-current="page" href="landing-page.html#landingHero">Inicio</a>
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
                      <a class="nav-link mega-dropdown-link" href="pricing-page.html">
                        <i class="icon-base bx bx-radio-circle me-1"></i>
                        <span data-i18n="Pricing">Humanidades</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="payment-page.html">
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
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-login-basic.html" target="_blank">
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

<!-- Sections:Start -->
  <div data-bs-spy="scroll" class="scrollspy-example">
    <!-- Hero: Start -->
    <section id="hero-animation">
      <div id="landingHero" class="section-py landing-hero position-relative">        
        <div class="container">
          <div class="hero-text-box text-center position-relative">
            <h1 class="text-primary hero-title display-6 fw-extrabold">
              Tu Futuro Académico Comienza Aquí</h1>
            <h2 class="hero-sub-title h6 mb-6">
              Descubre las mejores maestrías y programas de especialización
            </h2>            
          </div>

          <div class="help-center-header">
            <h4 class="text-center text-primary">Hola, qué programa buscas</h4>
            <div class="input-wrapper mb-4 input-group input-group-merge position-relative mx-auto">
              <span class="input-group-text" id="basic-addon1"><i class="icon-base bx bx-search"></i></span>
              <input type="text" class="form-control" id="search-name" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon1" />
            </div>
            <!-- Filtros añadidos aquí -->
            <div class="filters-container bg-white rounded-3 p-4 shadow-sm mt-4 position-relative mx-auto">
              <div class="row g-3">
                <!-- Filtro 1 -->
                <div class="col-md-4 col-12">
                  <label for="filter-tipo" class="form-label small text-muted mb-1">Tipo de Programa</label>
                  <select id="filter-tipo" class="form-select">
                    <option value="">Todos los tipos</option>
                    <?php
                    $tipos = $conn->query("SELECT DISTINCT tipo FROM data_maestrias WHERE tipo IS NOT NULL");
                    while($tipo = $tipos->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="'.htmlspecialchars($tipo['tipo']).'">'.htmlspecialchars($tipo['tipo']).'</option>';
                    }
                    ?>
                  </select>
                </div>
                
                <!-- Filtro 2 -->
                <div class="col-md-4 col-12">
                  <label for="filter-categoria" class="form-label small text-muted mb-1">Categorías</label>
                  <select id="filter-categoria" class="form-select">
                    <option value="">Todas las categorías</option>
                    <?php
                    $categorias = $conn->query("SELECT DISTINCT categoria FROM data_maestrias WHERE categoria IS NOT NULL");
                    while($categoria = $categorias->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="'.htmlspecialchars($categoria['categoria']).'">'.htmlspecialchars($categoria['categoria']).'</option>';
                    }
                    ?>
                  </select>
                </div>
                
                <!-- Filtro 3 -->
                <div class="col-md-4 col-12">
                  <label for="filter-pais" class="form-label small text-muted mb-1">País</label>
                  <select id="filter-pais" class="form-select">
                    <option value="">Todos los países</option>
                    <?php
                    $paises = $conn->query("SELECT DISTINCT pais FROM data_maestrias WHERE pais IS NOT NULL");
                    while($pais = $paises->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="'.htmlspecialchars($pais['pais']).'">'.htmlspecialchars($pais['pais']).'</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>

              <!-- Botón Más Filtros -->
              <div class="text-center my-3">
                <button onclick="toggleMoreFilters()" class="btn btn-link p-0 text-decoration-none">
                  <span id="more-filters-text">Más filtros</span>
                  <i id="more-filters-icon" class="bx bx-chevron-down ms-1"></i>
                </button>
              </div>
              
              <!-- Filtros adicionales (ocultos inicialmente) -->
              <div id="additional-filters" class="row g-3 d-none">           
                <div class="col-md-4 col-12">
                  <label for="filter-modalidad" class="form-label small text-muted mb-1">Modalidades</label>
                  <select id="filter-modalidad" class="form-select">
                    <option value="">Modalidades</option>
                    <?php
                    $modalidades = $conn->query("SELECT DISTINCT modalidad FROM data_maestrias WHERE modalidad IS NOT NULL");
                    while($modalidad = $modalidades->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="'.htmlspecialchars($modalidad['modalidad']).'">'.htmlspecialchars($modalidad['modalidad']).'</option>';
                    }
                    ?>
                  </select>
                </div>
                
                <div class="col-md-4 col-12">
                  <label for="filter-universidad" class="form-label small text-muted mb-1">Universidades</label>
                  <select id="filter-universidad" class="form-select">
                    <option value="">Todas las universidades</option>
                    <?php
                    $universidades = $conn->query("SELECT DISTINCT universidad FROM data_maestrias WHERE universidad IS NOT NULL");
                    while($universidad = $universidades->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="'.htmlspecialchars($universidad['universidad']).'">'.htmlspecialchars($universidad['universidad']).'</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              
              <!-- Botón de búsqueda -->
              <div class="text-center mt-4">
                <button onclick="buscarProgramas()" class="btn btn-primary">
                  <i class="bx bx-search me-2"></i>
                  Buscar Programas
                </button>
              </div>
            </div>
          </div>
      </div>
    </section>
    <!-- Hero: End -->

    <!-- Useful features: Start -->
    <section id="landingFeatures" class="section-py landing-features">
      <div class="container">
        <div class="text-center mb-2">
          <span class="badge bg-label-primary">Programas Educativos</span>
        </div>
        <h4 class="text-center mb-1">
          Encuentra el programa perfecto para tu desarrollo profesional
        </h4>
        <br>
        <br>

        <div id="programsGrid" class="row g-6">
          <?php
          $stmt = $conn->query("SELECT * FROM data_maestrias WHERE estado_programa = 'Publicado' LIMIT 8");
          while ($programa = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo '
              <div class="col-12 col-lg-4 col-xl-3" data-aos="fade-up">
                  <div class="card h-100 shadow border">
                      <div class="rounded-2 text-center mb-4 position-relative" style="height: 220px;">
                          <img class="img-fluid-program w-100 h-100 rounded-top" src="'.htmlspecialchars($programa['imagen_url'] ?? 'https://via.placeholder.com/400x250').'" alt="'.htmlspecialchars($programa['titulo']).'">
                          <div class="position-absolute bottom-0 start-0 w-100 h-50" style="background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 100%); pointer-events: none;"></div>
                      </div>
                      <div class="card-body p-5 pt-2 d-flex flex-column">
                          <div class="flex-grow-1"> <!-- Contenedor principal que crece -->
                              <div class="d-flex justify-content-between align-items-center mb-4 pe-xl-4 pe-xxl-0">
                                  <span class="badge bg-label-info">'.htmlspecialchars($programa['tipo']).'</span>
                              </div>
                              <a class="h5" style="line-height:1.25rem" href="#"><strong>'.htmlspecialchars($programa['titulo']).'</strong></a>
                              <p class="mt-1" style="color:#95A5A6">'.htmlspecialchars(substr($programa['descripcion'] ?? 'Programa académico de excelencia', 0, 100)).'...</p>

                          </div>                          
                          <!-- Botón Ver Detalles -->
                          <div class="pt-2">
                          <!-- Contenedor de ubicación e institución -->
                              <div class="mt-auto"> 
                                  <div class="row g-3 justify-content-center mb-3">
                                      <div class="col-6 d-flex">
                                          <div class="d-flex align-items-center">
                                              <div class="avatar flex-shrink-0 me-3">
                                                  <span class="avatar-initial rounded bg-label-info">
                                                      <i class="icon-base bx bx-location-map icon-lg"></i>
                                                  </span>
                                              </div>
                                              <div>
                                                  <h6 class="mb-0 text-nowrap">'.htmlspecialchars($programa['pais'] ?? 'Online').'</h6>
                                                  <small>Ubicación</small>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-6 d-flex">
                                          <div class="d-flex align-items-center">
                                              <div class="avatar flex-shrink-0 me-3">
                                                  <span class="avatar-initial rounded bg-label-info">
                                                      <i class="icon-base bx bx-building icon-lg"></i>
                                                  </span>
                                              </div>
                                              <div>
                                                  <h6 class="mb-0">'.htmlspecialchars($programa['universidad'] ?? 'Universidad').'</h6>
                                                  <small>Institución</small>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>    
                          <button class="w-100 btn btn-label-primary d-flex align-items-center" onclick=\'openModal('.json_encode($programa).')\'>
                                  <span class="me-2">Ver detalles</span>
                                  <i class="icon-base bx bx-chevron-right icon-sm lh-1"></i>
                              </button>
                          </div>
                      </div>
                  </div>
              </div>';
          }
          ?>
        </div>

        <div class="load-more-container text-center mt-4">
                <button id="loadMoreBtn" class="btn btn-info" onclick="cargarMasProgramas()">
                    <span>Ver más programas</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
        </div>

      </div>
    </section>
    <!-- Useful features: End -->

    <!-- Real customers reviews: Start -->
    <section id="landingReviews" class="section-py bg-body landing-reviews pb-0">
      <!-- What people say slider: Start -->
      <div class="container">
        <div class="row align-items-center gx-0 gy-4 g-lg-5 mb-5 pb-md-5">
          <div class="col-md-6 col-lg-5 col-xl-3">
            <div class="mb-4">
              <span class="badge bg-label-primary">Testimonios</span>
            </div>
            <h4 class="mb-1">
              <span class="position-relative fw-extrabold z-1"
                >Experiencias de Estudiantes</span>
            </h4>
            <p class="mb-5 mb-md-12">
            Lo que dicen nuestros estudiantes sobre su experiencia
            </p>
            <div class="landing-reviews-btns">
              <button id="reviews-previous-btn" class="btn btn-icon btn-label-primary reviews-btn me-3" type="button">
                <i class="icon-base bx bx-chevron-left icon-md scaleX-n1-rtl"></i>
              </button>
              <button id="reviews-next-btn" class="btn btn-icon btn-label-primary reviews-btn" type="button">
                <i class="icon-base bx bx-chevron-right icon-md scaleX-n1-rtl"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6 col-lg-7 col-xl-9">
            <div class="swiper-reviews-carousel overflow-hidden">
              <div class="swiper" id="swiper-reviews">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="card h-100">
                      <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                        <div class="mb-4"></div>
                        <p>“Vuexy is hands down the most useful front end Bootstrap theme I've ever used. I can't wait to use it again for my next project.”</p>
                        <div class="text-warning mb-4">
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="avatar me-3 avatar-sm">
                            <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                          </div>
                          <div>
                            <h6 class="mb-0">Cecilia Payne</h6>
                            <p class="small text-body-secondary mb-0">CEO of Airbnb</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div class="card h-100">
                      <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                        <div class="mb-4">
                          <img src="../../assets/img/front-pages/branding/logo-4.png" alt="client logo" class="client-logo img-fluid" />
                        </div>
                        <p>All the requirements for developers have been taken into consideration, so I’m able to build any interface I want.</p>
                        <div class="text-warning mb-4">
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bx-star"></i>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="avatar me-3 avatar-sm">
                            <img src="../../assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                          </div>
                          <div>
                            <h6 class="mb-0">Sara Smith</h6>
                            <p class="small text-body-secondary mb-0">Founder of Continental</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div class="card h-100">
                      <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                        <div class="mb-4">
                          <img src="../../assets/img/front-pages/branding/logo-5.png" alt="client logo" class="client-logo img-fluid" />
                        </div>
                        <p>“I've never used a theme as versatile and flexible as Vuexy. It's my go to for building dashboard sites on almost any project.”</p>
                        <div class="text-warning mb-4">
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="avatar me-3 avatar-sm">
                            <img src="../../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                          </div>
                          <div>
                            <h6 class="mb-0">Eugenia Moore</h6>
                            <p class="small text-body-secondary mb-0">Founder of Hubspot</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div class="card h-100">
                      <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                        <div class="mb-4">
                          <img src="../../assets/img/front-pages/branding/logo-6.png" alt="client logo" class="client-logo img-fluid" />
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam nemo mollitia, ad eum officia numquam nostrum repellendus consequuntur!</p>
                        <div class="text-warning mb-4">
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bxs-star"></i>
                          <i class="icon-base bx bx-star"></i>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="avatar me-3 avatar-sm">
                            <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                          </div>
                          <div>
                            <h6 class="mb-0">Sara Smith</h6>
                            <p class="small text-body-secondary mb-0">Founder of Continental</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- What people say slider: End -->
      <hr class="m-0 mt-6 mt-md-12" />
      <!-- Logo slider: Start -->
      <div class="container">
        <div class="swiper-logo-carousel pt-8">
          <div class="swiper" id="swiper-clients-logos">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo_1-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo_1-light.png" data-app-dark-img="front-pages/branding/logo_1-dark.png" />
              </div>
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo_2-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo_2-light.png" data-app-dark-img="front-pages/branding/logo_2-dark.png" />
              </div>
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo_3-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo_3-light.png" data-app-dark-img="front-pages/branding/logo_3-dark.png" />
              </div>
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo_4-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo_4-light.png" data-app-dark-img="front-pages/branding/logo_4-dark.png" />
              </div>
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo_5-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo_5-light.png" data-app-dark-img="front-pages/branding/logo_5-dark.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Logo slider: End -->
    </section>

    <section id="landingTeam" class="section-py landing-team">
      <div class="container">
        <div class="text-center mb-4">
          <span class="badge bg-label-primary">Nuestros convenios</span>
        </div>
        <h4 class="text-center mb-1">
          <span class="position-relative fw-extrabold z-1"
            >Universidades </span>con las cuales tenemos convenios.
        </h4>
        <p class="text-center mb-md-11 pb-0 pb-xl-12">Who is behind these great-looking interfaces?</p>
       
      </div>
    </section>


    <!-- Fun facts: Start -->
    <section id="landingFunFacts" class="section-py landing-fun-facts">
      <div class="container">
        <div class="row gy-6">
          <div class="col-sm-6 col-lg-3">
            <div class="card border border-primary shadow-none">
              <div class="card-body text-center">
                <div class="mb-4 text-primary">
                  <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.2" d="M10 44.4663V18.4663C10 17.4054 10.4214 16.388 11.1716 15.6379C11.9217 14.8877 12.9391 14.4663 14 14.4663H50C51.0609 14.4663 52.0783 14.8877 52.8284 15.6379C53.5786 16.388 54 17.4054 54 18.4663V44.4663H10Z" fill="currentColor" />
                    <path
                      d="M10 44.4663V18.4663C10 17.4054 10.4214 16.388 11.1716 15.6379C11.9217 14.8877 12.9391 14.4663 14 14.4663H50C51.0609 14.4663 52.0783 14.8877 52.8284 15.6379C53.5786 16.388 54 17.4054 54 18.4663V44.4663M36 22.4663H28M6 44.4663H58V48.4663C58 49.5272 57.5786 50.5446 56.8284 51.2947C56.0783 52.0449 55.0609 52.4663 54 52.4663H10C8.93913 52.4663 7.92172 52.0449 7.17157 51.2947C6.42143 50.5446 6 49.5272 6 48.4663V44.4663Z"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </div>
                <h3 class="mb-0">7.1k+</h3>
                <p class="fw-medium mb-0">
                  Support Tickets<br />
                  Resolved
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card border border-success shadow-none">
              <div class="card-body text-center">
                <div class="mb-4 text-success">
                  <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="User">
                      <path
                        id="Vector"
                        opacity="0.2"
                        d="M32.4999 8.52881C27.6437 8.52739 22.9012 9.99922 18.899 12.7499C14.8969 15.5005 11.8233 19.4006 10.0844 23.9348C8.34542 28.4691 8.02291 33.4242 9.15945 38.1456C10.296 42.867 12.8381 47.1326 16.4499 50.3788C17.9549 47.4151 20.2511 44.9261 23.0841 43.1875C25.917 41.4489 29.176 40.5287 32.4999 40.5288C30.5221 40.5288 28.5887 39.9423 26.9442 38.8435C25.2997 37.7447 24.018 36.1829 23.2611 34.3556C22.5043 32.5284 22.3062 30.5177 22.6921 28.5779C23.0779 26.6381 24.0303 24.8563 25.4289 23.4577C26.8274 22.0592 28.6092 21.1068 30.549 20.721C32.4888 20.3351 34.4995 20.5331 36.3268 21.29C38.154 22.0469 39.7158 23.3286 40.8146 24.9731C41.9135 26.6176 42.4999 28.551 42.4999 30.5288C42.4999 33.181 41.4464 35.7245 39.571 37.5999C37.6956 39.4752 35.1521 40.5288 32.4999 40.5288C35.8238 40.5287 39.0829 41.4489 41.9158 43.1875C44.7487 44.9261 47.045 47.4151 48.5499 50.3788C52.1618 47.1326 54.7039 42.867 55.8404 38.1456C56.977 33.4242 56.6545 28.4691 54.9155 23.9348C53.1766 19.4006 50.103 15.5005 46.1008 12.7499C42.0987 9.99922 37.3562 8.52739 32.4999 8.52881Z"
                        fill="currentColor" />
                      <path
                        id="Vector_2"
                        d="M32.5 40.5288C38.0228 40.5288 42.5 36.0517 42.5 30.5288C42.5 25.006 38.0228 20.5288 32.5 20.5288C26.9772 20.5288 22.5 25.006 22.5 30.5288C22.5 36.0517 26.9772 40.5288 32.5 40.5288ZM32.5 40.5288C29.1759 40.5288 25.9168 41.4477 23.0839 43.1866C20.2509 44.9255 17.9548 47.4149 16.45 50.3788M32.5 40.5288C35.8241 40.5288 39.0832 41.4477 41.9161 43.1866C44.7491 44.9255 47.0452 47.4149 48.55 50.3788M56.5 32.5288C56.5 45.7836 45.7548 56.5288 32.5 56.5288C19.2452 56.5288 8.5 45.7836 8.5 32.5288C8.5 19.274 19.2452 8.52881 32.5 8.52881C45.7548 8.52881 56.5 19.274 56.5 32.5288Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                    </g>
                  </svg>
                </div>
                <h3 class="mb-0">50k+</h3>
                <p class="fw-medium mb-0">
                  Join Creatives<br />
                  Community
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card border border-info shadow-none">
              <div class="card-body text-center">
                <div class="mb-4 text-info">
                  <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.2" d="M46.5001 10.5288H32.5001L20.2251 26.5288L32.5001 56.5288L60.5001 26.5288L46.5001 10.5288Z" fill="currentColor" />
                    <path d="M18.5 10.5288H46.5L60.5 26.5288L32.5 56.5288L4.5 26.5288L18.5 10.5288Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M33.2934 9.92012C33.1042 9.67343 32.8109 9.52881 32.5 9.52881C32.1891 9.52881 31.8958 9.67343 31.7066 9.92012L19.7318 25.5288H4.5C3.94772 25.5288 3.5 25.9765 3.5 26.5288C3.5 27.0811 3.94772 27.5288 4.5 27.5288H19.5537L31.5745 56.9075C31.7282 57.2833 32.094 57.5288 32.5 57.5288C32.906 57.5288 33.2718 57.2833 33.4255 56.9075L45.4463 27.5288H60.5C61.0523 27.5288 61.5 27.0811 61.5 26.5288C61.5 25.9765 61.0523 25.5288 60.5 25.5288H45.2682L33.2934 9.92012ZM42.7474 25.5288L32.5 12.1717L22.2526 25.5288H42.7474ZM21.7146 27.5288L32.5 53.8881L43.2854 27.5288H21.7146Z"
                      fill="currentColor" />
                  </svg>
                </div>
                <h3 class="mb-0">4.8/5</h3>
                <p class="fw-medium mb-0">
                  Highly Rated<br />
                  Products
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card border border-warning shadow-none">
              <div class="card-body text-center">
                <div class="mb-4 text-warning">
                  <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      opacity="0.2"
                      d="M14.125 50.9038C11.825 48.6038 13.35 43.7788 12.175 40.9538C11 38.1288 6.5 35.6538 6.5 32.5288C6.5 29.4038 10.95 27.0288 12.175 24.1038C13.4 21.1788 11.825 16.4538 14.125 14.1538C16.425 11.8538 21.25 13.3788 24.075 12.2038C26.9 11.0288 29.375 6.52881 32.5 6.52881C35.625 6.52881 38 10.9788 40.925 12.2038C43.85 13.4288 48.575 11.8538 50.875 14.1538C53.175 16.4538 51.65 21.2788 52.825 24.1038C54 26.9288 58.5 29.4038 58.5 32.5288C58.5 35.6538 54.05 38.0288 52.825 40.9538C51.6 43.8788 53.175 48.6038 50.875 50.9038C48.575 53.2038 43.75 51.6788 40.925 52.8538C38.1 54.0288 35.625 58.5288 32.5 58.5288C29.375 58.5288 27 54.0788 24.075 52.8538C21.15 51.6288 16.425 53.2038 14.125 50.9038Z"
                      fill="currentColor" />
                    <path
                      d="M43.5 26.5288L28.825 40.5288L21.5 33.5288M14.125 50.9038C11.825 48.6038 13.35 43.7788 12.175 40.9538C11 38.1288 6.5 35.6538 6.5 32.5288C6.5 29.4038 10.95 27.0288 12.175 24.1038C13.4 21.1788 11.825 16.4538 14.125 14.1538C16.425 11.8538 21.25 13.3788 24.075 12.2038C26.9 11.0288 29.375 6.52881 32.5 6.52881C35.625 6.52881 38 10.9788 40.925 12.2038C43.85 13.4288 48.575 11.8538 50.875 14.1538C53.175 16.4538 51.65 21.2788 52.825 24.1038C54 26.9288 58.5 29.4038 58.5 32.5288C58.5 35.6538 54.05 38.0288 52.825 40.9538C51.6 43.8788 53.175 48.6038 50.875 50.9038C48.575 53.2038 43.75 51.6788 40.925 52.8538C38.1 54.0288 35.625 58.5288 32.5 58.5288C29.375 58.5288 27 54.0788 24.075 52.8538C21.15 51.6288 16.425 53.2038 14.125 50.9038Z"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </div>
                <h3 class="mb-0">100%</h3>
                <p class="fw-medium mb-0">
                  Money Back<br />
                  Guarantee
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Us: Start -->
    <section id="landingContact" class="section-py bg-body landing-contact">
      <div class="container">
        <div class="text-center mb-4">
          <span class="badge bg-label-primary">Contact US</span>
        </div>
        <h4 class="text-center mb-1">
          <span class="position-relative fw-extrabold z-1"
            >Let's work </span>
          together
        </h4>
        <p class="text-center mb-12 pb-md-4">Any question or remark? just write us a message</p>
        <div class="row g-6">
          <div class="col-lg-5">
            <div class="contact-img-box position-relative border p-2 h-100"><div class="p-4 pb-2">
                <div class="row g-4">
                  <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="d-flex align-items-center">
                      <div class="badge bg-label-primary rounded p-1_5 me-3"><i class="icon-base bx bx-envelope icon-lg"></i></div>
                      <div>
                        <p class="mb-0">Email</p>
                        <h6 class="mb-0"><a href="mailto:example@gmail.com" class="text-heading">example@gmail.com</a></h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="d-flex align-items-center">
                      <div class="badge bg-label-success rounded p-1_5 me-3"><i class="icon-base bx bx-phone-call icon-lg"></i></div>
                      <div>
                        <p class="mb-0">Phone</p>
                        <h6 class="mb-0"><a href="tel:+1234-568-963" class="text-heading">+1234 568 963</a></h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="card h-100">
              <div class="card-body">
                <h4 class="mb-2">Send a message</h4>
                <p class="mb-6">
                  If you would like to discuss anything related to payment, account, licensing,<br class="d-none d-lg-block" />
                  partnerships, or have pre-sales questions, you’re at the right place.
                </p>
                <form>
                  <div class="row g-4">
                    <div class="col-md-6">
                      <label class="form-label" for="contact-form-fullname">Full Name</label>
                      <input type="text" class="form-control" id="contact-form-fullname" placeholder="john" />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="contact-form-email">Email</label>
                      <input type="text" id="contact-form-email" class="form-control" placeholder="johndoe@gmail.com" />
                    </div>
                    <div class="col-12">
                      <label class="form-label" for="contact-form-message">Message</label>
                      <textarea id="contact-form-message" class="form-control" rows="11" placeholder="Write a message"></textarea>
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary">Send inquiry</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact Us: End -->
  </div>
<!-- / Sections:End -->

<!-- Footer: Start -->
<footer class="landing-footer bg-body footer-text" style="background-color: #241d31;">
  <div class="footer-top position-relative overflow-hidden z-1">
    <div class="container">
      <div class="row gx-0 gy-6 g-lg-10">
        <div class="col-lg-5">
          <a href="landing-page.html" class="app-brand-link mb-6">
            <span class="app-brand-logo demo"> </span>
            <span class="app-brand-text demo text-white fw-bold ms-2 ps-1">Sneat</span>
          </a>
          <p class="footer-text footer-logo-description mb-6">Most developer friendly & highly customisable Admin Dashboard Template.</p>
          <form class="footer-form">
            <label for="footer-email" class="small">Subscribe to newsletter</label>
            <div class="d-flex mt-1">
              <input type="email" class="form-control rounded-0 rounded-start-bottom rounded-start-top" id="footer-email" placeholder="Your email" />
              <button type="submit" class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">Subscribe</button>
            </div>
          </form>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
          <h6 class="footer-title mb-6">Demos</h6>
          <ul class="list-unstyled">
            <li class="mb-4">
              <a href="../vertical-menu-template/" target="_blank" class="footer-link">Vertical Layout</a>
            </li>
            <li class="mb-4">
              <a href="../horizontal-menu-template/" target="_blank" class="footer-link">Horizontal Layout</a>
            </li>
            <li class="mb-4">
              <a href="../vertical-menu-template-bordered/" target="_blank" class="footer-link">Bordered Layout</a>
            </li>
            <li class="mb-4">
              <a href="../vertical-menu-template-semi-dark/" target="_blank" class="footer-link">Semi Dark Layout</a>
            </li>
            <li>
              <a href="../vertical-menu-template-dark/" target="_blank" class="footer-link">Dark Layout</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
          <h6 class="footer-title mb-6">Pages</h6>
          <ul class="list-unstyled">
            <li class="mb-4">
              <a href="pricing-page.html" class="footer-link">Pricing</a>
            </li>
            <li class="mb-4">
              <a href="payment-page.html" class="footer-link">Payment<span class="badge bg-primary ms-2">New</span></a>
            </li>
            <li class="mb-4">
              <a href="checkout-page.html" class="footer-link">Checkout</a>
            </li>
            <li class="mb-4">
              <a href="help-center-landing.html" class="footer-link">Help Center</a>
            </li>
            <!--<li>
              <a href="../vertical-menu-template/auth-login-cover.html" target="_blank" class="footer-link">Login/Register</a>
            </li>-->
          </ul>
        </div>
        <div class="col-lg-3 col-md-4">
          <h6 class="footer-title mb-6">Download our app</h6>
          <a href="javascript:void(0);" class="d-block mb-4"><img src="../../assets/img/front-pages/landing-page/apple-icon.png" alt="apple icon" /></a>
          <a href="javascript:void(0);" class="d-block"><img src="../../assets/img/front-pages/landing-page/google-play-icon.png" alt="google play icon" /></a>
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
        <a href="https://www.facebook.com/ThemeSelections/" class="me-4 text-white" target="_blank">
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
        </a>
      </div>
    </div>
  </div>
</footer>
<!-- Footer: End -->

    <script src="assets/pages-front/popper.js"></script>
    <script src="assets/pages-front/bootstrap.js"></script>
    <script src="assets/pages-front/autocomplete-js.js"></script>

    <script src="assets/pages-front/pickr.js"></script>
    

    
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/pages-front/nouislider.js"></script>
    <script src="assets/pages-front/swiper.js"></script>

    <!-- Main JS -->
    
      <script src="assets/pages-front/front-main.js"></script>
    

    <!-- Page JS -->
    <script src="assets/pages-front/front-page-landing.js"></script>

    <script>
    // Variables globales
    let currentPage = 1;
    const programsPerPage = 8;


    // Inicializar AOS
    AOS.init({
        duration: 800,
        offset: 100,
        once: true
    });

    // Función para mostrar/ocultar filtros adicionales
    function toggleMoreFilters() {
      const additionalFilters = document.getElementById('additional-filters');
      const moreFiltersIcon = document.getElementById('more-filters-icon');
      const moreFiltersText = document.getElementById('more-filters-text');
      
      additionalFilters.classList.toggle('d-none');
      
      if (additionalFilters.classList.contains('d-none')) {
        moreFiltersText.textContent = 'Más filtros';
        moreFiltersIcon.classList.replace('bx-chevron-up', 'bx-chevron-down');
      } else {
        moreFiltersText.textContent = 'Menos filtros';
        moreFiltersIcon.classList.replace('bx-chevron-down', 'bx-chevron-up');
      }
    }

    // Function to open modal with program details
    function openModal(programa) {
        // Set basic info
        document.getElementById('modalImage').src = programa.imagen_url || 'https://via.placeholder.com/1200x400';
        document.getElementById('modalTitle').textContent = programa.titulo;
        document.getElementById('modalTipo').textContent = programa.tipo;
        document.getElementById('modalCategoria').textContent = programa.categoria;
        
        // Set description with line breaks
        document.getElementById('modalDescription').innerHTML = 
            (programa.descripcion || 'Información no disponible').replace(/\n/g, '<br>');
        
        // Set details
        document.getElementById('modalUniversidad').textContent = programa.universidad || 'No especificada';
        document.getElementById('modalDuracion').textContent = programa.duracion || 'No especificada';
        document.getElementById('modalPais').textContent = programa.pais || 'No especificado';
        document.getElementById('modalModalidad').textContent = programa.modalidad || 'No especificada';
        
        // Set objectives with line breaks
        document.getElementById('modalObjetivos').innerHTML = 
            (programa.objetivos || 'Información no disponible').replace(/\n/g, '<br>');
        
        // Set study plan with line breaks
        document.getElementById('modalPlanEstudios').innerHTML = 
            (programa.plan_estudios || 'Información no disponible').replace(/\n/g, '<br>');
        
        // Set URL button
        const urlBtn = document.getElementById('modalUrl');
        if (programa.url) {
            urlBtn.href = programa.url;
            urlBtn.style.display = 'flex';
        } else {
            urlBtn.style.display = 'none';
        }

        // Show modal
        const modal = document.getElementById('programModal');
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        // Initialize Bootstrap accordion (if not already initialized)
        if (typeof bootstrap !== 'undefined') {
            new bootstrap.Collapse(document.getElementById('collapseDescription'), { toggle: false });
            new bootstrap.Collapse(document.getElementById('collapseObjetivos'), { toggle: false });
            new bootstrap.Collapse(document.getElementById('collapsePlan'), { toggle: false });
        }
    }

    // Función para cerrar el modal
    function closeModal() {
        const modal = document.getElementById('programModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Función para buscar programas con los filtros aplicados
    function buscarProgramas() {
        // Crear objeto con todos los posibles filtros
        const filtros = {
            nombre: document.getElementById('search-name').value.trim(),
            tipo: document.getElementById('filter-tipo').value,
            categoria: document.getElementById('filter-categoria').value,
            pais: document.getElementById('filter-pais').value,
            modalidad: document.getElementById('filter-modalidad').value,
            universidad: document.getElementById('filter-universidad').value
        };

        // Filtrar solo los parámetros que tienen valor
        const params = new URLSearchParams();
        for (const [key, value] of Object.entries(filtros)) {
            if (value) {
                params.append(key, value);
            }
        }

        // Mostrar loader
        Swal.fire({
            title: 'Buscando programas...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Realizar la petición AJAX
        fetch(`control/buscar_programas.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            Swal.close();
            
            if (data.error) {
                Swal.fire('Error', data.error, 'error');
                return;
            }

            const programas = data.programas || [];
            const totalResultados = data.total || 0;

            // Limpiar el grid actual
            const programsGrid = document.getElementById('programsGrid');
            programsGrid.innerHTML = '';
            
            // Mostrar los resultados
            if (programas.length === 0) {
                programsGrid.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-search fa-3x mb-3" style="color: #ccc;"></i>
                        <h3>No se encontraron programas</h3>
                        <p>Intenta con otros criterios de búsqueda</p>
                    </div>
                `;
            } else {
                mostrarProgramas(programas);
            }

            // Mostrar SweetAlert con el número de resultados
            let mensaje = '';
            let icono = '';

            if (totalResultados > 0) {
                const mostrando = Math.min(programas.length, 8);
                mensaje = `Se encontraron <b>${totalResultados}</b> programa${totalResultados === 1 ? '' : 's'} en total<br>`;
                mensaje += `Mostrando ${mostrando} de ${totalResultados}`;
                icono = 'success';
            } else {
                mensaje = 'No se encontraron programas que coincidan con los criterios de búsqueda';
                icono = 'info';
            }

            Swal.fire({
                title: 'Resultados de búsqueda',
                html: mensaje,
                icon: icono,
                timer: 4000, // Un poco más de tiempo para leer
                timerProgressBar: true,
                showConfirmButton: false,
                position: 'top-end',
                toast: true,
                customClass: {
                    popup: 'swal2-show-custom',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom'
                }
            });
            
            // Resetear la página actual
            currentPage = 1;
            
            // Mostrar u ocultar botón "Ver más" según resultados
            document.getElementById('loadMoreBtn').style.display = totalResultados > 8 ? 'block' : 'none';
        })
        .catch(error => {
            Swal.close();
            Swal.fire('Error', 'Ocurrió un error al buscar los programas', 'error');
            console.error('Error:', error);
        });
    }

    // Función para cargar más programas via AJAX
    function cargarMasProgramas() {
        currentPage++;
        
        // Obtener valores de los filtros (si hay alguno aplicado)
        const nombre = document.getElementById('search-name').value.trim();
        const tipo = document.getElementById('filter-tipo').value;
        const categoria = document.getElementById('filter-categoria').value;
        const pais = document.getElementById('filter-pais').value;
        const modalidad = document.getElementById('filter-modalidad').value;
        const universidad = document.getElementById('filter-universidad').value;

        // Mostrar loader en el botón
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        loadMoreBtn.innerHTML = '<span>Cargando...</span> <i class="fas fa-spinner fa-spin"></i>';
        loadMoreBtn.disabled = true;

        // Realizar la petición AJAX
        fetch('/control/cargar_masprogramas.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `page=${currentPage}&nombre=${encodeURIComponent(nombre)}&tipo=${encodeURIComponent(tipo)}&categoria=${encodeURIComponent(categoria)}&pais=${encodeURIComponent(pais)}&modalidad=${encodeURIComponent(modalidad)}&universidad=${encodeURIComponent(universidad)}`
        })
        .then(response => response.json())
        .then(data => {
            // Restaurar el botón
            loadMoreBtn.innerHTML = '<span>Ver más programas</span> <i class="fas fa-chevron-down"></i>';
            loadMoreBtn.disabled = false;
            
            if (data.error) {
                Swal.fire('Error', data.error, 'error');
                return;
            }

            // Mostrar los resultados
            if (data.length === 0) {
                loadMoreBtn.style.display = 'none';
                Swal.fire({
                    title: 'No hay más programas',
                    text: 'Has llegado al final de los resultados',
                    icon: 'info',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                mostrarProgramas(data);
            }
        })
        .catch(error => {
            // Restaurar el botón
            loadMoreBtn.innerHTML = '<span>Ver más programas</span> <i class="fas fa-chevron-down"></i>';
            loadMoreBtn.disabled = false;
            
            Swal.fire('Error', 'Ocurrió un error al cargar más programas', 'error');
            console.error('Error:', error);
        });
    }

    // Función para mostrar programas en el grid
    function mostrarProgramas(programas) {
        const contenedor = document.getElementById('programsGrid');
        
        programas.forEach(programa => {
            const card = `
                <div class="program-card" data-aos="fade-up">
                    <img src="${programa.imagen_url || 'https://via.placeholder.com/400x250'}"
                        alt="${programa.titulo}" class="program-image">
                    <div class="program-content">
                        <h3 class="program-title">${programa.titulo}</h3>
                        <p class="program-description">${programa.descripcion || 'Sin descripción disponible'}</p>
                        <div class="program-details">
                            <span class="program-detail">
                                <i class="fas fa-graduation-cap"></i>
                                ${programa.tipo}
                            </span>
                            <span class="program-detail">
                                <i class="fas fa-university"></i>
                                ${programa.universidad}
                            </span>
                        </div>
                        <button class="program-button" onclick='openModal(${JSON.stringify(programa)})'>
                            <span>Ver detalles</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            `;
            contenedor.insertAdjacentHTML('beforeend', card);
        });
    }

    // Función para cargar la galería de universidades
    function cargarGaleria() {
        // Mostrar loader mientras carga
        const galleryGrid = document.getElementById('galleryGrid');
        galleryGrid.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Cargando universidades...</div>';

        fetch('/control/galeria_universidad_handler.php')
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Error al cargar datos');
                }

                galleryGrid.innerHTML = '';

                if (data.universidades && data.universidades.length > 0) {
                    data.universidades.forEach(universidad => {
                        const imageUrl = universidad.imagen_url || 'img/default-university.jpg';
                        const galleryItem = document.createElement('div');
                        galleryItem.className = 'gallery-item';
                        galleryItem.setAttribute('data-aos', 'fade-up');
                        
                        galleryItem.innerHTML = `
                            <a href="${imageUrl}"
                              data-fancybox="gallery"
                              data-caption="${universidad.nombreuniversidad}"
                              data-thumb="${imageUrl}">
                                <img src="${imageUrl}" 
                                    alt="${universidad.nombreuniversidad}" 
                                    class="gallery-image">
                                <div class="gallery-overlay">
                                    <h3 class="gallery-title">${universidad.nombreuniversidad}</h3>
                                    <p class="gallery-description">${universidad.descripcion || universidad.pais || 'Convenio activo'}</p>
                                </div>
                            </a>
                        `;
                        galleryGrid.appendChild(galleryItem);
                    });

                    // Inicializar Fancybox si está disponible
                    if (typeof Fancybox !== 'undefined') {
                        Fancybox.bind("[data-fancybox]", {
                            // Opciones de Fancybox
                        });
                    }
                } else {
                    galleryGrid.innerHTML = '<p class="no-results">No se encontraron universidades con convenio activo.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                galleryGrid.innerHTML = '<p class="error-message">Error al cargar la galería de universidades.</p>';
            });
    }

    // Función para cargar testimonios
    function cargarTestimonios() {
        const contenedor = document.getElementById('contenedor-testimonios');
        if (!contenedor) return;

        // Mostrar loader
        contenedor.innerHTML = '<div class="loading-testimonios"><i class="fas fa-spinner fa-spin"></i> Cargando testimonios...</div>';

        fetch('control/testimonios_handler.php')
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Error al cargar testimonios');
                }

                contenedor.innerHTML = '';

                if (data.testimonios && data.testimonios.length > 0) {
                    data.testimonios.forEach(testimonio => {
                        const slide = document.createElement('div');
                        slide.className = 'swiper-slide';
                        
                        slide.innerHTML = `
                            <div class="testimonial-card">
                                <div class="testimonial-content">
                                    <div class="quote-icon">
                                        <i class="fas fa-quote-right"></i>
                                    </div>
                                    <p class="testimonial-text">${escapeHtml(testimonio.testimonio)}</p>
                                    <div class="testimonial-author">
                                        <img src="${escapeHtml(testimonio.imagen_url || 'https://via.placeholder.com/60x60')}"
                                            alt="${escapeHtml(testimonio.nombre_persona)}"
                                            class="author-image">
                                        <div class="author-info">
                                            <h4>${escapeHtml(testimonio.nombre_persona)}</h4>
                                            <p>${escapeHtml(testimonio.programa_cursado || 'Programa destacado')}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        contenedor.appendChild(slide);
                    });

                    // Inicializar/reiniciar Swiper después de cargar los testimonios
                    if (typeof Swiper !== 'undefined') {
                        initTestimonialsSwiper();
                    }
                } else {
                    contenedor.innerHTML = '<div class="no-testimonials">No hay testimonios disponibles actualmente</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                contenedor.innerHTML = '<div class="error-testimonios">Error al cargar testimonios. <button onclick="cargarTestimonios()">Reintentar</button></div>';
            });
    }

    // Función para inicializar Swiper
    function initTestimonialsSwiper() {
        new Swiper('.testimonials-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    }


    // Event Listeners para el modal
    document.addEventListener('DOMContentLoaded', function() {

        // Cargar la galería al inicio
        cargarGaleria();

        // Cargar testimonios al inicio
        cargarTestimonios();

        // Event Listeners para el modal
        // Cerrar con el botón X
        const closeButton = document.querySelector('.close');
        if (closeButton) {
            closeButton.addEventListener('click', function(e) {
                e.stopPropagation();
                closeModal();
            });
        }

        // Cerrar cuando se hace clic fuera del modal
        const modal = document.getElementById('programModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // Cerrar con la tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    });

    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.testimonials-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    });
    </script>
    
  </body>
</html>

