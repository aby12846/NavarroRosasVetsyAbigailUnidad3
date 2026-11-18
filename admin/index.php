<?php
// admin/index.php - Dashboard de Administrador
$pageTitle = "Dashboard";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/pets_helper.php';
require_once __DIR__ . '/admin_header.php';

$mascotas = getAllPets();
$solicitudes = getAllSolicitudes();
$usuarios = getAllUsuarios();

$totalMascotas = count($mascotas);
$disponibles = count(array_filter($mascotas, fn($m) => strtolower($m['estado']) === 'disponible'));
$solicitudesPendientes = count(array_filter($solicitudes, fn($s) => $s['estado'] === 'Pendiente' || $s['estado'] === 'En revisión'));
$totalUsuarios = count($usuarios);
?>

<div class="container py-4 py-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-shield-check me-1"></i> Administración General
            </span>
            <h1 class="display-6 fw-bold text-verde-oscuro mt-1 mb-0">Panel de Control</h1>
            <p class="text-muted mb-0">Bienvenido, <?= sanitize($user['nombre']) ?>. Gestiona tus mascotas y solicitudes de adopción.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="mascotas_crear.php" class="btn btn-naranja text-white">
                <i class="bi bi-plus-lg me-1"></i> Nueva Mascota
            </a>
            <a href="solicitudes.php" class="btn btn-verde text-white">
                <i class="bi bi-inbox me-1"></i> Ver Solicitudes
            </a>
        </div>
    </div>

    <!-- TARJETAS DE MÉTRICAS -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card card-custom p-4 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Total Mascotas</div>
                        <div class="display-6 fw-bold text-verde-oscuro mt-1"><?= $totalMascotas ?></div>
                    </div>
                    <div class="step-icon text-verde m-0" style="width: 55px; height: 55px; font-size: 1.6rem;">
                        <i class="bi bi-paw-fill"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top small text-muted">
                    <span class="text-verde fw-bold"><?= $disponibles ?></span> listas para adopción
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-custom p-4 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Solicitudes Activas</div>
                        <div class="display-6 fw-bold text-naranja mt-1"><?= $solicitudesPendientes ?></div>
                    </div>
                    <div class="step-icon text-naranja m-0" style="width: 55px; height: 55px; font-size: 1.6rem; background: rgba(242, 166, 90, 0.15);">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top small text-muted">
                    <span class="text-naranja fw-bold"><?= count($solicitudes) ?></span> solicitudes en total
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-custom p-4 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Adoptados Felices</div>
                        <div class="display-6 fw-bold text-success mt-1">
                            <?= count(array_filter($mascotas, fn($m) => strtolower($m['estado']) === 'adoptado')) ?>
                        </div>
                    </div>
                    <div class="step-icon text-success m-0" style="width: 55px; height: 55px; font-size: 1.6rem; background: rgba(40, 167, 69, 0.12);">
                        <i class="bi bi-house-heart-fill"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top small text-muted">
                    En sus nuevos hogares
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-custom p-4 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Usuarios</div>
                        <div class="display-6 fw-bold text-verde-oscuro mt-1"><?= $totalUsuarios ?></div>
                    </div>
                    <div class="step-icon text-verde-oscuro m-0" style="width: 55px; height: 55px; font-size: 1.6rem; background: rgba(63, 98, 69, 0.12);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top small text-muted">
                    Adoptantes registrados
                </div>
            </div>
        </div>
    </div>

    <!-- TABLA DE SOLICITUDES RECIENTES -->
    <div class="card card-custom p-4 border-0 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold text-verde-oscuro mb-1">Últimas Solicitudes Recibidas</h4>
                <p class="text-muted small mb-0">Revisa los perfiles de los adoptantes postulados</p>
            </div>
            <a href="solicitudes.php" class="btn btn-outline-verde btn-sm">Ver todas</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0">Mascota</th>
                        <th class="border-0">Solicitante</th>
                        <th class="border-0">Ciudad</th>
                        <th class="border-0">Fecha</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($solicitudes, 0, 5) as $s): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?= sanitize($s['mascota_foto']) ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-verde-oscuro"><?= sanitize($s['mascota_nombre']) ?></div>
                                        <div class="text-muted small"><?= ucfirst(sanitize($s['especie'])) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark"><?= sanitize($s['nombre_solicitante']) ?></div>
                                <div class="text-muted small"><?= sanitize($s['email_solicitante']) ?></div>
                            </td>
                            <td><?= sanitize($s['ciudad']) ?></td>
                            <td class="text-muted small"><?= date('d/m/Y', strtotime($s['fecha_solicitud'])) ?></td>
                            <td>
                                <span class="badge <?= $s['estado'] === 'Aprobada' ? 'bg-success' : ($s['estado'] === 'En revisión' ? 'bg-warning text-dark' : 'bg-info') ?> rounded-pill px-3 py-1">
                                    <?= sanitize($s['estado']) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="solicitudes.php" class="btn btn-outline-verde btn-sm py-1 px-3">
                                    Gestionar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

