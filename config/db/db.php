<?php

class Database
{
    // Variables de conexión
    private static $host = "localhost";
    private static $db = "habitaroomtest";
    private static $username = "root";
    private static $password = "";
    private static $conn = null;

    // Función para conectar a la base de datos
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

    // Función para desconectar la base de datos
    public static function disconnect()
    {
        self::$conn = null;
    }

    // Función para crear la base de datos, las tablas e insertar los datos
    private static function createDatabase()
    {
        try {
            // Conectar al servidor MySQL sin especificar base de datos
            $conn = new PDO("mysql:host=" . self::$host, self::$username, self::$password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Crear la base de datos
            $sql = "CREATE DATABASE IF NOT EXISTS " . self::$db . " CHARACTER SET utf8 COLLATE utf8_spanish_ci";
            $conn->exec($sql);
            echo "Base de datos creada correctamente.<br>";

            // Seleccionar la base de datos
            $conn->exec("USE " . self::$db);

            // Crear la tabla usuarios
            $sqlUsuarios = "
            CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(255) NOT NULL,
                apellidos VARCHAR(255) NOT NULL,
                nombre_usuario VARCHAR(100) UNIQUE,
                correo_electronico VARCHAR(255) NOT NULL UNIQUE,
                telefono VARCHAR(20),
                contrasena VARCHAR(255) NOT NULL,
                tipo_usuario ENUM('habitante', 'propietario', 'empresa') NOT NULL,
                ubicacion VARCHAR(255),
                foto_perfil VARCHAR(255),
                descripcion TEXT,
                preferencia_contacto ENUM('whatsapp', 'email', 'mensaje') NOT NULL,
                terminos_aceptados BOOLEAN NOT NULL DEFAULT FALSE,
                creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
                actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $conn->exec($sqlUsuarios);
            echo "Tabla 'usuarios' creada.<br>";

            // Insertar datos en la tabla usuarios
            $sqlInsertUsuarios = "
            INSERT INTO usuarios (nombre, apellidos, nombre_usuario, correo_electronico, telefono, contrasena, tipo_usuario, ubicacion, foto_perfil, descripcion, preferencia_contacto, terminos_aceptados) VALUES
            ('Juan', 'Pérez López', 'juanperez', 'juan.perez@email.com', '555-1234', 'clave123', 'habitante', 'Madrid, España', 'juan.jpg', 'Interesado en inmuebles modernos', 'email', TRUE),
            ('Ana', 'García Fernández', 'anagf', 'ana.garcia@email.com', '555-5678', '$2b$12$.g/zZfZ5Fd5uZE0qkUSUf.4j1vFd2MVYeZ6YeSTy9JXiaidOm7QQy', 'propietario', 'Barcelona, España', 'ana.jpg', 'Dueña de varias propiedades', 'whatsapp', TRUE),
            ('Carlos', 'Martínez Gómez', 'carlosm', 'carlos.martinez@email.com', '555-8765', 'clave789', 'empresa', 'Valencia, España', 'carlos.jpg', 'Agente inmobiliario con experiencia', 'mensaje', TRUE),
            ('Laura', 'Ruiz Sánchez', 'laurar', 'laura.ruiz@email.com', '555-4321', 'clave111', 'habitante', 'Sevilla, España', 'laura.jpg', 'Buscando una casa con jardín', 'whatsapp', TRUE),
            ('Pedro', 'López García', 'pedrolg', 'pedro.lopez@email.com', '555-2468', 'clave222', 'propietario', 'Málaga, España', 'pedro.jpg', 'Vendo propiedades en la costa', 'email', TRUE)
            ";
            $conn->exec($sqlInsertUsuarios);
            echo "Datos insertados en la tabla 'usuarios'.<br>";

            // Crear la tabla publicaciones
            $sqlPublicaciones = "
            CREATE TABLE IF NOT EXISTS publicaciones (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NOT NULL,
                tipo_anuncio ENUM('venta', 'alquiler') NOT NULL,
                tipo_inmueble ENUM('casa', 'oficina', 'apartamento', 'local', 'terreno', 'otro') NOT NULL,
                ubicacion VARCHAR(255) NOT NULL,
                titulo VARCHAR(255) NOT NULL,
                descripcion TEXT NOT NULL,
                precio DECIMAL(12, 2) NOT NULL,
                habitaciones INT NOT NULL,
                banos INT NOT NULL,
                estado ENUM('nuevo', 'usado', 'semi-nuevo', 'renovado') NOT NULL,
                ascensor BOOLEAN NOT NULL DEFAULT FALSE,
                piscina BOOLEAN NOT NULL DEFAULT FALSE,
                gimnasio BOOLEAN NOT NULL DEFAULT FALSE,
                garaje BOOLEAN NOT NULL DEFAULT FALSE,
                terraza BOOLEAN NOT NULL DEFAULT FALSE,
                jardin BOOLEAN NOT NULL DEFAULT FALSE,
                aire_acondicionado BOOLEAN NOT NULL DEFAULT FALSE,
                calefaccion BOOLEAN NOT NULL DEFAULT FALSE,
                tipo_publicitante ENUM('habitante', 'propietario', 'empresa') NOT NULL,
                superficie DECIMAL(10, 2) NOT NULL,
                fotos JSON,
                videos JSON,
                fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
            )";
            $conn->exec($sqlPublicaciones);
            echo "Tabla 'publicaciones' creada.<br>";

            // Insertar datos en la tabla publicaciones
            $sqlInsertPublicaciones = "
INSERT INTO publicaciones (
    usuario_id, tipo_anuncio, tipo_inmueble, ubicacion, titulo, descripcion, precio, habitaciones, banos, estado, 
    ascensor, piscina, gimnasio, garaje, terraza, jardin, aire_acondicionado, calefaccion, tipo_publicitante, superficie, fotos, videos
) VALUES
-- Publicaciones de otros usuarios
(1, 'venta', 'apartamento', 'Madrid, España', 'Moderno apartamento en el centro', 'Apartamento con excelentes vistas, recién reformado.', 
 250000.00, 3, 2, 'renovado', TRUE, FALSE, TRUE, TRUE, FALSE, FALSE, TRUE, TRUE, 'habitante', 120.50, 
 '[\"apart1_1.jpg\", \"apart1_2.jpg\"]', '[\"video1.mp4\"]'
),
(3, 'venta', 'oficina', 'Valencia, España', 'Oficina en edificio corporativo', 'Oficina espaciosa con ascensor y aire acondicionado.', 
 300000.00, 0, 2, 'semi-nuevo', TRUE, FALSE, FALSE, TRUE, FALSE, FALSE, TRUE, TRUE, 'empresa', 85.75, 
 '[\"oficina1_1.jpg\", \"oficina1_2.jpg\"]', '[\"video2.mp4\"]'
),
(4, 'alquiler', 'apartamento', 'Sevilla, España', 'Piso céntrico con garaje', 'Apartamento con buena ubicación y plaza de garaje.', 
 1200.00, 2, 1, 'usado', TRUE, FALSE, FALSE, TRUE, FALSE, FALSE, TRUE, FALSE, 'habitante', 90.00, 
 '[\"suite1_1.jpg\", \"suite1_2.jpg\"]', NULL
),
(5, 'venta', 'terreno', 'Málaga, España', 'Terreno con vista al mar', 'Terreno urbanizable en zona tranquila.', 
 150000.00, 0, 0, 'nuevo', FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, 'propietario', 500.00, 
 '[\"terreno1_1.jpg\"]', NULL
),
-- Publicaciones del usuario con ID 2
(2, 'alquiler', 'casa', 'Barcelona, España', 'Casa con jardín y piscina', 'Amplia casa con piscina privada y jardín.', 
 1800.00, 4, 3, 'nuevo', FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, 'propietario', 250.00, 
 '[\"casa1_1.jpg\", \"casa1_2.jpg\"]', NULL
),
(2, 'venta', 'local', 'Madrid, España', 'Local comercial céntrico', 'Local ideal para comercio o cafetería.', 
 210000.00, 0, 1, 'renovado', FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, TRUE, FALSE, 'empresa', 95.00, 
 '[\"local1_1.jpg\", \"local1_2.jpg\"]', '[\"video3.mp4\"]'
),
(2, 'alquiler', 'oficina', 'Barcelona, España', 'Oficina con terraza', 'Oficina moderna con vistas a la ciudad.', 
 2200.00, 0, 2, 'nuevo', TRUE, FALSE, FALSE, TRUE, TRUE, FALSE, TRUE, TRUE, 'empresa', 130.00, 
 '[\"oficina1_1.jpg\", \"oficina1_2.jpg\"]', '[\"video4.mp4\"]'
),
(2, 'venta', 'casa', 'Valencia, España', 'Casa de lujo con piscina', 'Casa espaciosa con jardín y piscina privada.', 
 450000.00, 5, 4, 'nuevo', FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, 'propietario', 350.00, 
 '[\"casa2_1.jpg\", \"casa2_2.jpg\"]', '[\"video5.mp4\"]'
),
(2, 'alquiler', 'suite', 'Bilbao, España', 'Suite con jacuzzi y terraza', 'Suite de lujo con vistas panorámicas.', 
 3200.00, 1, 1, 'nuevo', TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, 'empresa', 85.00, 
 '[\"suite1_1.jpg\", \"suite1_2.jpg\"]', '[\"video6.mp4\"]'
),
(2, 'venta', 'terreno', 'Granada, España', 'Terreno con acceso a la montaña', 'Terreno rústico ideal para casa de campo.', 
 90000.00, 0, 0, 'nuevo', FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, 'propietario', 600.00, 
 '[\"terreno1_1.jpg\"]', NULL
),
(2, 'alquiler', 'apartamento', 'Sevilla, España', 'Apartamento con balcón', 'Cómodo apartamento con terraza y garaje.', 
 1400.00, 2, 1, 'usado', TRUE, FALSE, FALSE, TRUE, TRUE, FALSE, TRUE, TRUE, 'habitante', 100.00, 
 '[\"apart1_1.jpg\", \"apart1_2.jpg\"]', NULL
)";



            $conn->exec($sqlInsertPublicaciones);
            echo "Datos insertados en la tabla 'publicaciones'.<br>";
        } catch (PDOException $exception) {
            die("Error al crear la base de datos o las tablas: " . $exception->getMessage());
        }
    }
}
