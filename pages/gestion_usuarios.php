<?php 
include '../includes/db.php';
include '../control/check_session.php';
include '../includes/header.php';

?>

<div class="container-xxl flex-grow-1 container-p-y">

<!--<div class="row g-6 mb-6" style="margin-bottom:20px;">
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span class="text-heading">Sesiones</span>
              <div class="d-flex align-items-center my-1">
                <h4 class=" text-success mb-0 me-2">21,459</h4>
              </div>
              <small class="mb-0">Total Usuarios</small>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="icon-base bx bx-group icon-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span class="text-heading">Usuarios Activos</span>
              <div class="d-flex align-items-center my-1">
                <h4 class="mb-0 me-2">19,860</h4>
              </div>
              <small class="mb-0">Análisis de la ultima semana</small>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-success">
                <i class="icon-base bx bx-user-check icon-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>-->

  
    <?php
    // Mostrar mensajes de éxito o error
        if(isset($_GET['success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    '.htmlspecialchars($_GET['success']).'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }

        if(isset($_GET['error'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    '.htmlspecialchars($_GET['error']).'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    ?>
    <div class="card" style="margin-top: 20px;">
        <div class="card-header border-bottom">
        <h5 class="card-title mb-0">Búsqueda</h5>
        <div class="d-flex justify-content-between align-items-center row pt-4 gap-md-0 g-6">
            <div class="col-md-4 user_role">
                <select id="UserRole" class="form-select text-capitalize">
                    <option value="">Select Role</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Gestor">Gestor</option>
                    <option value="Suscriptor">Suscriptor</option>
                </select></div>
            <div class="col-md-4 user_status">
                <select id="FilterTransaction" class="form-select text-capitalize">
                    <option value="">Select Status</option>
                    <option value="Pending" class="text-capitalize">Pending</option>
                    <option value="Active" class="text-capitalize">Active</option>
                    <option value="Inactive" class="text-capitalize">Inactive</option>
                </select>
            </div>
            <div class="col-md-4">
            <a href="registrar_usuario.php" class="btn btn-primary add-new">
                <span>
                    <i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i>
                    <span class="d-none d-sm-inline-block">Nuevo Usuario</span>
                </span>
            </a> 
            </div>
            
        </div>
        </div>
    
        <hr class="my-0" />
        <div class="table-responsive text-nowrap" style="margin: 20px;">
        <table id="tabla-usuarios" class="datatables-basic table table-bordered table-responsive dataTable dtr-column collapsed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $stmt = $conn->query("SELECT * FROM data_usuarios ORDER BY id DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>" . ($row['nombreusuario'] ?? 'N/A') . "</td>
                                <td>" . ($row['nombre'] ?? 'N/A') . "</td>
                                <td>" . ($row['apellido'] ?? 'N/A') . "</td>
                                <td>" . ($row['tipousuario'] ?? 'N/A') . "</td>
                                <td><span class='badge " . ($row['estado'] == 'Activo' ? 'bg-label-success' : 'bg-label-secondary') . "'>" . ($row['estado'] ?? 'N/A') . "</span></td>
                                <td>
                                    <button
                                        type='button'
                                        class='btn btn-secondary btn-sm btn-ver'
                                        data-bs-toggle='modal'
                                        data-bs-target='#modalCenter'
                                        data-id='{$row['id']}'
                                        data-nombre='" . ($row['nombre'] ?? '') . "'
                                        data-apellido='" . ($row['apellido'] ?? '') . "'
                                        data-username='" . ($row['nombreusuario'] ?? '') . "'
                                        data-email='" . ($row['email'] ?? '') . "'
                                        data-tipousuario='" . ($row['tipousuario'] ?? '') . "'
                                        data-estado='" . ($row['estado'] ?? '') . "'
                                    >
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <!-- Cambiar el enlace de editar para que abra el offcanvas -->
                                    <a href='registrar_usuario.php?id={$row['id']}' class='btn btn-info btn-sm'><i class='bx bx-edit'></i>
                                    </a>
                                    <a href='../control/pr_eliminar_usuario.php?id={$row['id']}' class='btn btn-danger btn-sm'><i class='bx bx-trash'></i></a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para ver detalles -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Detalles del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ID</label>
                            <input type="text" id="modal-id" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <input type="text" id="modal-estado" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre de Usuario</label>
                            <input type="text" id="modal-username" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Usuario</label>
                            <input type="text" id="modal-tipousuario" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" id="modal-nombre" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" id="modal-apellido" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" id="modal-email" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#tabla-usuarios').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: true,
                ordering: true,
                searching: true,
                paging: true,
                lengthMenu: [15, 20, 30, 50],
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: true, targets: [0, 1, 2, 3, 4, 5] }
                ]
            });

            // Configuración del modal
            document.querySelectorAll(".btn-ver").forEach(button => {
                button.addEventListener("click", function() {
                    document.getElementById("modal-id").value = this.dataset.id;
                    document.getElementById("modal-nombre").value = this.dataset.nombre;
                    document.getElementById("modal-apellido").value = this.dataset.apellido;
                    document.getElementById("modal-username").value = this.dataset.username;
                    document.getElementById("modal-email").value = this.dataset.email;
                    document.getElementById("modal-estado").value = this.dataset.estado;
                    document.getElementById("modal-tipousuario").value = this.dataset.tipousuario;
                    
                });
            });

            // Configuración de SweetAlert para eliminar
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger mx-2',
                    cancelButton: 'btn btn-secondary mx-2'
                },
                buttonsStyling: false
            });

             // Mostrar automáticamente el offcanvas en modo edición
             const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('id');
            
            if (userId) {
                var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasUserForm'));
                offcanvas.show();
            }

            // Manejar eliminación de usuarios
            document.querySelectorAll('.btn-danger').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteUrl = this.getAttribute('href');
                    const usuarioNombre = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                    
                    swalWithBootstrapButtons.fire({
                        title: '¿Eliminar Usuario?',
                        html: `¿Estás seguro que deseas eliminar el usuario <b>"${usuarioNombre}"</b>?<br><br>Esta acción no se puede deshacer.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true,
                        focusConfirm: false,
                        focusCancel: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = deleteUrl;
                        }
                    });
                });
            });
             
        });
</script>

<?php include '../includes/footer.php'; ?>