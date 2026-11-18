-- Base de datos para Adopta una Mascota
CREATE DATABASE IF NOT EXISTS `adopta_mascotas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `adopta_mascotas`;

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `telefono` VARCHAR(25) NULL,
  `direccion` VARCHAR(255) NULL,
  `rol` ENUM('admin', 'adoptante') DEFAULT 'adoptante',
  `fecha_registro` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Mascotas
CREATE TABLE IF NOT EXISTS `mascotas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `especie` ENUM('perro', 'gato') NOT NULL,
  `raza` VARCHAR(100) NOT NULL,
  `edad` VARCHAR(50) NOT NULL,
  `rango_edad` ENUM('cachorro', 'joven', 'adulto', 'senior') NOT NULL DEFAULT 'joven',
  `sexo` ENUM('Macho', 'Hembra') NOT NULL,
  `tamano` ENUM('Pequeño', 'Mediano', 'Grande') NOT NULL,
  `ubicacion` VARCHAR(150) NOT NULL,
  `foto` VARCHAR(255) NOT NULL,
  `fotos_adicionales` TEXT NULL,
  `descripcion` TEXT NOT NULL,
  `personalidad` VARCHAR(255) NULL,
  `vacunado` TINYINT(1) DEFAULT 1,
  `desparasitado` TINYINT(1) DEFAULT 1,
  `esterilizado` TINYINT(1) DEFAULT 1,
  `estado` ENUM('Disponible', 'En proceso', 'Adoptado') DEFAULT 'Disponible',
  `destacado` TINYINT(1) DEFAULT 0,
  `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Solicitudes de Adopción
CREATE TABLE IF NOT EXISTS `solicitudes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `mascota_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `nombre_solicitante` VARCHAR(120) NOT NULL,
  `email_solicitante` VARCHAR(120) NOT NULL,
  `telefono_solicitante` VARCHAR(30) NOT NULL,
  `ciudad` VARCHAR(100) NOT NULL,
  `tipo_vivienda` ENUM('Casa propia', 'Casa alquilada', 'Departamento propio', 'Departamento alquilado') NOT NULL,
  `tiene_patio` TINYINT(1) DEFAULT 1,
  `otras_mascotas` VARCHAR(255) NULL,
  `motivo` TEXT NOT NULL,
  `estado` ENUM('Pendiente', 'En revisión', 'Aprobada', 'Rechazada') DEFAULT 'Pendiente',
  `notas_admin` TEXT NULL,
  `fecha_solicitud` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`mascota_id`) REFERENCES `mascotas`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Mensajes de Contacto
CREATE TABLE IF NOT EXISTS `mensajes_contacto` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `telefono` VARCHAR(30) NULL,
  `asunto` VARCHAR(150) NOT NULL,
  `mensaje` TEXT NOT NULL,
  `leido` TINYINT(1) DEFAULT 0,
  `fecha_envio` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario Administrador por defecto (Contraseña: admin123)
-- Hash generado con password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `telefono`, `direccion`, `rol`) VALUES
('Administrador', 'admin@adoptaunamascota.com', '$2y$12$8WDZPMi6OrhG9Is4aOwE1et1lMB1IFrjXYodsP7T1WvmCUVpaedHu', '555-0199', 'Refugio Central', 'admin'),
('Carlos Adoptante', 'carlos@ejemplo.com', '$2y$12$8WDZPMi6OrhG9Is4aOwE1et1lMB1IFrjXYodsP7T1WvmCUVpaedHu', '555-0144', 'Calle Palmeras #123', 'adoptante')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`), `nombre` = VALUES(`nombre`);

