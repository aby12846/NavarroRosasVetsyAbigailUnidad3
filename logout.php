<?php
// logout.php - Cierre de Sesión
require_once __DIR__ . '/config/db.php';

session_unset();
session_destroy();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
setFlash('info', 'Has cerrado tu sesión de forma segura.');
header('Location: ' . BASE_URL . '/login.php');
exit;

