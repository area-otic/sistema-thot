<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html
  lang="es" class="light-style customizer-hide" dir="ltr"
  data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Inicio Sesión</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
   <!-- Icons. Uncomment required icon fonts -->
   <link rel="stylesheet" href="assets/fonts/boxicons.css" />

    <link rel="stylesheet" href="assets/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/page-auth.css" />
    <!-- Helpers -->
    <script src="assets/js/helpers.js"></script>
    
    <script src="assets/js/config.js"></script>

    <style>
      body {
        background-image: url('assets/img/thot-fondo.webp');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    </style>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                      <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                          <g id="Icon" transform="translate(27.000000, 15.000000)">
                            <g id="Mask" transform="translate(0.000000, 8.000000)">
                              <mask id="mask-2" fill="white">
                                <use xlink:href="#path-1"></use>
                              </mask>
                              <use fill="#696cff" xlink:href="#path-1"></use>
                              <g id="Path-3" mask="url(#mask-2)">
                                <use fill="#696cff" xlink:href="#path-3"></use>
                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                              </g>
                              <g id="Path-4" mask="url(#mask-2)">
                                <use fill="#696cff" xlink:href="#path-4"></use>
                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                              </g>
                            </g>
                            <g
                              id="Triangle"
                              transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
                            >
                              <use fill="#696cff" xlink:href="#path-5"></use>
                              <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                            </g>
                          </g>
                        </g>
                      </g>
                    </svg>
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder">THOT Education</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2"><strong>Bienvenido 🎓</strong></h4>
              <p class="mb-4">Por favor, ingresa tu usuario y contraseña para acceder:</p>

              <?php
                // Mostrar mensajes de error si existen
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    echo '<div class="alert alert-danger mb-3">';
                    if ($error == 'credenciales_incorrectas' || $error == 'usuario_no_encontrado') {
                        echo 'Usuario o contraseña incorrectos.';
                    } elseif ($error == 'cuenta_inactiva') {
                        echo 'Tu cuenta no está activa. Contacta al administrador.';
                    } elseif ($error == 'campos_vacios') {
                        echo 'Por favor, completa todos los campos.';
                    } elseif ($error == 'error_bd') {
                        echo 'Error en el sistema. Por favor, intenta más tarde.';
                    }
                    echo '</div>';
                }
              ?>

              <form id="formAuthentication" class="mb-3" action="control/login_proceso.php" method="POST">
                <div class="mb-3">
                  <label for="username" class="form-label">Nombre de usuario</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Ingresa tu nombre usuario" autofocus required />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Contraseña</label>                
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me">Recordarlo </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Iniciar Sesión</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
  </body>
</html>
