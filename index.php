<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Obtener datos desde la BD
$bio = getBiografia($pdo);
$habilidades = getHabilidades($pdo);
$tecnologias = getTecnologias($pdo);
$proyectos = getProyectos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Portafolio - Benjamin Alegria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- ====== NAVBAR ====== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#inicio">
            <div class="brand-icon">
                <i class="bi bi-person-fill"></i>
            </div>
            Mi Portafolio
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-1">
                <li class="nav-item"><a class="nav-link" href="#biografia">Biografía</a></li>
                <li class="nav-item"><a class="nav-link" href="#habilidades">Habilidades</a></li>
                <li class="nav-item"><a class="nav-link" href="#tecnologias">Tecnologías</a></li>
                <li class="nav-item"><a class="nav-link" href="#proyectos">Proyectos</a></li>
            </ul>
        </div>
        <div class="d-flex">
            <a href="login.php" class="btn btn-dark px-4">
                <i class="bi bi-lock-fill me-2"></i>Inicio de Sesión
            </a>
        </div>
    </div>
</nav>

<!-- ====== BIOGRAFÍA ====== -->
<section id="biografia" class="hero-section py-5">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge-welcome mb-3 d-inline-flex align-items-center gap-2">
                    👋 Bienvenido a mi portafolio
                </span>
                <h1 class="display-4 fw-bold mb-2">
                    <?php echo htmlspecialchars($bio['nombre'] ?? 'Benjamin Alegria'); ?>
                </h1>
                <p class="text-muted fs-5 mb-3">
                    <?php echo htmlspecialchars($bio['titulo'] ?? 'Estudiante Tec. Informatica UCT'); ?>
                </p>
                <p class="text-secondary mb-4" style="max-width: 520px; line-height: 1.7;">
                    <?php echo htmlspecialchars($bio['descripcion'] ?? 'Estudiante con formación en modelado de bases de datos, programación y documentación técnica. Me apasiona encontrar soluciones prácticas a problemas tecnológicos y optimizar procesos mediante el uso de herramientas digitales.'); ?>
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#proyectos" class="btn btn-dark btn-lg px-4">
                        Ver Proyectos <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <a href="#contacto" class="btn btn-outline-secondary btn-lg px-4">Contactar</a>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-5 mt-lg-0">
                <div class="avatar-container">
                    <?php if (!empty($bio['foto'])): ?>
                        <img src="assets/img/<?php echo htmlspecialchars($bio['foto']); ?>" 
                             alt="Foto de perfil" class="avatar-img">
                    <?php else: ?>
                        <div class="avatar-placeholder">
                            <i class="bi bi-person" style="font-size: 5rem; color: #adb5bd;"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== HABILIDADES Y HERRAMIENTAS ====== -->
