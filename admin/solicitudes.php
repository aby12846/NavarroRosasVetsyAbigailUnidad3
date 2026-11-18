<?php
// admin/solicitudes.php - Gestión de Solicitudes de Adopción
$pageTitle = "Solicitudes de Adopción";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/pets_helper.php';

// Manejo de actualización de estado
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['solicitud_id'])) {
    $solId = intval($_POST['solicitud_id']);
    $nuevoEstado = trim($_POST['nuevo_estado'] ?? 'Pendiente');
    $notasAdmin = trim($_POST['notas_admin'] ?? '');

    updateSolicitudEstado($solId, $nuevoEstado, $notasAdmin);
    setFlash('success', "Estado de la solicitud #{$solId} actualizado a '{$nuevoEstado}'.");
    header('Location: solicitudes.php');
    exit;
}

$todas = getAllSolicitudes();
$filtroEstado = $_GET['estado'] ?? 'todos';

if ($filtroEstado !== 'todos' && !empty($filtroEstado)) {
    $solicitudes = array_filter($todas, fn($s) => strtolower($s['estado']) === strtolower($filtroEstado));
} else {
    $solicitudes = $todas;
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="container py-4 py-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-inbox-fill me-1"></i> Control de Procesos
            </span>
            <h1 class="display-6 fw-bold text-verde-oscuro mt-1 mb-0">Solicitudes de Adopción</h1>
            <p class="text-muted mb-0">Evalúa a los postulantes, aprueba o actualiza el estado del trámite.</p>
        </div>
        
        <!-- Filtros rápidos por estado -->
        <div class="d-flex flex-wrap gap-2">
            <a href="solicitudes.php?estado=todos" class="btn btn-sm <?= ($filtroEstado === 'todos') ? 'btn-verde' : 'btn-outline-verde' ?>">
                Todas (<?= count($todas) ?>)
            </a>
            <a href="solicitudes.php?estado=pendiente" class="btn btn-sm <?= ($filtroEstado === 'pendiente') ? 'btn-naranja' : 'btn-outline-naranja' ?>">
                Pendientes
            </a>
            <a href="solicitudes.php?estado=en revisión" class="btn btn-sm <?= ($filtroEstado === 'en revisión') ? 'btn-verde-oscuro' : 'btn-outline-secondary' ?>">
                En revisión
            </a>
            <a href="solicitudes.php?estado=aprobada" class="btn btn-sm <?= ($filtroEstado === 'aprobada') ? 'btn-success' : 'btn-outline-success' ?>">
                Aprobadas
            </a>
        </div>
    </div>

    <div class="row g-4">
        <?php if (!empty($solicitudes)): ?>
            <?php foreach ($solicitudes as $s): ?>
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
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="<?= sanitize($s['mascota_foto']) ?>" class="rounded-4" style="width: 65px; height: 65px; object-fit: cover;">
                                <div>
                                    <h4 class="fw-bold text-verde-oscuro mb-0"><?= sanitize($s['mascota_nombre']) ?></h4>
                                    <span class="text-muted small"><?= ucfirst(sanitize($s['especie'])) ?> &bull; <?= sanitize($s['raza']) ?></span>
                                </div>
                            </div>
                            <span class="badge <?= $badgeClass ?> px-3 py-2 rounded-pill small">
                                <?= sanitize($s['estado']) ?>
                            </span>
                        </div>

                        <div class="bg-crema p-3 rounded-3 mb-3 small">
                            <div class="fw-bold text-dark mb-1"><i class="bi bi-person-fill text-verde me-1"></i> <?= sanitize($s['nombre_solicitante']) ?></div>
                            <div class="text-muted"><i class="bi bi-envelope me-1"></i> <?= sanitize($s['email_solicitante']) ?></div>
                            <div class="text-muted"><i class="bi bi-telephone me-1"></i> <?= sanitize($s['telefono_solicitante']) ?></div>
                            <div class="text-muted"><i class="bi bi-geo-alt me-1"></i> <?= sanitize($s['ciudad']) ?> | <?= sanitize($s['tipo_vivienda']) ?> (<?= !empty($s['tiene_patio']) ? 'Con patio' : 'Sin patio' ?>)</div>
                        </div>

                        <div class="mb-3">
                            <span class="fw-semibold text-verde-oscuro small">Motivo de adopción:</span>
                            <p class="text-muted small mb-0 fst-italic">"<?= sanitize($s['motivo']) ?>"</p>
                        </div>

                        <?php if (!empty($s['otras_mascotas'])): ?>
                            <div class="small text-muted mb-3">
                                <strong>Otras mascotas en casa:</strong> <?= sanitize($s['otras_mascotas']) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Formulario para cambiar estado -->
                        <div class="mt-auto pt-3 border-top">
                            <form method="POST" action="solicitudes.php" class="row g-2 align-items-end">
                                <input type="hidden" name="solicitud_id" value="<?= $s['id'] ?>">
                                
                                <div class="col-sm-5">
                                    <label class="form-label small mb-1">Cambiar estado:</label>
                                    <select name="nuevo_estado" class="form-select form-select-sm">
                                        <option value="Pendiente" <?= ($s['estado'] === 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                                        <option value="En revisión" <?= ($s['estado'] === 'En revisión') ? 'selected' : '' ?>>En revisión</option>
                                        <option value="Aprobada" <?= ($s['estado'] === 'Aprobada') ? 'selected' : '' ?>>Aprobada</option>
                                        <option value="Rechazada" <?= ($s['estado'] === 'Rechazada') ? 'selected' : '' ?>>Rechazada</option>
                                    </select>
                                </div>

                                <div class="col-sm-5">
                                    <label class="form-label small mb-1">Nota al adoptante:</label>
                                    <input type="text" name="notas_admin" class="form-control form-control-sm" placeholder="Respuesta..." value="<?= sanitize($s['notas_admin'] ?? '') ?>">
                                </div>

                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-naranja btn-sm w-100 text-white" title="Guardar estado">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">No se encontraron solicitudes con este filtro.</p>
                <a href="solicitudes.php" class="btn btn-outline-verde">Ver todas las solicitudes</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
