<?php
// includes/db.php
// Configuración de conexión a la base de datos

define('DB_HOST', 'localhost');
define('DB_NAME', 'balegria_db1');
define('DB_USER', 'balegria');        
define('DB_PASS', 'BaX94kLm?');        
define('DB_CHARSET', 'utf8mb4');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // En producción no mostrar el error real
    error_log("Error de conexión BD: " . $e->getMessage());
    $pdo = null;
    // Continuar sin BD (mostrará datos por defecto en las funciones)
}
