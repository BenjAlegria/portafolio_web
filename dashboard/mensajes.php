<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();

$mensajes = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM contacto ORDER BY created_at DESC");
        $mensajes = $stmt->fetchAll();
    } catch (Exception $e) {}
}

if (isset($_GET['eliminar']) && $pdo) {
    try {
        $stmt = $pdo->prepare("DELETE FROM contacto WHERE id = ?");
        $stmt->execute([(int)$_GET['eliminar']]);
        header('Location: mensajes.php');
        exit;
    } catch (Exception $e) {}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - Dashboard</title>
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
    <a href="proyectos.php" class="sidebar-link"><i class="bi bi-briefcase"></i> Proyectos</a>
    <a href="mensajes.php" class="sidebar-link active"><i class="bi bi-envelope"></i> Mensajes</a>
    <div style="margin-top:auto;padding-top:40px;">
        <a href="../index.php" class="sidebar-link" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver Sitio</a>
        <a href="logout.php" class="sidebar-link" style="color:#ef4444;"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
    </div>
</div>

<div class="dashboard-content">
    <h4 class="fw-bold mb-1">Mensajes de Contacto</h4>
    <p class="text-muted small mb-4">Mensajes recibidos desde el formulario de contacto</p>

    <div class="dashboard-card">
        <?php if (empty($mensajes)): ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                <p>No hay mensajes aún.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr><th>Nombre</th><th>Email</th><th>Asunto</th><th>Mensaje</th><th>Fecha</th><th></th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mensajes as $m): ?>
                        <tr>
                            <td class="fw-medium"><?php echo htmlspecialchars($m['nombre']); ?></td>
                            <td><small><?php echo htmlspecialchars($m['email']); ?></small></td>
                            <td><small><?php echo htmlspecialchars($m['asunto']); ?></small></td>
                            <td><small class="text-muted"><?php echo htmlspecialchars(substr($m['mensaje'], 0, 60)) . '...'; ?></small></td>
                            <td><small class="text-muted"><?php echo date('d/m/Y', strtotime($m['created_at'])); ?></small></td>
                            <td>
                                <a href="?eliminar=<?php echo $m['id']; ?>"
                                   onclick="return confirm('¿Eliminar mensaje?')"
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
