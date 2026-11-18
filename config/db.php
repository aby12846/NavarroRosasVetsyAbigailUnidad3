<?php
// config/db.php - Conexión a la base de datos MySQL en XAMPP y utilidades de seguridad

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Constantes de configuración para XAMPP
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'adopta_mascotas');
define('SITE_NAME', 'Adopta una Mascota');
define('BASE_URL', '/adoptarmascotass');

/**
 * Obtiene la conexión PDO a MySQL en XAMPP.
 * Utiliza consultas preparadas reales para máxima seguridad contra SQL Injection.
 */
function getDB() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Desactiva la emulación de prepares para forzar consultas preparadas reales en el motor MySQL
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

        // Verificar que la columna de contraseña sea VARCHAR(255)
        verificarColumnaPassword($pdo);

        return $pdo;
    } catch (PDOException $e) {
        // Si la base de datos no existe aún, intentar crearla e inicializarla automáticamente
        try {
            $dsnInit = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
            $connInit = new PDO($dsnInit, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $connInit->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $connInit->exec("USE `" . DB_NAME . "`");

            $sqlFile = dirname(__DIR__) . '/database.sql';
            if (file_exists($sqlFile)) {
                $connInit->exec(file_get_contents($sqlFile));
            }

            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);

            verificarColumnaPassword($pdo);
            return $pdo;
        } catch (PDOException $ex) {
            error_log("Error de conexión MySQL: " . $ex->getMessage());
            return null;
        }
    }
}

/**
 * Verifica y asegura que la columna 'password' en la tabla 'usuarios' sea VARCHAR(255).
 * Esto garantiza que el hash generado por Bcrypt (60 caracteres) se almacene sin truncamiento.
 */
function verificarColumnaPassword(PDO $pdo) {
    try {
        $stmt = $pdo->query("SHOW COLUMNS FROM `usuarios` LIKE 'password'");
        $col = $stmt->fetch();
        if ($col) {
            $tipo = strtolower($col['Type']);
            if ($tipo !== 'varchar(255)') {
                $pdo->exec("ALTER TABLE `usuarios` MODIFY COLUMN `password` VARCHAR(255) NOT NULL");
            }
        }
    } catch (Exception $e) {
        // Ignorar si la tabla no existe aún
    }
}

// Helpers de autenticación y sesión
function isLoggedIn() {
    return isset($_SESSION['usuario_id']);
}

function isAdmin() {
    return isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';
}

function currentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    return [
        'id' => $_SESSION['usuario_id'],
        'nombre' => $_SESSION['usuario_nombre'] ?? 'Usuario',
        'email' => $_SESSION['usuario_email'] ?? 'usuario@ejemplo.com',
        'rol' => $_SESSION['usuario_rol'] ?? 'adoptante'
    ];
}

function setFlash($tipo, $mensaje) {
    $_SESSION['flash'] = [
        'tipo' => $tipo,
        'mensaje' => $mensaje
    ];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function sanitize($data) {
    return htmlspecialchars(trim((string)($data ?? '')), ENT_QUOTES, 'UTF-8');
}
?>
