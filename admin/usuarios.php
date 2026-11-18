<?php
// admin/usuarios.php - Listado de Usuarios Registrados
$pageTitle = "Usuarios Registrados";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/pets_helper.php';
require_once __DIR__ . '/admin_header.php';

$usuarios = getAllUsuarios();
?>

<div class="container py-4 py-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="text-naranja fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-people-fill me-1"></i> Comunidad de Adoptantes
            </span>
            <h1 class="display-6 fw-bold text-verde-oscuro mt-1 mb-0">Usuarios Registrados</h1>
            <p class="text-muted mb-0">Lista de cuentas creadas en la plataforma y datos de contacto.</p>
        </div>
        <div>
            <span class="badge bg-verde fs-6 py-2 px-3 rounded-pill">
                <?= count($usuarios) ?> usuarios registrados
            </span>
        </div>
    </div>

    <div class="card card-custom p-4 border-0">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0">Usuario</th>
                        <th class="border-0">Correo Electrónico</th>
                        <th class="border-0">Teléfono</th>
                        <th class="border-0">Ubicación</th>
                        <th class="border-0">Rol</th>
                        <th class="border-0">Fecha Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="step-icon text-verde m-0" style="width: 38px; height: 38px; font-size: 1.1rem;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <span class="fw-bold text-dark"><?= sanitize($u['nombre']) ?></span>
                                </div>
                            </td>
                            <td class="text-muted"><?= sanitize($u['email']) ?></td>
                            <td class="text-muted"><?= sanitize($u['telefono'] ?: 'No registrado') ?></td>
                            <td class="text-muted"><?= sanitize($u['direccion'] ?: 'No especificada') ?></td>
                            <td>
                                <span class="badge <?= ($u['rol'] === 'admin') ? 'bg-verde-oscuro text-white' : 'bg-crema text-verde-oscuro border' ?> rounded-pill px-3 py-1">
                                    <?= ($u['rol'] === 'admin') ? 'Administrador' : 'Adoptante' ?>
                                </span>
                            </td>
                            <td class="text-muted small"><?= date('d/m/Y', strtotime($u['fecha_registro'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