-- Mascotas Iniciales con fotos reales y atractivas
INSERT INTO `mascotas` (`nombre`, `especie`, `raza`, `edad`, `rango_edad`, `sexo`, `tamano`, `ubicacion`, `foto`, `descripcion`, `personalidad`, `vacunado`, `desparasitado`, `esterilizado`, `estado`, `destacado`) VALUES
('Max', 'perro', 'Golden Retriever Mix', '1 año y medio', 'joven', 'Macho', 'Grande', 'Ciudad de México, Refugio Norte', 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=800&q=80', 'Max es un perro muy alegre, juguetón y lleno de ternura. Le encanta correr al aire libre, jugar con pelotas y recibir caricias. Es ideal para familias activas y convive de maravilla con niños.', 'Cariñoso, Juguetón, Protector', 1, 1, 1, 'Disponible', 1),

('Luna', 'gato', 'Europeo Común Atigrado', '8 meses', 'joven', 'Hembra', 'Pequeño', 'Guadalajara, Zona Centro', 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=800&q=80', 'Luna es una gatita dulce y curiosa con hermosos ojos verdes. Le gusta mirar por la ventana, buscar rayos de sol para dormir la siesta y ronronear cuando la acaricias en la cabeza.', 'Tranquila, Tierna, Ronroneadora', 1, 1, 1, 'Disponible', 1),

('Rocky', 'perro', 'Mestizo de Pastor', '2 años', 'adulto', 'Macho', 'Grande', 'Monterrey, Valle Oriente', 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=800&q=80', 'Rocky es un compañero leal y noble. Fue rescatado de la calle y ahora busca un hogar donde le brinden la seguridad y el amor que se merece. Muy obediente y aprende rápido los comandos.', 'Leal, Inteligente, Guardián', 1, 1, 1, 'Disponible', 1),

('Milo', 'gato', 'Gato Naranja Doméstico', '1 año', 'joven', 'Macho', 'Mediano', 'Puebla, San Andrés', 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=800&q=80', 'Milo es un torbellino de amor naranja. Siempre listo para trepar rascadores y dormir acurrucado junto a ti en el sofá. Es sumamente sociable con personas y otros felinos.', 'Sociable, Aventurero, Amoroso', 1, 1, 1, 'Disponible', 1),

('Bella', 'perro', 'Beagle', '3 meses', 'cachorro', 'Hembra', 'Pequeño', 'Querétaro, Juriquilla', 'https://images.unsplash.com/photo-1505628346881-b72b27e84530?auto=format&fit=crop&w=800&q=80', 'Bella es una cachorrita traviesa y adorable. Tiene energía contagiosa y una carita angelical que enamora a cualquiera. Está aprendiendo a hacer sus necesidades en tapetes entrenadores.', 'Curiosa, Activa, Encantadora', 1, 1, 0, 'Disponible', 1),

('Simba', 'gato', 'Siamés Mix', '2 años', 'adulto', 'Macho', 'Mediano', 'Mérida, Altabrisa', 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=800&q=80', 'Simba tiene unos ojos azules profundos que te cautivarán. Es un gato vocal y comunicativo al que le agrada seguirte por toda la casa y participar en tus actividades diarias.', 'Elegante, Comunicativo, Mimoso', 1, 1, 1, 'Disponible', 1),

('Maya', 'perro', 'Husky Siberiano Mix', '3 años', 'adulto', 'Hembra', 'Grande', 'Toluca, Metepec', 'https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?auto=format&fit=crop&w=800&q=80', 'Maya es majestuosa, activa y dulce. Necesita una familia que disfrute de paseos largos y caminatas al aire libre. Se lleva muy bien con otros perros de temperamento tranquilo.', 'Enérgica, Noble, Juguetona', 1, 1, 1, 'Disponible', 0),

('Cleo', 'gato', 'Calicó Carey', '4 años', 'adulto', 'Hembra', 'Mediano', 'León, Jardines', 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=800&q=80', 'Cleo es una gatita tricolor hermosa y serena. Valora mucho los momentos de paz, los cojines suaves y los cariños detrás de las orejas. Es la compañera perfecta para teletrabajo.', 'Independiente, Tranquila, Dulce', 1, 1, 1, 'Disponible', 0),

('Toby', 'perro', 'Border Collie Mix', '1 año', 'joven', 'Macho', 'Mediano', 'Tijuana, Chapultepec', 'https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=800&q=80', 'Toby destaca por su brillante inteligencia. Le fascina aprender trucos nuevos y desafíos mentales de agilidad. Muy fiel y siempre atento a las miradas de sus cuidadores.', 'Hiperactivo, Astuto, Cariñoso', 1, 1, 1, 'En proceso', 0),

('Nala', 'gato', 'Gatita Gris de Pelo Corto', '4 meses', 'cachorro', 'Hembra', 'Pequeño', 'Cancún, Zona Urbana', 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?auto=format&fit=crop&w=800&q=80', 'Nala es una pequeñita de pelaje suave como seda. Adora perseguir pelotas de lana y quedarse dormida en tu regazo mientras miras una película. Super tierna.', 'Mimosa, Juguetona, Dócil', 1, 1, 0, 'Disponible', 0),

('Bruno', 'perro', 'Labrador Retriever', '5 años', 'adulto', 'Macho', 'Grande', 'Cuernavaca, Vista Hermosa', 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=800&q=80', 'Bruno es un perrazo bondadoso y equilibrado. Camina perfecto con correa, no tira ni ladra innecesariamente. Le gusta nadar y acompañar en paseos relajados.', 'Paciente, Amigable, Obediente', 1, 1, 1, 'Disponible', 0),

('Oliver', 'gato', 'Atigrado Plata', '6 años', 'senior', 'Macho', 'Mediano', 'San Luis Potosí, Lomas', 'https://images.unsplash.com/photo-1548802673-380ab8ebc7b7?auto=format&fit=crop&w=800&q=80', 'Oliver es un gato mayor sabio y tranquilo. Solo busca un hogar cálido donde pasar sus días durmiendo siestas acogedoras y recibiendo amor. Ideal para personas mayores.', 'Tranquilo, Afectuoso, Relajado', 1, 1, 1, 'Adoptado', 0);

