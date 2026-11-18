<?php
// index.php - Página Principal
$pageTitle = "Inicio";
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/pets_helper.php';

// Mascotas destacadas para la portada
$mascotasDestacadas = getAllPets(['destacado' => 1]);
if (count($mascotasDestacadas) > 6) {
    $mascotasDestacadas = array_slice($mascotasDestacadas, 0, 6);
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- ============================================================
     SECCIÓN HERO PRINCIPAL
     ============================================================ -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge">
                    <i class="bi bi-heart-pulse-fill text-naranja"></i> Adopción Responsable
                </span>
                <h1 class="hero-title">Encuentra a tu nuevo mejor amigo</h1>
                <p class="hero-subtitle">
                    Miles de mascotas esperan una segunda oportunidad. ¡Dales un hogar lleno de amor! Descubre perros y gatos listos para llenar tus días de alegría y lealtad.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= BASE_URL ?>/mascotas.php" class="btn btn-verde btn-lg px-4 py-3">
                        <i class="bi bi-search-heart"></i> Conocer mascotas
                    </a>
                    <a href="<?= BASE_URL ?>/como_adoptar.php" class="btn btn-outline-verde btn-lg px-4 py-3">
                        <i class="bi bi-info-circle"></i> ¿Cómo adoptar?
                    </a>
                </div>

                <!-- Métricas destacadas -->
                <div class="row mt-5 pt-3 g-3 border-top" style="border-color: rgba(63, 98, 69, 0.15) !important;">
                    <div class="col-4">
                        <div class="fw-bold text-verde-oscuro fs-3">+450</div>
                        <div class="text-muted small">Adopciones felices</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-verde-oscuro fs-3">100%</div>
                        <div class="text-muted small">Salud verificada</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-verde-oscuro fs-3">24/7</div>
                        <div class="text-muted small">Apoyo post-adopción</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-img-container">
                    <!-- Fotografía grande y atractiva de un perro y un gato juntos -->
                    <img src="https://images.unsplash.com/photo-1623387641168-d9803ddd3f35?auto=format&fit=crop&w=1200&q=80" 
                         alt="Perro y gato felices juntos esperando un hogar" 
                         class="hero-img img-fluid">
                    
                    <div class="hero-floating-badge">
                        <div class="hero-floating-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark mb-0 small">Vacunados y desparasitados</div>
                            <div class="text-muted" style="font-size: 0.78rem;">Listos para ir a su nuevo hogar</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SECCIÓN DE MASCOTAS DESTACADAS
     ============================================================ -->
<section class="py-5" style="background-color: rgba(255, 255, 255, 0.5);">
    <div class="container py-4">
        <div class="row justify-content-between align-items-end mb-5">
            <div class="col-md-8">
                <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                    <i class="bi bi-stars me-1"></i> Esperando por ti
                </span>
                <h2 class="display-6 fw-bold text-verde-oscuro mt-1">Mascotas Destacadas</h2>
                <p class="text-muted mb-0">
                    Conoce a algunos de nuestros amigos que están listos para ser parte de tu familia.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="<?= BASE_URL ?>/mascotas.php" class="btn btn-outline-verde">
                    Ver todas las mascotas <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($mascotasDestacadas)): ?>
                <?php foreach ($mascotasDestacadas as $pet): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="pet-card">
                            <div class="pet-img-wrap">
                                <img src="<?= sanitize($pet['foto']) ?>" 
                                     alt="<?= sanitize($pet['nombre']) ?>" 
                                     loading="lazy">
                                <span class="badge-specie">
                                    <i class="bi <?= $pet['especie'] === 'perro' ? 'bi-emoji-smile' : 'bi-moon-stars' ?> me-1"></i>
                                    <?= ucfirst(sanitize($pet['especie'])) ?>
                                </span>
                                <span class="badge-status badge-<?= strtolower($pet['estado']) === 'disponible' ? 'disponible' : (strtolower($pet['estado']) === 'en proceso' ? 'proceso' : 'adoptado') ?>">
                                    <?= sanitize($pet['estado']) ?>
                                </span>
                            </div>
                            <div class="pet-card-body">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h3 class="pet-card-title mb-0"><?= sanitize($pet['nombre']) ?></h3>
                                    <span class="text-muted small">
                                        <i class="bi <?= $pet['sexo'] === 'Macho' ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger' ?>"></i>
                                        <?= sanitize($pet['sexo']) ?>
                                    </span>
                                </div>
                                <div class="pet-card-breed"><?= sanitize($pet['raza']) ?></div>

                                <div class="pet-meta-grid">
                                    <div class="pet-meta-item">
                                        <i class="bi bi-clock-history"></i>
                                        <span><?= sanitize($pet['edad']) ?></span>
                                    </div>
                                    <div class="pet-meta-item">
                                        <i class="bi bi-arrows-angle-expand"></i>
                                        <span><?= sanitize($pet['tamano']) ?></span>
                                    </div>
                                    <div class="pet-meta-item col-span-2" style="grid-column: span 2;">
                                        <i class="bi bi-geo-alt-fill text-naranja"></i>
                                        <span class="text-truncate"><?= sanitize($pet['ubicacion']) ?></span>
                                    </div>
                                </div>

                                <div class="pet-card-footer">
                                    <a href="<?= BASE_URL ?>/detalles.php?id=<?= $pet['id'] ?>" class="btn btn-naranja w-100 text-white">
                                        <i class="bi bi-heart"></i> Conocer más
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">No hay mascotas destacadas en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     SECCIÓN ¿CÓMO FUNCIONA LA ADOPCIÓN? (3 PASOS)
     ============================================================ -->
