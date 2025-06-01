<?php
/**
 * Class Database
 *
 * Proporciona una conexión PDO persistente a la base de datos MySQL para la aplicación HabitaRoom.
 * Implementa el patrón Singleton para asegurar una única instancia de conexión.
 *
 * @package HabitaRoom\Core
 */
class Database
{
    /** @var string Host de la base de datos */
    private static $host = "localhost";

    /** @var string Nombre de la base de datos */
    private static $db = "habitaroom";

    /** @var string Usuario de la base de datos */
    private static $username = "root";

    /** @var string Contraseña de la base de datos */
    private static $password = "";

    /** @var PDO|null Instancia única de PDO */
    private static $conn = null;

    /**
     * Establece y devuelve la conexión PDO a la base de datos.
     *
     * Verifica si ya existe una conexión, si no, crea una nueva. En caso de que la base de datos
     * no exista (código de error 1049), intenta crearla y reconectar.
     *
     * @return PDO Instancia de PDO conectada a MySQL.
     * @throws PDOException Si ocurre un error de conexión diferente a inexistencia de base de datos.
     */
    public static function connect()
    {
        if (self::$conn === null) {
            try {
                // Intentar la conexión a la base de datos
                self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db, self::$username, self::$password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true
                ]);
            } catch (PDOException $exception) {
                // Si la base de datos no existe, se intenta crearla
                if ($exception->getCode() == 1049) {
                    self::createDatabase();
                    return self::connect(); // Intentar reconectar
                } else {
                    die("Error de conexión: " . $exception->getMessage());
                }
            }
        }
        return self::$conn;
    }

    /**
     * Cierra la conexión actual a la base de datos.
     */
    public static function disconnect()
    {
        self::$conn = null;
    }

    /**
     * Crea la base de datos si no existe.
     *
     * Se conecta al servidor sin especificar base de datos, crea la base de datos
     * con el nombre definido en la clase, y luego crea las tablas necesarias
     * para el funcionamiento de la aplicación.
     * Además, inserta datos de prueba en las tablas `usuarios` y `publicaciones`.
     * Esta función es llamada automáticamente si se detecta que la base de datos
     *
     * @return void
     */
    private static function createDatabase()
    {
        try {
            // 1. Conectar al servidor MySQL sin especificar base de datos
            $conn = new PDO(
                "mysql:host=" . self::$host,
                self::$username,
                self::$password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            // 2. Crear base de datos si no existe
            $conn->exec("
            CREATE DATABASE IF NOT EXISTS `" . self::$db . "`
            CHARACTER SET utf8
            COLLATE utf8_spanish_ci
        ");
            echo '<script>console.log(" Base de datos creada: ' . self::$db . ' ");</script>';

            // 3. Seleccionar la base de datos
            $conn->exec("USE `" . self::$db . "`");

            // 4. Iniciar transacción
            $conn->beginTransaction();

            // 5. Crear tabla `usuarios`
            $conn->exec("
            CREATE TABLE IF NOT EXISTS `usuarios` (
                `id`               INT(11) NOT NULL AUTO_INCREMENT,
                `nombre`           VARCHAR(255) NOT NULL,
                `apellidos`        VARCHAR(255) NOT NULL,
                `nombre_usuario`   VARCHAR(100) DEFAULT NULL,
                `correo_electronico` VARCHAR(255) NOT NULL,
                `telefono`         VARCHAR(20) DEFAULT NULL,
                `contrasena`       VARCHAR(255) NOT NULL,
                `tipo_usuario`     ENUM('habitante','propietario','empresa') NOT NULL,
                `ubicacion`        VARCHAR(255) DEFAULT NULL,
                `foto_perfil`      VARCHAR(255) DEFAULT NULL,
                `descripcion`      TEXT DEFAULT NULL,
                `preferencia_contacto` ENUM('whatsapp','email','mensaje') NOT NULL,
                `terminos_aceptados` TINYINT(1) NOT NULL DEFAULT 0,
                `creado_en`        DATETIME DEFAULT CURRENT_TIMESTAMP,
                `actualizado_en`   DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `correo_electronico` (`correo_electronico`),
                UNIQUE KEY `nombre_usuario` (`nombre_usuario`)
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8
              COLLATE=utf8_spanish_ci
        ");
            echo '<script>console.log("Tabla `usuarios` creada.");</script>';

            // 6. Insertar datos de prueba en `usuarios` si está vacía
            $countUsuarios = $conn->query("SELECT COUNT(*) FROM `usuarios`")->fetchColumn();
            if ($countUsuarios == 0) {
                $conn->exec("
                INSERT INTO `usuarios` (
                    `id`, `nombre`, `apellidos`, `nombre_usuario`, `correo_electronico`, `telefono`, `contrasena`, `tipo_usuario`,
                    `ubicacion`, `foto_perfil`, `descripcion`, `preferencia_contacto`, `terminos_aceptados`, `creado_en`, `actualizado_en`
                ) VALUES
                    (1, 'María',   'Gómez Ramírez',   'mariag',   'maria.gomez@example.com',   '600-111-222',  '\$2y\$10\$abcdefghijklmnopqrstuv', 'habitante',   'Madrid, España',    'maria.jpg',  'Buscando piso céntrico',            'email',    1, '2025-05-20 09:15:00', '2025-05-20 09:15:00'),
                    (2, 'Pedro',   'López Hernández', 'pedrol',   'pedro.lopez@example.com',   '600-333-444',  '\$2y\$10\$mnopqrstuvabcdefghijklm', 'propietario', 'Barcelona, España', 'pedro.jpg',  'Propietario con varios locales',    'whatsapp', 1, '2025-05-21 11:30:00', '2025-05-21 11:30:00'),
                    (3, 'Laura',   'Sánchez Ortiz',   'lauras',   'laura.sanchez@example.com', '600-555-666',  '\$2y\$10\$uvwxyzabcdefg hijklmnop', 'empresa',     'Valencia, España',  'laura.jpg',  'Agencia inmobiliaria local',       'mensaje',  1, '2025-05-22 14:45:00', '2025-05-22 14:45:00'),
                    (4, 'Raúl',    'Martínez Pérez',  'raulm',    'raul.martinez@example.com', '600-777-888',  '\$2y\$10\$cdefghijklmnopqrstuvwx',   'habitante',   'Sevilla, España',   'raul.jpg',   'Interesado en casas con jardín',    'whatsapp', 1, '2025-05-23 08:20:00', '2025-05-23 08:20:00'),
                    (5, 'Ana',     'Jiménez Ruiz',    'anaj',     'ana.jimenez@example.com',   '600-999-000',  '\$2y\$10\$yzabcdefg hijklmnopqrstu', 'propietario', 'Málaga, España',    'ana.jpg',    'Dueña de apartamentos de lujo',    'email',    1, '2025-05-24 10:05:00', '2025-05-24 10:05:00'),
                    (6, 'Carlos',  'Fernández Díaz',  'carlosf',  'carlos.fernandez@example.com','600-123-789', '\$2y\$10\$nopqrstuv abcdefghijklm',   'empresa',     'Bilbao, España',    'carlos.jpg', 'Inmobiliaria Bilbao Premium',      'mensaje',  1, '2025-05-25 12:50:00', '2025-05-25 12:50:00');
            ");
                echo '<script>console.log("Datos de prueba insertados en `usuarios`.");</script>';
            }

            // 7. Crear tabla `publicaciones`
            $conn->exec("
            CREATE TABLE IF NOT EXISTS `publicaciones` (
                `id`                  INT(11) NOT NULL AUTO_INCREMENT,
                `usuario_id`          INT(11) NOT NULL,
                `tipo_anuncio`        ENUM('venta','alquiler') NOT NULL,
                `tipo_inmueble`       ENUM('casa','oficina','apartamento','local','terreno','otro') NOT NULL,
                `ubicacion`           VARCHAR(255) NOT NULL,
                `latitud`             DECIMAL(9,6)   DEFAULT NULL,
                `longitud`            DECIMAL(9,6)   DEFAULT NULL,
                `calle`               VARCHAR(128)   DEFAULT NULL,
                `barrio`              VARCHAR(128)   DEFAULT NULL,
                `ciudad`              VARCHAR(128)   DEFAULT NULL,
                `provincia`           VARCHAR(128)   DEFAULT NULL,
                `codigo_postal`       VARCHAR(16)    DEFAULT NULL,
                `titulo`              VARCHAR(255)   NOT NULL,
                `descripcion`         TEXT           NOT NULL,
                `precio`              DECIMAL(12,2)  NOT NULL,
                `habitaciones`        INT(11)        NOT NULL,
                `banos`               INT(11)        NOT NULL,
                `estado`              ENUM('nuevo','usado','semi-nuevo','renovado') NOT NULL,
                `ascensor`            TINYINT(1)     NOT NULL DEFAULT 0,
                `piscina`             TINYINT(1)     NOT NULL DEFAULT 0,
                `gimnasio`            TINYINT(1)     NOT NULL DEFAULT 0,
                `garaje`              TINYINT(1)     NOT NULL DEFAULT 0,
                `terraza`             TINYINT(1)     NOT NULL DEFAULT 0,
                `jardin`              TINYINT(1)     NOT NULL DEFAULT 0,
                `aire_acondicionado`  TINYINT(1)     NOT NULL DEFAULT 0,
                `calefaccion`         TINYINT(1)     NOT NULL DEFAULT 0,
                `tipo_publicitante`   ENUM('habitante','propietario','empresa') NOT NULL,
                `superficie`          DECIMAL(10,2)  NOT NULL,
                `fotos`               LONGTEXT       CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
                                           CHECK (JSON_VALID(`fotos`)),
                `videos`              LONGTEXT       CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
                                           CHECK (JSON_VALID(`videos`)),
                `fecha_publicacion`   TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `usuario_id` (`usuario_id`),
                CONSTRAINT `publicaciones_ibfk_1`
                    FOREIGN KEY (`usuario_id`)
                    REFERENCES `usuarios` (`id`)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8
              COLLATE=utf8_spanish_ci
        ");
            echo '<script>console.log("Tabla `publicaciones` creada..");</script>';

            // Insertar datos de prueba en `publicaciones` 
            $countPub = $conn->query("SELECT COUNT(*) FROM `publicaciones`")->fetchColumn();
            if ($countPub == 0) {
                $conn->exec("
                INSERT INTO `publicaciones` (
                    `id`, `usuario_id`, `tipo_anuncio`, `tipo_inmueble`, `ubicacion`, 
                    `latitud`, `longitud`, `calle`, `barrio`, `ciudad`, `provincia`, `codigo_postal`,
                    `titulo`, `descripcion`, `precio`, `habitaciones`, `banos`, `estado`, 
                    `ascensor`, `piscina`, `gimnasio`, `garaje`, `terraza`, `jardin`, 
                    `aire_acondicionado`, `calefaccion`, `tipo_publicitante`, `superficie`, `fotos`, `videos`, `fecha_publicacion`
                ) VALUES
                    (1, 1, 'venta', 'apartamento', 'Calle Alcalá, 123, Salamanca', 
                        40.424637, -3.691960, 'Calle Alcalá, 123', 'Salamanca', 'Madrid', 'Madrid', '28009',
                        'Apartamento renovado junto al Retiro',
                        'Apartamento de 2 habitaciones, 1 baño, recién reformado, con aire acondicionado y ascensor. Cerca del Parque del Retiro.',
                        320000.00, 2, 1, 'renovado',
                        1, 0, 0, 1, 0, 0, 1, 1,
                        'habitante', 75.20,
                        '[\"apt_alianza1.jpg\",\"apt_alianza2.jpg\"]',
                        '[\"tour_alianza.mp4\"]',
                        '2025-03-15 10:00:00'
                    ),
                    (2, 4, 'alquiler', 'casa', 'Camino de la Fuente, 45, Triana', 
                        37.389092, -5.994534, 'Camino de la Fuente, 45', 'Triana', 'Sevilla', 'Sevilla', '41010',
                        'Casa nueva con jardín y piscina en Triana',
                        'Amplia casa de 4 habitaciones, 3 baños, con jardín, piscina privada, garaje y aire acondicionado. Zona tranquila de Triana.',
                        1800.00, 4, 3, 'nuevo',
                        0, 1, 0, 1, 0, 1, 1, 1,
                        'habitante', 220.00,
                        '[\"casa_triana1.jpg\",\"casa_triana2.jpg\"]',
                        '[\"video_triana.mp4\"]',
                        '2025-04-01 12:30:00'
                    ),
                    (3, 5, 'venta', 'terreno', 'Camino de los Olivos, 10, Ronda', 
                        36.744693, -5.161750, 'Camino de los Olivos, 10', 'Centro', 'Ronda', 'Málaga', '29400',
                        'Terreno de 1000 m² con vistas a la sierra',
                        'Terreno urbano de 1000 m², ideal para construcción de casa de campo. Ruta turística cercana.',
                        95000.00, 0, 0, 'nuevo',
                        0, 0, 0, 0, 1, 1, 0, 0,
                        'propietario', 1000.00,
                        '[\"terreno_ronda.jpg\"]',
                        NULL,
                        '2025-02-20 09:00:00'
                    ),
                    (4, 3, 'alquiler', 'oficina', 'Avenida de Aragón, 200, Ensanche', 
                        39.469907, -0.376288, 'Avenida de Aragón, 200', 'Ensanche', 'Valencia', 'Valencia', '46023',
                        'Oficina céntrica con aire acondicionado',
                        'Oficina de 80 m², 2 baños, en edificio con ascensor, aire acondicionado y seguridad las 24h. Zona Ensanche.',
                        1200.00, 0, 2, 'usado',
                        1, 0, 0, 0, 0, 0, 1, 1,
                        'empresa', 80.00,
                        '[\"oficina_valencia1.jpg\"]',
                        '[\"tour_valencia.mp4\"]',
                        '2025-05-05 08:15:00'
                    ),
                    (5, 2, 'venta', 'local', 'Calle Pelayo, 15, Barri Gòtic', 
                        41.381802, 2.175417, 'Calle Pelayo, 15', 'Barri Gòtic', 'Barcelona', 'Barcelona', '08002',
                        'Local semi-nuevo en el Barri Gòtic',
                        'Local comercial de 60 m² con escaparate, semi-nuevo, aire acondicionado, ideal para cafetería o tienda.',
                        210000.00, 0, 1, 'semi-nuevo',
                        0, 0, 0, 0, 0, 0, 1, 0,
                        'propietario', 60.00,
                        '[\"local_barri1.jpg\",\"local_barri2.jpg\"]',
                        '[\"promo_barri.mp4\"]',
                        '2025-04-18 16:00:00'
                    ),
                    (6, 1, 'alquiler', 'apartamento', 'Paseo del Prado, 50, Retiro', 
                        40.414431, -3.692093, 'Paseo del Prado, 50', 'Retiro', 'Madrid', 'Madrid', '28014',
                        'Apartamento con terraza junto al Prado',
                        'Apartamento de 1 dormitorio, 1 baño, usado pero en buen estado, con terraza y plaza de garaje. Cerca del Museo del Prado.',
                        1400.00, 1, 1, 'usado',
                        0, 0, 0, 1, 1, 0, 1, 0,
                        'habitante', 55.00,
                        '[\"apt_prado1.jpg\"]',
                        NULL,
                        '2025-03-30 11:20:00'
                    ),
                    (7, 4, 'venta', 'casa', 'Calle San Bernardo, 100, Triana', 
                        37.384375, -5.995924, 'Calle San Bernardo, 100', 'Triana', 'Sevilla', 'Sevilla', '41010',
                        'Casa renovada con chimenea y garaje',
                        'Casa de 3 habitaciones, 2 baños, renovada, con chimenea en salón y garaje. En pleno barrio de Triana.',
                        290000.00, 3, 2, 'renovado',
                        0, 0, 0, 1, 0, 0, 0, 1,
                        'habitante', 140.00,
                        '[\"casa_chimenea1.jpg\",\"casa_chimenea2.jpg\"]',
                        '[\"video_chimenea.mp4\"]',
                        '2025-04-10 09:50:00'
                    ),
                    (8, 2, 'alquiler', 'local', 'Calle Serrano, 45, Salamanca', 
                        40.433703, -3.680385, 'Calle Serrano, 45', 'Salamanca', 'Madrid', 'Madrid', '28001',
                        'Local nuevo en zona de lujo',
                        'Local comercial de 100 m², nuevo, con escaparate amplio, aire acondicionado y suelos de mármol.',
                        2500.00, 0, 1, 'nuevo',
                        0, 0, 0, 0, 0, 0, 1, 0,
                        'propietario', 100.00,
                        '[\"local_salamanca1.jpg\"]',
                        '[\"tour_salamanca.mp4\"]',
                        '2025-05-10 10:30:00'
                    ),
                    (9, 5, 'venta', 'apartamento', 'Calle Larios, 10, Centro', 
                        36.720156, -4.420340, 'Calle Larios, 10', 'Centro', 'Málaga', 'Málaga', '29015',
                        'Apartamento céntrico sin ascensor',
                        'Apartamento de 2 habitaciones, 1 baño, usado, sin ascensor ni aire acondicionado. Muy bien comunicado.',
                        180000.00, 2, 1, 'usado',
                        0, 0, 0, 0, 0, 0, 0, 0,
                        'propietario', 65.00,
                        '[\"apt_larios1.jpg\"]',
                        NULL,
                        '2025-02-28 14:10:00'
                    ),
                    (10, 6, 'venta', 'oficina', 'Calle Autonomía, 20, Abando', 
                        43.263012, -2.934985, 'Calle Autonomía, 20', 'Abando', 'Bilbao', 'Vizcaya', '48008',
                        'Oficina renovada en Abando',
                        'Oficina de 120 m², renovada, con 3 despachos, aire acondicionado, ascensor y plaza de garaje opcional.',
                        310000.00, 0, 2, 'renovado',
                        1, 0, 0, 1, 0, 0, 1, 1,
                        'empresa', 120.00,
                        '[\"ofic_bilbao1.jpg\",\"ofic_bilbao2.jpg\"]',
                        '[\"video_bilbao.mp4\"]',
                        '2025-03-05 13:00:00'
                    ),
                    (11, 5, 'alquiler', 'terreno', 'Calle Huertas, 5, Centro', 
                        36.720302, -4.419230, 'Calle Huertas, 5', 'Centro', 'Málaga', 'Málaga', '29008',
                        'Terreno en alquiler en el centro histórico',
                        'Terreno de 300 m², usado, sin servicios, ideal para eventos temporales o almacén.',
                        800.00, 0, 0, 'usado',
                        0, 0, 0, 0, 0, 0, 0, 0,
                        'propietario', 300.00,
                        NULL,
                        NULL,
                        '2025-04-20 11:00:00'
                    ),
                    (12, 3, 'venta', 'otro', 'Camino de las Aguas, 30, Patraix', 
                        39.426020, -0.402052, 'Camino de las Aguas, 30', 'Patraix', 'Valencia', 'Valencia', '46019',
                        'Edificio multifuncional con piscina y gimnasio',
                        'Edificio de oficinas y locales, nuevo, con piscina comunitaria, gimnasio, garaje subterráneo y zonas ajardinadas.',
                        550000.00, 0, 4, 'nuevo',
                        0, 1, 1, 1, 0, 1, 1, 1,
                        'empresa', 500.00,
                        '[\"edif_valencia1.jpg\",\"edif_valencia2.jpg\"]',
                        '[\"tour_edif_valencia.mp4\"]',
                        '2025-05-02 15:20:00'
                    ),
                    (13, 1, 'alquiler', 'apartamento', 'Calle Peña, 22, Ruzafa', 
                        39.464377, -0.378294, 'Calle Peña, 22', 'Ruzafa', 'Valencia', 'Valencia', '46006',
                        'Apartamento semi-nuevo en Ruzafa',
                        'Apartamento de 3 dormitorios, 2 baños, semi-nuevo, con aire acondicionado, garaje y calefacción central. Cerca de restaurantes y tiendas.',
                        1600.00, 3, 2, 'semi-nuevo',
                        0, 0, 0, 1, 0, 0, 1, 1,
                        'habitante', 95.00,
                        '[\"apt_ruzafa1.jpg\",\"apt_ruzafa2.jpg\"]',
                        NULL,
                        '2025-04-12 17:45:00'
                    ),
                    (14, 6, 'venta', 'otro', 'Gran Vía, 5, Abandoibarra', 
                        43.263306, -2.934829, 'Gran Vía, 5', 'Abandoibarra', 'Bilbao', 'Vizcaya', '48009',
                        'Suite de lujo con jacuzzi en Bilbao',
                        'Suite de 1 dormitorio, 1 baño con jacuzzi, nueva, con terraza privada y piscina comunitaria. Ubicación privilegiada.',
                        420000.00, 1, 1, 'nuevo',
                        1, 1, 0, 0, 1, 0, 1, 1,
                        'empresa', 85.00,
                        '[\"suite_bilbao1.jpg\",\"suite_bilbao2.jpg\"]',
                        '[\"video_suite_bilbao.mp4\"]',
                        '2025-05-15 09:30:00'
                    ),
                    (15, 4, 'alquiler', 'casa', 'Plaza Nueva, 1, Centro', 
                        37.386160, -5.992990, 'Plaza Nueva, 1', 'Centro', 'Sevilla', 'Sevilla', '41001',
                        'Casa semi-nueva con gimnasio en el centro',
                        'Casa de 5 habitaciones, 4 baños, semi-nueva, con gimnasio privado y calefacción por suelo radiante. A un paso de la Catedral.',
                        2500.00, 5, 4, 'semi-nuevo',
                        0, 0, 1, 0, 0, 0, 0, 1,
                        'habitante', 300.00,
                        '[\"casa_centro1.jpg\"]',
                        '[\"tour_casa_centro.mp4\"]',
                        '2025-03-28 12:00:00'
                    );
            ");
                echo '<script>console.log("Datos de prueba insertados en `publicaciones`.");</script>';
            }

            // Crear tabla `guardados`
            $conn->exec("
            CREATE TABLE IF NOT EXISTS `guardados` (
                `id_usuario`       INT(11) NOT NULL,
                `id_publicacion`   INT(11) NOT NULL,
                `fecha_guardado`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                PRIMARY KEY (`id_usuario`,`id_publicacion`),
                KEY `id_publicacion` (`id_publicacion`),
                CONSTRAINT `guardados_ibfk_1`
                    FOREIGN KEY (`id_usuario`)
                    REFERENCES `usuarios` (`id`)
                    ON DELETE CASCADE,
                CONSTRAINT `guardados_ibfk_2`
                    FOREIGN KEY (`id_publicacion`)
                    REFERENCES `publicaciones` (`id`)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8
              COLLATE=utf8_spanish_ci
        ");
            echo '<script>console.log("Tabla `guardados` creada.");</script>';

            // Insertar datos de prueba en `guardados`
            $countGuard = $conn->query("SELECT COUNT(*) FROM `guardados`")->fetchColumn();
            if ($countGuard == 0) {
                $conn->exec("
                INSERT INTO `guardados` (`id_usuario`, `id_publicacion`, `fecha_guardado`) VALUES
                    (1,  2,  '2025-05-25 18:00:00'),
                    (2,  1,  '2025-05-26 09:30:00'),
                    (3,  7,  '2025-05-27 14:45:00'),
                    (4, 13,  '2025-05-28 11:15:00'),
                    (5, 10,  '2025-05-29 16:50:00');
            ");
                echo '<script>console.log(" Datos de prueba insertados en `guardados`.");</script>';
            }

            // Confirmar transacción
            $conn->commit();

            // Recargar página para reflejar los cambios
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } catch (PDOException $e) {

            // Si hay error, deshacer cualquier cambio parcial
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            die("Error al crear la base de datos o las tablas: " . $e->getMessage());
        }
    }
}
