<?php 
include '../includes/db.php';
include '../control/check_session.php';
include '../includes/header.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
   
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Configuración /</span> Cuenta</h4>

    <div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Cuenta</a>
            </li>
        </ul>
        <div class="card mb-4">
        <h5 class="card-header">Detalles del Perfil</h5>

        <hr class="my-0" />
        <div class="card-body">
            <form id="formcuentausuario" method="POST" onsubmit="return false">
            <div class="row">
                <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Nombre</label>
                <input
                    class="form-control" type="text" id="firstName" name="firstName" value="John" autofocus />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="lastName" class="form-label">Apellido</label>
                    <input class="form-control" type="text" name="lastName" id="lastName" value="Doe" />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input class="form-control" type="text" id="email" name="email" value="john.doe@example.com" placeholder="john.doe@example.com" />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="organization" class="form-label">nombreusuario</label>
                    <input type="text" class="form-control" id="organization" name="organization" value="ThemeSelection" />
                </div>
                <div class="mb-3 col-md-6 form-password-toggle">
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
                
                <div class="mb-3 col-md-6">
                    <label for="language" class="form-label">Tipo de Usuario</label>
                    <select id="language" class="select2 form-select">
                        <option value="">Select </option>
                        <option value="Administrador">Administrador</option>
                        <option value="Gestor">Gestor</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="estado" class="form-label">Estado de Usuario</label>
                    <select id="estado" class="select2 form-select">
                        <option value="">Selecciona un estado </option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
            </div>
            </form>
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

    <?php include '../includes/footer.php'; ?>