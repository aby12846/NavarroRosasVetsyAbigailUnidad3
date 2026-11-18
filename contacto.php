<?php
// contacto.php - Página de Contacto
$pageTitle = "Contacto";
require_once __DIR__ . '/config/db.php';

$mensajeEnviado = false;
$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    // Sanitización de entradas para prevenir inyecciones y XSS
    $nombre   = trim(strip_tags($_POST['nombre'] ?? ''));
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $telefono = trim(strip_tags($_POST['telefono'] ?? ''));
    $asunto   = trim(strip_tags($_POST['asunto'] ?? ''));
    $mensaje  = trim(strip_tags($_POST['mensaje'] ?? ''));

    if (empty($nombre) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($asunto) || empty($mensaje)) {
        $error = 'Por favor completa todos los campos requeridos con un formato de correo válido.';
    } else {
        $pdo = getDB();
        if ($pdo) {
            try {
                // Consulta preparada con marcadores de posición con nombre (Protección SQL Injection)
                $stmt = $pdo->prepare("
                    INSERT INTO `mensajes_contacto` (`nombre`, `email`, `telefono`, `asunto`, `mensaje`, `fecha_envio`)
                    VALUES (:nombre, :email, :telefono, :asunto, :mensaje, NOW())
                ");
                $stmt->execute([
                    ':nombre'   => $nombre,
                    ':email'    => $email,
                    ':telefono' => $telefono,
                    ':asunto'   => $asunto,
                    ':mensaje'  => $mensaje
                ]);
                $mensajeEnviado = true;
            } catch (PDOException $e) {
                $error = 'Error al registrar tu mensaje: ' . $e->getMessage();
            }
        } else {
            $mensajeEnviado = true;
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4 py-md-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-chat-dots-fill me-1"></i> Estamos Para Ayudarte
            </span>
            <h1 class="display-6 fw-bold text-verde-oscuro mt-1 mb-3">Ponte en Contacto con Nosotros</h1>
            <p class="text-muted fs-5 mb-4">
                ¿Tienes dudas sobre el proceso de adopción, quieres ser voluntario o reportar un caso? Escríbenos y te responderemos a la brevedad.
            </p>

            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="step-icon text-naranja m-0" style="width: 50px; height: 50px; font-size: 1.4rem;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <strong class="text-verde-oscuro">Ubicación</strong>
                        <p class="text-muted mb-0 small">Av. de las Mascotas 404, Ciudad Solidaria</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="step-icon text-naranja m-0" style="width: 50px; height: 50px; font-size: 1.4rem;">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <strong class="text-verde-oscuro">Teléfono</strong>
                        <p class="text-muted mb-0 small">+52 (55) 8000-ADOPTA (236782)</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="step-icon text-naranja m-0" style="width: 50px; height: 50px; font-size: 1.4rem;">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <strong class="text-verde-oscuro">Correo Electrónico</strong>
                        <p class="text-muted mb-0 small">hola@adoptaunamascota.com</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-4 mt-lg-0">
            <div class="card card-custom p-4 p-md-5">
                <h3 class="fw-bold text-verde-oscuro mb-3">Envíanos un Mensaje</h3>

                <?php if ($mensajeEnviado): ?>
                    <div class="alert alert-success rounded-4 d-flex align-items-center p-3 mb-4">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div>
                            <strong>¡Gracias por comunicarte!</strong> Tu mensaje ha sido recibido y te responderemos cuanto antes.
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 d-flex align-items-center p-3 mb-4">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div><?= sanitize($error) ?></div>
                    </div>
                <?php endif; ?>

                <form action="contacto.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tu Nombre *</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej. Juan Pérez" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tu Correo *</label>
                            <input type="email" name="email" class="form-control" placeholder="juan@ejemplo.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" name="telefono" class="form-control" placeholder="55 1234 5678">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Asunto *</label>
                            <input type="text" name="asunto" class="form-control" placeholder="Ej. Duda sobre adopción de Max" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Mensaje *</label>
                            <textarea name="mensaje" rows="4" class="form-control" placeholder="Escribe aquí tu consulta o mensaje..." required></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-naranja text-white w-100 py-3 fs-6">
                                <i class="bi bi-send-fill me-1"></i> Enviar Mensaje
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SECCIÓN UBICACIÓN DE CENTROS DE ADOPCIÓN (GOOGLE MAPS) -->
    <div class="mt-5 pt-4 border-top">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-geo-alt-fill me-1"></i> Ven a Visitarnos
            </span>
            <h2 class="display-6 fw-bold text-verde-oscuro mt-1">Ubicación de centros de adopción</h2>
            <p class="text-muted">
                Contamos con múltiples refugios y sedes de adopción donde puedes acudir a convivir y conocer a tu futuro mejor amigo.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3 h-100 justify-content-between">
                    <div class="shelter-card active" 
                         data-map-url="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3764.582845688534!2d-99.1824194!3d19.3438965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce0003b879a835%3A0xc3cf94bb3583bb37!2sAv.%20Miguel%20%C3%81ngel%20de%20Quevedo%20850%2C%20Parque%20San%20Andr%C3%A9s%2C%20Coyoac%C3%A1n%2C%2004040%20Ciudad%20de%20M%C3%A9xico%2C%20CDMX!5e0!3m2!1ses!2smx!4v1700000000000!5m2!1ses!2smx">
                        <div class="d-flex align-items-start gap-3">
                            <div class="shelter-icon-circle">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold text-verde-oscuro mb-0">Refugio Central Coyoacán</h5>
                                    <span class="badge bg-verde text-white rounded-pill small">Sede Principal</span>
                                </div>
                                <p class="text-muted small mb-2">Av. Miguel Ángel de Quevedo #850, CDMX</p>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span><i class="bi bi-clock me-1 text-naranja"></i> 9:00 - 18:00</span>
                                    <span><i class="bi bi-telephone me-1 text-verde"></i> 55 8000-ADOPTA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="shelter-card" 
                         data-map-url="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.846875586616!2d-103.3693635!3d20.6758079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b18a1a9e8839%3A0x6b7724a2efca820e!2sAv.%20Chapultepec%20Sur%20450%2C%20Americana%2C%2044160%20Guadalajara%2C%20Jal.!5e0!3m2!1ses!2smx!4v1700000000001!5m2!1ses!2smx">
                        <div class="d-flex align-items-start gap-3">
                            <div class="shelter-icon-circle">
                                <i class="bi bi-house-heart-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold text-verde-oscuro mb-0">Centro Guadalajara</h5>
                                    <span class="badge bg-crema text-verde-oscuro border rounded-pill small">Jalisco</span>
                                </div>
                                <p class="text-muted small mb-2">Av. Chapultepec Sur #450, Guadalajara</p>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span><i class="bi bi-clock me-1 text-naranja"></i> 10:00 - 17:00</span>
                                    <span><i class="bi bi-telephone me-1 text-verde"></i> 33 3812-4455</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="shelter-card" 
                         data-map-url="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3596.5363365876356!2d-100.2893541!3d25.6535128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8662bf75e672727d%3A0x2db4bc2be966ce1e!2sAv.%20Eugenio%20Garza%20Sada%202145%2C%20Roma%2C%2064700%20Monterrey%2C%20N.L.!5e0!3m2!1ses!2smx!4v1700000000002!5m2!1ses!2smx">
                        <div class="d-flex align-items-start gap-3">
                            <div class="shelter-icon-circle">
                                <i class="bi bi-heart-pulse-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold text-verde-oscuro mb-0">Albergue Monterrey</h5>
                                    <span class="badge bg-crema text-verde-oscuro border rounded-pill small">Nuevo León</span>
                                </div>
                                <p class="text-muted small mb-2">Av. Eugenio Garza Sada #2145, Monterrey</p>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span><i class="bi bi-clock me-1 text-naranja"></i> 9:30 - 17:30</span>
                                    <span><i class="bi bi-telephone me-1 text-verde"></i> 81 8358-1122</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="map-container h-100">
                    <iframe id="shelterMapIframe" 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3764.582845688534!2d-99.1824194!3d19.3438965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce0003b879a835%3A0xc3cf94bb3583bb37!2sAv.%20Miguel%20%C3%81ngel%20de%20Quevedo%20850%2C%20Parque%20San%20Andr%C3%A9s%2C%20Coyoac%C3%A1n%2C%2004040%20Ciudad%20de%20M%C3%A9xico%2C%20CDMX!5e0!3m2!1ses!2smx!4v1700000000000!5m2!1ses!2smx" 
                            title="Mapa de Ubicación de Centros de Adopción" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

