<?php
// detalles.php - Ficha detallada de la Mascota
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/pets_helper.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mascota = getPetById($id);

if (!$mascota) {
    setFlash('warning', 'La mascota que estás buscando no fue encontrada.');
    header('Location: ' . BASE_URL . '/mascotas.php');
    exit;
}

$pageTitle = $mascota['nombre'] . ' - Detalles de la Mascota';
$user = currentUser();

// Otras mascotas recomendadas
$otrasMascotas = getAllPets(['especie' => $mascota['especie']]);
$otrasMascotas = array_filter($otrasMascotas, fn($m) => $m['id'] != $mascota['id']);
$otrasMascotas = array_slice($otrasMascotas, 0, 3);

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4 py-md-5">
    <!-- Migas de pan (Breadcrumbs) -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php" class="text-verde">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/mascotas.php" class="text-verde">Mascotas</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= sanitize($mascota['nombre']) ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Columna Izquierda: Fotografía principal e imágenes -->
        <div class="col-lg-6">
            <div class="pet-detail-gallery position-relative mb-4">
                <img src="<?= sanitize($mascota['foto']) ?>" 
                     alt="<?= sanitize($mascota['nombre']) ?>" 
                     class="pet-detail-main-img img-fluid">

                <span class="badge-status badge-<?= strtolower($mascota['estado']) === 'disponible' ? 'disponible' : (strtolower($mascota['estado']) === 'en proceso' ? 'proceso' : 'adoptado') ?>" style="font-size: 0.95rem; padding: 0.5rem 1.2rem; top: 20px; right: 20px;">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.65rem;"></i> <?= sanitize($mascota['estado']) ?>
                </span>

                <span class="badge-specie" style="top: 20px; left: 20px; font-size: 0.95rem; padding: 0.5rem 1rem;">
                    <i class="bi <?= $mascota['especie'] === 'perro' ? 'bi-emoji-smile' : 'bi-moon-stars' ?> me-1"></i>
                    <?= ucfirst(sanitize($mascota['especie'])) ?>
                </span>
            </div>

            <!-- Mini galería estética adicional -->
            <div class="row g-2">
                <div class="col-4">
                    <img src="<?= sanitize($mascota['foto']) ?>" class="img-fluid rounded-4 border border-2 border-success" style="height: 100px; width: 100%; object-fit: cover; opacity: 0.95;" alt="Foto 1">
                </div>
                <div class="col-4">
                    <img src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=400&q=80" class="img-fluid rounded-4 border border-light" style="height: 100px; width: 100%; object-fit: cover;" alt="Foto 2">
                </div>
                <div class="col-4">
                    <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?auto=format&fit=crop&w=400&q=80" class="img-fluid rounded-4 border border-light" style="height: 100px; width: 100%; object-fit: cover;" alt="Foto 3">
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Información completa de la Mascota -->
        <div class="col-lg-6">
            <div class="card card-custom p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h1 class="display-6 fw-bold text-verde-oscuro mb-1"><?= sanitize($mascota['nombre']) ?></h1>
                        <p class="text-muted fs-5 mb-0"><?= sanitize($mascota['raza']) ?></p>
                    </div>
                    <span class="fs-3">
                        <i class="bi <?= $mascota['sexo'] === 'Macho' ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger' ?>"></i>
                    </span>
                </div>

                <div class="d-flex align-items-center text-muted mb-4">
                    <i class="bi bi-geo-alt-fill text-naranja me-1 fs-5"></i>
                    <span><?= sanitize($mascota['ubicacion']) ?></span>
                </div>

                <!-- Cuadrícula de Atributos Físicos -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-4 col-6">
                        <div class="pet-info-pill">
                            <span class="label">Edad</span>
                            <span class="value"><?= sanitize($mascota['edad']) ?></span>
                        </div>
                    </div>
                    <div class="col-sm-4 col-6">
                        <div class="pet-info-pill">
                            <span class="label">Sexo</span>
                            <span class="value"><?= sanitize($mascota['sexo']) ?></span>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12">
                        <div class="pet-info-pill">
                            <span class="label">Tamaño</span>
                            <span class="value"><?= sanitize($mascota['tamano']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Historia y Descripción -->
                <h4 class="fw-bold text-verde-oscuro mb-2">Conoce su historia</h4>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    <?= nl2br(sanitize($mascota['descripcion'])) ?>
                </p>

                <!-- Personalidad -->
                <?php if (!empty($mascota['personalidad'])): ?>
                    <h5 class="fw-bold text-verde-oscuro mb-2">Personalidad</h5>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <?php 
                        $traits = explode(',', $mascota['personalidad']);
                        foreach ($traits as $trait): ?>
                            <span class="badge bg-crema text-verde-oscuro border border-success-subtle px-3 py-2 rounded-pill fw-medium">
                                <i class="bi bi-stars text-naranja me-1"></i><?= trim(sanitize($trait)) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Estado de Salud -->
                <h5 class="fw-bold text-verde-oscuro mb-2">Salud y Cuidados</h5>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="health-badge">
                        <i class="bi <?= !empty($mascota['vacunado']) ? 'bi-check-circle-fill' : 'bi-x-circle' ?>"></i>
                        <?= !empty($mascota['vacunado']) ? 'Vacunación al día' : 'Vacunación pendiente' ?>
                    </span>
                    <span class="health-badge">
                        <i class="bi <?= !empty($mascota['desparasitado']) ? 'bi-check-circle-fill' : 'bi-x-circle' ?>"></i>
                        <?= !empty($mascota['desparasitado']) ? 'Desparasitado' : 'Desparasitación pendiente' ?>
                    </span>
                    <span class="health-badge">
                        <i class="bi <?= !empty($mascota['esterilizado']) ? 'bi-check-circle-fill' : 'bi-x-circle' ?>"></i>
                        <?= !empty($mascota['esterilizado']) ? 'Esterilizado' : 'Esterilización programada' ?>
                    </span>
                </div>

                <!-- Botón de Solicitud de Adopción -->
                <div class="mt-2">
                    <?php if (strtolower($mascota['estado']) === 'disponible'): ?>
                        <?php if ($user): ?>
                            <button type="button" class="btn btn-naranja btn-lg w-100 py-3 text-white fs-5" data-bs-toggle="modal" data-bs-target="#modalAdopcion">
                                <i class="bi bi-heart-fill me-2"></i> Solicitar adopción
                            </button>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>/login.php?redirect=detalles.php?id=<?= $mascota['id'] ?>" class="btn btn-naranja btn-lg w-100 py-3 text-white fs-5">
                                <i class="bi bi-heart-fill me-2"></i> Inicia sesión para solicitar adopción
                            </a>
                            <p class="text-center text-muted small mt-2">
                                ¿No tienes cuenta? <a href="<?= BASE_URL ?>/registro.php" class="text-verde fw-semibold">Regístrate gratis aquí</a>.
                            </p>
                        <?php endif; ?>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg w-100 py-3" disabled>
                            <i class="bi bi-info-circle me-1"></i> Esta mascota está en estado: <?= sanitize($mascota['estado']) ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN: OTRAS MASCOTAS QUE PODRÍAN INTERESARTE -->
    <?php if (!empty($otrasMascotas)): ?>
        <div class="mt-5 pt-4">
            <h3 class="fw-bold text-verde-oscuro mb-4">Otros compañeros que buscan un hogar</h3>
            <div class="row g-4">
                <?php foreach ($otrasMascotas as $otra): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="pet-card">
                            <div class="pet-img-wrap" style="height: 200px;">
                                <img src="<?= sanitize($otra['foto']) ?>" alt="<?= sanitize($otra['nombre']) ?>">
                                <span class="badge-status badge-<?= strtolower($otra['estado']) === 'disponible' ? 'disponible' : 'proceso' ?>">
                                    <?= sanitize($otra['estado']) ?>
                                </span>
                            </div>
                            <div class="pet-card-body">
                                <h4 class="pet-card-title mb-1"><?= sanitize($otra['nombre']) ?></h4>
                                <div class="pet-card-breed mb-2"><?= sanitize($otra['raza']) ?> &bull; <?= sanitize($otra['edad']) ?></div>
                                <a href="<?= BASE_URL ?>/detalles.php?id=<?= $otra['id'] ?>" class="btn btn-outline-verde w-100">
                                    Conocer a <?= sanitize($otra['nombre']) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- ============================================================
     MODAL DE SOLICITUD DE ADOPCIÓN
     ============================================================ -->
<?php if ($user && strtolower($mascota['estado']) === 'disponible'): ?>
<div class="modal fade" id="modalAdopcion" tabindex="-1" aria-labelledby="modalAdopcionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-crema border-bottom-0 pb-0">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= sanitize($mascota['foto']) ?>" alt="<?= sanitize($mascota['nombre']) ?>" style="width: 55px; height: 55px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <h4 class="modal-title fw-bold text-verde-oscuro mb-0" id="modalAdopcionLabel">Solicitud para adoptar a <?= sanitize($mascota['nombre']) ?></h4>
                        <p class="text-muted small mb-0">Completa la siguiente información para comenzar la evaluación</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <form action="<?= BASE_URL ?>/solicitar_adopcion.php" method="POST">
                <input type="hidden" name="mascota_id" value="<?= $mascota['id'] ?>">

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" value="<?= sanitize($user['nombre']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="<?= sanitize($user['email']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono de Contacto</label>
                            <input type="tel" name="telefono" class="form-control" placeholder="Ej. 55 1234 5678" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ciudad o Localidad</label>
                            <input type="text" name="ciudad" class="form-control" placeholder="Ej. Ciudad de México" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Vivienda</label>
                            <select name="tipo_vivienda" class="form-select" required>
                                <option value="Casa propia">Casa propia</option>
                                <option value="Casa alquilada">Casa alquilada</option>
                                <option value="Departamento propio">Departamento propio</option>
                                <option value="Departamento alquilado">Departamento alquilado</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">¿Cuentas con patio o jardín?</label>
                            <select name="tiene_patio" class="form-select" required>
                                <option value="1">Sí, tengo patio o área verde</option>
                                <option value="0">No, es espacio cerrado o departamento</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">¿Tienes otras mascotas actualmente?</label>
                            <input type="text" name="otras_mascotas" class="form-control" placeholder="Ej. Un perro esterilizado de 4 años, o Ninguna">
                        </div>
                        <div class="col-12">
                            <label class="form-label">¿Por qué deseas adoptar a <?= sanitize($mascota['nombre']) ?>?</label>
                            <textarea name="motivo" rows="3" class="form-control" placeholder="Cuéntanos un poco sobre tu rutina, tu familia y el amor que le puedes brindar..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top-0 p-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-naranja text-white px-4">
                        <i class="bi bi-send-fill me-1"></i> Enviar mi Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

