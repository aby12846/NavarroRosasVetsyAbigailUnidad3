<?php
// config/pets_helper.php - Datos y funciones del catálogo para el Front-End

require_once __DIR__ . '/db.php';

function getDefaultPets() {
    return [
        [
            'id' => 1,
            'nombre' => 'Max',
            'especie' => 'perro',
            'raza' => 'Golden Retriever Mix',
            'edad' => '1 año y medio',
            'rango_edad' => 'joven',
            'sexo' => 'Macho',
            'tamano' => 'Grande',
            'ubicacion' => 'Ciudad de México, Refugio Norte',
            'foto' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Max es un perro sumamente alegre, cariñoso y lleno de energía positiva. Le apasiona jugar a la pelota, pasear por el parque y recibir caricias en la barriga. Convive de manera excelente con niños y otros perros.',
            'personalidad' => 'Cariñoso, Juguetón, Protector, Sociable',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Disponible',
            'destacado' => 1
        ],
        [
            'id' => 2,
            'nombre' => 'Luna',
            'especie' => 'gato',
            'raza' => 'Europeo Común Atigrado',
            'edad' => '8 meses',
            'rango_edad' => 'joven',
            'sexo' => 'Hembra',
            'tamano' => 'Pequeño',
            'ubicacion' => 'Guadalajara, Zona Centro',
            'foto' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Luna es una gatita curiosa, dulce y tranquila con hermosos ojos verdes. Le fascina tomar siestas bajo el sol, mirar por las ventanas y ronronear suavemente mientras descansa a tu lado en el sillón.',
            'personalidad' => 'Tranquila, Tierna, Ronroneadora, Curiosa',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Disponible',
            'destacado' => 1
        ],
        [
            'id' => 3,
            'nombre' => 'Rocky',
            'especie' => 'perro',
            'raza' => 'Mestizo de Pastor',
            'edad' => '2 años',
            'rango_edad' => 'adulto',
            'sexo' => 'Macho',
            'tamano' => 'Grande',
            'ubicacion' => 'Monterrey, Valle Oriente',
            'foto' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Rocky es el compañero leal y noble que siempre soñaste tener. Fue rescatado de una situación vulnerable y ahora busca un hogar donde entregar todo su agradecimiento y amor incondicional.',
            'personalidad' => 'Leal, Inteligente, Guardián, Obediente',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Disponible',
            'destacado' => 1
        ],
        [
            'id' => 4,
            'nombre' => 'Milo',
            'especie' => 'gato',
            'raza' => 'Gato Naranja Doméstico',
            'edad' => '1 año',
            'rango_edad' => 'joven',
            'sexo' => 'Macho',
            'tamano' => 'Mediano',
            'ubicacion' => 'Puebla, San Andrés',
            'foto' => 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Milo es un torbellino de ternura naranja. Siempre dispuesto a jugar con juguetes interactivos, trepar rascadores y dormir acurrucado bajo las sábanas en las noches frescas.',
            'personalidad' => 'Sociable, Aventurero, Amoroso, Curioso',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Disponible',
            'destacado' => 1
        ],
        [
            'id' => 5,
            'nombre' => 'Bella',
            'especie' => 'perro',
            'raza' => 'Beagle Tricolor',
            'edad' => '4 meses',
            'rango_edad' => 'cachorro',
            'sexo' => 'Hembra',
            'tamano' => 'Pequeño',
            'ubicacion' => 'Querétaro, Juriquilla',
            'foto' => 'https://images.unsplash.com/photo-1505628346881-b72b27e84530?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Bella es una cachorrita simpática con grandes orejas y ojos cautivadores. Le encanta explorar olfateando todo a su paso y recibir cariños antes de tomar una siesta reparadora.',
            'personalidad' => 'Curiosa, Activa, Encantadora, Juguetona',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 0,
            'estado' => 'Disponible',
            'destacado' => 1
        ],
        [
            'id' => 6,
            'nombre' => 'Simba',
            'especie' => 'gato',
            'raza' => 'Siamés Mix',
            'edad' => '2 años',
            'rango_edad' => 'adulto',
            'sexo' => 'Macho',
            'tamano' => 'Mediano',
            'ubicacion' => 'Mérida, Altabrisa',
            'foto' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Simba posee unos ojos azules intensos y un pelaje sedoso inconfundible. Es comunicativo, afectuoso y le gusta seguir a las personas de la casa para comprobar qué están haciendo.',
            'personalidad' => 'Elegante, Comunicativo, Mimoso, Observador',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Disponible',
            'destacado' => 1
        ],
        [
            'id' => 7,
            'nombre' => 'Maya',
            'especie' => 'perro',
            'raza' => 'Husky Siberiano Mix',
            'edad' => '3 años',
            'rango_edad' => 'adulto',
            'sexo' => 'Hembra',
            'tamano' => 'Grande',
            'ubicacion' => 'Toluca, Metepec',
            'foto' => 'https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Maya es de porte majestuoso y corazón dulce. Necesita una familia enérgica que goce de caminatas al aire libre y excursiones de fin de semana.',
            'personalidad' => 'Enérgica, Noble, Juguetona, Sociable',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Disponible',
            'destacado' => 0
        ],
        [
            'id' => 8,
            'nombre' => 'Cleo',
            'especie' => 'gato',
            'raza' => 'Calicó Carey',
            'edad' => '4 años',
            'rango_edad' => 'adulto',
            'sexo' => 'Hembra',
            'tamano' => 'Mediano',
            'ubicacion' => 'León, Jardines',
            'foto' => 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Cleo es una gata tricolor serena y dulce. Agradece los ambientes tranquilos, los cojines mullidos y las tardes de lectura compartidas.',
            'personalidad' => 'Independiente, Tranquila, Dulce, Paciente',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Disponible',
            'destacado' => 0
        ],
        [
            'id' => 9,
            'nombre' => 'Toby',
            'especie' => 'perro',
            'raza' => 'Border Collie Mix',
            'edad' => '1 año',
            'rango_edad' => 'joven',
            'sexo' => 'Macho',
            'tamano' => 'Mediano',
            'ubicacion' => 'Tijuana, Chapultepec',
            'foto' => 'https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Toby sobresale por su inteligencia y capacidad de aprendizaje. Siempre está atento para realizar trucos y resolver juguetes de estimulación mental.',
            'personalidad' => 'Astuto, Ágil, Cariñoso, Atento',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'En proceso',
            'destacado' => 0
        ],
        [
            'id' => 10,
            'nombre' => 'Nala',
            'especie' => 'gato',
            'raza' => 'Gatita Gris de Pelo Corto',
            'edad' => '5 meses',
            'rango_edad' => 'cachorro',
            'sexo' => 'Hembra',
            'tamano' => 'Pequeño',
            'ubicacion' => 'Cancún, Zona Urbana',
            'foto' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Nala es pequeña, tierna y con un pelaje suave como la seda. Adora perseguir bolitas de estambre y descansar en tu regazo mientras trabajas.',
            'personalidad' => 'Mimosa, Juguetona, Dócil, Ronroneadora',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 0,
            'estado' => 'Disponible',
            'destacado' => 0
        ],
        [
            'id' => 11,
            'nombre' => 'Bruno',
            'especie' => 'perro',
            'raza' => 'Labrador Retriever',
            'edad' => '5 años',
            'rango_edad' => 'adulto',
            'sexo' => 'Macho',
            'tamano' => 'Grande',
            'ubicacion' => 'Cuernavaca, Vista Hermosa',
            'foto' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Bruno es un perro maduro, noble y bondadoso. Camina con suavidad sin dar tirones y disfruta de las caricias constantes y las charlas tranquilas.',
            'personalidad' => 'Paciente, Amigable, Obediente, Tranquilo',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Disponible',
            'destacado' => 0
        ],
        [
            'id' => 12,
            'nombre' => 'Oliver',
            'especie' => 'gato',
            'raza' => 'Atigrado Plata',
            'edad' => '6 años',
            'rango_edad' => 'senior',
            'sexo' => 'Macho',
            'tamano' => 'Mediano',
            'ubicacion' => 'San Luis Potosí, Lomas',
            'foto' => 'https://images.unsplash.com/photo-1548802673-380ab8ebc7b7?auto=format&fit=crop&w=800&q=80',
            'descripcion' => 'Oliver es un gato sabio que solo busca un rincón acogedor donde disfrutar de la vida sin sobresaltos. Perfecto para personas que aprecian la serenidad.',
            'personalidad' => 'Tranquilo, Afectuoso, Relajado, Silencioso',
            'vacunado' => 1,
            'desparasitado' => 1,
            'esterilizado' => 1,
            'estado' => 'Adoptado',
            'destacado' => 0
        ]
    ];
}

