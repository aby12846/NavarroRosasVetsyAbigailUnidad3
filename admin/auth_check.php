<?php
// admin/auth_check.php - Verificación de seguridad para la zona administrativa
require_once __DIR__ . '/../config/db.php';

if (!isLoggedIn()) {
    setFlash('warning', 'Debes iniciar sesión con una cuenta de Administrador.');
    header('Location: ' . BASE_URL . '/login.php?redirect=admin/index.php');
    exit;
}

if (!isAdmin()) {
    setFlash('error', 'Acceso denegado: Se requieren permisos de Administrador.');
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}
?>

