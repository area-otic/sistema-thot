          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0"> ©
                  <script>
                      document.write(new Date().getFullYear());
                  </script>
                  , realizado por SSB
                </div>
              </div>
          </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js-->
    <script src="../assets/js/jquery.js"></script> 
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/perfect-scrollbar.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/menu.js"></script>
    
    <script src="../assets/js/main.js"></script>
    

    <script>
      function confirmarCerrarSesion(event) {
          event.preventDefault();
          
          Swal.fire({
              title: '¿Cerrar sesión?',
              text: "¿Estás seguro que deseas salir del sistema?",
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, cerrar sesión',
              cancelButtonText: 'Cancelar',
              reverseButtons: true
          }).then((result) => {
              if (result.isConfirmed) {
                  // Redirigir al logout.php si confirma
                  window.location.href = '../control/logout.php';
              }
          });
      }
    </script>

    <!-- Page JS 
    <script src="../assets/js/dashboards-analytics.js"></script>-->

    <!-- Place this tag in your head or just before your close body tag. 
    <script async defer src="https://buttons.github.io/buttons.js"></script>-->
  </body>
</html>
