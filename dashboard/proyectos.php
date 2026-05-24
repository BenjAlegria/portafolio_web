<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();

$mensaje = '';
$tipo = '';

// ELIMINAR
if (isset($_GET['eliminar']) && $pdo) {
    try {
        $stmt = $pdo->prepare("DELETE FROM proyectos WHERE id = ?");
        $stmt->execute([(int)$_GET['eliminar']]);
        $mensaje = 'Proyecto eliminado.';
        $tipo = 'success';
    } catch (Exception $e) {
        $mensaje = 'Error al eliminar.';
        $tipo = 'danger';
    }
}

// GUARDAR (crear o actualizar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $id          = (int)($_POST['id'] ?? 0);
    $titulo      = sanitize($_POST['titulo'] ?? '');
    $descripcion = sanitize($_POST['descripcion'] ?? '');
    $tecnologias = sanitize($_POST['tecnologias'] ?? '');
    $url_demo    = sanitize($_POST['url_demo'] ?? '');
    $url_github  = sanitize($_POST['url_github'] ?? '');

    // Imagen
    $imagen = $_POST['imagen_actual'] ?? '';
    if (!empty($_FILES['imagen']['name'])) {
        $ext     = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if (in_array($ext, $allowed)) {
            $newName = 'proyecto_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], '../assets/img/' . $newName)) {
                $imagen = $newName;
            }
        }
    }

    try {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE proyectos SET titulo=?, descripcion=?, tecnologias=?, url_demo=?, url_github=?, imagen=? WHERE id=?");
            $stmt->execute([$titulo, $descripcion, $tecnologias, $url_demo, $url_github, $imagen, $id]);
            $mensaje = 'Proyecto actualizado correctamente.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO proyectos (titulo, descripcion, tecnologias, url_demo, url_github, imagen) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$titulo, $descripcion, $tecnologias, $url_demo, $url_github, $imagen]);
            $mensaje = 'Proyecto creado correctamente.';
        }
        $tipo = 'success';
    } catch (Exception $e) {
        $mensaje = 'Error: ' . $e->getMessage();
        $tipo = 'danger';
    }
}

// Cargar proyecto para editar
$editProyecto = null;
if (isset($_GET['editar']) && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM proyectos WHERE id = ?");
        $stmt->execute([(int)$_GET['editar']]);
        $editProyecto = $stmt->fetch();
    } catch (Exception $e) {}
}

$proyectos = getProyectos($pdo) ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos - Dashboard</title>
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
    <a href="tecnologias.php" class="sidebar-link"><i class="bi bi-code-slash"></i> Tecnologías</a>
    <a href="proyectos.php" class="sidebar-link active"><i class="bi bi-briefcase"></i> Proyectos</a>
    <a href="mensajes.php" class="sidebar-link"><i class="bi bi-envelope"></i> Mensajes</a>
    <div style="margin-top:auto;padding-top:40px;">
        <a href="../index.php" class="sidebar-link" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver Sitio</a>
        <a href="logout.php" class="sidebar-link" style="color:#ef4444;"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
    </div>
</div>

<div class="dashboard-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Proyectos</h4>
            <p class="text-muted small mb-0">Gestiona tus proyectos del portafolio</p>
        </div>
        <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalProyecto">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Proyecto
        </button>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo; ?> rounded-3 mb-4">
            <i class="bi bi-<?php echo $tipo === 'success' ? 'check-circle' : 'exclamation-circle'; ?>-fill me-2"></i>
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <!-- Lista de proyectos -->
    <div class="dashboard-card">
        <?php if (empty($proyectos)): ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-briefcase fs-1 d-block mb-2"></i>
                <p>No hay proyectos aún. ¡Agrega el primero!</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Tecnologías</th>
                            <th>Demo</th>
                            <th>GitHub</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proyectos as $p): ?>
                        <tr>
                            <td class="fw-medium"><?php echo htmlspecialchars($p['titulo']); ?></td>
                            <td><small class="text-muted"><?php echo htmlspecialchars($p['tecnologias'] ?? '-'); ?></small></td>
                            <td>
                                <?php if (!empty($p['url_demo'])): ?>
                                    <a href="<?php echo htmlspecialchars($p['url_demo']); ?>" target="_blank" class="badge bg-light text-dark border text-decoration-none">Demo</a>
                                <?php else: echo '<span class="text-muted small">-</span>'; endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($p['url_github'])): ?>
                                    <a href="<?php echo htmlspecialchars($p['url_github']); ?>" target="_blank" class="badge bg-light text-dark border text-decoration-none">GitHub</a>
                                <?php else: echo '<span class="text-muted small">-</span>'; endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="?editar=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="?eliminar=<?php echo $p['id']; ?>"
                                   onclick="return confirm('¿Eliminar este proyecto?')"
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

<!-- Modal Proyecto -->
<div class="modal fade" id="modalProyecto" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <?php echo $editProyecto ? 'Editar Proyecto' : 'Nuevo Proyecto'; ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $editProyecto['id'] ?? 0; ?>">
                    <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($editProyecto['imagen'] ?? ''); ?>">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-medium small">Título del Proyecto</label>
                            <input type="text" name="titulo" class="form-control contact-input"
                                   value="<?php echo htmlspecialchars($editProyecto['titulo'] ?? ''); ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small">Descripción</label>
                            <textarea name="descripcion" class="form-control contact-input" rows="3"><?php echo htmlspecialchars($editProyecto['descripcion'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small">Tecnologías utilizadas</label>
                            <input type="text" name="tecnologias" class="form-control contact-input"
                                   placeholder="HTML, CSS, PHP, MySQL..."
                                   value="<?php echo htmlspecialchars($editProyecto['tecnologias'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">URL Demo</label>
                            <input type="url" name="url_demo" class="form-control contact-input"
                                   value="<?php echo htmlspecialchars($editProyecto['url_demo'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">URL GitHub</label>
                            <input type="url" name="url_github" class="form-control contact-input"
                                   value="<?php echo htmlspecialchars($editProyecto['url_github'] ?? ''); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small">Imagen del Proyecto</label>
                            <input type="file" name="imagen" class="form-control contact-input" accept="image/*">
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-dark px-4">
                                <i class="bi bi-save me-2"></i>Guardar
                            </button>
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Abrir modal automáticamente si hay edición
<?php if ($editProyecto): ?>
document.addEventListener('DOMContentLoaded', function() {
    new bootstrap.Modal(document.getElementById('modalProyecto')).show();
});
<?php endif; ?>
</script>
</body>
</html>
