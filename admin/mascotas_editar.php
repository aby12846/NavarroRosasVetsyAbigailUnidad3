<?php
// admin/mascotas_editar.php - Editar Mascota
$pageTitle = "Editar Mascota";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/pets_helper.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mascota = getPetById($id);

if (!$mascota) {
    setFlash('warning', 'La mascota indicada no existe.');
    header('Location: mascotas.php');
    exit;
}

$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $especie = trim($_POST['especie'] ?? 'perro');
    $raza = trim($_POST['raza'] ?? '');
    $edad = trim($_POST['edad'] ?? '');
    $rango_edad = trim($_POST['rango_edad'] ?? 'joven');
    $sexo = trim($_POST['sexo'] ?? 'Macho');
    $tamano = trim($_POST['tamano'] ?? 'Mediano');
    $ubicacion = trim($_POST['ubicacion'] ?? '');
    $foto = trim($_POST['foto'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $personalidad = trim($_POST['personalidad'] ?? '');
    $vacunado = isset($_POST['vacunado']) ? 1 : 0;
    $desparasitado = isset($_POST['desparasitado']) ? 1 : 0;
    $esterilizado = isset($_POST['esterilizado']) ? 1 : 0;
    $estado = trim($_POST['estado'] ?? 'Disponible');
    $destacado = isset($_POST['destacado']) ? 1 : 0;

    if (empty($nombre) || empty($raza) || empty($edad) || empty($descripcion)) {
        $error = 'Por favor completa todos los campos requeridos (*).';
    } else {
        $mascotaActualizada = [
            'id' => $id,
            'nombre' => $nombre,
            'especie' => $especie,
            'raza' => $raza,
            'edad' => $edad,
            'rango_edad' => $rango_edad,
            'sexo' => $sexo,
            'tamano' => $tamano,
            'ubicacion' => $ubicacion,
            'foto' => $foto,
            'descripcion' => $descripcion,
            'personalidad' => $personalidad,
            'vacunado' => $vacunado,
            'desparasitado' => $desparasitado,
            'esterilizado' => $esterilizado,
            'estado' => $estado,
            'destacado' => $destacado
        ];

        savePet($mascotaActualizada);
        setFlash('success', "¡Mascota '{$nombre}' actualizada con éxito!");
        header('Location: mascotas.php');
        exit;
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="container py-4 py-md-5">
    <div class="mb-4">
        <a href="mascotas.php" class="text-verde small fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado de mascotas
        </a>
        <h1 class="display-6 fw-bold text-verde-oscuro mt-2 mb-1">Editar a <?= sanitize($mascota['nombre']) ?></h1>
        <p class="text-muted mb-0">Modifica los detalles y características de la ficha de adopción.</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger rounded-4 d-flex align-items-center mb-4">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
            <div><?= sanitize($error) ?></div>
        </div>
    <?php endif; ?>

    <div class="card card-custom p-4 p-md-5 border-0">
        <form method="POST" action="mascotas_editar.php?id=<?= $id ?>">
            <div class="row g-4">
                <!-- Nombre y Especie -->
                <div class="col-md-6">
                    <label class="form-label">Nombre de la Mascota *</label>
                    <input type="text" name="nombre" class="form-control" value="<?= sanitize($mascota['nombre']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Especie *</label>
                    <select name="especie" class="form-select" required>
                        <option value="perro" <?= ($mascota['especie'] === 'perro') ? 'selected' : '' ?>>Perro</option>
                        <option value="gato" <?= ($mascota['especie'] === 'gato') ? 'selected' : '' ?>>Gato</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sexo *</label>
                    <select name="sexo" class="form-select" required>
                        <option value="Macho" <?= ($mascota['sexo'] === 'Macho') ? 'selected' : '' ?>>Macho</option>
                        <option value="Hembra" <?= ($mascota['sexo'] === 'Hembra') ? 'selected' : '' ?>>Hembra</option>
                    </select>
                </div>

                <!-- Raza, Edad y Rango -->
                <div class="col-md-4">
                    <label class="form-label">Raza / Tipo *</label>
                    <input type="text" name="raza" class="form-control" value="<?= sanitize($mascota['raza']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Edad (Texto descriptivo) *</label>
                    <input type="text" name="edad" class="form-control" value="<?= sanitize($mascota['edad']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Etapa de Vida *</label>
                    <select name="rango_edad" class="form-select" required>
                        <option value="cachorro" <?= ($mascota['rango_edad'] === 'cachorro') ? 'selected' : '' ?>>Cachorro (< 1 año)</option>
                        <option value="joven" <?= ($mascota['rango_edad'] === 'joven') ? 'selected' : '' ?>>Joven (1 a 3 años)</option>
                        <option value="adulto" <?= ($mascota['rango_edad'] === 'adulto') ? 'selected' : '' ?>>Adulto (3 a 7 años)</option>
                        <option value="senior" <?= ($mascota['rango_edad'] === 'senior') ? 'selected' : '' ?>>Senior (7+ años)</option>
                    </select>
                </div>

                <!-- Tamaño y Ubicación -->
                <div class="col-md-6">
                    <label class="form-label">Tamaño *</label>
                    <select name="tamano" class="form-select" required>
                        <option value="Pequeño" <?= ($mascota['tamano'] === 'Pequeño') ? 'selected' : '' ?>>Pequeño</option>
                        <option value="Mediano" <?= ($mascota['tamano'] === 'Mediano') ? 'selected' : '' ?>>Mediano</option>
                        <option value="Grande" <?= ($mascota['tamano'] === 'Grande') ? 'selected' : '' ?>>Grande</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ubicación / Refugio *</label>
                    <input type="text" name="ubicacion" class="form-control" value="<?= sanitize($mascota['ubicacion']) ?>" required>
                </div>

                <!-- URL Fotografía y Preview -->
                <div class="col-12">
                    <label class="form-label">URL de la Fotografía *</label>
                    <div class="d-flex gap-3 align-items-center">
                        <img src="<?= sanitize($mascota['foto']) ?>" class="rounded-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <input type="url" name="foto" class="form-control" value="<?= sanitize($mascota['foto']) ?>" required>
                    </div>
                </div>

                <!-- Personalidad -->
                <div class="col-12">
                    <label class="form-label">Personalidad (separada por comas)</label>
                    <input type="text" name="personalidad" class="form-control" value="<?= sanitize($mascota['personalidad'] ?? '') ?>">
                </div>

                <!-- Descripción -->
                <div class="col-12">
                    <label class="form-label">Historia y Descripción *</label>
                    <textarea name="descripcion" rows="4" class="form-control" required><?= sanitize($mascota['descripcion']) ?></textarea>
                </div>

                <!-- Salud y Cuidados -->
                <div class="col-md-8">
                    <label class="form-label d-block">Estado de Salud</label>
                    <div class="d-flex flex-wrap gap-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="vacunado" id="chkVac" value="1" <?= !empty($mascota['vacunado']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="chkVac">Vacunado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="desparasitado" id="chkDesp" value="1" <?= !empty($mascota['desparasitado']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="chkDesp">Desparasitado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="esterilizado" id="chkEster" value="1" <?= !empty($mascota['esterilizado']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="chkEster">Esterilizado</label>
                        </div>
                    </div>
                </div>

                <!-- Estado y Destacado -->
                <div class="col-md-4">
                    <label class="form-label">Estado de Adopción</label>
                    <select name="estado" class="form-select">
                        <option value="Disponible" <?= ($mascota['estado'] === 'Disponible') ? 'selected' : '' ?>>Disponible</option>
                        <option value="En proceso" <?= ($mascota['estado'] === 'En proceso') ? 'selected' : '' ?>>En proceso</option>
                        <option value="Adoptado" <?= ($mascota['estado'] === 'Adoptado') ? 'selected' : '' ?>>Adoptado</option>
                    </select>

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="destacado" id="chkDest" value="1" <?= !empty($mascota['destacado']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="chkDest">Mostrar en Mascotas Destacadas (Inicio)</label>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="col-12 mt-4 pt-3 border-top d-flex gap-3">
                    <button type="submit" class="btn btn-naranja text-white px-4 py-2 fs-6">
                        <i class="bi bi-check-lg me-1"></i> Guardar Cambios
                    </button>
                    <a href="mascotas.php" class="btn btn-outline-secondary px-4 py-2">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