// Almacenar mascotas en la sesión para permitir agregar, editar y eliminar en el front-end
if (!isset($_SESSION['lista_mascotas'])) {
    $_SESSION['lista_mascotas'] = getDefaultPets();
}

function getAllPets($filters = []) {
    $pdo = getDB();
    if ($pdo) {
        try {
            // Consulta preparada con marcadores con nombre (Protegida contra SQL Injection)
            $sql = "SELECT * FROM `mascotas` WHERE 1=1";
            $params = [];

            if (!empty($filters['especie']) && in_array(strtolower($filters['especie']), ['perro', 'gato'])) {
                $sql .= " AND LOWER(especie) = :especie";
                $params[':especie'] = strtolower($filters['especie']);
            }

            if (!empty($filters['rango_edad'])) {
                $sql .= " AND LOWER(rango_edad) = :rango_edad";
                $params[':rango_edad'] = strtolower($filters['rango_edad']);
            }

            if (!empty($filters['tamano'])) {
                $sql .= " AND LOWER(tamano) = :tamano";
                $params[':tamano'] = strtolower($filters['tamano']);
            }

            if (!empty($filters['sexo'])) {
                $sql .= " AND LOWER(sexo) = :sexo";
                $params[':sexo'] = strtolower($filters['sexo']);
            }

            if (!empty($filters['destacado'])) {
                $sql .= " AND destacado = 1";
            }

            if (!empty($filters['buscar'])) {
                $sql .= " AND (nombre LIKE :b_nombre OR raza LIKE :b_raza OR ubicacion LIKE :b_ubicacion)";
                $search = '%' . trim($filters['buscar']) . '%';
                $params[':b_nombre'] = $search;
                $params[':b_raza'] = $search;
                $params[':b_ubicacion'] = $search;
            }

            $sql .= " ORDER BY id DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll();

            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            error_log("Error al consultar mascotas en BD: " . $e->getMessage());
        }
    }

    $pets = $_SESSION['lista_mascotas'] ?? getDefaultPets();

    if (!empty($filters['especie']) && in_array(strtolower($filters['especie']), ['perro', 'gato'])) {
        $pets = array_filter($pets, fn($p) => strtolower($p['especie']) === strtolower($filters['especie']));
    }
    if (!empty($filters['rango_edad'])) {
        $pets = array_filter($pets, fn($p) => strtolower($p['rango_edad']) === strtolower($filters['rango_edad']));
    }
    if (!empty($filters['tamano'])) {
        $pets = array_filter($pets, fn($p) => strtolower($p['tamano']) === strtolower($filters['tamano']));
    }
    if (!empty($filters['sexo'])) {
        $pets = array_filter($pets, fn($p) => strtolower($p['sexo']) === strtolower($filters['sexo']));
    }
    if (!empty($filters['destacado'])) {
        $pets = array_filter($pets, fn($p) => !empty($p['destacado']));
    }
    if (!empty($filters['buscar'])) {
        $q = strtolower(trim($filters['buscar']));
        $pets = array_filter($pets, fn($p) => 
            str_contains(strtolower($p['nombre']), $q) || 
            str_contains(strtolower($p['raza']), $q) || 
            str_contains(strtolower($p['ubicacion']), $q)
        );
    }

    return array_values($pets);
}

