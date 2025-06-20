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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Doctorados/</span> Registros</h4>

    <!--<div class="card mb-4">
        <h5 class="card-header">Filtros de búsqueda</h5>
            <div class="card-body">
                <div class="row gx-3 gy-2 align-items-center">
                    <div class="col-md-3">
                      <label class="form-label" for="selectTypeOpt">Universidad</label>
                      <select id="selectTypeOpt" class="form-select color-dropdown">
                        <option value="bg-primary" selected="">Seleccionar</option>
                        <option value="bg-secondary">CESUMA</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label" for="selectPlacement">Tipo</label>
                      <select class="form-select placement-dropdown" id="selectPlacement">
                        <option value="top-0 start-0">Maestría</option>
                        <option value="top-0 start-50 translate-middle-x">Posgrado</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label" for="showToastPlacement">&nbsp;</label>
                      <button class="btn btn-primary d-block">Buscar</button>
                    </div>
                </div>
            </div>
    </div>-->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Lista de Doctorados</h5> <!-- Título a la izquierda -->
            <div>
              <a class="btn btn-secondary" href='importar_pro.php?origen=doctorado'>Importar</a>
              <a class="btn btn-primary" href='registrar_doctorado.php'>Registrar Doctorado</a>  
          </div>
        </div>
        <div class="table-responsive text-nowrap" style="margin: 20px;">
            <table id="tabla-doctorados" class="datatables-basic table table-bordered table-responsive dataTable dtr-column collapsed" >
                <thead>
                    <tr >
                        <th>ID</th>
                        <th>Título</th>
                        <th>Universidad</th>                        
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta a la base de datos - ORDEN DESCENDENTE POR ID
                    $stmt = $conn->query("SELECT * FROM data_programas WHERE tipo = 'Doctorado' ORDER BY id DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>" . ($row['titulo'] ?? 'N/A') . "</td>
                                <td>" . ($row['universidad'] ?? 'N/A') . "</td>                                
                                <td>" . ($row['pais'] ?? 'N/A') . "</td>
                                <td><span class='badge " . ($row['estado_programa'] == 'Publicado' ? 'bg-label-success' : 'bg-label-secondary') . "'>" . ($row['estado_programa'] ?? 'N/A') . "</span></td>
                                <td>
                                    <button
                                        type='button'
                                        class='btn btn-secondary btn-sm btn-ver'
                                        data-bs-toggle='modal'
                                        data-bs-target='#modalCenter'
                                        data-id='{$row['id']}'
                                        data-titulo='{$row['titulo']}'
                                        data-descripcion='" . ($row['descripcion'] ?? '') . "'
                                        data-tipo='" . ($row['tipo'] ?? '') . "'
                                        data-categoria='" . ($row['categoria'] ?? '') . "'
                                        data-universidad='" . ($row['universidad'] ?? '') . "'
                                        data-pais='" . ($row['pais'] ?? '') . "'
                                        data-modalidad='" . ($row['modalidad'] ?? '') . "'
                                        data-duracion='" . ($row['duracion'] ?? '') . "'
                                        data-imagen='" . ($row['imagen_url'] ?? '') . "'
                                        data-objetivos='" . ($row['objetivos'] ?? '') . "'
                                        data-plan='" . ($row['plan_estudios'] ?? '') . "'
                                        data-url='" . ($row['url'] ?? '') . "'
                                        data-estado='" . ($row['estado_programa'] ?? '') . "'
                                        data-fecha='" . ($row['fecha_modificada'] ?? '') . "'
                                    >
                                        <i class='bx bx-show'></i>
                                    </button>
                                        <a href='registrar_doctorado.php?id={$row['id']}' class='btn btn-info btn-sm'><i class='bx bx-edit'></i>
                                    </a>
                                        <a href='../control/pr_eliminar_doctorado.php?id={$row['id']}' class='btn btn-danger btn-sm'><i class='bx bx-trash'></i>
                                    </a>
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
                  <h5 class="modal-title" id="modalCenterTitle">Detalles de la Maestría</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="row g-2">
                      <div class="col-md-6">
                          <label for="id" class="form-label">ID</label>
                          <input type="text" id="id" class="form-control" readonly>
                      </div>
                      <div class="col-md-6">
                          <label for="titulo" class="form-label">Título</label>
                          <input type="text" id="titulo" class="form-control" readonly>
                      </div>
                  </div>

                  <div class="mb-3">
                      <label for="descripcion" class="form-label">Descripción</label>
                      <textarea id="descripcion" class="form-control" rows="3" readonly></textarea>
                  </div>

                  <div class="row g-2">
                      <div class="col-md-6">
                          <label for="tipo" class="form-label">Tipo</label>
                          <input type="text" id="tipo" class="form-control" readonly>
                      </div>
                      <div class="col-md-6">
                          <label for="categoria" class="form-label">Categoría</label>
                          <input type="text" id="categoria" class="form-control" readonly>
                      </div>
                  </div>

                  <div class="row g-2">
                      <div class="col-md-6">
                          <label for="universidad" class="form-label">Universidad</label>
                          <input type="text" id="universidad" class="form-control" readonly>
                      </div>
                      <div class="col-md-6">
                          <label for="pais" class="form-label">País</label>
                          <input type="text" id="pais" class="form-control" readonly>
                      </div>
                  </div>

                  <div class="row g-2">
                      <div class="col-md-6">
                          <label for="modalidad" class="form-label">Modalidad</label>
                          <input type="text" id="modalidad" class="form-control" readonly>
                      </div>
                      <div class="col-md-6">
                          <label for="duracion" class="form-label">Duración</label>
                          <input type="text" id="duracion" class="form-control" readonly>
                      </div>
                  </div>

                  <div class="mb-3">
                      <label for="imagen_url" class="form-label">Imagen URL</label>
                      <input type="text" id="imagen_url" class="form-control" readonly>
                  </div>

                  <div class="mb-3">
                      <label for="objetivos" class="form-label">Objetivos</label>
                      <textarea id="objetivos" class="form-control" rows="3" readonly></textarea>
                  </div>

                  <div class="mb-3">
                      <label for="plan_estudios" class="form-label">Plan de Estudios</label>
                      <textarea id="plan_estudios" class="form-control" rows="3" readonly></textarea>
                  </div>

                  <div class="mb-3">
                      <label for="url" class="form-label">URL</label>
                      <input type="text" id="url" class="form-control" readonly>
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
            $('#tabla-doctorados').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                scrollX: true,  // Cambiado a true para mejor manejo horizontal
                scrollCollapse: true,
                paging: true,
                lengthMenu: [15, 20, 30, 50],
                order: [[0, 'desc']],
                columnDefs: [
                    { responsivePriority: 1, targets: 1 }, // Prioridad a Título
                    { responsivePriority: 2, targets: 2 }, // Prioridad a Universidad
                    { responsivePriority: 3, targets: 3 }, // Prioridad a País
                    { 
                        targets: 5, // Columna de Acciones
                        orderable: false,
                        width: '8%'
                    },
                    { 
                        targets: [0, 4], // ID y Estado
                        responsivePriority: 4 
                    }
                ],
                dom: '<"top"lf>rt<"bottom"ip>',
                initComplete: function() {
                    $('.dataTables_scrollBody').css('min-height', '300px');
                }
            });
        });


        document.addEventListener("DOMContentLoaded", function () {
          document.querySelectorAll(".btn-ver").forEach(button => {
              button.addEventListener("click", function () {
                  document.getElementById("id").value = this.dataset.id;
                  document.getElementById("titulo").value = this.dataset.titulo;
                  document.getElementById("descripcion").value = this.dataset.descripcion;
                  document.getElementById("tipo").value = this.dataset.tipo;
                  document.getElementById("categoria").value = this.dataset.categoria;
                  document.getElementById("universidad").value = this.dataset.universidad;
                  document.getElementById("pais").value = this.dataset.pais;
                  document.getElementById("modalidad").value = this.dataset.modalidad;
                  document.getElementById("duracion").value = this.dataset.duracion;
                  document.getElementById("imagen_url").value = this.dataset.imagen;
                  document.getElementById("objetivos").value = this.dataset.objetivos;
                  document.getElementById("plan_estudios").value = this.dataset.plan;
                  document.getElementById("url").value = this.dataset.url;
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
                        title: '¿Eliminar Doctorado?',
                        html: `¿Estás seguro que deseas eliminar el doctorado <b>"${maestriaNombre}"</b>?<br><br>Esta acción no se puede deshacer.`,
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

