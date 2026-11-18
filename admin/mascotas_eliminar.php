<?php
// admin/mascotas_eliminar.php - Eliminar Mascota
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/pets_helper.php';
require_once __DIR__ . '/auth_check.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mascota = getPetById($id);

if ($mascota) {
    deletePet($id);
    setFlash('success', "La mascota '{$mascota['nombre']}' fue eliminada correctamente.");
} else {
    setFlash('error', "No se encontró la mascota para eliminar.");
}

header('Location: mascotas.php');
exit;

