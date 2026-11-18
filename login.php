<?php
// login.php - Iniciar Sesión con Verificación Bcrypt (password_verify) y Consultas Preparadas
$pageTitle = "Iniciar Sesión";
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/pets_helper.php';

$redirect = $_GET['redirect'] ?? 'index.php';
$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Botones de acceso rápido para pruebas
    if (isset($_POST['demo_admin'])) {
        $email = 'admin@adoptaunamascota.com';
        $password = 'admin123';
    } elseif (isset($_POST['demo_user'])) {
        $email = 'carlos@ejemplo.com';
        $password = 'admin123';
    }

    if (empty($email) || empty($password)) {
        $error = 'Por favor ingresa tu correo y contraseña.';
    } else {
        $pdo = getDB();

        if ($pdo) {
            try {
                // 1. Consulta preparada para obtener el usuario por correo (Previene SQL Injection)
                $stmt = $pdo->prepare("SELECT id, nombre, email, password, rol FROM `usuarios` WHERE `email` = :email LIMIT 1");
                $stmt->execute([':email' => $email]);
                $usuario = $stmt->fetch();

                // 2. VERIFICACIÓN DE CONTRASEÑA CON BCRYPT (password_verify)
                // Compara de forma segura la contraseña ingresada en texto plano con el hash almacenado en la BD
                if ($usuario && password_verify($password, $usuario['password'])) {

                    // 3. Opcional: Rehash automático si el algoritmo o coste de Bcrypt se actualiza
                    if (password_needs_rehash($usuario['password'], PASSWORD_DEFAULT)) {
                        $nuevoHash = password_hash($password, PASSWORD_DEFAULT);
                        $rehashStmt = $pdo->prepare("UPDATE `usuarios` SET `password` = :password WHERE `id` = :id");
                        $rehashStmt->execute([':password' => $nuevoHash, ':id' => $usuario['id']]);
                    }

                    // 4. Regenerar ID de sesión para prevenir Session Fixation
                    session_regenerate_id(true);

                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_email'] = $usuario['email'];
                    $_SESSION['usuario_rol'] = $usuario['rol'];

                    setFlash('success', '¡Bienvenido de nuevo, ' . $usuario['nombre'] . '!');

                    if ($usuario['rol'] === 'admin') {
                        header('Location: ' . BASE_URL . '/admin/index.php');
                    } else {
                        header('Location: ' . BASE_URL . '/' . ltrim($redirect, '/'));
                    }
                    exit;
                } else {
                    // Mensaje genérico para prevenir enumeración de usuarios
                    $error = 'Correo electrónico o contraseña incorrectos.';
                }
            } catch (PDOException $e) {
                error_log("Error en login: " . $e->getMessage());
                $error = 'Error en el servidor de base de datos. Por favor intenta más tarde.';
            }
        } else {
            $error = 'No se pudo conectar a la base de datos MySQL en XAMPP. Asegúrate de que el servicio MySQL esté iniciado en el panel de control de XAMPP.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-5">
    <div class="auth-container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <span class="logo-icon mb-2"><i class="bi bi-paw-fill"></i></span>
                <h2 class="fw-bold text-verde-oscuro mb-1">¡Qué alegría verte!</h2>
                <p class="text-muted small">Inicia sesión para continuar en Adopta una Mascota</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger rounded-4 d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                    <div><?= sanitize($error) ?></div>
                </div>
            <?php endif; ?>

            <form action="login.php?redirect=<?= urlencode($redirect) ?>" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-4 text-muted">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control border-start-0 rounded-end-4" 
                               placeholder="tucorreo@ejemplo.com" 
                               value="admin@adoptaunamascota.com" 
                               required>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label mb-0">Contraseña</label>
                        <a href="recuperar_password.php" class="small text-verde">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="input-group mt-1">
                        <span class="input-group-text bg-light border-end-0 rounded-start-4 text-muted">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control border-start-0 rounded-end-4" 
                               placeholder="••••••••" 
                               value="admin123" 
                               required>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-naranja py-3 text-white fs-6">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                    </button>
                </div>

                <!-- Acceso rápido 1-click para pruebas en XAMPP -->
                <div class="mt-4 pt-3 border-top">
                    <div class="text-center text-muted small mb-2 fw-medium">O ingresa rápidamente con un clic:</div>
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="submit" name="demo_admin" value="1" class="btn btn-outline-verde w-100 btn-sm py-2">
                                <i class="bi bi-shield-lock me-1"></i> Como Admin
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="submit" name="demo_user" value="1" class="btn btn-outline-naranja w-100 btn-sm py-2">
                                <i class="bi bi-person-heart me-1"></i> Como Adoptante
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="text-center mt-4 pt-2">
                <p class="text-muted mb-0 small">
                    ¿Aún no tienes una cuenta? 
                    <a href="registro.php" class="text-verde fw-bold">Regístrate gratis aquí</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
