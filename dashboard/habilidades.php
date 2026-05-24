<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();

$mensaje = '';
$tipo = '';

// Eliminar
if (isset($_GET['eliminar']) && $pdo) {
    try {
        $stmt = $pdo->prepare("DELETE FROM habilidades WHERE id = ?");
        $stmt->execute([(int)$_GET['eliminar']]);
        $mensaje = 'Habilidad eliminada.';
        $tipo = 'success';
    } catch (Exception $e) {
        $mensaje = 'Error al eliminar.';
        $tipo = 'danger';
    }
}

// Guardar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $id         = (int)($_POST['id'] ?? 0);
    $nombre     = sanitize($_POST['nombre'] ?? '');
    $icono_html = $_POST['icono_html'] ?? '';
    $orden      = (int)($_POST['orden'] ?? 0);

    try {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE habilidades SET nombre=?, icono_html=?, orden=? WHERE id=?");
            $stmt->execute([$nombre, $icono_html, $orden, $id]);
            $mensaje = 'Habilidad actualizada.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO habilidades (nombre, icono_html, orden) VALUES (?,?,?)");
            $stmt->execute([$nombre, $icono_html, $orden]);
            $mensaje = 'Habilidad agregada.';
        }
        $tipo = 'success';
    } catch (Exception $e) {
        $mensaje = 'Error: ' . $e->getMessage();
        $tipo = 'danger';
    }
}

$habilidades = getHabilidades($pdo) ?? [];

// Íconos predefinidos
$iconosDisponibles = [
    'HTML5'      => '<i class="bi bi-filetype-html fs-1" style="color:#e34c26"></i>',
    'CSS3'       => '<i class="bi bi-filetype-css fs-1" style="color:#264de4"></i>',
    'JavaScript' => '<i class="bi bi-filetype-js fs-1" style="color:#f0db4f"></i>',
    'PHP'        => '<i class="bi bi-filetype-php fs-1" style="color:#8892be"></i>',
    'MySQL'      => '<i class="bi bi-database-fill fs-1" style="color:#00758f"></i>',
    'Bootstrap'  => '<i class="bi bi-bootstrap-fill fs-1" style="color:#7952b3"></i>',
    'GitHub'     => '<i class="bi bi-github fs-1" style="color:#24292e"></i>',
    'IA Tools'   => '<i class="bi bi-robot fs-1" style="color:#10a37f"></i>',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habilidades - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="dashboard-sidebar">
    <div class="brand"><div class="brand-icon"><i class="bi bi-person-fill"></i></div>Mi Portafolio</div>
    <a href="index.php" class="sidebar-link"><i class="bi bi-grid"></i> Dashboard</a>
    <a href="biografia.php" class="sidebar-link"><i class="bi bi-person"></i> Biografía</a>
    <a href="habilidades.php" class="sidebar-link active"><i class="bi bi-tools"></i> Habilidades</a>
    <a href="tecnologias.php" class="sidebar-link"><i class="bi bi-code-slash"></i> Tecnologías</a>
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
            <h4 class="fw-bold mb-1">Habilidades</h4>
            <p class="text-muted small mb-0">Gestiona las habilidades de tu portafolio</p>
        </div>
        <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalHabilidad">
            <i class="bi bi-plus-circle me-1"></i> Nueva Habilidad
        </button>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo; ?> rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i><?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-card">
        <?php if (empty($habilidades)): ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-tools fs-1 d-block mb-2"></i>
                <p>No hay habilidades aún.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ícono</th>
                            <th>Nombre</th>
                            <th>Orden</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($habilidades as $h): ?>
                        <tr>
                            <td><?php echo $h['icono_html']; ?></td>
                            <td class="fw-medium"><?php echo htmlspecialchars($h['nombre']); ?></td>
                            <td><?php echo $h['orden']; ?></td>
                            <td class="text-end">
                                <a href="?eliminar=<?php echo $h['id']; ?>"
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

<!-- Modal -->
<div class="modal fade" id="modalHabilidad" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Nueva Habilidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form method="POST">
                    <input type="hidden" name="id" value="0">
                    <div class="mb-3">
                        <label class="form-label fw-medium small">Nombre</label>
                        <select name="nombre" class="form-control contact-input" id="selectHabilidad" onchange="updateIcono(this)">
                            <?php foreach ($iconosDisponibles as $nombre => $icono): ?>
                                <option value="<?php echo $nombre; ?>"><?php echo $nombre; ?></option>
                            <?php endforeach; ?>
                            <option value="otro">Otro...</option>
                        </select>
                    </div>
                    <div id="nombrePersonalizado" class="mb-3" style="display:none;">
                        <label class="form-label fw-medium small">Nombre personalizado</label>
                        <input type="text" id="nombreCustom" class="form-control contact-input" placeholder="Nombre de la habilidad">
                    </div>
                    <input type="hidden" name="icono_html" id="iconoHtml" value='<?php echo array_values($iconosDisponibles)[0]; ?>'>
                    <div class="mb-3">
                        <label class="form-label fw-medium small">Orden</label>
                        <input type="number" name="orden" class="form-control contact-input" value="<?php echo count($habilidades) + 1; ?>">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark px-4">
                            <i class="bi bi-save me-2"></i>Guardar
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
const iconos = <?php echo json_encode($iconosDisponibles); ?>;

function updateIcono(select) {
    const val = select.value;
    const customDiv = document.getElementById('nombrePersonalizado');
    if (val === 'otro') {
        customDiv.style.display = 'block';
        document.getElementById('iconoHtml').value = '<i class="bi bi-code-slash fs-1"></i>';
    } else {
        customDiv.style.display = 'none';
        document.getElementById('iconoHtml').value = iconos[val] || '';
    }
}

// Si nombre es "otro", usar el campo personalizado
document.querySelector('form').addEventListener('submit', function(e) {
    const select = document.getElementById('selectHabilidad');
    if (select.value === 'otro') {
        const custom = document.getElementById('nombreCustom').value.trim();
        if (!custom) { e.preventDefault(); alert('Ingresa un nombre.'); return; }
        select.insertAdjacentHTML('beforebegin', `<input type="hidden" name="nombre" value="${custom}">`);
        select.removeAttribute('name');
    }
});
</script>
</body>
</html>
