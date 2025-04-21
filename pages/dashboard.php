<?php 
include '../control/check_session.php';
include '../includes/header.php';
?>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Bienvenida <?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']); ?>! 🎉</h5>
                          <p class="mb-4">
                            Sistemas de Gestión de THOT.
                            Almacena y gestiona toda la documentacion de la plataforma de THOT.
                          </p>

                          <a href="https://thoth.education/" class="btn btn-sm btn-outline-primary">Ver Página de Thot</a>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="../assets/img/bienvenida-img.svg"
                            height="160"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
            <!-- / Content -->


<?php include '../includes/footer.php'; ?>