<section class="py-5" id="como-funciona">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-signpost-2 me-1"></i> Proceso Simple y Transparente
            </span>
            <h2 class="display-6 fw-bold text-verde-oscuro mt-1">¿Cómo funciona la adopción?</h2>
            <p class="text-muted">
                Nuestro proceso está diseñado para asegurar el bienestar del animal y hacer que tu experiencia sea maravillosa y segura.
            </p>
        </div>

        <div class="row g-4 mt-2">
            <!-- Paso 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h4 class="fw-bold text-verde-oscuro mb-3">Encuentra a tu compañero</h4>
                    <p class="text-muted mb-0">
                        Explora nuestro catálogo con fotos reales y filtros detallados para conocer la personalidad, edad y tamaño del perro o gato que mejor se adapte a tu estilo de vida.
                    </p>
                </div>
            </div>

            <!-- Paso 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h4 class="fw-bold text-verde-oscuro mb-3">Envía tu solicitud</h4>
                    <p class="text-muted mb-0">
                        Completa un breve formulario en línea con tus datos y detalles sobre tu hogar. Nuestro equipo de adopciones revisará la compatibilidad con el animal.
                    </p>
                </div>
            </div>

            <!-- Paso 3 -->
            <div class="col-lg-4 col-md-6 mx-auto">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="bi bi-house-heart"></i>
                    </div>
                    <h4 class="fw-bold text-verde-oscuro mb-3">Conoce y dale un hogar</h4>
                    <p class="text-muted mb-0">
                        Coordinamos una visita presencial para que se conozcan personalmente. Formalizamos el compromiso y le das la bienvenida a su nueva familia.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="<?= BASE_URL ?>/mascotas.php" class="btn btn-verde btn-lg px-5">
                <i class="bi bi-arrow-right-circle"></i> Iniciar proceso de adopción
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     SECCIÓN DE BENEFICIOS DE ADOPTAR
     ============================================================ -->
<section class="py-5" style="background-color: rgba(255, 255, 255, 0.65);">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-gift me-1"></i> Amor Incondicional
            </span>
            <h2 class="display-6 fw-bold text-verde-oscuro mt-1">Beneficios de Adoptar</h2>
            <p class="text-muted">
                Adoptar no solo transforma la vida de un animal sin hogar, también enriquece la tuya en muchísimos aspectos.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-verde-oscuro mb-2">Salvas una vida inocente</h4>
                        <p class="text-muted mb-0">
                            Al adoptar, rescatas a un animal vulnerable del abandono y liberas un espacio en el refugio para que otro compañero pueda ser salvado.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-emoji-smile"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-verde-oscuro mb-2">Compañía y bienestar emocional</h4>
                        <p class="text-muted mb-0">
                            Estudios demuestran que convivir con una mascota reduce los niveles de estrés, combate la soledad y fomenta un estilo de vida más activo y feliz.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-verde-oscuro mb-2">Salud y vacunación al día</h4>
                        <p class="text-muted mb-0">
                            Nuestras mascotas se entregan desparasitadas, con cartilla de vacunación y esterilización realizada o programada, garantizando su bienestar.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-verde-oscuro mb-2">Combates el comercio irresponsable</h4>
                        <p class="text-muted mb-0">
                            Dices NO a los criaderos clandestinos y a la explotación animal, promoviendo una cultura de respeto, compasión y tenencia responsable.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SECCIÓN UBICACIÓN DE CENTROS DE ADOPCIÓN (GOOGLE MAPS)
     ============================================================ -->