<section id="habilidades" class="py-5 bg-light-gray">
    <div class="container py-3">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Habilidades y Herramientas</h2>
            <p class="text-muted">Tecnologías y herramientas que domino para desarrollar proyectos web</p>
        </div>
        <div class="row g-3 justify-content-center">
            <?php if ($habilidades): ?>
                <?php foreach ($habilidades as $hab): ?>
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="skill-card text-center p-4">
                        <div class="skill-icon mb-3">
                            <?php echo $hab['icono_html'] ?? '<i class="bi bi-code-slash fs-1"></i>'; ?>
                        </div>
                        <p class="mb-0 fw-medium"><?php echo htmlspecialchars($hab['nombre']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Habilidades por defecto -->
                <?php
                $defaultSkills = [
                    ['nombre' => 'HTML5', 'color' => '#e34c26', 'icon' => 'bi-filetype-html'],
                    ['nombre' => 'CSS3', 'color' => '#264de4', 'icon' => 'bi-filetype-css'],
                    ['nombre' => 'JavaScript', 'color' => '#f7df1e', 'icon' => 'bi-filetype-js'],
                    ['nombre' => 'PHP', 'color' => '#8892be', 'icon' => 'bi-filetype-php'],
                    ['nombre' => 'MySQL', 'color' => '#00758f', 'icon' => 'bi-database-fill'],
                    ['nombre' => 'Bootstrap', 'color' => '#7952b3', 'icon' => 'bi-bootstrap-fill'],
                    ['nombre' => 'GitHub', 'color' => '#24292e', 'icon' => 'bi-github'],
                    ['nombre' => 'IA Tools', 'color' => '#10a37f', 'icon' => 'bi-robot'],
                ];
                foreach ($defaultSkills as $s): ?>
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="skill-card text-center p-4">
                        <div class="skill-icon-wrap mb-3" style="background: <?php echo $s['color']; ?>20; border-radius: 14px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="<?php echo $s['icon']; ?> fs-2" style="color: <?php echo $s['color']; ?>"></i>
                        </div>
                        <p class="mb-0 fw-medium small"><?php echo $s['nombre']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ====== TECNOLOGÍAS / NIVEL ACTUAL ====== -->
<section id="tecnologias" class="py-5 bg-white">
    <div class="container py-3">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nivel Actual y Enfoque</h2>
            <p class="text-muted">Mi progreso y aprendizaje en diferentes tecnologías</p>
        </div>
        <div class="row g-3 justify-content-center" style="max-width: 800px; margin: 0 auto;">
            <?php if ($tecnologias): ?>
                <?php foreach ($tecnologias as $tec): ?>
                <div class="col-12 col-md-6">
                    <div class="tech-card p-4">
                        <h6 class="fw-bold mb-2">
                            <span class="dot-indicator me-2"></span>
                            <?php echo htmlspecialchars($tec['nombre']); ?>
                        </h6>
                        <p class="text-muted small mb-0"><?php echo htmlspecialchars($tec['descripcion']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php
                $defaultTechs = [
                    ['nombre' => 'HTML/CSS', 'desc' => 'Conocimientos básicos, practicando estructura y estilos de páginas web.'],
                    ['nombre' => 'JavaScript', 'desc' => 'Aprendiendo lógica y funciones simples para interacción en sitios web.'],
                    ['nombre' => 'PHP', 'desc' => 'Explorando fundamentos para desarrollo backend y proyectos académicos.'],
                    ['nombre' => 'MySQL', 'desc' => 'Familiarizándome con consultas básicas y modelado de bases de datos.'],
                    ['nombre' => 'Bootstrap', 'desc' => 'Usando componentes para maquetar páginas responsivas.'],
                    ['nombre' => 'Git/GitHub', 'desc' => 'Conociendo el flujo de control de versiones y trabajo colaborativo.'],
                    ['nombre' => 'React', 'desc' => 'Iniciando en conceptos de componentes y estado, con proyectos pequeños.'],
                ];
                foreach ($defaultTechs as $t): ?>
                <div class="col-12 col-md-6">
                    <div class="tech-card p-4">
                        <h6 class="fw-bold mb-2">
                            <span class="dot-indicator me-2"></span>
                            <?php echo $t['nombre']; ?>
                        </h6>
                        <p class="text-muted small mb-0"><?php echo $t['desc']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ====== PROYECTOS ====== -->
<section id="proyectos" class="py-5 bg-light-gray">
    <div class="container py-3">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Proyectos Realizados</h2>
            <p class="text-muted">Algunos de los proyectos en los que he trabajado</p>
        </div>
        <div class="row g-4">
            <?php if ($proyectos): ?>
                <?php foreach ($proyectos as $proy): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="project-card h-100">
                        <div class="project-img-wrap">
                            <?php if (!empty($proy['imagen'])): ?>
                                <img src="assets/img/<?php echo htmlspecialchars($proy['imagen']); ?>" 
                                     class="img-fluid w-100" alt="<?php echo htmlspecialchars($proy['titulo']); ?>">
                            <?php else: ?>
                                <div class="project-img-placeholder">
                                    <i class="bi bi-briefcase" style="font-size: 3rem; color: #adb5bd;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="project-body p-4">
                            <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($proy['titulo']); ?></h5>
                            <p class="text-muted small mb-2"><?php echo htmlspecialchars($proy['descripcion']); ?></p>
                            <?php if (!empty($proy['tecnologias'])): ?>
                                <p class="text-muted small mb-3">
                                    <strong>Tecnologías:</strong> <?php echo htmlspecialchars($proy['tecnologias']); ?>
                                </p>
                            <?php endif; ?>
                            <div class="d-flex gap-3">
                                <?php if (!empty($proy['url_demo'])): ?>
                                    <a href="<?php echo htmlspecialchars($proy['url_demo']); ?>" 
                                       target="_blank" class="project-link">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Ver Demo
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($proy['url_github'])): ?>
                                    <a href="<?php echo htmlspecialchars($proy['url_github']); ?>" 
                                       target="_blank" class="project-link">
                                        <i class="bi bi-github me-1"></i> GitHub
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Proyectos por defecto -->
                <?php
                $defaultProjects = [
                    ['titulo' => 'Sistema de Gestión Escolar', 'desc' => 'Aplicación web para gestionar estudiantes, profesores y calificaciones. Desarrollada con PHP, MySQL y Bootstrap.', 'techs' => 'HTML, CSS, JavaScript, PHP, MySQL, Bootstrap'],
                    ['titulo' => 'E-commerce Responsive', 'desc' => 'Tienda online con carrito de compras, sistema de pagos y panel administrativo. Incluye integración con pasarela de pagos.', 'techs' => 'HTML, CSS, JavaScript, PHP, MySQL, AJAX'],
                    ['titulo' => 'Blog Personal con CMS', 'desc' => 'Blog con sistema de gestión de contenidos, categorías, comentarios y búsqueda avanzada.', 'techs' => 'HTML, CSS, JavaScript, PHP, MySQL'],
                ];
                foreach ($defaultProjects as $p): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="project-card h-100">
                        <div class="project-img-placeholder">
                            <i class="bi bi-briefcase" style="font-size: 3rem; color: #adb5bd;"></i>
                        </div>
                        <div class="project-body p-4">
                            <h5 class="fw-bold mb-2"><?php echo $p['titulo']; ?></h5>
                            <p class="text-muted small mb-2"><?php echo $p['desc']; ?></p>
                            <p class="text-muted small mb-3"><strong>Tecnologías:</strong> <?php echo $p['techs']; ?></p>
                            <div class="d-flex gap-3">
                                <a href="#" class="project-link"><i class="bi bi-box-arrow-up-right me-1"></i> Ver Demo</a>
                                <a href="#" class="project-link"><i class="bi bi-github me-1"></i> GitHub</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ====== CONTACTO ====== -->
<section id="contacto" class="py-5 bg-white">
    <div class="container py-3">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Contacto</h2>
            <p class="text-muted">¿Tienes un proyecto en mente? Hablemos</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div id="alertContacto"></div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Nombre</label>
                    <input type="text" class="form-control contact-input" id="contactNombre" placeholder="Tu nombre">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Correo Electrónico</label>
                    <input type="email" class="form-control contact-input" id="contactEmail" placeholder="tu@email.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Asunto</label>
                    <input type="text" class="form-control contact-input" id="contactAsunto" placeholder="Asunto del mensaje">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-medium">Mensaje</label>
                    <textarea class="form-control contact-input" id="contactMensaje" rows="5" placeholder="Tu mensaje"></textarea>
                </div>
                <button class="btn btn-dark w-100 btn-lg" id="btnEnviar">
                    <i class="bi bi-envelope me-2"></i>Enviar Mensaje
                </button>
            </div>
        </div>
    </div>
</section>

<!-- ====== FOOTER ====== -->
<footer class="footer-dark py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <h5 class="fw-bold text-white mb-3">Mi Portafolio</h5>
                <p class="text-muted-footer small">Desarrollador Web Full Stack especializado en crear soluciones innovadoras.</p>
            </div>
            <div class="col-6 col-md-4">
                <h6 class="fw-bold text-white mb-3">Enlaces</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#biografia">Biografía</a></li>
                    <li><a href="#proyectos">Proyectos</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4">
                <h6 class="fw-bold text-white mb-3">Redes Sociales</h6>
                <div class="d-flex gap-2">
                    <a href="#" class="social-btn"><i class="bi bi-github"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
