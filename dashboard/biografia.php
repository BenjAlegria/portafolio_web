<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();

$mensaje = '';
$tipo = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $nombre      = sanitize($_POST['nombre'] ?? '');
    $titulo      = sanitize($_POST['titulo'] ?? '');
    $descripcion = sanitize($_POST['descripcion'] ?? '');
    $email       = sanitize($_POST['email'] ?? '');
    $github      = sanitize($_POST['github'] ?? '');
    $linkedin    = sanitize($_POST['linkedin'] ?? '');

    // Manejar subida de foto
    $foto = $_POST['foto_actual'] ?? '';
    if (!empty($_FILES['foto']['name'])) {
        $ext       = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed   = ['jpg','jpeg','png','webp'];
        if (in_array($ext, $allowed)) {
            $newName = 'profile.' . $ext;
            $destino = '../assets/img/' . $newName;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $foto = $newName;
            }
        }
    }

    try {
        $check = $pdo->query("SELECT COUNT(*) FROM biografia")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE biografia SET nombre=?, titulo=?, descripcion=?, email=?, github=?, linkedin=?, foto=? WHERE id=1");
        } else {
            $stmt = $pdo->prepare("INSERT INTO biografia (nombre, titulo, descripcion, email, github, linkedin, foto) VALUES (?,?,?,?,?,?,?)");
        }
        $stmt->execute([$nombre, $titulo, $descripcion, $email, $github, $linkedin, $foto]);
        $mensaje = 'Biografía actualizada correctamente.';
        $tipo = 'success';
    } catch (Exception $e) {
        $mensaje = 'Error al guardar: ' . $e->getMessage();
        $tipo = 'danger';
    }
}

$bio = getBiografia($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Biografía - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="dashboard-sidebar">
    <div class="brand"><div class="brand-icon"><i class="bi bi-person-fill"></i></div>Mi Portafolio</div>
    <a href="index.php" class="sidebar-link"><i class="bi bi-grid"></i> Dashboard</a>
    <a href="biografia.php" class="sidebar-link active"><i class="bi bi-person"></i> Biografía</a>
    <a href="habilidades.php" class="sidebar-link"><i class="bi bi-tools"></i> Habilidades</a>
    <a href="tecnologias.php" class="sidebar-link"><i class="bi bi-code-slash"></i> Tecnologías</a>
    <a href="proyectos.php" class="sidebar-link"><i class="bi bi-briefcase"></i> Proyectos</a>
    <a href="mensajes.php" class="sidebar-link"><i class="bi bi-envelope"></i> Mensajes</a>
    <div style="margin-top:auto;padding-top:40px;">
        <a href="../index.php" class="sidebar-link" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver Sitio</a>
        <a href="logout.php" class="sidebar-link" style="color:#ef4444;"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
    </div>
</div>

<div class="dashboard-content">
    <h4 class="fw-bold mb-1">Editar Biografía</h4>
    <p class="text-muted small mb-4">Actualiza tu información personal y profesional</p>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo; ?> rounded-3 mb-4">
            <i class="bi bi-<?php echo $tipo === 'success' ? 'check-circle' : 'exclamation-circle'; ?>-fill me-2"></i>
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-card">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="foto_actual" value="<?php echo htmlspecialchars($bio['foto'] ?? ''); ?>">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Nombre Completo</label>
                    <input type="text" name="nombre" class="form-control contact-input"
                           value="<?php echo htmlspecialchars($bio['nombre'] ?? 'Benjamin Ignacio Alegria Barrientos'); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Título / Cargo</label>
                    <input type="text" name="titulo" class="form-control contact-input"
                           value="<?php echo htmlspecialchars($bio['titulo'] ?? 'Estudiante Tec. Informática UCT'); ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-medium small">Descripción Personal</label>
                    <textarea name="descripcion" class="form-control contact-input" rows="4" required><?php echo htmlspecialchars($bio['descripcion'] ?? 'Estudiante con formación en modelado de bases de datos, programación y documentación técnica. Me apasiona encontrar soluciones prácticas a problemas tecnológicos y optimizar procesos mediante el uso de herramientas digitales.'); ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Email</label>
                    <input type="email" name="email" class="form-control contact-input"
                           value="<?php echo htmlspecialchars($bio['email'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Foto de Perfil</label>
                    <input type="file" name="foto" class="form-control contact-input" accept="image/*">
                    <?php if (!empty($bio['foto'])): ?>
                        <small class="text-muted">Actual: <?php echo htmlspecialchars($bio['foto']); ?></small>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">GitHub URL</label>
                    <input type="url" name="github" class="form-control contact-input"
                           value="<?php echo htmlspecialchars($bio['github'] ?? ''); ?>" placeholder="https://github.com/usuario">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">LinkedIn URL</label>
                    <input type="url" name="linkedin" class="form-control contact-input"
                           value="<?php echo htmlspecialchars($bio['linkedin'] ?? ''); ?>" placeholder="https://linkedin.com/in/usuario">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-dark px-4">
                        <i class="bi bi-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
