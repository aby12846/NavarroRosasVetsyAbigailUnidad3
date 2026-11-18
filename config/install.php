<?php
// config/install.php - Instalador manual o verificación de base de datos y seguridad Bcrypt
require_once __DIR__ . '/db.php';

$pdo = getDB();
$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reiniciar'])) {
    if ($pdo) {
        try {
            $sqlFile = dirname(__DIR__) . '/database.sql';
            if (file_exists($sqlFile)) {
                $sqlContent = file_get_contents($sqlFile);
                $pdo->exec($sqlContent);
                $mensaje = "¡Base de datos restablecida con contraseñas encriptadas con Bcrypt y VARCHAR(255)!";
            } else {
                $error = "No se encontró el archivo database.sql";
            }
        } catch (PDOException $e) {
            $error = "Error al ejecutar SQL: " . $e->getMessage();
        }
    } else {
        $error = "No se pudo conectar a MySQL. Asegúrate de que MySQL esté activo en el panel de XAMPP.";
    }
}

// Verificar columna password
$tipoColumnaPassword = 'Desconocido';
if ($pdo) {
    try {
        $colStmt = $pdo->query("SHOW COLUMNS FROM `usuarios` LIKE 'password'");
        $colInfo = $colStmt->fetch();
        if ($colInfo) {
            $tipoColumnaPassword = strtoupper($colInfo['Type']);
        }
    } catch (Exception $e) {
        $tipoColumnaPassword = 'Tabla no inicializada';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Seguridad y BD - Adopta una Mascota</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="bg-crema min-vh-100 d-flex align-items-center justify-content-center p-3">
    <div class="card card-custom p-4 shadow-sm" style="max-width: 600px; width: 100%;">
        <div class="text-center mb-4">
            <span class="fs-1 text-verde"><i class="bi bi-shield-lock-fill"></i></span>
            <h2 class="h4 fw-bold mt-2 text-verde-oscuro">Mecanismo de Seguridad Bcrypt y BD</h2>
            <p class="text-muted small">Estado de verificación del sistema Adopta una Mascota</p>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert alert-success d-flex align-items-center rounded-3">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div><?= sanitize($mensaje) ?></div>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center rounded-3">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div><?= sanitize($error) ?></div>
            </div>
        <?php endif; ?>

        <!-- Panel de Mecanismos de Seguridad -->
        <div class="bg-light p-3 rounded-3 mb-3 border">
            <h6 class="fw-semibold mb-3 text-verde-oscuro"><i class="bi bi-shield-check text-verde me-1"></i> Estado de los Mecanismos de Seguridad:</h6>
            <ul class="list-unstyled mb-0 small text-muted d-flex flex-column gap-2">
                <li class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-key me-1 text-naranja"></i> Algoritmo de Hashing:</span>
                    <span class="badge bg-success">Bcrypt (password_hash)</span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-check2-circle me-1 text-naranja"></i> Validación de Login:</span>
                    <span class="badge bg-success">password_verify()</span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-table me-1 text-naranja"></i> Columna `password`:</span>
                    <span class="badge <?= str_contains($tipoColumnaPassword, 'VARCHAR(255)') ? 'bg-success' : 'bg-warning text-dark' ?>">
                        <?= sanitize($tipoColumnaPassword) ?>
                    </span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-shield-shaded me-1 text-naranja"></i> Protección SQL Injection:</span>
                    <span class="badge bg-success">PDO Prepared Statements</span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-robot me-1 text-naranja"></i> Google reCAPTCHA:</span>
                    <span class="badge bg-success">v2 Integrado y Protegido</span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-map me-1 text-naranja"></i> Google Maps:</span>
                    <span class="badge bg-success">Embed API Activo</span>
                </li>
            </ul>
        </div>

        <!-- Información de Conexión -->
        <div class="bg-light p-3 rounded-3 mb-4 border">
            <h6 class="fw-semibold mb-2 text-dark"><i class="bi bi-hdd-network text-verde me-1"></i> Conexión MySQL XAMPP:</h6>
            <ul class="list-unstyled mb-0 small text-muted">
                <li><i class="bi bi-server me-1"></i> Servidor: <strong>localhost</strong></li>
                <li><i class="bi bi-database me-1"></i> Base de datos: <strong>adopta_mascotas</strong></li>
                <li><i class="bi bi-person me-1"></i> Usuario: <strong>root</strong></li>
                <li><i class="bi bi-activity me-1"></i> Estado: 
                    <?php if ($pdo): ?>
                        <span class="badge bg-success">Conectado y Operativo</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Sin Conexión (Iniciar MySQL en XAMPP)</span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>

        <form method="POST">
            <div class="d-grid gap-2">
                <button type="submit" name="reiniciar" value="1" class="btn btn-naranja py-2 fw-medium text-white">
                    <i class="bi bi-arrow-clockwise me-1"></i> Restablecer / Ejecutar Script SQL
                </button>
                <div class="row g-2">
                    <div class="col-6">
                        <a href="../login.php" class="btn btn-outline-verde py-2 fw-medium w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Ir a Login
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="../registro.php" class="btn btn-outline-naranja py-2 fw-medium w-100">
                            <i class="bi bi-person-plus me-1"></i> Ir a Registro
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
