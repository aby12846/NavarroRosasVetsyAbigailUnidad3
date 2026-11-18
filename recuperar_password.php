<?php
// recuperar_password.php - Recuperación de Contraseña
$pageTitle = "Recuperar Contraseña";
require_once __DIR__ . '/config/db.php';

$mensaje = '';
$email = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = 'Si el correo electrónico está registrado en nuestro sistema, recibirás un enlace con las instrucciones para restablecer tu contraseña.';
    } else {
        $mensaje = 'Por favor ingresa un correo electrónico válido.';
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-5">
    <div class="auth-container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <span class="logo-icon mb-2"><i class="bi bi-shield-lock-fill"></i></span>
                <h2 class="fw-bold text-verde-oscuro mb-1">Recuperar Contraseña</h2>
                <p class="text-muted small">Ingresa el correo asociado a tu cuenta para enviarte un enlace de recuperación.</p>
            </div>

            <?php if ($mensaje): ?>
                <div class="alert alert-info rounded-4 d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                    <div><?= sanitize($mensaje) ?></div>
                </div>
            <?php endif; ?>

            <form action="recuperar_password.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-4 text-muted">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="form-control border-start-0 rounded-end-4" placeholder="tucorreo@ejemplo.com" value="<?= sanitize($email) ?>" required>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-naranja py-3 text-white fs-6">
                        <i class="bi bi-send-fill me-1"></i> Enviar Enlace de Recuperación
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 pt-2">
                <p class="text-muted mb-0 small">
                    <a href="login.php" class="text-verde fw-bold"><i class="bi bi-arrow-left me-1"></i> Volver a Iniciar Sesión</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

