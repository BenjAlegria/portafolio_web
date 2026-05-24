<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();

$mensaje = '';
$tipo = '';

if (isset($_GET['eliminar']) && $pdo) {
    try {
        $stmt = $pdo->prepare("DELETE FROM tecnologias WHERE id = ?");
        $stmt->execute([(int)$_GET['eliminar']]);
        $mensaje = 'Tecnología eliminada.';
        $tipo = 'success';
    } catch (Exception $e) {
        $mensaje = 'Error al eliminar.';
        $tipo = 'danger';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $id          = (int)($_POST['id'] ?? 0);
    $nombre      = sanitize($_POST['nombre'] ?? '');
    $descripcion = sanitize($_POST['descripcion'] ?? '');
    $orden       = (int)($_POST['orden'] ?? 0);

    try {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE tecnologias SET nombre=?, descripcion=?, orden=? WHERE id=?");
            $stmt->execute([$nombre, $descripcion, $orden, $id]);
            $mensaje = 'Tecnología actualizada.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO tecnologias (nombre, descripcion, orden) VALUES (?,?,?)");
            $stmt->execute([$nombre, $descripcion, $orden]);
            $mensaje = 'Tecnología agregada.';
        }
        $tipo = 'success';
    } catch (Exception $e) {
        $mensaje = 'Error: ' . $e->getMessage();
        $tipo = 'danger';
    }
}

$tecnologias = getTecnologias($pdo) ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnologías - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="dashboard-sidebar">
    <div class="brand"><div class="brand-icon"><i class="bi bi-person-fill"></i></div>Mi Portafolio</div>
    <a href="index.php" class="sidebar-link"><i class="bi bi-grid"></i> Dashboard</a>
    <a href="biografia.php" class="sidebar-link"><i class="bi bi-person"></i> Biografía</a>
    <a href="habilidades.php" class="sidebar-link"><i class="bi bi-tools"></i> Habilidades</a>
    <a href="tecnologias.php" class="sidebar-link active"><i class="bi bi-code-slash"></i> Tecnologías</a>
    <a href="proyectos.php" class="sidebar-link"><i class="bi bi-briefcase"></i> Proyectos</a>
    <a href="mensajes.php" class="sidebar-link"><i class="bi bi-envelope"></i> Mensajes</a>
    <div style="margin-top:auto;padding-top:40px;">
        <a href="../index.php" class="sidebar-link" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver Sitio</a>
        <a href="logout.php" class="sidebar-link" style="color:#ef4444;"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
    </div>
</div>

<div class="dashboard-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tecnologías</h4>
            <p class="text-muted small mb-0">Gestiona tu nivel y enfoque tecnológico</p>
        </div>
        <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalTech">
            <i class="bi bi-plus-circle me-1"></i> Nueva Tecnología
        </button>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo; ?> rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i><?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-card">
        <?php if (empty($tecnologias)): ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-code-slash fs-1 d-block mb-2"></i>
                <p>No hay tecnologías aún.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr><th>Nombre</th><th>Descripción</th><th>Orden</th><th class="text-end">Acciones</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tecnologias as $t): ?>
                        <tr>
                            <td class="fw-medium"><?php echo htmlspecialchars($t['nombre']); ?></td>
                            <td><small class="text-muted"><?php echo htmlspecialchars($t['descripcion']); ?></small></td>
                            <td><?php echo $t['orden']; ?></td>
                            <td class="text-end">
                                <a href="?eliminar=<?php echo $t['id']; ?>"
                                   onclick="return confirm('¿Eliminar?')"
                                   class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="modalTech" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Nueva Tecnología</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form method="POST">
                    <input type="hidden" name="id" value="0">
                    <div class="mb-3">
                        <label class="form-label fw-medium small">Nombre</label>
                        <input type="text" name="nombre" class="form-control contact-input" placeholder="ej: HTML/CSS" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small">Descripción del nivel</label>
                        <textarea name="descripcion" class="form-control contact-input" rows="3"
                                  placeholder="Describe tu nivel y enfoque en esta tecnología..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium small">Orden</label>
                        <input type="number" name="orden" class="form-control contact-input" value="<?php echo count($tecnologias) + 1; ?>">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark px-4"><i class="bi bi-save me-2"></i>Guardar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
