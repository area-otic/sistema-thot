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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Contenido/</span> Testimonios</h4>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Lista de Testimonios</h5>
            <div>
                <a class="btn btn-secondary" href='importar_testimonios.php'>Importar</a>
                <a class="btn btn-primary" href='registrar_testimonio.php'>Nuevo Testimonio</a>  
            </div>
        </div>
        <div class="table-responsive text-nowrap" style="margin: 20px;">
            <table id="tabla-testimonios" class="datatables-basic table table-bordered table-responsive dataTable dtr-column collapsed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th>País</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta a la base de datos - ORDEN DESCENDENTE POR ID
                    $stmt = $conn->query("SELECT * FROM data_testimonios ORDER BY id DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>" . ($row['nombre_persona'] ?? 'N/A') . "</td>
                                <td>" . ($row['programa_cursado'] ?? 'N/A') . "</td>
                                <td>" . ($row['pais'] ?? 'N/A') . "</td>
                                <td><span class='badge " . ($row['estado'] == 'Publicado' ? 'bg-label-success' : 'bg-label-secondary') . "'>" . ($row['estado'] ?? 'N/A') . "</span></td>
                                <td>" . date('d/m/Y', strtotime($row['fecha_creacion'])) . "</td>
                                <td>
                                    <button
                                        type='button'
                                        class='btn btn-secondary btn-sm btn-ver'
                                        data-bs-toggle='modal'
                                        data-bs-target='#modalCenter'
                                        data-id='{$row['id']}'
                                        data-nombre='{$row['nombre_persona']}'
                                        data-imagen='" . ($row['imagen_url'] ?? '') . "'
                                        data-testimonio='" . ($row['testimonio'] ?? '') . "'
                                        data-programa='" . ($row['programa_cursado'] ?? '') . "'
                                        data-pais='" . ($row['pais'] ?? '') . "'
                                        data-estado='" . ($row['estado'] ?? '') . "'
                                        data-fecha='" . ($row['fecha_creacion'] ?? '') . "'
                                    >
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <a href='registrar_testimonio.php?id={$row['id']}' class='btn btn-info btn-sm'><i class='bx bx-edit'></i></a>
                                    " . (
                                            ($_SESSION['tipo_usuario'] === 'Gestor' || $_SESSION['tipo_usuario'] === 'Administrador') ?
                                            "<a href='../control/pr_eliminar_testimonio.php?id={$row['id']}' class='btn btn-danger btn-sm'><i class='bx bx-trash'></i></a>" :
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

    <!-- Modal para ver detalles -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Detalles del Testimonio</h5>
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
                            <label class="form-label">Nombre</label>
                            <input type="text" id="modal-nombre" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Programa Cursado</label>
                            <input type="text" id="modal-programa" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">País</label>
                            <input type="text" id="modal-pais" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha</label>
                            <input type="text" id="modal-fecha" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Imagen</label>
                        <div id="modal-imagen-container">
                            <img id="modal-imagen" src="" class="img-thumbnail" style="max-height: 200px; display: none;">
                        </div>
                        <input type="text" id="modal-imagen-url" class="form-control mt-2" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Testimonio</label>
                        <textarea id="modal-testimonio" class="form-control" rows="5" readonly></textarea>
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
            $('#tabla-testimonios').DataTable({
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
                    document.getElementById("modal-testimonio").value = this.dataset.testimonio;
                    document.getElementById("modal-programa").value = this.dataset.programa;
                    document.getElementById("modal-pais").value = this.dataset.pais;
                    document.getElementById("modal-estado").value = this.dataset.estado;
                    document.getElementById("modal-fecha").value = this.dataset.fecha;
                    document.getElementById("modal-imagen-url").value = this.dataset.imagen;
                    
                    // Mostrar imagen si existe
                    const imgElement = document.getElementById("modal-imagen");
                    if(this.dataset.imagen) {
                        imgElement.src = this.dataset.imagen;
                        imgElement.style.display = 'block';
                    } else {
                        imgElement.style.display = 'none';
                    }
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

            document.querySelectorAll('.btn-danger').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteUrl = this.getAttribute('href');
                    const testimonioNombre = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                    
                    swalWithBootstrapButtons.fire({
                        title: '¿Eliminar Testimonio?',
                        html: `¿Estás seguro que deseas eliminar el testimonio de <b>"${testimonioNombre}"</b>?<br><br>Esta acción no se puede deshacer.`,
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