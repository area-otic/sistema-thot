<?php 
include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thoth Education - Tu futuro académico comienza aquí</title>

    <!-- Meta tags para SEO -->
    <meta name="description" content="Thoth Education - Descubre las mejores maestrías y programas de especialización">
    <meta name="keywords" content="educación, maestrías, especialización, programas académicos">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- Swiper -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <link rel="stylesheet" href="assets/css/front-css.css" />
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

</head>

<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav-container">
            <a href="#" class="logo">
                <i class="fas fa-graduation-cap"></i>
                Thoth Education
            </a>
        </nav>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Tu Futuro Académico Comienza Aquí</h1>
            <p>Descubre las mejores maestrías y programas de especialización</p>

            <!-- Filters -->
            <div class="filters-container">
                <div class="row">
                    <!-- Filtros principales -->
                    <div class="col-md-4 col-12 filter-group">
                        <label for="search-name">Nombre del Programa</label>
                        <input type="text" id="search-name" class="filter-input" placeholder="Ej: Maestría en...">
                    </div>
                    <div class="col-md-4 col-12 filter-group">
                        <label for="filter-tipo">Tipo de Programa</label>
                        <select id="filter-tipo" class="filter-input">
                            <option value="">Todos los tipos</option>
                            <?php
                            $tipos = $conn->query("SELECT DISTINCT tipo FROM data_maestrias WHERE tipo IS NOT NULL");
                            while($tipo = $tipos->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.htmlspecialchars($tipo['tipo']).'">'.htmlspecialchars($tipo['tipo']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 filter-group">
                        <label for="filter-categoria">Categoría</label>
                        <select id="filter-categoria" class="filter-input">
                            <option value="">Todas las categorías</option>
                            <?php
                            $categorias = $conn->query("SELECT DISTINCT categoria FROM data_maestrias WHERE categoria IS NOT NULL");
                            while($categoria = $categorias->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.htmlspecialchars($categoria['categoria']).'">'.htmlspecialchars($categoria['categoria']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            
                <!-- Botón más filtros -->
                <div class="text-center my-3">
                    <button onclick="toggleMoreFilters()" class="toggle-filters-button">
                        <span id="more-filters-text">Más filtros</span>
                        <i id="more-filters-icon" class="fas fa-chevron-down"></i>
                    </button>
                </div>
            
                <!-- Filtros adicionales (inicialmente ocultos) -->
                <div id="additional-filters" class="row hidden">
                    <div class="col-md-4 col-12 filter-group">
                        <label for="filter-pais">País</label>
                        <select id="filter-pais" class="filter-input">
                            <option value="">Todos los países</option>
                            <?php
                            $paises = $conn->query("SELECT DISTINCT pais FROM data_maestrias WHERE pais IS NOT NULL");
                            while($pais = $paises->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.htmlspecialchars($pais['pais']).'">'.htmlspecialchars($pais['pais']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 filter-group">
                        <label for="filter-modalidad">Modalidad</label>
                        <select id="filter-modalidad" class="filter-input">
                            <option value="">Todas las modalidades</option>
                            <?php
                            $modalidades = $conn->query("SELECT DISTINCT modalidad FROM data_maestrias WHERE modalidad IS NOT NULL");
                            while($modalidad = $modalidades->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.htmlspecialchars($modalidad['modalidad']).'">'.htmlspecialchars($modalidad['modalidad']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 filter-group">
                        <label for="filter-universidad">Universidad</label>
                        <select id="filter-universidad" class="filter-input">
                            <option value="">Todas las universidades</option>
                            <?php
                            $universidades = $conn->query("SELECT DISTINCT universidad FROM data_maestrias WHERE universidad IS NOT NULL");
                            while($universidad = $universidades->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.htmlspecialchars($universidad['universidad']).'">'.htmlspecialchars($universidad['universidad']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            
                <div class="text-center mt-3">
                    <button onclick="buscarProgramas()" class="search-button">
                        <i class="fas fa-search"></i>
                        Buscar Programas
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs-section" id="programas">
        <div class="section-container">
            <div class="section-title" data-aos="fade-up">
                <h2>Programas Educativos</h2>
                <p>Encuentra el programa perfecto para tu desarrollo profesional</p>
            </div>

            <div id="programsGrid" class="programs-grid">
                <?php
                // Obtener programas de la base de datos
                $stmt = $conn->query("SELECT * FROM data_maestrias WHERE estado_programa = 'Publicado' LIMIT 8");
                while ($programa = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                    <div class="program-card" data-aos="fade-up">
                        <img src="'.htmlspecialchars($programa['imagen_url'] ?? 'https://via.placeholder.com/400x250').'"
                            alt="'.htmlspecialchars($programa['titulo']).'" class="program-image">
                        <div class="program-content">
                            <h3 class="program-title">'.htmlspecialchars($programa['titulo']).'</h3>
                            <p class="program-description">'.htmlspecialchars($programa['descripcion'] ?? 'Sin descripción disponible').'</p>
                            <div class="program-details">
                                <span class="program-detail">
                                    <i class="fas fa-graduation-cap"></i>
                                    '.htmlspecialchars($programa['tipo']).'
                                </span>
                                <span class="program-detail">
                                    <i class="fas fa-university"></i>
                                    '.htmlspecialchars($programa['universidad']).'
                                </span>
                            </div>
                            <button class="program-button" onclick=\'openModal('.json_encode($programa).')\'>
                                <span>Ver detalles</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>';
                }
                ?>
            </div>

            <div class="load-more-container">
                <button id="loadMoreBtn" class="load-more" onclick="cargarMasProgramas()">
                    <span>Ver más programas</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="programModal" class="modal">
        <div class="modal-contentMaestrias">
            <div class="modal-headerMaestria">
                <span class="close">&times;</span>
            </div>
            <div class="modal-bodyMaestria">
                <div class="modal-hero">
                    <img id="modalImage" src="" alt="Programa">
                    <div class="modal-overlay">
                        <h2 id="modalTitle" class="modal-title"></h2>
                        <div class="modal-tags">
                            <span id="modalTipo" class="tag"></span>
                            <span id="modalCategoria" class="tag"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-info-container row">
                    <div class="modal-sidebar col-md-4 col-12">
                        <div class="modal-details">
                            <div class="detail-item">
                                <i class="fas fa-university"></i>
                                <div class="detail-content">
                                    <div class="detail-label">Universidad</div>
                                    <div id="modalUniversidad" class="detail-value"></div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <div class="detail-content">
                                    <div class="detail-label">Duración</div>
                                    <div id="modalDuracion" class="detail-value"></div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="detail-content">
                                    <div class="detail-label">País</div>
                                    <div id="modalPais" class="detail-value"></div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-laptop"></i>
                                <div class="detail-content">
                                    <div class="detail-label">Modalidad</div>
                                    <div id="modalModalidad" class="detail-value"></div>
                                </div>
                            </div>
                        </div>
                        <a id="modalUrl" href="#" target="_blank" class="program-apply-btn">
                            <span>Conoce más</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="modal-main-content col-md-8 col-12">
                        <h3 style="font-size:18px;">SOBRE EL PROGRAMA</h3>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription" aria-expanded="true" aria-controls="collapseDescription">
                                        <i class="fa-solid fa-file-alt me-2"></i> Descripción del Programa
                                    </button>
                                </h2>
                                <div id="collapseDescription" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                    <div class="accordion-body" id="modalDescription"></div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseObjetivos" aria-expanded="false" aria-controls="collapseObjetivos">
                                        <i class="fa-solid fa-bullseye me-2"></i> Objetivos del Programa
                                    </button>
                                </h2>
                                <div id="collapseObjetivos" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body" id="modalObjetivos"></div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlan" aria-expanded="false" aria-controls="collapsePlan">
                                        <i class="fa-solid fa-book-open me-2"></i> Plan de Estudios
                                    </button>
                                </h2>
                                <div id="collapsePlan" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body" id="modalPlanEstudios"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <section class="gallery-section" id="galeria">
        <div class="section-container">
            <div class="section-title" data-aos="fade-up">
                <h2>Nuestra Galería</h2>
                <p>Universidades con convenio activo</p>
            </div>
            
            <div id="galleryGrid" class="gallery-grid">
                <!-- Los elementos se cargarán dinámicamente aquí -->
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="section-container">
            <div class="section-title" data-aos="fade-up">
                <h2>Experiencias de Estudiantes</h2>
                <p>Lo que dicen nuestros estudiantes sobre su experiencia</p>
            </div>

            <div class="testimonials-slider swiper" data-aos="fade-up">
                <div class="swiper-wrapper" id="contenedor-testimonios">
                    <?php
                    // Consulta para obtener testimonios publicados
                    $stmt = $conn->query("SELECT * FROM data_testimonios WHERE estado = 'Publicado' ORDER BY fecha_creacion DESC");
                    
                    while ($testimonio = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <div class="testimonial-content">
                                    <div class="quote-icon">
                                        <i class="fas fa-quote-right"></i>
                                    </div>
                                    <p class="testimonial-text">'.htmlspecialchars($testimonio['testimonio']).'</p>
                                    <div class="testimonial-author">
                                        <img src="'.htmlspecialchars($testimonio['imagen_url'] ?? 'https://via.placeholder.com/60x60').'"
                                            alt="'.htmlspecialchars($testimonio['nombre_persona']).'"
                                            class="author-image">
                                        <div class="author-info">
                                            <h4>'.htmlspecialchars($testimonio['nombre_persona']).'</h4>
                                            <p>'.htmlspecialchars($testimonio['programa_cursado'] ?? 'Programa destacado').'</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    
                    // Mostrar mensaje si no hay testimonios
                    if ($stmt->rowCount() === 0) {
                        echo '<div class="no-testimonials">No hay testimonios disponibles actualmente</div>';
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contacto">
        <div class="section-container">
            <div class="contact-container">
                <div class="contact-info" data-aos="fade-right">
                    <div class="section-title">
                        <h2>¿Necesitas Ayuda?</h2>
                        <p>Estamos aquí para guiarte en tu camino académico</p>
                    </div>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h3>Email</h3>
                                <p>info@thotheducation.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h3>Horario de Atención</h3>
                                <p>Lun - Vie: 9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iframe-wrapper">
                    <iframe
                    src="https://b24-atnnfq.bitrix24.site/crm_form_iq60u/"
                    style="width: 100%; height: 600px; border: none;"
                    title="Formulario Bitrix24"
                    loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Thoth Education</h3>
                <p>Conectando estudiantes con las mejores oportunidades educativas en todo el mundo.</p>
            </div>
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#programas">Programas</a></li>
                    <li><a href="#galeria">Galería</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Thoth Education. Todos los derechos reservados.</p>
        </div>
    </footer>


<!-- Bootstrap (antes de cualquier script que lo use) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scripts -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Variables globales
let currentPage = 1;
const programsPerPage = 8;


// Inicializar AOS
AOS.init({
    duration: 800,
    offset: 100,
    once: true
});

// Función para mostrar/ocultar filtros adicionales
function toggleMoreFilters() {
    const additionalFilters = document.getElementById('additional-filters');
    const icon = document.getElementById('more-filters-icon');
    const text = document.getElementById('more-filters-text');
    
    additionalFilters.classList.toggle('hidden');
    
    if (additionalFilters.classList.contains('hidden')) {
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
        text.textContent = 'Más filtros';
    } else {
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
        text.textContent = 'Menos filtros';
    }
}

function mostrarProgramas(programas) {
        const contenedor = document.getElementById('programsGrid');
        contenedor.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos elementos
        
        programas.forEach(programa => {
            const card = `
                <div class="col-12 col-lg-4 col-xl-3" data-aos="fade-up">
                    <div class="card h-100 shadow border">
                        <div class="rounded-2 text-center mb-4 position-relative" style="height: 220px;">
                            <img class="img-fluid-program w-100 h-100 rounded-top" 
                                src="${programa.imagen_url || 'https://via.placeholder.com/400x250'}" 
                                alt="${programa.titulo}">
                            <div class="position-absolute bottom-0 start-0 w-100 h-50" style="background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 100%); pointer-events: none;"></div>
                        </div>
                        <div class="card-body p-5 pt-2 d-flex flex-column">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-4 pe-xl-4 pe-xxl-0">
                                    <span class="badge bg-label-info">${programa.tipo || 'Maestría'}</span>
                                </div>
                                <a class="h5" style="line-height:1.25rem" href="#"><strong>${programa.titulo}</strong></a>
                                <p class="mt-1" style="color:#95A5A6">${(programa.descripcion || 'Programa académico de excelencia').substring(0, 100)}...</p>
                            </div>                          
                            <div class="pt-2">
                                <div class="mt-auto"> 
                                    <div class="row g-3 justify-content-center mb-3">
                                        <div class="col-6 d-flex">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-info">
                                                        <i class="icon-base bx bx-location-map icon-lg"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-nowrap">${programa.pais || 'Online'}</h6>
                                                    <small>Ubicación</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-info">
                                                        <i class="icon-base bx bx-building icon-lg"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">${programa.universidad || 'Universidad'}</h6>
                                                    <small>Institución</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                <button class="w-100 btn btn-label-primary d-flex align-items-center" >
                                    <span class="me-2">Ver detalles</span>
                                    <i class="icon-base bx bx-chevron-right icon-sm lh-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            contenedor.insertAdjacentHTML('beforeend', card);
        });
    }
    
// Function to open modal with program details
function openModal(programa) {
    // Set basic info
    document.getElementById('modalImage').src = programa.imagen_url || 'https://via.placeholder.com/1200x400';
    document.getElementById('modalTitle').textContent = programa.titulo;
    document.getElementById('modalTipo').textContent = programa.tipo;
    document.getElementById('modalCategoria').textContent = programa.categoria;
    
    // Set description with line breaks
    document.getElementById('modalDescription').innerHTML = 
        (programa.descripcion || 'Información no disponible').replace(/\n/g, '<br>');
    
    // Set details
    document.getElementById('modalUniversidad').textContent = programa.universidad || 'No especificada';
    document.getElementById('modalDuracion').textContent = programa.duracion || 'No especificada';
    document.getElementById('modalPais').textContent = programa.pais || 'No especificado';
    document.getElementById('modalModalidad').textContent = programa.modalidad || 'No especificada';
    
    // Set objectives with line breaks
    document.getElementById('modalObjetivos').innerHTML = 
        (programa.objetivos || 'Información no disponible').replace(/\n/g, '<br>');
    
    // Set study plan with line breaks
    document.getElementById('modalPlanEstudios').innerHTML = 
        (programa.plan_estudios || 'Información no disponible').replace(/\n/g, '<br>');
    
    // Set URL button
    const urlBtn = document.getElementById('modalUrl');
    if (programa.url) {
        urlBtn.href = programa.url;
        urlBtn.style.display = 'flex';
    } else {
        urlBtn.style.display = 'none';
    }

    // Show modal
    const modal = document.getElementById('programModal');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Initialize Bootstrap accordion (if not already initialized)
    if (typeof bootstrap !== 'undefined') {
        new bootstrap.Collapse(document.getElementById('collapseDescription'), { toggle: false });
        new bootstrap.Collapse(document.getElementById('collapseObjetivos'), { toggle: false });
        new bootstrap.Collapse(document.getElementById('collapsePlan'), { toggle: false });
    }
}

// Función para cerrar el modal
function closeModal() {
    const modal = document.getElementById('programModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Función para buscar programas con los filtros aplicados
function buscarProgramas() {
    // Crear objeto con todos los posibles filtros
    const filtros = {
        nombre: document.getElementById('search-name').value.trim(),
        tipo: document.getElementById('filter-tipo').value,
        categoria: document.getElementById('filter-categoria').value,
        pais: document.getElementById('filter-pais').value,
        modalidad: document.getElementById('filter-modalidad').value,
        universidad: document.getElementById('filter-universidad').value
    };

    // Filtrar solo los parámetros que tienen valor
    const params = new URLSearchParams();
    for (const [key, value] of Object.entries(filtros)) {
        if (value) {
            params.append(key, value);
        }
    }

    // Mostrar loader
    Swal.fire({
        title: 'Buscando programas...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Realizar la petición AJAX
    fetch(`control/buscar_programas.php?${params.toString()}`)
    .then(response => response.json())
    .then(data => {
        Swal.close();
        
        if (data.error) {
            Swal.fire('Error', data.error, 'error');
            return;
        }

        const programas = data.programas || [];
        const totalResultados = data.total || 0;

        // Limpiar el grid actual
        const programsGrid = document.getElementById('programsGrid');
        programsGrid.innerHTML = '';
        
        // Mostrar los resultados
        if (programas.length === 0) {
            programsGrid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-3x mb-3" style="color: #ccc;"></i>
                    <h3>No se encontraron programas</h3>
                    <p>Intenta con otros criterios de búsqueda</p>
                </div>
            `;
        } else {
            mostrarProgramas(programas);
        }

        // Mostrar SweetAlert con el número de resultados
        let mensaje = '';
        let icono = '';

        if (totalResultados > 0) {
            const mostrando = Math.min(programas.length, 8);
            mensaje = `Se encontraron <b>${totalResultados}</b> programa${totalResultados === 1 ? '' : 's'} en total<br>`;
            mensaje += `Mostrando ${mostrando} de ${totalResultados}`;
            icono = 'success';
        } else {
            mensaje = 'No se encontraron programas que coincidan con los criterios de búsqueda';
            icono = 'info';
        }

        Swal.fire({
            title: 'Resultados de búsqueda',
            html: mensaje,
            icon: icono,
            timer: 4000, // Un poco más de tiempo para leer
            timerProgressBar: true,
            showConfirmButton: false,
            position: 'top-end',
            toast: true,
            customClass: {
                popup: 'swal2-show-custom',
                title: 'swal2-title-custom',
                content: 'swal2-content-custom'
            }
        });
        
        // Resetear la página actual
        currentPage = 1;
        
        // Mostrar u ocultar botón "Ver más" según resultados
        document.getElementById('loadMoreBtn').style.display = totalResultados > 8 ? 'block' : 'none';
    })
    .catch(error => {
        Swal.close();
        Swal.fire('Error', 'Ocurrió un error al buscar los programas', 'error');
        console.error('Error:', error);
    });
}

// Función para cargar más programas via AJAX
function cargarMasProgramas() {
    currentPage++;
    
    // Obtener valores de los filtros (si hay alguno aplicado)
    const nombre = document.getElementById('search-name').value.trim();
    const tipo = document.getElementById('filter-tipo').value;
    const categoria = document.getElementById('filter-categoria').value;
    const pais = document.getElementById('filter-pais').value;
    const modalidad = document.getElementById('filter-modalidad').value;
    const universidad = document.getElementById('filter-universidad').value;

    // Mostrar loader en el botón
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    loadMoreBtn.innerHTML = '<span>Cargando...</span> <i class="fas fa-spinner fa-spin"></i>';
    loadMoreBtn.disabled = true;

    // Realizar la petición AJAX
    fetch('control/cargar_masprogramas.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `page=${currentPage}&nombre=${encodeURIComponent(nombre)}&tipo=${encodeURIComponent(tipo)}&categoria=${encodeURIComponent(categoria)}&pais=${encodeURIComponent(pais)}&modalidad=${encodeURIComponent(modalidad)}&universidad=${encodeURIComponent(universidad)}`
    })
    .then(response => response.json())
    .then(data => {
        // Restaurar el botón
        loadMoreBtn.innerHTML = '<span>Ver más programas</span> <i class="fas fa-chevron-down"></i>';
        loadMoreBtn.disabled = false;
        
        if (data.error) {
            Swal.fire('Error', data.error, 'error');
            return;
        }

        // Mostrar los resultados
        if (data.length === 0) {
            loadMoreBtn.style.display = 'none';
            Swal.fire({
                title: 'No hay más programas',
                text: 'Has llegado al final de los resultados',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            mostrarProgramas(data);
        }
    })
    .catch(error => {
        // Restaurar el botón
        loadMoreBtn.innerHTML = '<span>Ver más programas</span> <i class="fas fa-chevron-down"></i>';
        loadMoreBtn.disabled = false;
        
        Swal.fire('Error', 'Ocurrió un error al cargar más programas', 'error');
        console.error('Error:', error);
    });
}

// Función para mostrar programas en el grid
function mostrarProgramas(programas) {
    const contenedor = document.getElementById('programsGrid');
    
    programas.forEach(programa => {
        const card = `
            <div class="program-card" data-aos="fade-up">
                <img src="${programa.imagen_url || 'https://via.placeholder.com/400x250'}"
                     alt="${programa.titulo}" class="program-image">
                <div class="program-content">
                    <h3 class="program-title">${programa.titulo}</h3>
                    <p class="program-description">${programa.descripcion || 'Sin descripción disponible'}</p>
                    <div class="program-details">
                        <span class="program-detail">
                            <i class="fas fa-graduation-cap"></i>
                            ${programa.tipo}
                        </span>
                        <span class="program-detail">
                            <i class="fas fa-university"></i>
                            ${programa.universidad}
                        </span>
                    </div>
                    <button class="program-button" onclick='openModal(${JSON.stringify(programa)})'>
                        <span>Ver detalles</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        `;
        contenedor.insertAdjacentHTML('beforeend', card);
    });
}

    // Función para cargar la galería de universidades
    function cargarGaleria() {
        // Mostrar loader mientras carga
        const galleryGrid = document.getElementById('galleryGrid');
        galleryGrid.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Cargando universidades...</div>';

        fetch('control/galeria_universidad_handler.php')
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Error al cargar datos');
                }

                galleryGrid.innerHTML = '';

                if (data.universidades && data.universidades.length > 0) {
                    data.universidades.forEach(universidad => {
                        const imageUrl = universidad.imagen_url || 'img/default-university.jpg';
                        const galleryItem = document.createElement('div');
                        galleryItem.className = 'gallery-item';
                        galleryItem.setAttribute('data-aos', 'fade-up');
                        
                        galleryItem.innerHTML = `
                            <a href="${imageUrl}"
                            data-fancybox="gallery"
                            data-caption="${universidad.nombreuniversidad}"
                            data-thumb="${imageUrl}">
                                <img src="${imageUrl}" 
                                    alt="${universidad.nombreuniversidad}" 
                                    class="gallery-image">
                                <div class="gallery-overlay">
                                    <h3 class="gallery-title">${universidad.nombreuniversidad}</h3>
                                    <p class="gallery-description">${universidad.descripcion || universidad.pais || 'Convenio activo'}</p>
                                </div>
                            </a>
                        `;
                        galleryGrid.appendChild(galleryItem);
                    });

                    // Inicializar Fancybox si está disponible
                    if (typeof Fancybox !== 'undefined') {
                        Fancybox.bind("[data-fancybox]", {
                            // Opciones de Fancybox
                        });
                    }
                } else {
                    galleryGrid.innerHTML = '<p class="no-results">No se encontraron universidades con convenio activo.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                galleryGrid.innerHTML = '<p class="error-message">Error al cargar la galería de universidades.</p>';
            });
    }

    // Función para inicializar Swiper
    function initTestimonialsSwiper() {
        new Swiper('.testimonials-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    }


    // Event Listeners para el modal
    document.addEventListener('DOMContentLoaded', function() {

        // Cargar la galería al inicio
        cargarGaleria();

        // Cargar testimonios al inicio
        cargarTestimonios();

        // Event Listeners para el modal
        // Cerrar con el botón X
        const closeButton = document.querySelector('.close');
        if (closeButton) {
            closeButton.addEventListener('click', function(e) {
                e.stopPropagation();
                closeModal();
            });
        }

        // Cerrar cuando se hace clic fuera del modal
        const modal = document.getElementById('programModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // Cerrar con la tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    });

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.testimonials-slider', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        slidesPerView: 1,
        spaceBetween: 20,
        breakpoints: {
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            }
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
</body>
</html>


