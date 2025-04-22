
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maestría en Administración de Negocios | Universidad Thoth</title>
    <meta name="description" content="Potencia tu carrera con nuestra Maestría en Administración de Negocios. Programa completo con enfoque práctico y profesores de alto nivel.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --azul-marino: #002366;
            --azul-marino-claro: #1a4b8c;
            --naranja: #FF7F11;
            --naranja-claro: #FF9E40;
            --gris-claro: #f8f9fa;
            --blanco: #ffffff;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        /* Header */
        .navbar {
            background-color: var(--azul-marino);
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--blanco) !important;
            font-size: 1.5rem;
        }
        
        .navbar-brand span {
            color: var(--naranja);
        }
        
        .nav-link {
            color: var(--blanco) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--naranja) !important;
        }
        
        .btn-primary {
            background-color: var(--naranja);
            border-color: var(--naranja);
            color: var(--azul-marino);
            font-weight: 600;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--naranja-claro);
            border-color: var(--naranja-claro);
            color: var(--azul-marino);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 35, 102, 0.8), rgba(0, 35, 102, 0.9)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        /* Features */
        .features {
            padding: 80px 0;
            background-color: var(--gris-claro);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--naranja);
            margin-bottom: 20px;
        }
        
        .feature-card {
            background: var(--blanco);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        /* Program Details */
        .program-details {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-weight: 700;
            color: var(--azul-marino);
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background-color: var(--naranja);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .detail-item {
            margin-bottom: 30px;
        }
        
        .detail-item i {
            font-size: 1.5rem;
            color: var(--naranja);
            margin-right: 15px;
        }
        
        /* Testimonials */
        .testimonials {
            background-color: var(--azul-marino);
            color: white;
            padding: 80px 0;
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            margin: 15px;
        }
        
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--naranja);
            margin-bottom: 20px;
        }
        
        /* CTA */
        .cta {
            background: linear-gradient(rgba(0, 35, 102, 0.9), rgba(0, 35, 102, 0.9)), url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        /* Footer */
        footer {
            background-color: var(--azul-marino);
            color: white;
            padding: 50px 0 20px;
        }
        
        footer h5 {
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--naranja);
        }
        
        footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: var(--naranja);
        }
        
        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background-color: var(--naranja);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 30px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Thoth<span>Education</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#programa">Programa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#beneficios">Beneficios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonios">Testimonios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                </ul>
                <a href="#inscripcion" class="btn btn-primary ms-lg-3">Aplicar ahora</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Maestría en Administración de Negocios</h1>
            <p>Desarrolla habilidades estratégicas de liderazgo y gestión empresarial con nuestro programa de posgrado diseñado para profesionales que buscan transformar sus carreras.</p>
            <a href="#inscripcion" class="btn btn-primary">Solicitar información</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="beneficios">
        <div class="container">
            <div class="section-title">
                <h2>¿Por qué elegir nuestra maestría?</h2>
                <p class="text-muted">Un programa diseñado para el éxito profesional</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3>Enfoque Práctico</h3>
                        <p>Casos reales de negocios y metodologías aplicadas que podrás implementar inmediatamente en tu trabajo.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3>Profesores Expertos</h3>
                        <p>Claustro docente con amplia experiencia ejecutiva y académica en empresas líderes del mercado.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h3>Networking</h3>
                        <p>Acceso a una red de más de 5,000 egresados en posiciones estratégicas en diversas industrias.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Flexibilidad</h3>
                        <p>Modalidad presencial y virtual con horarios diseñados para profesionales que trabajan.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-globe-americas"></i>
                        </div>
                        <h3>Enfoque Global</h3>
                        <p>Contenidos actualizados con las últimas tendencias de negocios internacionales.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3>Acreditación</h3>
                        <p>Programa acreditado internacionalmente por las principales asociaciones de educación en negocios.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Details -->
    <section class="program-details" id="programa">
        <div class="container">
            <div class="section-title">
                <h2>Detalles del Programa</h2>
                <p class="text-muted">Todo lo que necesitas saber sobre nuestra maestría</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <h3>Plan de Estudios</h3>
                    <p>Nuestro programa de Maestría en Administración de Negocios está estructurado en 4 semestres académicos, con un total de 20 cursos diseñados para desarrollar competencias directivas.</p>
                    
                    <div class="accordion" id="planAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    Primer Semestre - Fundamentos
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#planAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Economía para la Toma de Decisiones</li>
                                        <li>Contabilidad Gerencial</li>
                                        <li>Marketing Estratégico</li>
                                        <li>Liderazgo y Comportamiento Organizacional</li>
                                        <li>Análisis de Datos para Negocios</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    Segundo Semestre - Profundización
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#planAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Finanzas Corporativas</li>
                                        <li>Estrategia Competitiva</li>
                                        <li>Innovación y Emprendimiento</li>
                                        <li>Gestión de Operaciones</li>
                                        <li>Negocios Internacionales</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    Tercer Semestre - Especialización
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#planAccordion">
                                <div class="accordion-body">
                                    <p>Elige una de nuestras áreas de concentración:</p>
                                    <strong>Finanzas:</strong>
                                    <ul>
                                        <li>Mercados Financieros</li>
                                        <li>Gestión de Riesgos</li>
                                        <li>Inversiones</li>
                                    </ul>
                                    <strong>Marketing:</strong>
                                    <ul>
                                        <li>Marketing Digital</li>
                                        <li>Comportamiento del Consumidor</li>
                                        <li>Brand Management</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Duración</h4>
                            <p>24 meses (4 semestres académicos)</p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-graduation-cap"></i>
                        <div>
                            <h4>Título Otorgado</h4>
                            <p>Magíster en Administración de Negocios</p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-laptop"></i>
                        <div>
                            <h4>Modalidades</h4>
                            <p>Presencial (Vespertino) | Virtual (Clases en vivo)</p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Sedes</h4>
                            <p>Ciudad de México, Bogotá, Lima, Santiago (y online)</p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-calendar-check"></i>
                        <div>
                            <h4>Inicio de Clases</h4>
                            <p>Marzo y Agosto de cada año</p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-dollar-sign"></i>
                        <div>
                            <h4>Inversión</h4>
                            <p>Consulta nuestros planes de pago y becas disponibles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonios">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;">Lo que dicen nuestros egresados</h2>
                <p>Experiencias reales de profesionales como tú</p>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Testimonial 1" class="testimonial-img">
                        <p>"La maestría me dio las herramientas para ascender a un puesto directivo en mi empresa. El networking con compañeros y profesores ha sido invaluable."</p>
                        <h5>María González</h5>
                        <p class="text-muted">Directora de Marketing, TechSolutions</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Testimonial 2" class="testimonial-img">
                        <p>"El enfoque práctico del programa me permitió aplicar conceptos inmediatamente en mi trabajo. Los casos reales fueron especialmente útiles."</p>
                        <h5>Carlos Mendoza</h5>
                        <p class="text-muted">Gerente Financiero, Banco Continental</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Testimonial 3" class="testimonial-img">
                        <p>"Como emprendedora, la maestría me dio la estructura y conocimientos para escalar mi negocio de manera estratégica. Totalmente recomendado."</p>
                        <h5>Ana Torres</h5>
                        <p class="text-muted">Fundadora, EcoModa Sostenible</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="inscripcion">
        <div class="container">
            <h2>¿Listo para transformar tu carrera?</h2>
            <p class="mb-4">Completa el formulario y un asesor se pondrá en contacto contigo para brindarte toda la información.</p>
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form class="bg-white p-4 rounded shadow">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Nombre completo" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" class="form-control" placeholder="Correo electrónico" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="tel" class="form-control" placeholder="Teléfono">
                            </div>
                            <div class="col-md-6 mb-3">
                                <select class="form-select">
                                    <option selected>País de residencia</option>
                                    <option>México</option>
                                    <option>Colombia</option>
                                    <option>Perú</option>
                                    <option>Chile</option>
                                    <option>Argentina</option>
                                    <option>Otro</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <textarea class="form-control" rows="3" placeholder="¿Qué te motiva a estudiar esta maestría?"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contacto">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>Thoth Education</h5>
                    <p>Líderes en educación ejecutiva con más de 15 años formando a los profesionales del futuro.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i> Av. Universidad 123, CDMX</li>
                        <li><i class="fas fa-phone me-2"></i> +52 55 1234 5678</li>
                        <li><i class="fas fa-envelope me-2"></i> info@thotheducation.edu</li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5>Horario de atención</h5>
                    <ul class="list-unstyled">
                        <li>Lunes a Viernes: 9:00 - 18:00</li>
                        <li>Sábados: 9:00 - 13:00</li>
                        <li>Domingos: Cerrado</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright text-center">
                <p>&copy; 2023 Thoth Education. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>