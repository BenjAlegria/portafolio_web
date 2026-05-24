<?php
// api/contacto.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Leer JSON del body
$data = json_decode(file_get_contents('php://input'), true);

$nombre  = trim($data['nombre']  ?? '');
$email   = trim($data['email']   ?? '');
$asunto  = trim($data['asunto']  ?? '');
$mensaje = trim($data['mensaje'] ?? '');

// Validaciones
if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Correo electrónico inválido.']);
    exit;
}

if (strlen($mensaje) < 10) {
    echo json_encode(['success' => false, 'message' => 'El mensaje es muy corto.']);
    exit;
}

// Sanitizar
$nombre  = htmlspecialchars(strip_tags($nombre));
$email   = htmlspecialchars(strip_tags($email));
$asunto  = htmlspecialchars(strip_tags($asunto));
$mensaje = htmlspecialchars(strip_tags($mensaje));

// Guardar en BD
if ($pdo) {
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO contacto (nombre, email, asunto, mensaje, created_at) VALUES (?, ?, ?, ?, NOW())"
        );
        $stmt->execute([$nombre, $email, $asunto, $mensaje]);
        echo json_encode(['success' => true, 'message' => 'Mensaje enviado correctamente.']);
    } catch (Exception $e) {
        error_log("Error contacto: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al guardar el mensaje.']);
    }
} else {
    // Sin BD: simular éxito (para desarrollo)
    echo json_encode(['success' => true, 'message' => 'Mensaje recibido (sin BD).']);
}
