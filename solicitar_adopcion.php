<?php
// solicitar_adopcion.php - Procesar solicitud de adopción con Consultas Preparadas y Sanitización
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/pets_helper.php';

if (!isLoggedIn()) {
    setFlash('warning', 'Debes iniciar sesión para poder enviar una solicitud de adopción.');
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: ' . BASE_URL . '/mascotas.php');
    exit;
}

$user = currentUser();

// 1. Sanitización y validación estricta de datos de entrada (Previene XSS y SQL Injection)
$mascotaId    = isset($_POST['mascota_id']) ? intval($_POST['mascota_id']) : 0;
$nombre       = trim(strip_tags($_POST['nombre'] ?? ''));
$email        = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$telefono     = trim(strip_tags($_POST['telefono'] ?? ''));
$ciudad       = trim(strip_tags($_POST['ciudad'] ?? ''));
$viviendasValidas = ['Casa propia', 'Casa alquilada', 'Departamento propio', 'Departamento alquilado'];
$tipoVivienda = in_array($_POST['tipo_vivienda'] ?? '', $viviendasValidas, true) ? $_POST['tipo_vivienda'] : 'Casa propia';
$tienePatio   = !empty($_POST['tiene_patio']) ? 1 : 0;
$otrasMascotas= trim(strip_tags($_POST['otras_mascotas'] ?? ''));
$motivo       = trim(strip_tags($_POST['motivo'] ?? ''));

// Verificar que la mascota existe mediante consulta preparada
$mascota = getPetById($mascotaId);
if (!$mascota) {
    setFlash('error', 'La mascota indicada no fue encontrada en nuestro catálogo.');
    header('Location: ' . BASE_URL . '/mascotas.php');
    exit;
}

if (empty($nombre) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($telefono) || empty($motivo)) {
    setFlash('error', 'Por favor completa todos los campos requeridos con información válida.');
    header('Location: ' . BASE_URL . '/detalles.php?id=' . $mascotaId);
    exit;
}

// 2. Inserción protegida en MySQL mediante PDO Prepared Statements
$pdo = getDB();
if ($pdo) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO `solicitudes` (
                `mascota_id`, `usuario_id`, `nombre_solicitante`, `email_solicitante`, 
                `telefono_solicitante`, `ciudad`, `tipo_vivienda`, `tiene_patio`, 
                `otras_mascotas`, `motivo`, `estado`, `fecha_solicitud`
            ) VALUES (
                :mascota_id, :usuario_id, :nombre, :email, 
                :telefono, :ciudad, :tipo_vivienda, :tiene_patio, 
                :otras_mascotas, :motivo, 'Pendiente', NOW()
            )
        ");

        $stmt->execute([
            ':mascota_id'    => $mascotaId,
            ':usuario_id'    => $user['id'],
            ':nombre'        => $nombre,
            ':email'         => $email,
            ':telefono'      => $telefono,
            ':ciudad'        => $ciudad,
            ':tipo_vivienda' => $tipoVivienda,
            ':tiene_patio'   => $tienePatio,
            ':otras_mascotas'=> $otrasMascotas,
            ':motivo'        => $motivo
        ]);

        // Actualizar el estado de la mascota a 'En proceso' con consulta preparada
        $updateStmt = $pdo->prepare("UPDATE `mascotas` SET `estado` = 'En proceso' WHERE `id` = :id AND `estado` = 'Disponible'");
        $updateStmt->execute([':id' => $mascotaId]);

    } catch (PDOException $e) {
        error_log("Error guardando solicitud en BD: " . $e->getMessage());
    }
}

// Actualizar también la lista en sesión para sincronización instantánea
if (!isset($_SESSION['lista_solicitudes'])) {
    $_SESSION['lista_solicitudes'] = [];
}

$nuevaSolicitud = [
    'id' => time(),
    'mascota_id' => $mascotaId,
    'mascota_nombre' => $mascota['nombre'],
    'especie' => $mascota['especie'],
    'raza' => $mascota['raza'],
    'mascota_foto' => $mascota['foto'],
    'usuario_id' => $user['id'],
    'nombre_solicitante' => $nombre,
    'email_solicitante' => $email,
    'telefono_solicitante' => $telefono,
    'ciudad' => $ciudad,
    'tipo_vivienda' => $tipoVivienda,
    'tiene_patio' => $tienePatio,
    'otras_mascotas' => $otrasMascotas,
    'motivo' => $motivo,
    'estado' => 'Pendiente',
    'notas_admin' => 'Solicitud recibida. En proceso de evaluación por el equipo.',
    'fecha_solicitud' => date('Y-m-d H:i:s')
];

array_unshift($_SESSION['lista_solicitudes'], $nuevaSolicitud);
savePet(['id' => $mascotaId, 'estado' => 'En proceso']);

setFlash('success', "¡Excelente, {$nombre}! Tu solicitud para adoptar a {$mascota['nombre']} ha sido registrada de forma segura.");
header('Location: ' . BASE_URL . '/solicitudes.php');
exit;
?>
