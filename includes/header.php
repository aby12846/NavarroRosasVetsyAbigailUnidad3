<?php
// includes/header.php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../config/db.php';
}

$currentPage = basename($_SERVER['PHP_SELF']);
$user = currentUser();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? sanitize($pageTitle) . ' | ' . SITE_NAME : SITE_NAME . ' - Encuentra a tu nuevo mejor amigo' ?></title>
    
    <!-- Tipografía Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Estilos Personalizados Oficiales -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
</head>
<body class="bg-crema d-flex flex-column min-vh-100">

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/index.php">
                <span class="logo-icon"><i class="bi bi-paw-fill"></i></span>
                <span>Adopta una <span class="text-naranja">Mascota</span></span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Abrir navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == 'index.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/index.php">
                            <i class="bi bi-house-door me-1"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == 'mascotas.php' || $currentPage == 'detalles.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/mascotas.php">
                            <i class="bi bi-heart me-1"></i> Mascotas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == 'como_adoptar.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/como_adoptar.php">
                            <i class="bi bi-journal-check me-1"></i> Cómo adoptar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == 'nosotros.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/nosotros.php">
                            <i class="bi bi-people me-1"></i> Nosotros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == 'contacto.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/contacto.php">
                            <i class="bi bi-envelope me-1"></i> Contacto
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <?php if ($user): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-verde dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> <?= sanitize($user['nombre']) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 p-2 mt-2">
                                <?php if (isAdmin()): ?>
                                    <li>
                                        <a class="dropdown-item py-2 rounded-3 text-verde-oscuro fw-semibold" href="<?= BASE_URL ?>/admin/index.php">
                                            <i class="bi bi-speedometer2 me-2 text-verde"></i> Panel de Administrador
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item py-2 rounded-3" href="<?= BASE_URL ?>/solicitudes.php">
                                        <i class="bi bi-file-earmark-text me-2 text-verde"></i> Mis Solicitudes
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item py-2 rounded-3 text-danger" href="<?= BASE_URL ?>/logout.php">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/login.php" class="btn btn-outline-verde">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                        </a>
                        <a href="<?= BASE_URL ?>/registro.php" class="btn btn-naranja text-white">
                            <i class="bi bi-person-plus me-1"></i> Registrarse
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alertas Flash -->
    <?php if ($flash): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= $flash['tipo'] === 'error' ? 'danger' : sanitize($flash['tipo']) ?> alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi <?= $flash['tipo'] === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill' ?> fs-4 me-3"></i>
                <div class="flex-grow-1"><?= sanitize($flash['mensaje']) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        </div>
    <?php endif; ?>