function getPetById($id) {
    $id = intval($id);
    $pdo = getDB();
    if ($pdo && $id > 0) {
        try {
            // Consulta preparada por ID protegida contra SQL Injection
            $stmt = $pdo->prepare("SELECT * FROM `mascotas` WHERE `id` = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $pet = $stmt->fetch();
            if ($pet) return $pet;
        } catch (PDOException $e) {
            error_log("Error buscando mascota por ID: " . $e->getMessage());
        }
    }

    $pets = $_SESSION['lista_mascotas'] ?? getDefaultPets();
    foreach ($pets as $p) {
        if ($p['id'] == $id) return $p;
    }
    return null;
}

function savePet($petData) {
    $pdo = getDB();
    if ($pdo) {
        try {
            if (!empty($petData['id'])) {
                // UPDATE con prepared statement
                $id = intval($petData['id']);
                $stmt = $pdo->prepare("
                    UPDATE `mascotas` SET
                        `nombre`       = COALESCE(:nombre, `nombre`),
                        `especie`      = COALESCE(:especie, `especie`),
                        `raza`         = COALESCE(:raza, `raza`),
                        `edad`         = COALESCE(:edad, `edad`),
                        `rango_edad`   = COALESCE(:rango_edad, `rango_edad`),
                        `sexo`         = COALESCE(:sexo, `sexo`),
                        `tamano`       = COALESCE(:tamano, `tamano`),
                        `ubicacion`    = COALESCE(:ubicacion, `ubicacion`),
                        `foto`         = COALESCE(:foto, `foto`),
                        `descripcion`  = COALESCE(:descripcion, `descripcion`),
                        `personalidad` = COALESCE(:personalidad, `personalidad`),
                        `vacunado`     = COALESCE(:vacunado, `vacunado`),
                        `desparasitado`= COALESCE(:desparasitado, `desparasitado`),
                        `esterilizado` = COALESCE(:esterilizado, `esterilizado`),
                        `estado`       = COALESCE(:estado, `estado`),
                        `destacado`    = COALESCE(:destacado, `destacado`)
                    WHERE `id` = :id
                ");
                $stmt->execute([
                    ':id'          => $id,
                    ':nombre'      => isset($petData['nombre']) ? trim(strip_tags($petData['nombre'])) : null,
                    ':especie'     => $petData['especie'] ?? null,
                    ':raza'        => isset($petData['raza']) ? trim(strip_tags($petData['raza'])) : null,
                    ':edad'        => isset($petData['edad']) ? trim(strip_tags($petData['edad'])) : null,
                    ':rango_edad'  => $petData['rango_edad'] ?? null,
                    ':sexo'        => $petData['sexo'] ?? null,
                    ':tamano'      => $petData['tamano'] ?? null,
                    ':ubicacion'   => isset($petData['ubicacion']) ? trim(strip_tags($petData['ubicacion'])) : null,
                    ':foto'        => isset($petData['foto']) ? trim($petData['foto']) : null,
                    ':descripcion' => isset($petData['descripcion']) ? trim(strip_tags($petData['descripcion'])) : null,
                    ':personalidad'=> isset($petData['personalidad']) ? trim(strip_tags($petData['personalidad'])) : null,
                    ':vacunado'    => isset($petData['vacunado']) ? intval($petData['vacunado']) : null,
                    ':desparasitado'=> isset($petData['desparasitado']) ? intval($petData['desparasitado']) : null,
                    ':esterilizado'=> isset($petData['esterilizado']) ? intval($petData['esterilizado']) : null,
                    ':estado'      => $petData['estado'] ?? null,
                    ':destacado'   => isset($petData['destacado']) ? intval($petData['destacado']) : null
                ]);
            } else {
                // INSERT con prepared statement
                $stmt = $pdo->prepare("
                    INSERT INTO `mascotas` (
                        `nombre`, `especie`, `raza`, `edad`, `rango_edad`, `sexo`, `tamano`,
                        `ubicacion`, `foto`, `descripcion`, `personalidad`, `vacunado`,
                        `desparasitado`, `esterilizado`, `estado`, `destacado`, `fecha_creacion`
                    ) VALUES (
                        :nombre, :especie, :raza, :edad, :rango_edad, :sexo, :tamano,
                        :ubicacion, :foto, :descripcion, :personalidad, :vacunado,
                        :desparasitado, :esterilizado, :estado, :destacado, NOW()
                    )
                ");
                $stmt->execute([
                    ':nombre'      => trim(strip_tags($petData['nombre'] ?? 'Sin nombre')),
                    ':especie'     => $petData['especie'] ?? 'perro',
                    ':raza'        => trim(strip_tags($petData['raza'] ?? 'Mestizo')),
                    ':edad'        => trim(strip_tags($petData['edad'] ?? '1 año')),
                    ':rango_edad'  => $petData['rango_edad'] ?? 'joven',
                    ':sexo'        => $petData['sexo'] ?? 'Macho',
                    ':tamano'      => $petData['tamano'] ?? 'Mediano',
                    ':ubicacion'   => trim(strip_tags($petData['ubicacion'] ?? 'Refugio Central')),
                    ':foto'        => trim($petData['foto'] ?? ''),
                    ':descripcion' => trim(strip_tags($petData['descripcion'] ?? '')),
                    ':personalidad'=> trim(strip_tags($petData['personalidad'] ?? '')),
                    ':vacunado'    => !empty($petData['vacunado']) ? 1 : 0,
                    ':desparasitado'=> !empty($petData['desparasitado']) ? 1 : 0,
                    ':esterilizado'=> !empty($petData['esterilizado']) ? 1 : 0,
                    ':estado'      => $petData['estado'] ?? 'Disponible',
                    ':destacado'   => !empty($petData['destacado']) ? 1 : 0
                ]);
                $petData['id'] = $pdo->lastInsertId();
            }
        } catch (PDOException $e) {
            error_log("Error guardando mascota en BD: " . $e->getMessage());
        }
    }

    if (!isset($_SESSION['lista_mascotas'])) {
        $_SESSION['lista_mascotas'] = getDefaultPets();
    }

    if (!empty($petData['id'])) {
        foreach ($_SESSION['lista_mascotas'] as &$p) {
            if ($p['id'] == $petData['id']) {
                $p = array_merge($p, $petData);
                return $p['id'];
            }
        }
    } else {
        $maxId = 0;
        foreach ($_SESSION['lista_mascotas'] as $p) {
            if ($p['id'] > $maxId) $maxId = $p['id'];
        }
        $petData['id'] = $maxId + 1;
        $_SESSION['lista_mascotas'][] = $petData;
        return $petData['id'];
    }
    return false;
}

function deletePet($id) {
    $id = intval($id);
    $pdo = getDB();
    if ($pdo && $id > 0) {
        try {
            // DELETE protegido con prepared statement
            $stmt = $pdo->prepare("DELETE FROM `mascotas` WHERE `id` = :id");
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error eliminando mascota en BD: " . $e->getMessage());
        }
    }

    if (!isset($_SESSION['lista_mascotas'])) {
        $_SESSION['lista_mascotas'] = getDefaultPets();
    }
    $_SESSION['lista_mascotas'] = array_values(array_filter($_SESSION['lista_mascotas'], fn($p) => $p['id'] != $id));
    return true;
}

// Solicitudes en sesión para el front-end
if (!isset($_SESSION['lista_solicitudes'])) {
    $_SESSION['lista_solicitudes'] = [
        [
            'id' => 1,
            'mascota_id' => 1,
            'mascota_nombre' => 'Max',
            'especie' => 'perro',
            'raza' => 'Golden Retriever Mix',
            'mascota_foto' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=800&q=80',
            'usuario_id' => 2,
            'nombre_solicitante' => 'Carlos Adoptante',
            'email_solicitante' => 'carlos@ejemplo.com',
            'telefono_solicitante' => '55-1234-5678',
            'ciudad' => 'Ciudad de México',
            'tipo_vivienda' => 'Casa propia con jardín',
            'tiene_patio' => 1,
            'otras_mascotas' => 'Ninguna por el momento',
            'motivo' => 'Buscamos un amigo peludo para paseos matutinos y darle mucho amor en familia.',
            'estado' => 'En revisión',
            'notas_admin' => 'Nos pondremos en contacto para agendar la visita este sábado.',
            'fecha_solicitud' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        [
            'id' => 2,
            'mascota_id' => 2,
            'mascota_nombre' => 'Luna',
            'especie' => 'gato',
            'raza' => 'Europeo Común Atigrado',
            'mascota_foto' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=800&q=80',
            'usuario_id' => 3,
            'nombre_solicitante' => 'Mariana Gómez',
            'email_solicitante' => 'mariana@ejemplo.com',
            'telefono_solicitante' => '33-9876-5432',
            'ciudad' => 'Guadalajara',
            'tipo_vivienda' => 'Departamento propio',
            'tiene_patio' => 0,
            'otras_mascotas' => 'Un gato castrado de 3 años',
            'motivo' => 'Queremos darle una hermanita a nuestro gato para que jueguen juntos.',
            'estado' => 'Aprobada',
            'notas_admin' => 'Entrevista satisfactoria y red de seguridad en balcones verificada.',
            'fecha_solicitud' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ],
        [
            'id' => 3,
            'mascota_id' => 9,
            'mascota_nombre' => 'Toby',
            'especie' => 'perro',
            'raza' => 'Border Collie Mix',
            'mascota_foto' => 'https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=800&q=80',
            'usuario_id' => 4,
            'nombre_solicitante' => 'Roberto Sánchez',
            'email_solicitante' => 'roberto@ejemplo.com',
            'telefono_solicitante' => '66-4123-9988',
            'ciudad' => 'Tijuana',
            'tipo_vivienda' => 'Casa propia',
            'tiene_patio' => 1,
            'otras_mascotas' => 'Ninguna',
            'motivo' => 'Practico senderismo y quiero un compañero inteligente y activo.',
            'estado' => 'Pendiente',
            'notas_admin' => '',
            'fecha_solicitud' => date('Y-m-d H:i:s', strtotime('-5 hours'))
        ]
    ];
}

function getAllSolicitudes() {
    $pdo = getDB();
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("
                SELECT s.*, m.nombre AS mascota_nombre, m.especie, m.raza, m.foto AS mascota_foto
                FROM `solicitudes` s
                JOIN `mascotas` m ON s.mascota_id = m.id
                ORDER BY s.fecha_solicitud DESC
            ");
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            error_log("Error consultando solicitudes en BD: " . $e->getMessage());
        }
    }
    return $_SESSION['lista_solicitudes'] ?? [];
}

function updateSolicitudEstado($id, $nuevoEstado, $notas = '') {
    $id = intval($id);
    $estadosValidos = ['Pendiente', 'En revisión', 'Aprobada', 'Rechazada'];
    $nuevoEstado = in_array($nuevoEstado, $estadosValidos, true) ? $nuevoEstado : 'Pendiente';
    $notas = trim(strip_tags($notas));

    $pdo = getDB();
    if ($pdo && $id > 0) {
        try {
            // Consulta preparada para actualizar estado y notas del administrador
            $stmt = $pdo->prepare("
                UPDATE `solicitudes` 
                SET `estado` = :estado, `notas_admin` = :notas 
                WHERE `id` = :id
            ");
            $stmt->execute([
                ':estado' => $nuevoEstado,
                ':notas'  => $notas,
                ':id'     => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error actualizando estado de solicitud en BD: " . $e->getMessage());
        }
    }

    if (!isset($_SESSION['lista_solicitudes'])) return false;
    foreach ($_SESSION['lista_solicitudes'] as &$sol) {
        if ($sol['id'] == $id) {
            $sol['estado'] = $nuevoEstado;
            if (!empty($notas)) {
                $sol['notas_admin'] = $notas;
            }
            return true;
        }
    }
    return false;
}

// Usuarios en sesión para el front-end
if (!isset($_SESSION['lista_usuarios'])) {
    $_SESSION['lista_usuarios'] = [
        [
            'id' => 1,
            'nombre' => 'Administrador',
            'email' => 'admin@adoptaunamascota.com',
            'telefono' => '555-0199',
            'direccion' => 'Refugio Central',
            'rol' => 'admin',
            'fecha_registro' => '2026-01-10 10:00:00'
        ],
        [
            'id' => 2,
            'nombre' => 'Carlos Adoptante',
            'email' => 'carlos@ejemplo.com',
            'telefono' => '555-0144',
            'direccion' => 'Calle Palmeras #123, CDMX',
            'rol' => 'adoptante',
            'fecha_registro' => '2026-02-14 14:30:00'
        ],
        [
            'id' => 3,
            'nombre' => 'Mariana Gómez',
            'email' => 'mariana@ejemplo.com',
            'telefono' => '333-8821',
            'direccion' => 'Av. Chapultepec #45, Guadalajara',
            'rol' => 'adoptante',
            'fecha_registro' => '2026-03-01 09:15:00'
        ],
        [
            'id' => 4,
            'nombre' => 'Roberto Sánchez',
            'email' => 'roberto@ejemplo.com',
            'telefono' => '664-9912',
            'direccion' => 'Col. Cacho #88, Tijuana',
            'rol' => 'adoptante',
            'fecha_registro' => '2026-03-12 16:45:00'
        ]
    ];
}

function getAllUsuarios() {
    $pdo = getDB();
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT id, nombre, email, telefono, direccion, rol, fecha_registro FROM `usuarios` ORDER BY id DESC");
            $users = $stmt->fetchAll();
            if (!empty($users)) {
                return $users;
            }
        } catch (PDOException $e) {
            error_log("Error obteniendo usuarios: " . $e->getMessage());
        }
    }
    return $_SESSION['lista_usuarios'] ?? [];
}
?>
