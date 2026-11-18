<?php
// admin/mascotas.php - Listado y Gestión de Mascotas
$pageTitle = "Gestión de Mascotas";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/pets_helper.php';
require_once __DIR__ . '/admin_header.php';

$mascotas = getAllPets();
?>

<div class="container py-4 py-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-paw-fill me-1"></i> Catálogo Administrativo
            </span>
            <h1 class="display-6 fw-bold text-verde-oscuro mt-1 mb-0">Gestión de Mascotas</h1>
            <p class="text-muted mb-0">Administra, da de alta o modifica los datos de los perros y gatos en adopción.</p>
        </div>
        <div>
            <a href="mascotas_crear.php" class="btn btn-naranja text-white">
                <i class="bi bi-plus-circle-fill me-1"></i> Registrar Nueva Mascota
            </a>
        </div>
    </div>

    <div class="card card-custom p-4 border-0">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0">Mascota</th>
                        <th class="border-0">Especie</th>
                        <th class="border-0">Edad y Tamaño</th>
                        <th class="border-0">Ubicación</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mascotas)): ?>
                        <?php foreach ($mascotas as $m): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="<?= sanitize($m['foto']) ?>" 
                                             class="rounded-3 shadow-sm" 
                                             style="width: 55px; height: 55px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-verde-oscuro fs-6"><?= sanitize($m['nombre']) ?></div>
                                            <div class="text-muted small"><?= sanitize($m['raza']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-crema text-verde-oscuro border px-3 py-2 rounded-pill">
                                        <i class="bi <?= $m['especie'] === 'perro' ? 'bi-emoji-smile' : 'bi-moon-stars' ?> me-1"></i>
                                        <?= ucfirst(sanitize($m['especie'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="small fw-medium text-dark"><?= sanitize($m['edad']) ?></div>
                                    <div class="text-muted small"><?= sanitize($m['tamano']) ?> &bull; <?= sanitize($m['sexo']) ?></div>
                                </td>
                                <td class="text-muted small">
                                    <i class="bi bi-geo-alt text-naranja"></i> <?= sanitize($m['ubicacion']) ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= strtolower($m['estado']) === 'disponible' ? 'disponible' : (strtolower($m['estado']) === 'en proceso' ? 'proceso' : 'adoptado') ?> px-3 py-2 rounded-pill small">
                                        <?= sanitize($m['estado']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?= BASE_URL ?>/detalles.php?id=<?= $m['id'] ?>" class="btn btn-outline-secondary btn-sm" title="Ver ficha pública" target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="mascotas_editar.php?id=<?= $m['id'] ?>" class="btn btn-outline-verde btn-sm" title="Editar mascota">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="mascotas_eliminar.php?id=<?= $m['id'] ?>" class="btn btn-outline-danger btn-sm btn-confirm-delete" data-item="<?= sanitize($m['nombre']) ?>" title="Eliminar mascota">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No hay mascotas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

