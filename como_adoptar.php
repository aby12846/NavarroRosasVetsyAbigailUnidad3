<?php
// como_adoptar.php - Guía del Proceso de Adopción
$pageTitle = "¿Cómo Adoptar?";
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4 py-md-5">
    <div class="text-center max-w-700 mx-auto mb-5">
        <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
            <i class="bi bi-compass me-1"></i> Guía Paso a Paso
        </span>
        <h1 class="display-6 fw-bold text-verde-oscuro mt-1">¿Cómo funciona el proceso de adopción?</h1>
        <p class="text-muted">
            Adoptar es un acto de amor y compromiso. Conoce las etapas y requisitos para darle la bienvenida a tu nuevo compañero de vida.
        </p>
    </div>

    <!-- Etapas Detalladas -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card card-custom p-4 text-center h-100">
                <div class="step-icon mx-auto mb-3">
                    <i class="bi bi-search"></i>
                </div>
                <h4 class="fw-bold text-verde-oscuro mb-2">1. Exploración</h4>
                <p class="text-muted small mb-0">
                    Navega por nuestro catálogo de perros y gatos. Revisa su edad, nivel de energía y personalidad para identificar al compañero ideal para tu hogar.
                </p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card card-custom p-4 text-center h-100">
                <div class="step-icon mx-auto mb-3">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h4 class="fw-bold text-verde-oscuro mb-2">2. Solicitud</h4>
                <p class="text-muted small mb-0">
                    Inicia sesión y llena el formulario en línea explicando tus motivos, tipo de vivienda y experiencia previa con mascotas.
                </p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card card-custom p-4 text-center h-100">
                <div class="step-icon mx-auto mb-3">
                    <i class="bi bi-chat-heart"></i>
                </div>
                <h4 class="fw-bold text-verde-oscuro mb-2">3. Entrevista y Visita</h4>
                <p class="text-muted small mb-0">
                    Nuestro equipo revisa tu perfil y coordinamos una visita para que interactúes con la mascota y compruebes la química mutua.
                </p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card card-custom p-4 text-center h-100">
                <div class="step-icon mx-auto mb-3">
                    <i class="bi bi-house-door"></i>
                </div>
                <h4 class="fw-bold text-verde-oscuro mb-2">4. ¡A Casa!</h4>
                <p class="text-muted small mb-0">
                    Firmamos el contrato de adopción responsable, te entregamos su cartilla veterinaria y ¡empieza su nueva vida juntos!
                </p>
            </div>
        </div>
    </div>

    <!-- Requisitos Comunes -->
    <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=1000&q=80" 
                 alt="Familia feliz con perro adoptado" 
                 class="img-fluid rounded-4 shadow-sm">
        </div>
        <div class="col-lg-6">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-check2-circle me-1"></i> Criterios Importantes
            </span>
            <h2 class="fw-bold text-verde-oscuro mt-1 mb-3">Requisitos para Adoptar</h2>
            <ul class="list-unstyled d-flex flex-column gap-3 text-muted">
                <li class="d-flex align-items-start gap-3">
                    <i class="bi bi-check-circle-fill text-verde fs-5 mt-1"></i>
                    <div>
                        <strong class="text-dark">Ser mayor de edad (18+ años)</strong>
                        <p class="mb-0 small">Contar con identificación oficial vigente (INE, pasaporte o licencia).</p>
                    </div>
                </li>
                <li class="d-flex align-items-start gap-3">
                    <i class="bi bi-check-circle-fill text-verde fs-5 mt-1"></i>
                    <div>
                        <strong class="text-dark">Acuerdo de todos los integrantes del hogar</strong>
                        <p class="mb-0 small">Todos los miembros de la familia deben estar de acuerdo con la llegada de la mascota.</p>
                    </div>
                </li>
                <li class="d-flex align-items-start gap-3">
                    <i class="bi bi-check-circle-fill text-verde fs-5 mt-1"></i>
                    <div>
                        <strong class="text-dark">Espacio seguro y adecuado</strong>
                        <p class="mb-0 small">Garantizar que la vivienda cuenta con protecciones contra escapes y espacio digno.</p>
                    </div>
                </li>
                <li class="d-flex align-items-start gap-3">
                    <i class="bi bi-check-circle-fill text-verde fs-5 mt-1"></i>
                    <div>
                        <strong class="text-dark">Solvencia para su cuidado y salud</strong>
                        <p class="mb-0 small">Capacidad para brindar alimentación de calidad, vacunas anuales y atención médica oportuna.</p>
                    </div>
                </li>
            </ul>

            <div class="mt-4">
                <a href="<?= BASE_URL ?>/mascotas.php" class="btn btn-naranja text-white px-4 py-2">
                    <i class="bi bi-paw me-1"></i> Ver Mascotas Disponibles
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

