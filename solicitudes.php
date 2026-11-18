<?php
// solicitudes.php - Mis Solicitudes de Adopción (Front-End)
$pageTitle = "Mis Solicitudes de Adopción";
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/pets_helper.php';

if (!isLoggedIn()) {
    setFlash('warning', 'Inicia sesión para ver el estado de tus solicitudes.');
    header('Location: ' . BASE_URL . '/login.php?redirect=solicitudes.php');
    exit;
}

$user = currentUser();
$pdo = getDB();
$misSolicitudes = [];

// Consulta protegida contra SQL Injection con Prepared Statements
if ($pdo) {
    try {
        if ($user['rol'] === 'admin') {
            $stmt = $pdo->prepare("
                SELECT s.*, m.nombre AS mascota_nombre, m.especie, m.raza, m.foto AS mascota_foto
                FROM `solicitudes` s
                JOIN `mascotas` m ON s.mascota_id = m.id
                ORDER BY s.fecha_solicitud DESC
            ");
            $stmt->execute();
        } else {
            $stmt = $pdo->prepare("
                SELECT s.*, m.nombre AS mascota_nombre, m.especie, m.raza, m.foto AS mascota_foto
                FROM `solicitudes` s
                JOIN `mascotas` m ON s.mascota_id = m.id
                WHERE s.usuario_id = :usuario_id
                ORDER BY s.fecha_solicitud DESC
            ");
            $stmt->execute([':usuario_id' => intval($user['id'])]);
        }
        $misSolicitudes = $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error obteniendo solicitudes: " . $e->getMessage());
    }
}

// Fallback a sesión en caso de que la BD no esté activa en XAMPP
if (empty($misSolicitudes)) {
    $todas = getAllSolicitudes();
    $misSolicitudes = array_filter($todas, function($s) use ($user) {
        return ($s['usuario_id'] == $user['id']) || ($user['rol'] === 'admin');
    });
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4 py-md-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-clock-history me-1"></i> Seguimiento en Vivo
            </span>
            <h1 class="display-6 fw-bold text-verde-oscuro mt-1">Mis Solicitudes de Adopción</h1>
            <p class="text-muted mb-0">Revisa el estado actual del proceso de adopción de tus futuros compañeros de vida.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="<?= BASE_URL ?>/mascotas.php" class="btn btn-naranja text-white">
                <i class="bi bi-plus-circle me-1"></i> Ver más mascotas
            </a>
        </div>
    </div>

    <?php if (empty($misSolicitudes)): ?>
        <div class="card card-custom p-5 text-center my-4">
            <div class="mb-3 text-muted" style="font-size: 3.5rem;">
                <i class="bi bi-journal-text text-verde"></i>
            </div>
            <h3 class="fw-bold text-verde-oscuro mb-2">Aún no tienes solicitudes registradas</h3>
            <p class="text-muted max-w-500 mx-auto mb-4">
                Encuentra al perro o gato ideal para tu hogar en nuestro catálogo y postúlate para darle una segunda oportunidad llena de amor.
            </p>
            <div>
                <a href="<?= BASE_URL ?>/mascotas.php" class="btn btn-verde px-4 py-2">
                    <i class="bi bi-search me-1"></i> Explorar Catálogo
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($misSolicitudes as $s): ?>
                <?php
                    $badgeClass = match($s['estado']) {
                        'Aprobada' => 'bg-success text-white',
                        'En revisión' => 'bg-warning text-dark',
                        'Rechazada' => 'bg-danger text-white',
                        default => 'bg-info text-white'
                    };
                ?>
                <div class="col-lg-6">
                    <div class="card card-custom p-4 h-100">
                        <div class="d-flex gap-3 align-items-start">
                            <img src="<?= sanitize($s['mascota_foto']) ?>" 
                                 alt="<?= sanitize($s['mascota_nombre']) ?>" 
                                 class="rounded-4" 
                                 style="width: 105px; height: 105px; object-fit: cover;">
                            
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h4 class="fw-bold text-verde-oscuro mb-1"><?= sanitize($s['mascota_nombre']) ?></h4>
                                    <span class="badge <?= $badgeClass ?> px-3 py-2 rounded-pill small">
                                        <?= sanitize($s['estado']) ?>
                                    </span>
                                </div>
                                <div class="text-muted small mb-2">
                                    <?= ucfirst(sanitize($s['especie'])) ?> &bull; <?= sanitize($s['raza']) ?>
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-calendar-event me-1 text-verde"></i> Solicitado el: <?= date('d/m/Y H:i', strtotime($s['fecha_solicitud'])) ?>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3" style="border-color: rgba(63, 98, 69, 0.1);">

                        <div class="small text-muted mb-2">
                            <strong>Ciudad:</strong> <?= sanitize($s['ciudad']) ?> | 
                            <strong>Vivienda:</strong> <?= sanitize($s['tipo_vivienda']) ?>
                        </div>

                        <div class="small text-muted mb-3">
                            <strong>Motivo expresado:</strong> 
                            <p class="mb-0 fst-italic">"<?= sanitize($s['motivo']) ?>"</p>
                        </div>

                        <?php if (!empty($s['notas_admin'])): ?>
                            <div class="alert alert-light border rounded-3 p-3 small mb-0">
                                <strong class="text-verde-oscuro"><i class="bi bi-chat-left-quote me-1"></i> Respuesta del Refugio:</strong>
                                <p class="mb-0 mt-1"><?= sanitize($s['notas_admin']) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
