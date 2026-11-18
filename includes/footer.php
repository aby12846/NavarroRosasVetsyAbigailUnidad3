<?php
// includes/footer.php
?>
    <!-- Pie de página -->
    <footer class="footer-custom mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="logo-icon bg-white text-verde" style="width: 40px; height: 40px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <i class="bi bi-paw-fill"></i>
                        </span>
                        <h4 class="text-white mb-0 fw-bold">Adopta una <span class="text-naranja">Mascota</span></h4>
                    </div>
                    <p class="mb-4">
                        Conectamos animales rescatados con personas amorosas listas para brindarles un hogar digno. Fomentamos la adopción responsable y el bienestar animal.
                    </p>
                    <div class="d-flex">
                        <a href="#" class="footer-social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="footer-social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="footer-social-link" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="footer-social-link" title="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6">
                    <h5>Navegación</h5>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                        <li><a href="<?= BASE_URL ?>/index.php"><i class="bi bi-chevron-right me-1 small"></i> Inicio</a></li>
                        <li><a href="<?= BASE_URL ?>/mascotas.php"><i class="bi bi-chevron-right me-1 small"></i> Mascotas</a></li>
                        <li><a href="<?= BASE_URL ?>/index.php#centros-adopcion"><i class="bi bi-chevron-right me-1 small"></i> Centros de adopción</a></li>
                        <li><a href="<?= BASE_URL ?>/como_adoptar.php"><i class="bi bi-chevron-right me-1 small"></i> Cómo adoptar</a></li>
                        <li><a href="<?= BASE_URL ?>/nosotros.php"><i class="bi bi-chevron-right me-1 small"></i> Nosotros</a></li>
                        <li><a href="<?= BASE_URL ?>/contacto.php"><i class="bi bi-chevron-right me-1 small"></i> Contacto</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 col-6">
                    <h5>Compañeros</h5>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                        <li><a href="<?= BASE_URL ?>/mascotas.php?especie=perro"><i class="bi bi-chevron-right me-1 small"></i> Perros en adopción</a></li>
                        <li><a href="<?= BASE_URL ?>/mascotas.php?especie=gato"><i class="bi bi-chevron-right me-1 small"></i> Gatos en adopción</a></li>
                        <li><a href="<?= BASE_URL ?>/mascotas.php?edad=cachorro"><i class="bi bi-chevron-right me-1 small"></i> Cachorros</a></li>
                        <li><a href="<?= BASE_URL ?>/solicitudes.php"><i class="bi bi-chevron-right me-1 small"></i> Estado de solicitud</a></li>
                        <li><a href="<?= BASE_URL ?>/login.php"><i class="bi bi-chevron-right me-1 small"></i> Acceso voluntarios</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Contacto y Ayuda</h5>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt-fill text-naranja"></i>
                            <span>Av. de las Mascotas 404, Ciudad Solidaria</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-telephone-fill text-naranja"></i>
                            <span>+52 (55) 8000-ADOPTA</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-fill text-naranja"></i>
                            <span>hola@adoptaunamascota.com</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-clock-fill text-naranja"></i>
                            <span>Lunes a Sábado: 9:00 AM - 6:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <p class="mb-0">&copy; <?= date('Y') ?> Adopta una Mascota. Todos los derechos reservados.</p>
                <div class="d-flex gap-3">
                    <a href="#">Términos y condiciones</a>
                    <a href="#">Política de privacidad</a>
                    <a href="<?= BASE_URL ?>/config/install.php" class="text-white opacity-50 small"><i class="bi bi-gear"></i> BD</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script Personalizado -->
    <script src="<?= BASE_URL ?>/js/main.js"></script>
</body>
</html>

