<?php 
include '../control/check_session.php';
include '../includes/header.php';

$origen = $_GET['origen'] ?? ''; // Capturamos el parámetro de origen

// Puedes usar esta variable para mostrar contenido diferente o guardarla en sesión
if ($origen === 'maestria') {
    // Aquí puedes establecer una variable de sesión o lógica específica para maestrías
    $_SESSION['origen_importacion'] = 'maestria';
}
else{
    // Aquí puedes establecer una variable de sesión o lógica específica para doctorados
    $_SESSION['origen_importacion'] = 'doctorado';

}
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h2>Importar Programas desde Archivo</h2>
    
    <div class="card">
        <h5 class="card-header">Cargar Archivo</h5>
        <div class="card-body">
            <form action="../control/pr_importacion_pro.php" method="POST" enctype="multipart/form-data" id="uploadForm">
                <div class="mb-3">
                    <label for="archivo" class="form-label">Seleccione archivo CSV</label>
                    <input class="form-control" type="file" name="archivo" id="archivo" accept=".csv" required>
                    <div class="form-text">Formato aceptado: CSV. El archivo debe contener los campos: título, descripción, tipo, categoría, universidad, país, modalidad, duración, imagen_url, objetivos, plan_estudios, url, estado, encargado</div>
                    <div class="form-text">Esto incluye subida de Fecha de subida, solo pueden subirlo los administradores</div>
                </div>
                <button type="submit" class="btn btn-primary">Importar Datos</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Validación adicional en el cliente
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('archivo');
    const file = fileInput.files[0];
    
    if (!file) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor seleccione un archivo',
        });
        return;
    }
    
    const extension = file.name.split('.').pop().toLowerCase();
    
    if (extension !== 'csv') {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Formato incorrecto',
            text: 'Solo se permiten archivos CSV',
            confirmButtonText: 'Entendido'
        }).then(() => {
            fileInput.value = ''; // Limpiar el input después de cerrar el alert
        });
    }
});
</script>

<?php include '../includes/footer.php'; ?>