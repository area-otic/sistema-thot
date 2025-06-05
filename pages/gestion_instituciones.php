<?php 
include '../includes/db.php';
include '../control/check_session.php';
include '../includes/header.php';

?>

<div class="container-xxl flex-grow-1 container-p-y">
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Universidades/</span> Registros</h4>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Lista de Universidades</h5> <!-- Título a la izquierda -->
            <div>
              <a class="btn btn-primary" href='registrar_instituciones.php'>Registrar Institución</a>  
          </div>
        </div>
        <div class="table-responsive " style="margin: 20px;">
            <table id="tabla-universidad" class="datatables-basic table table-bordered table-responsive dataTable dtr-column collapsed" >
                <thead>
                    <tr >
                        <th>ID</th>
                        <th>Universidad</th>
                        <th>País</th>
                        <th>Convenio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta a la base de datos - ORDEN DESCENDENTE POR ID
                    $stmt = $conn->query("SELECT * FROM data_instituciones ORDER BY id DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>" . ($row['nombre'] ?? 'N/A') . "</td>
                                <td>" . ($row['pais'] ?? 'N/A') . "</td>
                                <td><span class='badge " . ($row['convenio'] == 'Si' ? 'bg-label-info' : 'bg-label-secondary') . "'>" . ($row['convenio'] ?? 'N/A') . "</span></td>
                                
                                <td><span class='badge " . ($row['estado'] == 'Activo' ? 'bg-label-success' : 'bg-label-secondary') . "'>" . ($row['estado'] ?? 'N/A') . "</span></td>
                                <td>
                                    <button
                                        type='button'
                                        class='btn btn-secondary btn-sm btn-ver'
                                        data-bs-toggle='modal'
                                        data-bs-target='#modalCenter'
                                        data-id='{$row['id']}'
                                        data-universidad='{$row['nombre']}'
                                        data-descripcion='" . ($row['descripcion'] ?? '') . "'
                                        data-imagen='" . ($row['imagen_url'] ?? '') . "'
                                        data-pais='" . ($row['pais'] ?? '') . "'
                                        data-ciudad='" . ($row['ciudad'] ?? '') . "'
                                        data-sitioweb='" . ($row['url'] ?? '') . "'
                                        data-tipo='" . ($row['tipo'] ?? '') . "'
                                        data-convenio='" . ($row['convenio'] ?? '') . "'
                                        data-estado='" . ($row['estado'] ?? '') . "'
                                        data-fecha='" . ($row['fecha_modificada'] ?? '') . "'
                                        data-encargado='" . ($row['user_encargado'] ?? '') . "'
                                    >
                                        <i class='bx bx-show'></i>
                                    </button>
                                        <a href='registrar_instituciones.php?id={$row['id']}' class='btn btn-info btn-sm'><i class='bx bx-edit'></i>
                                    </a>                                       
                                    " . (
                                            ($_SESSION['tipo_usuario'] === 'Gestor' || $_SESSION['tipo_usuario'] === 'Administrador') ?
                                            "<a href='../control/pr_eliminar_universidad.php?id={$row['id']}' class='btn btn-danger btn-sm'><i class='bx bx-trash'></i></a>" :
                                            ""
                                        ) . "
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Detalles de la Universidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" id="id" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nombreuniversidad" class="form-label">Nombre de la Universidad</label>
                            <input type="text" id="nombreuniversidad" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea id="descripcion" class="form-control" rows="3" readonly></textarea>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="tipo_institucion" class="form-label">Tipo de Institución</label>
                            <input type="text" id="tipo_institucion" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="convenio" class="form-label">Convenio</label>
                            <input type="text" id="convenio" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="pais" class="form-label">País</label>
                            <input type="text" id="pais" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="sitio_web" class="form-label">Sitio Web</label>
                            <input type="text" id="sitio_web" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" id="estado" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_modificada" class="form-label">Última Actualización</label>
                            <input type="text" id="fecha_modificada" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="imagen_url" class="form-label">Imagen URL</label>
                        <input type="text" id="imagen_url" class="form-control" readonly>
                        <div id="imagen-preview" class="mt-2 text-center"></div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="user_encargado" class="form-label">Registrado/Modificado por</label>
                            <input type="text" id="user_encargado" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
                            <input type="text" id="fecha_creacion" class="form-control" readonly>
                        </div>
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

<script>
        $(document).ready(function() {
            $('#tabla-universidad').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' // Español
                },
                responsive: true, // Hace que la tabla sea responsive
                ordering: true, // Permite ordenar las columnas
                searching: true, // Habilita la búsqueda
                paging: true, // Habilita la paginación
                lengthMenu: [15, 20, 30, 50], // Opciones de cantidad de registros por página
                order: [[0, 'desc']], // Orden inicial: columna 0 (ID) descendente
                columnDefs: [
                    { orderable: true, targets: [0] }, // ID ordenable
                    { orderable: true, targets: [1] }, // Título ordenable
                    { orderable: true, targets: [2] }, // Universidad ordenable
                    { orderable: true, targets: [3] }, // Tipo ordenable
                    { orderable: true, targets: [4] }  // Categoría ordenable
                ]
            });
        });


        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".btn-ver").forEach(button => {
                button.addEventListener("click", function () {
                    // Datos básicos
                    document.getElementById("id").value = this.dataset.id;
                    document.getElementById("nombreuniversidad").value = this.dataset.universidad;
                    document.getElementById("descripcion").value = this.dataset.descripcion;
                    document.getElementById("tipo_institucion").value = this.dataset.tipo;
                    document.getElementById("convenio").value = this.dataset.convenio;
                    document.getElementById("pais").value = this.dataset.pais;
                    document.getElementById("sitio_web").value = this.dataset.sitioweb;
                    document.getElementById("estado").value = this.dataset.estado;
                    document.getElementById("fecha_modificada").value = this.dataset.fecha;
                    document.getElementById("imagen_url").value = this.dataset.imagen;
                    document.getElementById("user_encargado").value = this.dataset.encargado;
                    
                    // Mostrar vista previa de la imagen si existe
                    const imagenPreview = document.getElementById("imagen-preview");
                    if (this.dataset.imagen) {
                        imagenPreview.innerHTML = `<img src="${this.dataset.imagen}" alt="Imagen de la universidad" style="max-height: 150px;" class="img-thumbnail">`;
                    } else {
                        imagenPreview.innerHTML = '<div class="text-muted">No hay imagen disponible</div>';
                    }
                    
                    // Actualizar título del modal con el nombre de la universidad
                    document.getElementById("modalCenterTitle").textContent = `Detalles: ${this.dataset.universidad}`;
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Configuración de SweetAlert
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger mx-2',
                    cancelButton: 'btn btn-secondary mx-2'
                },
                buttonsStyling: false
            });

            // Evento para todos los botones de eliminar
            document.querySelectorAll('.btn-danger').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteUrl = this.getAttribute('href');
                    const maestriaNombre = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                    
                    swalWithBootstrapButtons.fire({
                        title: '¿Eliminar Institución?',
                        html: `¿Estás seguro que deseas eliminar la institución <b>"${maestriaNombre}"</b>?<br><br>Esta acción no se puede deshacer.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true,
                        focusConfirm: false,
                        focusCancel: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirigir a la URL de eliminación si se confirma
                            window.location.href = deleteUrl;
                        }
                    });
                });
            });
        });
  </script>
<!-- Vendors JS -->
<script src="../assets/vendor/datatables-bootstrap5.js"></script>
<!-- Page JS -->
<script src="../assets/js/tables-datatables-basic.js"></script>

<?php include '../includes/footer.php'; ?>