<section class="py-5" id="centros-adopcion" style="background-color: rgba(255, 255, 255, 0.45);">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-geo-alt-fill me-1"></i> Red de Refugios Aliados
            </span>
            <h2 class="display-6 fw-bold text-verde-oscuro mt-1">Ubicación de centros de adopción</h2>
            <p class="text-muted">
                Visita nuestros refugios y centros de adopción autorizados. Conoce en persona a los perritos y gatitos que esperan por una familia amorosa. Haz clic en cualquiera de ellos para ver su ubicación en el mapa.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Selector Interactivo de Refugios -->
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3 h-100 justify-content-between">
                    <!-- Refugio 1 (Activo por defecto) -->
                    <div class="shelter-card active" 
                         data-map-url="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3764.582845688534!2d-99.1824194!3d19.3438965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce0003b879a835%3A0xc3cf94bb3583bb37!2sAv.%20Miguel%20%C3%81ngel%20de%20Quevedo%20850%2C%20Parque%20San%20Andr%C3%A9s%2C%20Coyoac%C3%A1n%2C%2004040%20Ciudad%20de%20M%C3%A9xico%2C%20CDMX!5e0!3m2!1ses!2smx!4v1700000000000!5m2!1ses!2smx">
                        <div class="d-flex align-items-start gap-3">
                            <div class="shelter-icon-circle">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold text-verde-oscuro mb-0">Refugio Central "Esperanza"</h5>
                                    <span class="badge bg-verde text-white rounded-pill small">Sede Principal</span>
                                </div>
                                <p class="text-muted small mb-2">Av. Miguel Ángel de Quevedo #850, Coyoacán, CDMX</p>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span><i class="bi bi-clock me-1 text-naranja"></i> Lun - Sáb: 9:00 - 18:00</span>
                                    <span><i class="bi bi-telephone me-1 text-verde"></i> 55 8000-ADOPTA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Refugio 2 -->
                    <div class="shelter-card" 
                         data-map-url="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.846875586616!2d-103.3693635!3d20.6758079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b18a1a9e8839%3A0x6b7724a2efca820e!2sAv.%20Chapultepec%20Sur%20450%2C%20Americana%2C%2044160%20Guadalajara%2C%20Jal.!5e0!3m2!1ses!2smx!4v1700000000001!5m2!1ses!2smx">
                        <div class="d-flex align-items-start gap-3">
                            <div class="shelter-icon-circle">
                                <i class="bi bi-house-heart-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold text-verde-oscuro mb-0">Centro "Huellitas Guadalajara"</h5>
                                    <span class="badge bg-crema text-verde-oscuro border rounded-pill small">Jalisco</span>
                                </div>
                                <p class="text-muted small mb-2">Av. Chapultepec Sur #450, Col. Americana, Guadalajara</p>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span><i class="bi bi-clock me-1 text-naranja"></i> Mar - Dom: 10:00 - 17:00</span>
                                    <span><i class="bi bi-telephone me-1 text-verde"></i> 33 3812-4455</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Refugio 3 -->
                    <div class="shelter-card" 
                         data-map-url="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3596.5363365876356!2d-100.2893541!3d25.6535128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8662bf75e672727d%3A0x2db4bc2be966ce1e!2sAv.%20Eugenio%20Garza%20Sada%202145%2C%20Roma%2C%2064700%20Monterrey%2C%20N.L.!5e0!3m2!1ses!2smx!4v1700000000002!5m2!1ses!2smx">
                        <div class="d-flex align-items-start gap-3">
                            <div class="shelter-icon-circle">
                                <i class="bi bi-heart-pulse-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold text-verde-oscuro mb-0">Albergue "San Roque Monterrey"</h5>
                                    <span class="badge bg-crema text-verde-oscuro border rounded-pill small">Nuevo León</span>
                                </div>
                                <p class="text-muted small mb-2">Av. Eugenio Garza Sada #2145, Col. Roma, Monterrey</p>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span><i class="bi bi-clock me-1 text-naranja"></i> Lun - Sáb: 9:30 - 17:30</span>
                                    <span><i class="bi bi-telephone me-1 text-verde"></i> 81 8358-1122</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenedor Responsivo de Google Maps -->
            <div class="col-lg-7">
                <div class="map-container h-100">
                    <iframe id="shelterMapIframe" 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3764.582845688534!2d-99.1824194!3d19.3438965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce0003b879a835%3A0xc3cf94bb3583bb37!2sAv.%20Miguel%20%C3%81ngel%20de%20Quevedo%20850%2C%20Parque%20San%20Andr%C3%A9s%2C%20Coyoac%C3%A1n%2C%2004040%20Ciudad%20de%20M%C3%A9xico%2C%20CDMX!5e0!3m2!1ses!2smx!4v1700000000000!5m2!1ses!2smx" 
                            title="Ubicación de centros de adopción en Google Maps" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     BANNER LLAMADO A LA ACCIÓN (CTA)
     ============================================================ -->
<section class="py-5">
    <div class="container">
        <div class="card card-custom border-0 p-4 p-md-5 text-white" style="background: linear-gradient(135deg, var(--verde-principal), var(--verde-oscuro));">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold text-white mb-3">¿Listo para cambiar una vida para siempre?</h2>
                    <p class="text-white-50 fs-5 mb-0">
                        Cada uno de ellos tiene una mirada llena de esperanza. Explora los perfiles de nuestros perros y gatos y encuentra a tu fiel compañero hoy mismo.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?= BASE_URL ?>/mascotas.php" class="btn btn-naranja btn-lg px-4 py-3 text-white">
                        <i class="bi bi-paw me-1"></i> Explorar Catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

