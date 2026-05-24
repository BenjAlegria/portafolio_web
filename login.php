<?php
session_start();
require_once 'includes/db.php';

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Por favor completa todos los campos.';
    } else {
        // Verificar credenciales en BD
        $loggedIn = false;
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? LIMIT 1");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                if ($user && password_verify($password, $user['password'])) {
                    $loggedIn = true;
                    $_SESSION['admin_id']       = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                }
            } catch (Exception $e) {
                // fallback
            }
        }
        // Credenciales hardcodeadas como fallback de seguridad
        if (!$loggedIn && $username === 'admin' && $password === 'admin123') {
            $loggedIn = true;
            $_SESSION['admin_username'] = 'admin';
        }

        if ($loggedIn) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: dashboard/index.php');
            exit;
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Mi Portafolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <!-- Logo -->
        <div class="text-center mb-4">
            <div class="brand-icon mx-auto mb-3">
                <i class="bi bi-person-fill"></i>
            </div>
            <h4 class="fw-bold mb-1">Acceso Administrativo</h4>
            <p class="text-muted small">Ingresa tus credenciales para continuar</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 mb-3">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label fw-medium small">Usuario</label>
                <input type="text" name="username" class="form-control contact-input"
                       placeholder="Tu usuario" 
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                       required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium small">Contraseña</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput" 
                           class="form-control contact-input border-end-0"
                           placeholder="Tu contraseña" required
                           style="border-radius: 10px 0 0 10px;">
                    <button type="button" class="btn border contact-input border-start-0 px-3"
                            style="border-radius: 0 10px 10px 0; background: #f9fafb;"
                            onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100">
                <i class="bi bi-lock-fill me-2"></i>Iniciar Sesión
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="index.php" class="text-muted small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Volver al portafolio
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>
