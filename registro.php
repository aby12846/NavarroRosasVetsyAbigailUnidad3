<?php
// registro.php - Registro de Usuarios con Hashing Bcrypt, Consultas Preparadas y Google reCAPTCHA
$pageTitle = "Crear Cuenta";
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/pets_helper.php';
require_once __DIR__ . '/config/recaptcha.php';

$error = '';
$nombre = '';
$email = '';
$telefono = '';
$direccion = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    // 1. Validaciones de campos de entrada
    if (empty($nombre) || empty($email) || empty($password)) {
        $error = 'Por favor completa todos los campos obligatorios (*).';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico ingresado no tiene un formato válido.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres por seguridad.';
    } elseif ($password !== $password_confirm) {
        $error = 'Las contraseñas no coinciden. Por favor verifícalas.';
    } else {
        // 2. VALIDACIÓN DE GOOGLE reCAPTCHA EN EL SERVIDOR (PHP)
        // Evita que bots completen el registro de forma automatizada
        $resultadoCaptcha = verificarGoogleReCaptcha($recaptchaResponse);

        if (!$resultadoCaptcha['valido']) {
            $error = $resultadoCaptcha['error'];
        } else {
            $pdo = getDB();

            if ($pdo) {
                try {
                    // 3. Consulta preparada para verificar si el correo ya existe (Previene SQL Injection)
                    $checkStmt = $pdo->prepare("SELECT id FROM `usuarios` WHERE `email` = :email LIMIT 1");
                    $checkStmt->execute([':email' => $email]);

                    if ($checkStmt->fetch()) {
                        $error = 'Ya existe una cuenta registrada con este correo electrónico.';
                    } else {
                        // 4. HASHING MEDIANTE BCRYPT: La contraseña NUNCA se almacena en texto plano
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                        // 5. Inserción protegida mediante consulta preparada
                        $insertStmt = $pdo->prepare("
                            INSERT INTO `usuarios` (`nombre`, `email`, `password`, `telefono`, `direccion`, `rol`, `fecha_registro`) 
                            VALUES (:nombre, :email, :password, :telefono, :direccion, 'adoptante', NOW())
                        ");

                        $insertStmt->execute([
                            ':nombre'    => $nombre,
                            ':email'     => $email,
                            ':password'  => $passwordHash,
                            ':telefono'  => $telefono,
                            ':direccion' => $direccion
                        ]);

                        $nuevoId = $pdo->lastInsertId();

                        // 6. Iniciar sesión segura para el nuevo usuario verificado
                        session_regenerate_id(true);
                        $_SESSION['usuario_id'] = $nuevoId;
                        $_SESSION['usuario_nombre'] = $nombre;
                        $_SESSION['usuario_email'] = $email;
                        $_SESSION['usuario_rol'] = 'adoptante';

                        setFlash('success', '¡Cuenta creada y verificada con éxito! Bienvenido a Adopta una Mascota.');
                        header('Location: ' . BASE_URL . '/index.php');
                        exit;
                    }
                } catch (PDOException $e) {
                    error_log("Error en registro: " . $e->getMessage());
                    $error = 'Error en el servidor de base de datos. Por favor intenta más tarde.';
                }
            } else {
                $error = 'No se pudo conectar a la base de datos MySQL en XAMPP. Asegúrate de que el servicio MySQL esté iniciado en el panel de control de XAMPP.';
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Script Oficial de Google reCAPTCHA v2 -->
<script src="https://www.google.com/recaptcha/api.js?hl=es" async defer></script>

<div class="container py-5">
    <div class="auth-container" style="max-width: 540px;">
        <div class="auth-card">
            <div class="text-center mb-4">
                <span class="logo-icon mb-2"><i class="bi bi-paw-fill"></i></span>
                <h2 class="fw-bold text-verde-oscuro mb-1">Crea tu Cuenta</h2>
                <p class="text-muted small">Únete a nuestra comunidad de adoptantes y amantes de los animales</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger rounded-4 d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                    <div><?= sanitize($error) ?></div>
                </div>
            <?php endif; ?>

            <form action="registro.php" method="POST" id="formRegistro">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-4 text-muted">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="nombre" id="nombre" class="form-control border-start-0 rounded-end-4" placeholder="Ej. Ana Martínez" value="<?= sanitize($nombre) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-4 text-muted">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="form-control border-start-0 rounded-end-4" placeholder="tucorreo@ejemplo.com" value="<?= sanitize($email) ?>" required>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono Móvil</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-4 text-muted">
                                <i class="bi bi-telephone"></i>
                            </span>
                            <input type="tel" name="telefono" id="telefono" class="form-control border-start-0 rounded-end-4" placeholder="55 1234 5678" value="<?= sanitize($telefono) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Ciudad / Colonia</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-4 text-muted">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <input type="text" name="direccion" id="direccion" class="form-control border-start-0 rounded-end-4" placeholder="Tu ciudad" value="<?= sanitize($direccion) ?>">
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" name="password" id="password" class="form-control rounded-4" placeholder="Mínimo 6 caracteres" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirm" class="form-label">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control rounded-4" placeholder="Repite contraseña" required>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="terms" required checked>
                    <label class="form-check-label small text-muted" for="terms">
                        Acepto los términos de tenencia responsable y política de adopción
                    </label>
                </div>

                <!-- Google reCAPTCHA v2 ("No soy un robot") -->
                <div class="recaptcha-wrapper mb-3 text-center">
                    <div class="g-recaptcha d-inline-block" data-sitekey="<?= RECAPTCHA_SITE_KEY ?>"></div>
                    <div class="form-text small text-muted mt-1">
                        <i class="bi bi-shield-check text-verde"></i> Verificación de seguridad anti-spam
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-naranja py-3 text-white fs-6">
                        <i class="bi bi-person-check-fill me-1"></i> Registrarme Ahora
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 pt-2">
                <p class="text-muted mb-0 small">
                    ¿Ya tienes una cuenta? 
                    <a href="login.php" class="text-verde fw-bold">Inicia sesión aquí</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
