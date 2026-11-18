<?php
// mascotas.php - Catálogo de Mascotas
$pageTitle = "Catálogo de Mascotas";
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/pets_helper.php';

// Filtros recibidos por GET para soporte directo de URL y formularios
$filtroEspecie = isset($_GET['especie']) ? strtolower(trim($_GET['especie'])) : 'all';
$filtroEdad = isset($_GET['edad']) ? strtolower(trim($_GET['edad'])) : '';
$filtroTamano = isset($_GET['tamano']) ? strtolower(trim($_GET['tamano'])) : '';
$filtroSexo = isset($_GET['sexo']) ? strtolower(trim($_GET['sexo'])) : '';
$filtroBuscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// Consulta de mascotas según los filtros iniciales
$filtros = [
    'especie' => ($filtroEspecie !== 'all') ? $filtroEspecie : null,
    'rango_edad' => $filtroEdad ?: null,
    'tamano' => $filtroTamano ?: null,
    'sexo' => $filtroSexo ?: null,
    'buscar' => $filtroBuscar ?: null
];

$todasMascotas = getAllPets($filtros);

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4 py-md-5">
    <!-- Encabezado de la página -->
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-heart-fill me-1"></i> Adopción Responsable
            </span>
            <h1 class="display-6 fw-bold text-verde-oscuro mt-1">Nuestras Mascotas en Adopción</h1>
            <p class="text-muted mb-0">
                Cada uno de estos pequeños está listo para llenar tu vida de alegría. ¡Filtra y encuentra a tu compañero perfecto!
            </p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <span id="petResultsCount" class="badge bg-verde text-white fs-6 py-2 px-3 rounded-pill shadow-sm">
                <?= count($todasMascotas) ?> mascota<?= count($todasMascotas) === 1 ? '' : 's' ?> encontrada<?= count($todasMascotas) === 1 ? '' : 's' ?>
            </span>
        </div>
    </div>

    <!-- CAJA DE FILTROS -->
    <div class="filter-box">
        <form method="GET" action="mascotas.php" id="filterForm">
            <div class="row g-3 align-items-end">
                <!-- Buscador de texto -->
                <div class="col-lg-3 col-md-6">
                    <label for="searchPet" class="form-label">
                        <i class="bi bi-search me-1 text-verde"></i> Buscar por nombre o raza
                    </label>
                    <div class="input-group">
                        <input type="text" 
                               id="searchPet" 
                               name="buscar" 
                               class="form-control" 
                               placeholder="Ej. Max, Golden, Luna..." 
                               value="<?= sanitize($filtroBuscar) ?>">
                    </div>
                </div>

                <!-- Botones de Especie (Perros / Gatos / Todos) -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label d-block">
                        <i class="bi bi-tag-fill me-1 text-verde"></i> Tipo de Mascota
                    </label>
                    <div class="filter-pills-wrap">
                        <button type="button" 
                                class="filter-pill filter-species-btn <?= ($filtroEspecie === 'all' || empty($filtroEspecie)) ? 'active' : '' ?>" 
                                data-species="all">
                            Todos
                        </button>
                        <button type="button" 
                                class="filter-pill filter-species-btn <?= ($filtroEspecie === 'perro') ? 'active' : '' ?>" 
                                data-species="perro">
                            <i class="bi bi-emoji-smile"></i> Perros
                        </button>
                        <button type="button" 
                                class="filter-pill filter-species-btn <?= ($filtroEspecie === 'gato') ? 'active' : '' ?>" 
                                data-species="gato">
                            <i class="bi bi-moon-stars"></i> Gatos
                        </button>
                    </div>
                </div>

                <!-- Filtro por Edad -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label for="filterAge" class="form-label">
                        <i class="bi bi-clock-history me-1 text-verde"></i> Edad
                    </label>
                    <select id="filterAge" name="edad" class="form-select">
                        <option value="">Cualquier edad</option>
                        <option value="cachorro" <?= ($filtroEdad === 'cachorro') ? 'selected' : '' ?>>Cachorro (< 1 año)</option>
                        <option value="joven" <?= ($filtroEdad === 'joven') ? 'selected' : '' ?>>Joven (1 - 3 años)</option>
                        <option value="adulto" <?= ($filtroEdad === 'adulto') ? 'selected' : '' ?>>Adulto (3 - 7 años)</option>
                        <option value="senior" <?= ($filtroEdad === 'senior') ? 'selected' : '' ?>>Senior (7+ años)</option>
                    </select>
                </div>

                <!-- Filtro por Tamaño -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label for="filterSize" class="form-label">
                        <i class="bi bi-arrows-angle-expand me-1 text-verde"></i> Tamaño
                    </label>
                    <select id="filterSize" name="tamano" class="form-select">
                        <option value="">Cualquier tamaño</option>
                        <option value="pequeño" <?= ($filtroTamano === 'pequeño' || $filtroTamano === 'pequeno') ? 'selected' : '' ?>>Pequeño</option>
                        <option value="mediano" <?= ($filtroTamano === 'mediano') ? 'selected' : '' ?>>Mediano</option>
                        <option value="grande" <?= ($filtroTamano === 'grande') ? 'selected' : '' ?>>Grande</option>
                    </select>
                </div>

                <!-- Filtro por Sexo -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label for="filterSex" class="form-label">
                        <i class="bi bi-gender-ambiguous me-1 text-verde"></i> Sexo
                    </label>
                    <select id="filterSex" name="sexo" class="form-select">
                        <option value="">Ambos sexos</option>
                        <option value="macho" <?= ($filtroSexo === 'macho') ? 'selected' : '' ?>>Macho</option>
                        <option value="hembra" <?= ($filtroSexo === 'hembra') ? 'selected' : '' ?>>Hembra</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- MENSAJE DE SIN RESULTADOS -->
    <div id="noResultsMessage" class="text-center py-5 <?= empty($todasMascotas) ? '' : 'd-none' ?>">
        <div class="mb-3 text-muted" style="font-size: 3.5rem;">
            <i class="bi bi-emoji-frown"></i>
        </div>
        <h3 class="fw-bold text-verde-oscuro mb-2">No encontramos mascotas con esos filtros</h3>
        <p class="text-muted mb-4">Intenta cambiar los parámetros de búsqueda o explora todos nuestros amigos peludos.</p>
        <a href="mascotas.php" class="btn btn-naranja text-white">
            <i class="bi bi-arrow-clockwise me-1"></i> Restablecer filtros
        </a>
    </div>

    <!-- CUADRÍCULA DE MASCOTAS -->
    <div class="row g-4" id="petGrid">
        <?php foreach ($todasMascotas as $pet): ?>
            <div class="col-lg-4 col-md-6 pet-col-item"
                 data-name="<?= sanitize($pet['nombre']) ?>"
                 data-breed="<?= sanitize($pet['raza']) ?>"
                 data-location="<?= sanitize($pet['ubicacion']) ?>"
                 data-species="<?= strtolower(sanitize($pet['especie'])) ?>"
                 data-age="<?= strtolower(sanitize($pet['rango_edad'])) ?>"
                 data-size="<?= strtolower(sanitize($pet['tamano'])) ?>"
                 data-sex="<?= strtolower(sanitize($pet['sexo'])) ?>">
                
                <div class="pet-card">
                    <div class="pet-img-wrap">
                        <img src="<?= sanitize($pet['foto']) ?>" 
                             alt="<?= sanitize($pet['nombre']) ?>" 
                             loading="lazy">
                        
                        <span class="badge-specie">
                            <i class="bi <?= $pet['especie'] === 'perro' ? 'bi-emoji-smile' : 'bi-moon-stars' ?> me-1"></i>
                            <?= ucfirst(sanitize($pet['especie'])) ?>
                        </span>

                        <span class="badge-status badge-<?= strtolower($pet['estado']) === 'disponible' ? 'disponible' : (strtolower($pet['estado']) === 'en proceso' ? 'proceso' : 'adoptado') ?>">
                            <?= sanitize($pet['estado']) ?>
                        </span>
                    </div>

                    <div class="pet-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h3 class="pet-card-title mb-0"><?= sanitize($pet['nombre']) ?></h3>
                            <span class="text-muted small">
                                <i class="bi <?= $pet['sexo'] === 'Macho' ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger' ?>"></i>
                                <?= sanitize($pet['sexo']) ?>
                            </span>
                        </div>
                        
                        <div class="pet-card-breed"><?= sanitize($pet['raza']) ?></div>

                        <div class="pet-meta-grid">
                            <div class="pet-meta-item">
                                <i class="bi bi-clock-history"></i>
                                <span><?= sanitize($pet['edad']) ?></span>
                            </div>
                            <div class="pet-meta-item">
                                <i class="bi bi-arrows-angle-expand"></i>
                                <span><?= sanitize($pet['tamano']) ?></span>
                            </div>
                            <div class="pet-meta-item" style="grid-column: span 2;">
                                <i class="bi bi-geo-alt-fill text-naranja"></i>
                                <span class="text-truncate"><?= sanitize($pet['ubicacion']) ?></span>
                            </div>
                        </div>

                        <div class="pet-card-footer">
                            <a href="<?= BASE_URL ?>/detalles.php?id=<?= $pet['id'] ?>" class="btn btn-naranja w-100 text-white">
                                <i class="bi bi-eye"></i> Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

