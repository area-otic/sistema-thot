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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Categorías/</span> Registros</h4>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Lista de Categorías de programas</h5>
            <div>
              <a class="btn btn-primary" href='registrar_categoria.php'>Registrar Categoría</a>  
          </div>
        </div>
        <div class="table-responsive " style="margin: 20px;">
            <table id="tabla-categorias" class="datatables-basic table table-bordered table-responsive dataTable dtr-column collapsed" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta a la base de datos - ORDEN DESCENDENTE POR ID
                    $stmt = $conn->query("SELECT * FROM data_categorias_programas ORDER BY id DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>" . ($row['nombre'] ?? 'N/A') . "</td>
                                <td>" . (substr($row['descripcion'] ?? 'N/A', 0, 50)) . "...</td>
                                <td><span class='badge " . ($row['estado'] == 'Activo' ? 'bg-label-success' : 'bg-label-secondary') . "'>" . ($row['estado'] ?? 'N/A') . "</span></td>
                                <td>
                                    <button
                                        type='button'
                                        class='btn btn-secondary btn-sm btn-ver'
                                        data-bs-toggle='modal'
                                        data-bs-target='#modalCenter'
                                        data-id='{$row['id']}'
                                        data-nombre='{$row['nombre']}'
                                        data-descripcion='" . ($row['descripcion'] ?? '') . "'
                                        data-estado='" . ($row['estado'] ?? '') . "'
                                        data-fecha-creacion='" . ($row['fecha_creacion'] ?? '') . "'
                                        data-fecha-modificada='" . ($row['fecha_modificada'] ?? '') . "'
                                    >
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <a href='registrar_categoria.php?id={$row['id']}' class='btn btn-info btn-sm'><i class='bx bx-edit'></i></a>
                                    <a href='../control/pr_eliminar_categoria.php?id={$row['id']}' class='btn btn-danger btn-sm'><i class='bx bx-trash'></i></a>
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
                    <h5 class="modal-title" id="modalCenterTitle">Detalles de la Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" id="id" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea id="descripcion" class="form-control" rows="5" readonly></textarea>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" id="estado" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
                            <input type="text" id="fecha_creacion" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="fecha_modificada" class="form-label">Última Modificación</label>
                            <input type="text" id="fecha_modificada" class="form-control" readonly>
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
        $('#tabla-categorias').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' // Español
            },
            responsive: true,
            ordering: true,
            searching: true,
            paging: true,
            lengthMenu: [15, 20, 30, 50],
            order: [[0, 'desc']], // Orden inicial: columna 0 (ID) descendente
            columnDefs: [
                { orderable: true, targets: [0] }, // ID ordenable
                { orderable: true, targets: [1] }, // Nombre ordenable
                { orderable: true, targets: [2] }, // Descripción ordenable
                { orderable: true, targets: [3] }, // Estado ordenable
                { orderable: false, targets: [4] }  // Acciones no ordenable
            ]
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-ver").forEach(button => {
            button.addEventListener("click", function () {
                // Datos básicos
                document.getElementById("id").value = this.dataset.id;
                document.getElementById("nombre").value = this.dataset.nombre;
                document.getElementById("descripcion").value = this.dataset.descripcion;
                document.getElementById("estado").value = this.dataset.estado;
                document.getElementById("fecha_creacion").value = this.dataset.fechaCreacion;
                document.getElementById("fecha_modificada").value = this.dataset.fechaModificada;
                
                // Formatear fechas si es necesario
                if(this.dataset.fechaCreacion) {
                    const fechaCreacion = new Date(this.dataset.fechaCreacion);
                    document.getElementById("fecha_creacion").value = fechaCreacion.toLocaleString();
                }
                
                if(this.dataset.fechaModificada) {
                    const fechaModificada = new Date(this.dataset.fechaModificada);
                    document.getElementById("fecha_modificada").value = fechaModificada.toLocaleString();
                }
                
                // Actualizar título del modal
                document.getElementById("modalCenterTitle").textContent = `Detalles: ${this.dataset.nombre}`;
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Configuración de SweetAlert para eliminar
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
                const categoriaNombre = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                
                swalWithBootstrapButtons.fire({
                    title: '¿Eliminar Categoría?',
                    html: `¿Estás seguro que deseas eliminar la categoría <b>"${categoriaNombre}"</b>?<br><br>Esta acción no se puede deshacer.`,
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