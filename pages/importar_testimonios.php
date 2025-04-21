<?php 
include '../control/check_session.php';
include '../includes/header.php'; 
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h2>Importar Testimonios desde Archivo</h2>
    
    <div class="card">
        <h5 class="card-header">Cargar Archivo</h5>
        <div class="card-body">
            <form action="../control/pr_importacion_testimonios.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="archivo" class="form-label">Seleccione archivo (Excel o CSV)</label>
                    <input class="form-control" type="file" name="archivo" id="archivo" accept=".csv, .xls, .xlsx" required>
                    <div class="form-text">Formatos aceptados: CSV, XLS, XLSX. El archivo debe contener los campos: título, descripción, tipo, categoría, universidad, país, modalidad, duración, imagen_url, objetivos, plan_estudios, url, estado, encargado</div>
                </div>
                <button type="submit" class="btn btn-primary">Importar Datos</button>
            </form>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>