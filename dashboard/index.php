<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();

$username = $_SESSION['admin_username'] ?? 'Admin';

// Estadísticas rápidas
$stats = ['proyectos' => 0, 'habilidades' => 0, 'tecnologias' => 0, 'mensajes' => 0];
if ($pdo) {
    try {
        $stats['proyectos']   = $pdo->query("SELECT COUNT(*) FROM proyectos")->fetchColumn();
        $stats['habilidades'] = $pdo->query("SELECT COUNT(*) FROM habilidades")->fetchColumn();
        $stats['tecnologias'] = $pdo->query("SELECT COUNT(*) FROM tecnologias")->fetchColumn();
        $stats['mensajes']    = $pdo->query("SELECT COUNT(*) FROM contacto")->fetchColumn();
    } catch (Exception $e) {}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mi Portafolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- SIDEBAR -->
<div class="dashboard-sidebar">
    <div class="brand">
        <div class="brand-icon"><i class="bi bi-person-fill"></i></div>
        Mi Portafolio
    </div>
    <a href="index.php" class="sidebar-link active">
        <i class="bi bi-grid"></i> Dashboard
    </a>
    <a href="biografia.php" class="sidebar-link">
        <i class="bi bi-person"></i> Biografía
    </a>
    <a href="habilidades.php" class="sidebar-link">
        <i class="bi bi-tools"></i> Habilidades
    </a>
    <a href="tecnologias.php" class="sidebar-link">
        <i class="bi bi-code-slash"></i> Tecnologías
    </a>
    <a href="proyectos.php" class="sidebar-link">
        <i class="bi bi-briefcase"></i> Proyectos
    </a>
    <a href="mensajes.php" class="sidebar-link">
        <i class="bi bi-envelope"></i> Mensajes
    </a>
    <div style="margin-top: auto; padding-top: 40px;">
        <a href="../index.php" class="sidebar-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Ver Sitio
        </a>
        <a href="logout.php" class="sidebar-link" style="color: #ef4444;">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </a>
    </div>
</div>

<!-- CONTENT -->
<div class="dashboard-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dashboard</h4>
            <p class="text-muted small mb-0">Bienvenido, <?php echo htmlspecialchars($username); ?></p>
        </div>
        <a href="../index.php" class="btn btn-dark btn-sm" target="_blank">
            <i class="bi bi-eye me-1"></i> Ver Portafolio
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="dashboard-card text-center">
                <div class="fs-1 fw-bold mb-1"><?php echo $stats['proyectos']; ?></div>
                <p class="text-muted small mb-0"><i class="bi bi-briefcase me-1"></i>Proyectos</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="dashboard-card text-center">
                <div class="fs-1 fw-bold mb-1"><?php echo $stats['habilidades']; ?></div>
                <p class="text-muted small mb-0"><i class="bi bi-tools me-1"></i>Habilidades</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="dashboard-card text-center">
                <div class="fs-1 fw-bold mb-1"><?php echo $stats['tecnologias']; ?></div>
                <p class="text-muted small mb-0"><i class="bi bi-code-slash me-1"></i>Tecnologías</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="dashboard-card text-center">
                <div class="fs-1 fw-bold mb-1"><?php echo $stats['mensajes']; ?></div>
                <p class="text-muted small mb-0"><i class="bi bi-envelope me-1"></i>Mensajes</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="dashboard-card">
        <h6 class="fw-bold mb-3">Acciones Rápidas</h6>
        <div class="row g-2">
            <div class="col-12 col-sm-6 col-md-3">
                <a href="biografia.php" class="btn btn-outline-secondary w-100 text-start">
                    <i class="bi bi-pencil me-2"></i>Editar Biografía
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a href="proyectos.php" class="btn btn-outline-secondary w-100 text-start">
                    <i class="bi bi-plus-circle me-2"></i>Agregar Proyecto
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a href="habilidades.php" class="btn btn-outline-secondary w-100 text-start">
                    <i class="bi bi-gear me-2"></i>Gestionar Habilidades
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a href="mensajes.php" class="btn btn-outline-secondary w-100 text-start">
                    <i class="bi bi-inbox me-2"></i>Ver Mensajes
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
