<?php
// admin/admin_header.php
require_once __DIR__ . '/auth_check.php';
$adminPage = basename($_SERVER['PHP_SELF']);
$user = currentUser();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? sanitize($pageTitle) . ' | Admin - ' . SITE_NAME : 'Panel de Administrador | ' . SITE_NAME ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
</head>
<body class="bg-crema d-flex flex-column min-vh-100">

    <!-- Admin Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/admin/index.php">
                <span class="logo-icon"><i class="bi bi-shield-lock-fill"></i></span>
                <span>Panel <span class="text-naranja">Admin</span></span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($adminPage == 'index.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/index.php">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($adminPage == 'mascotas.php' || $adminPage == 'mascotas_crear.php' || $adminPage == 'mascotas_editar.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/mascotas.php">
                            <i class="bi bi-paw me-1"></i> Mascotas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($adminPage == 'solicitudes.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/solicitudes.php">
                            <i class="bi bi-file-earmark-check me-1"></i> Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($adminPage == 'usuarios.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/usuarios.php">
                            <i class="bi bi-people me-1"></i> Usuarios
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="<?= BASE_URL ?>/index.php" class="btn btn-outline-verde btn-sm" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Ver Sitio Web
                    </a>
                    <a href="<?= BASE_URL ?>/logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Admin Flash Messages -->
    <?php if ($flash): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= $flash['tipo'] === 'error' ? 'danger' : sanitize($flash['tipo']) ?> alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi <?= $flash['tipo'] === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill' ?> fs-4 me-3"></i>
                <div class="flex-grow-1"><?= sanitize($flash['mensaje']) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

