<?php
// admin/mascotas_crear.php - Registrar Nueva Mascota
$pageTitle = "Registrar Mascota";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/pets_helper.php';

$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    // Sanitización y validación estricta de entradas (Previene XSS y datos maliciosos)
    $nombre        = trim(strip_tags($_POST['nombre'] ?? ''));
    $especie       = in_array($_POST['especie'] ?? '', ['perro', 'gato'], true) ? $_POST['especie'] : 'perro';
    $raza          = trim(strip_tags($_POST['raza'] ?? ''));
    $edad          = trim(strip_tags($_POST['edad'] ?? ''));
    $rango_edad    = in_array($_POST['rango_edad'] ?? '', ['cachorro', 'joven', 'adulto', 'senior'], true) ? $_POST['rango_edad'] : 'joven';
    $sexo          = in_array($_POST['sexo'] ?? '', ['Macho', 'Hembra'], true) ? $_POST['sexo'] : 'Macho';
    $tamano        = in_array($_POST['tamano'] ?? '', ['Pequeño', 'Mediano', 'Grande'], true) ? $_POST['tamano'] : 'Mediano';
    $ubicacion     = trim(strip_tags($_POST['ubicacion'] ?? ''));
    $foto          = filter_var(trim($_POST['foto'] ?? ''), FILTER_SANITIZE_URL);
    $descripcion   = trim(strip_tags($_POST['descripcion'] ?? ''));
    $personalidad  = trim(strip_tags($_POST['personalidad'] ?? ''));
    $vacunado      = !empty($_POST['vacunado']) ? 1 : 0;
    $desparasitado = !empty($_POST['desparasitado']) ? 1 : 0;
    $esterilizado  = !empty($_POST['esterilizado']) ? 1 : 0;
    $estado        = in_array($_POST['estado'] ?? '', ['Disponible', 'En proceso', 'Adoptado'], true) ? $_POST['estado'] : 'Disponible';
    $destacado     = !empty($_POST['destacado']) ? 1 : 0;

    if (empty($foto)) {
        $foto = ($especie === 'gato') 
            ? 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=800&q=80'
            : 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=800&q=80';
    }

    if (empty($nombre) || empty($raza) || empty($edad) || empty($descripcion)) {
        $error = 'Por favor completa todos los campos requeridos (*).';
    } else {
        $nuevaMascota = [
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

        savePet($nuevaMascota);
        setFlash('success', "¡Mascota '{$nombre}' registrada con éxito!");
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
        <h1 class="display-6 fw-bold text-verde-oscuro mt-2 mb-1">Registrar Nueva Mascota</h1>
        <p class="text-muted mb-0">Llena la ficha con los datos del perro o gato listo para adopción.</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger rounded-4 d-flex align-items-center mb-4">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
            <div><?= sanitize($error) ?></div>
        </div>
    <?php endif; ?>

    <div class="card card-custom p-4 p-md-5 border-0">
        <form method="POST" action="mascotas_crear.php">
            <div class="row g-4">
                <!-- Nombre y Especie -->
                <div class="col-md-6">
                    <label class="form-label">Nombre de la Mascota *</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej. Toby, Canela, Misi..." required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Especie *</label>
                    <select name="especie" class="form-select" required>
                        <option value="perro">Perro</option>
                        <option value="gato">Gato</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sexo *</label>
                    <select name="sexo" class="form-select" required>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>

                <!-- Raza, Edad y Rango -->
                <div class="col-md-4">
                    <label class="form-label">Raza / Tipo *</label>
                    <input type="text" name="raza" class="form-control" placeholder="Ej. Labrador Mestizo, Siamés..." required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Edad (Texto descriptivo) *</label>
                    <input type="text" name="edad" class="form-control" placeholder="Ej. 6 meses, 2 años..." required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Etapa de Vida *</label>
                    <select name="rango_edad" class="form-select" required>
                        <option value="cachorro">Cachorro (< 1 año)</option>
                        <option value="joven" selected>Joven (1 a 3 años)</option>
                        <option value="adulto">Adulto (3 a 7 años)</option>
                        <option value="senior">Senior (7+ años)</option>
                    </select>
                </div>

                <!-- Tamaño y Ubicación -->
                <div class="col-md-6">
                    <label class="form-label">Tamaño *</label>
                    <select name="tamano" class="form-select" required>
                        <option value="Pequeño">Pequeño</option>
                        <option value="Mediano" selected>Mediano</option>
                        <option value="Grande">Grande</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ubicación / Refugio *</label>
                    <input type="text" name="ubicacion" class="form-control" placeholder="Ej. Refugio Norte, CDMX" required>
                </div>

                <!-- URL Fotografía -->
                <div class="col-12">
                    <label class="form-label">URL de la Fotografía *</label>
                    <input type="url" name="foto" class="form-control" placeholder="https://images.unsplash.com/photo-..." value="https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=800&q=80" required>
                    <div class="form-text small">Ingresa el enlace directo a una imagen de alta calidad de Unsplash u otro servicio web.</div>
                </div>

                <!-- Personalidad -->
                <div class="col-12">
                    <label class="form-label">Personalidad (separada por comas)</label>
                    <input type="text" name="personalidad" class="form-control" placeholder="Ej. Cariñoso, Juguetón, Dócil, Guardián">
                </div>

                <!-- Descripción -->
                <div class="col-12">
                    <label class="form-label">Historia y Descripción *</label>
                    <textarea name="descripcion" rows="4" class="form-control" placeholder="Cuéntanos su temperamento, de dónde fue rescatado y cómo convive con otros..." required></textarea>
                </div>

                <!-- Salud y Cuidados -->
                <div class="col-md-8">
                    <label class="form-label d-block">Estado de Salud</label>
                    <div class="d-flex flex-wrap gap-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="vacunado" id="chkVac" value="1" checked>
                            <label class="form-check-label" for="chkVac">Vacunado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="desparasitado" id="chkDesp" value="1" checked>
                            <label class="form-check-label" for="chkDesp">Desparasitado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="esterilizado" id="chkEster" value="1" checked>
                            <label class="form-check-label" for="chkEster">Esterilizado</label>
                        </div>
                    </div>
                </div>

                <!-- Estado y Destacado -->
                <div class="col-md-4">
                    <label class="form-label">Estado de Adopción</label>
                    <select name="estado" class="form-select">
                        <option value="Disponible">Disponible</option>
                        <option value="En proceso">En proceso</option>
                        <option value="Adoptado">Adoptado</option>
                    </select>

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="destacado" id="chkDest" value="1">
                        <label class="form-check-label" for="chkDest">Mostrar en Mascotas Destacadas (Inicio)</label>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="col-12 mt-4 pt-3 border-top d-flex gap-3">
                    <button type="submit" class="btn btn-naranja text-white px-4 py-2 fs-6">
                        <i class="bi bi-save me-1"></i> Guardar Mascota
                    </button>
                    <a href="mascotas.php" class="btn btn-outline-secondary px-4 py-2">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
