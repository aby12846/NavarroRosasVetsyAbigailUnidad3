<?php
// nosotros.php - Sobre Nosotros
$pageTitle = "Sobre Nosotros";
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4 py-md-5">
    <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-heart-pulse-fill me-1"></i> Nuestra Misión
            </span>
            <h1 class="display-6 fw-bold text-verde-oscuro mt-1 mb-3">Uniendo corazones, transformando vidas</h1>
            <p class="text-muted fs-5 mb-4">
                <strong>Adopta una Mascota</strong> nació del sueño de construir un puente de empatía y compasión entre los miles de perros y gatos abandonados y aquellas personas con ganas de brindar amor verdadero.
            </p>
            <p class="text-muted">
                Creemos firmemente que cada animal merece respeto, cuidados y una familia donde no vuelva a conocer el frío de la calle o la indiferencia. Trabajamos día a día con refugios aliados, rescatistas independientes y veterinarios comprometidos.
            </p>
            <div class="d-flex gap-3 mt-4">
                <a href="<?= BASE_URL ?>/mascotas.php" class="btn btn-verde px-4 py-2">
                    <i class="bi bi-search me-1"></i> Conoce las Mascotas
                </a>
                <a href="<?= BASE_URL ?>/contacto.php" class="btn btn-outline-verde px-4 py-2">
                    <i class="bi bi-envelope me-1"></i> Contáctanos
                </a>
            </div>
        </div>

        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=1000&q=80" 
                 alt="Perros felices corriendo al aire libre" 
                 class="img-fluid rounded-4 shadow-sm">
        </div>
    </div>

    <!-- Valores -->
    <div class="row g-4 my-4">
        <div class="col-lg-4">
            <div class="card card-custom p-4 h-100">
                <div class="step-icon text-verde mb-3">
                    <i class="bi bi-shield-heart"></i>
                </div>
                <h4 class="fw-bold text-verde-oscuro mb-2">Compromiso Ético</h4>
                <p class="text-muted small mb-0">
                    Cero sacrificios innecesarios. Cada animal es cuidado, rehabilitado física y emocionalmente hasta encontrar a su familia adecuada.
                </p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-custom p-4 h-100">
                <div class="step-icon text-verde mb-3">
                    <i class="bi bi-transparency"></i>
                </div>
                <h4 class="fw-bold text-verde-oscuro mb-2">Transparencia Total</h4>
                <p class="text-muted small mb-0">
                    Procesos claros de adopción, seguimiento post-adopción y cartillas sanitarias completas sin costos ocultos.
                </p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-custom p-4 h-100">
                <div class="step-icon text-verde mb-3">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h4 class="fw-bold text-verde-oscuro mb-2">Comunidad Solidaria</h4>
                <p class="text-muted small mb-0">
                    Una red de voluntarios, familias adoptantes y donantes unidos por la causa del bienestar animal.
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

