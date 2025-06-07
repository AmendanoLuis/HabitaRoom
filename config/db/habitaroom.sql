-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2025 a las 00:21:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `habitaroom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guardados`
--

CREATE TABLE `guardados` (
  `id_usuario` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `fecha_guardado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo_anuncio` enum('venta','alquiler') NOT NULL,
  `tipo_inmueble` enum('casa','garaje','oficina','terreno','apartamento','local','terreno','piso','otro') NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `latitud` decimal(9,6) DEFAULT NULL,
  `longitud` decimal(9,6) DEFAULT NULL,
  `calle` varchar(128) DEFAULT NULL,
  `barrio` varchar(128) DEFAULT NULL,
  `ciudad` varchar(128) DEFAULT NULL,
  `provincia` varchar(128) DEFAULT NULL,
  `codigo_postal` varchar(16) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `habitaciones` int(11) NOT NULL,
  `banos` int(11) NOT NULL,
  `estado` enum('nuevo','usado','semi-nuevo','renovado') NOT NULL,
  `ascensor` tinyint(1) NOT NULL DEFAULT 0,
  `piscina` tinyint(1) NOT NULL DEFAULT 0,
  `gimnasio` tinyint(1) NOT NULL DEFAULT 0,
  `garaje` tinyint(1) NOT NULL DEFAULT 0,
  `terraza` tinyint(1) NOT NULL DEFAULT 0,
  `jardin` tinyint(1) NOT NULL DEFAULT 0,
  `aire_acondicionado` tinyint(1) NOT NULL DEFAULT 0,
  `calefaccion` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_publicitante` enum('habitante','propietario','empresa') NOT NULL,
  `superficie` decimal(10,2) NOT NULL,
  `fotos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fotos`)),
  `videos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`videos`)),
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `usuario_id`, `tipo_anuncio`, `tipo_inmueble`, `ubicacion`, `latitud`, `longitud`, `calle`, `barrio`, `ciudad`, `provincia`, `codigo_postal`, `titulo`, `descripcion`, `precio`, `habitaciones`, `banos`, `estado`, `ascensor`, `piscina`, `gimnasio`, `garaje`, `terraza`, `jardin`, `aire_acondicionado`, `calefaccion`, `tipo_publicitante`, `superficie`, `fotos`, `videos`, `fecha_publicacion`) VALUES
(19, 7, 'venta', 'piso', 'calle de alcalá, goya, salamanca, madrid, comunidad de madrid, 28009, españa', 40.423069, -3.679563, 'Calle de Alcalá', 'Salamanca', 'Madrid', 'Comunidad de Madrid', '28009', 'piso elegante en barrio salamanca', 'amplio piso reformado con ascensor y calefacción central.', 395000.00, 3, 2, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'habitante', 120.00, '[\"pub_6842466ead1bd.jpg\"]', NULL, '2025-06-06 01:37:50'),
(20, 7, 'alquiler', 'casa', 'carrer de balmes, galvany, sant gervasi - galvany, sarrià - sant gervasi, barcelona, barcelonés, barcelona, cataluña, 08006, españa', 41.399968, 2.149373, 'Carrer de Balmes', 'Sarrià - Sant Gervasi', 'Barcelona', 'Cataluña', '08006', 'ático con terraza y vistas en barcelona', 'ático con terraza grande, aire acondicionado y ascensor.', 1200.00, 2, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'habitante', 90.00, '[\"pub_68424e4780d2d.jpg\"]', NULL, '2025-06-06 02:11:19'),
(21, 7, 'venta', 'apartamento', 'avenida de blasco ibañez, beteró, poblados marítimos, valencia, comarca de valencia, valencia, comunidad valenciana, 46022, españa', 39.470353, -0.336642, 'Avenida de Blasco Ibañez', 'Poblados Marítimos', 'Valencia', 'Comunidad Valenciana', '46022', 'apartamento en pleno centro de valencia', 'precioso apartamento con piscina privada, 2 plazas de garaje y amplio jardín.', 52000.00, 5, 4, 'renovado', 1, 1, 1, 1, 1, 1, 1, 1, 'habitante', 300.00, '[\"pub_68424f15c3c18.jpg\"]', NULL, '2025-06-06 02:14:45'),
(22, 8, 'venta', 'apartamento', 'calle mayor, barrio de la latina, palacio, centro, madrid, comunidad de madrid, 28013, españa', 40.415454, -3.710872, 'Calle Mayor', '', 'Madrid', 'Comunidad de Madrid', '28013', 'apartamento céntrico cerca del palacio real', 'apartamento céntrico para dos personas super cerca de palacio real.', 320000.00, 2, 1, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 78.50, '[\"pub_684255b540fc3.jpg\"]', NULL, '2025-06-06 02:43:01'),
(23, 8, 'alquiler', 'piso', 'carrer de sants, sants-badal, sants-montjuïc, barcelona, barcelonés, barcelona, cataluña, 08028, españa', 41.375562, 2.127943, 'Carrer de Sants', 'Sants-Montjuïc', 'Barcelona', 'Cataluña', '08028', 'piso de 3 habitaciones en zona comercial', 'piso de estudiantes en barcelona en zona comercial.', 1100.00, 3, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 90.00, '[\"pub_684256f012ee6.jpg\"]', NULL, '2025-06-06 02:48:16'),
(24, 8, 'venta', 'garaje', 'avenida de américa, guindalera, salamanca, madrid, comunidad de madrid, 28028, españa', 40.443557, -3.662937, 'Avenida de América', 'Salamanca', 'Madrid', 'Comunidad de Madrid', '28028', 'plaza de garaje amplia cerca del intercambiador', 'plaza de garaje para un coche.', 19000.00, 2, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 13.00, '[\"pub_684257c1d7753.jpg\"]', NULL, '2025-06-06 02:51:45'),
(25, 8, 'venta', 'casa', 'calle cervantes, camas, sevilla, andalucía, 41900, españa', 37.400849, -6.029501, 'Calle Cervantes', '', 'Camas', 'Andalucía', '41900', 'casa clásica con azotea en el centro histórico', 'casa con un gimnasio precioso y con una azotea en pleno centro histórico.', 275000.00, 3, 2, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 120.00, '[\"pub_68425834eb93f.jpg\"]', NULL, '2025-06-06 02:53:40'),
(26, 8, 'alquiler', 'oficina', 'gran vía, malasaña, palacio, centro, madrid, comunidad de madrid, 28013, españa', 40.422046, -3.708722, 'Gran Vía', '', 'Madrid', 'Comunidad de Madrid', '28013', 'oficina moderna lista para entrar', 'oficina en gran vía madrid.', 800.00, 1, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 45.00, '[\"pub_6842589c62c83.jpg\"]', NULL, '2025-06-06 02:55:24'),
(27, 9, 'venta', 'apartamento', 'calle marqués de larios, calle san pastor, centro histórico, centro, málaga, málaga-costa del sol, málaga, andalucía, 29005, españa', 36.719669, -4.421597, 'Calle San Pastor', '', 'Málaga', 'Andalucía', '29005', 'apartamento reformado en el casco antiguo', 'apartamento reformado en casco antiguo de málaga.', 240000.00, 2, 1, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 70.00, '[\"pub_6842593d8b6d9.jpg\"]', NULL, '2025-06-06 02:58:05'),
(28, 9, 'venta', 'piso', 'paseo de zorrilla, campo grande, valladolid, castilla y león, 47007, españa', 41.643110, -4.736087, 'Paseo de Zorrilla', 'Campo Grande', 'Valladolid', 'Castilla y León', '47007', 'piso familiar cerca de colegios', 'piso familiar cerca de los colegios.', 165000.00, 4, 2, 'semi-nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 105.00, '[\"pub_684259db56a8a.jpg\"]', NULL, '2025-06-06 03:00:43'),
(29, 9, 'venta', 'casa', 'gabinete literario, calle general bravo, triana, las palmas de gran canaria, las palmas, canarias, 35002, españa', 28.103174, -15.416606, 'Calle General Bravo', 'Triana', 'Las Palmas de Gran Canaria', '', '35002', 'casa adosada con jardín y garaje', 'casa adosada con jardín y garaje en las canarias.', 295000.00, 4, 2, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 135.00, '[\"pub_6842cc20a00d0.jpg\"]', NULL, '2025-06-06 11:08:16'),
(30, 9, 'alquiler', 'garaje', 'calle pintor rosales, la alhóndiga, getafe, comunidad de madrid, 28904, españa', 40.301608, -3.736387, 'Calle Pintor Rosales', 'La Alhóndiga', 'Getafe', 'Comunidad de Madrid', '28904', 'alquiler de garaje cubierto', 'garaje cubierto en madrid calle pintor rosales', 100.00, 1, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 0.00, '[\"pub_6842cc69aa399.jpg\"]', NULL, '2025-06-06 11:09:29'),
(31, 10, 'venta', 'terreno', 'camino viejo de coín, mijas, costa del sol occidental, málaga, andalucía, 29469, españa', 36.559183, -4.691750, 'Camino Viejo de Coín', '', 'Mijas', 'Andalucía', '29469', 'casa rural con terreno y piscina', 'amplia casa de campo con 4 dormitorios, piscina privada y terreno de 2000 m². ideal para vivir en la naturaleza.', 315000.00, 4, 2, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'habitante', 145.00, '[\"pub_6842cd3ff0083.jpg\"]', NULL, '2025-06-06 11:13:03'),
(32, 10, 'alquiler', 'piso', 'avenida de la constitución, santa cruz, casco antiguo, sevilla, andalucía, 41004, españa', 37.384749, -5.993899, 'Avenida de la Constitución', 'Casco Antiguo', 'Sevilla', 'Andalucía', '41004', 'piso con encanto en zona histórica', 'piso de 2 habitaciones, techos altos y balcones a la calle. a dos pasos de la catedral.', 980.00, 2, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'habitante', 75.00, '[\"pub_6842cd9980898.jpg\"]', NULL, '2025-06-06 11:14:33'),
(33, 10, 'venta', 'garaje', 'calle aragón, pedro garau, palma de mallorca, islas baleares, 07005, españa', 39.579342, 2.663917, 'Calle Aragón', 'Pedro Garau', 'Palma de Mallorca', 'Islas Baleares', '07005', 'plaza de garaje en edificio moderno', 'plaza de garaje amplia en garaje comunitario con puerta automática.', 22000.00, 0, 0, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'habitante', 14.00, '[\"pub_6842ce516092d.png\"]', NULL, '2025-06-06 11:17:37'),
(34, 10, 'venta', 'apartamento', 'calle laurel, villamediana de iregua, la rioja, 26142, españa', 42.426299, -2.420163, 'Calle Laurel', '', 'Villamediana de Iregua', 'La Rioja', '26142', 'apartamento moderno en calle peatonal', 'apartamento de 1 dormitorio, muy luminoso, ideal para parejas o inversión.', 125000.00, 1, 1, 'semi-nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'habitante', 52.00, '[\"pub_6842ced321839.jpg\"]', NULL, '2025-06-06 11:19:47'),
(35, 10, 'alquiler', 'oficina', '08010, eixample, barcelona, barcelonés, barcelona, cataluña, españa', 41.391507, 2.174675, '', '', 'Barcelona', 'Cataluña', '08010', 'oficina lista para entrar en el eixample', 'oficina con divisiones de cristal, muy luminosa, con baño y ascensor.', 1250.00, 0, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'habitante', 65.00, '[\"pub_6842cf521738a.jpg\"]', NULL, '2025-06-06 11:21:54'),
(36, 11, 'venta', 'otro', 'avenida de galicia, acea de ama, o burgo, culleredo, la coruña, galicia, 15670, españa', 43.316053, -8.366361, 'Avenida de Galicia', 'Acea de Ama', 'Culleredo', 'Galicia', '15670', 'chalet adosado con vistas al mar', 'chalet de 3 plantas con jardín, garaje y terraza frente a la costa.', 385000.00, 5, 3, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 165.00, '[\"pub_6842f16e0fc99.jpg\"]', NULL, '2025-06-06 13:47:26'),
(37, 11, 'alquiler', 'piso', 'calle toledo, argés, toledo, castilla-la mancha, 45122, españa', 39.809386, -4.057881, 'Calle Toledo', '', 'Argés', 'Castilla-La Mancha', '45122', 'piso amueblado en el casco histórico', 'piso en primera planta con mobiliario moderno y buena ventilación natural.', 850.00, 2, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 70.00, '[\"pub_6842f21793b19.jpg\"]', NULL, '2025-06-06 13:50:15'),
(38, 11, 'alquiler', 'garaje', 'calle federico garcía lorca, nervión, sevilla, andalucía, 41005, españa', 37.377332, -5.970364, 'Calle Federico García Lorca', 'Nervión', 'Sevilla', 'Andalucía', '41005', 'plaza de garaje cubierta con acceso privado', 'se alquila plaza de garaje en sótano con mando a distancia y vigilancia.', 90.00, 0, 0, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 12.00, '[\"pub_6842f29bba508.jpg\"]', NULL, '2025-06-06 13:52:27'),
(39, 11, 'venta', 'piso', 'calle san juan, orrio, ezcabarte, comarca de pamplona, 31013, españa', 42.872896, -1.656465, 'Calle San Juan', '', 'Ezcabarte', '', '31013', 'piso reformado a estrenar en pleno centro', 'piso de 3 habitaciones totalmente reformado con materiales de alta calidad.', 198000.00, 3, 2, 'semi-nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 95.00, '[\"pub_6842f4114af61.jpg\"]', NULL, '2025-06-06 13:58:41'),
(40, 11, 'venta', 'apartamento', 'calle la marina, rojales, la vega baja, alicante, comunidad valenciana, 03078, españa', 38.086598, -0.728669, 'Calle La Marina', '', 'Rojales', 'Comunidad Valenciana', '03078', 'apartamento en zona turística con piscina comunitaria', 'apartamento ideal para vacaciones, 2 habitaciones, piscina y zona tranquila cerca del mar.', 145000.00, 2, 1, 'semi-nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'empresa', 68.00, '[\"pub_6842f46d75365.jpg\"]', NULL, '2025-06-06 14:00:13'),
(41, 12, 'venta', 'local', 'calle san vicente mártir, sant marcel·lí, jesús, valencia, comarca de valencia, valencia, comunidad valenciana, 46017, españa', 39.447658, -0.385945, 'Calle San Vicente Mártir', 'Jesús', 'Valencia', 'Comunidad Valenciana', '46017', 'local comercial a pie de calle en zona céntrica', 'local de 90 m² en pleno centro de valencia, ideal para tienda, oficina o cafetería. reformado recientemente.', 210000.00, 2, 1, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 90.00, '[\"pub_6842f5164db73.jpg\"]', NULL, '2025-06-06 14:03:02'),
(42, 12, 'alquiler', 'oficina', 'paseo de la castellana, castilla, chamartín, madrid, comunidad de madrid, 28046, españa', 40.466730, -3.688918, 'Paseo de la Castellana', 'Chamartín', 'Madrid', 'Comunidad de Madrid', '28046', 'oficina de diseño con despachos y zona coworking', 'oficina moderna de 120 m² con sala de reuniones, aire acondicionado y mucha luz natural.', 1800.00, 4, 1, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 120.00, '[\"pub_6842f5842e749.jpg\"]', NULL, '2025-06-06 14:04:52'),
(43, 12, 'venta', 'otro', 'calle de bravo murillo, almenara, tetuán, madrid, comunidad de madrid, 28020, españa', 40.465758, -3.690391, 'Calle de Bravo Murillo', 'Tetuán', 'Madrid', 'Comunidad de Madrid', '28020', 'trastero de 8 m² con fácil acceso', 'trastero seco, con ventilación, puerta metálica y acceso independiente.', 7500.00, 0, 0, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 0.00, '[\"pub_6842f5f7b1a76.jpg\"]', NULL, '2025-06-06 14:06:47'),
(44, 12, 'alquiler', 'casa', 'calle mayor, elorz, valle de elorz, comarca de pamplona, navarra, españa', 42.733480, -1.561276, 'Calle Mayor', '', 'Valle de Elorz', 'Navarra', '', 'casa familiar en zona tranquila con jardín', 'vivienda de 2 plantas con 4 dormitorios, jardín privado y garaje. ideal para familias.', 1250.00, 4, 2, 'usado', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 135.00, '[\"pub_6842f6323f356.jpg\"]', NULL, '2025-06-06 14:07:46'),
(45, 12, 'venta', 'piso', 'avenida juan carlos i, vista alegre, murcia, área metropolitana de murcia, región de murcia, 30008, españa', 37.992928, -1.130573, 'Avenida Juan Carlos I', '', 'Murcia', 'Región de Murcia', '30008', 'piso con vistas despejadas y trastero', 'piso amplio de 3 habitaciones, salón comedor, cocina independiente y trastero incluido en el precio.', 169000.00, 3, 2, 'semi-nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 97.00, '[\"pub_6842f680f09f0.jpg\"]', NULL, '2025-06-06 14:09:04'),
(46, 12, 'alquiler', 'garaje', 'bolaños de calatrava, ciudad real, castilla-la mancha, 13260, españa', 38.906253, -3.662981, '', '', 'Bolaños de Calatrava', 'Castilla-La Mancha', '13260', 'local en centro de localidad', 'local situado en la plaza de la localidad.', 140000.00, 0, 0, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 70.00, '[\"pub_6842fbfb6ee04.jpg\"]', NULL, '2025-06-06 14:32:27'),
(47, 12, 'alquiler', 'casa', 'almagro, ciudad real, castilla-la mancha, 13270, españa', 38.888238, -3.711822, '', '', 'Almagro', 'Castilla-La Mancha', '13270', 'casa a las afueras', 'casa familiar con chimenea para inviernos frios.', 145004.00, 3, 2, 'nuevo', 1, 1, 1, 1, 1, 1, 1, 1, 'propietario', 150.00, '[\"pub_6842fc7c9a3d4.jpg\"]', NULL, '2025-06-06 14:34:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `nombre_usuario` varchar(100) DEFAULT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipo_usuario` enum('habitante','propietario','empresa') NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `preferencia_contacto` enum('whatsapp','email','mensaje') NOT NULL,
  `terminos_aceptados` tinyint(1) NOT NULL DEFAULT 0,
  `creado_en` datetime DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `nombre_usuario`, `correo_electronico`, `telefono`, `contrasena`, `tipo_usuario`, `ubicacion`, `foto_perfil`, `descripcion`, `preferencia_contacto`, `terminos_aceptados`, `creado_en`, `actualizado_en`) VALUES
(7, 'Luis Augusto', 'Procel Amendaño', 'LuisAu', '1uis4ugus70@gmail.com', '6666666', '$2y$10$3wamamvPaKNjMOxILMBfHuHDvW5/dIgUp2ea4byMccGyRhicMR6AS', 'habitante', 'Granada, Partido Judicial de Granada, Granada, Andalucía, España', 'noGuardados.png', 'Hola esta es una descripción de mi mismo', 'whatsapp', 1, '2025-06-05 23:46:40', '2025-06-05 23:46:40'),
(8, 'Pablo', 'Lopez', 'PaLopez', 'pablo123@gmail.com', '666444555', '$2y$10$udv9UvVe2BydG0.uO9ZMtuT71rGEnPIM6HMC3jtJgDA5RpTyE1RL6', 'propietario', 'Burgos, Castilla y León, España', 'brooke-cagle-KriecpTIWgY-unsplash.jpg', 'Propietario de dos departamentos en el edificio central. Supervisa el mantenimiento general.', 'email', 1, '2025-06-06 04:22:16', '2025-06-06 04:22:16'),
(9, 'Erik', 'Mendoza Torres', 'ErikMT', 'erik123@gmail.com', '777555666', '$2y$10$wg7/Sc1rvpxaOO8TDv.9m.0YhYS3e1yOzlAzhAhmsNh54vVMIgepy', 'empresa', 'Ciudad Real, Castilla-La Mancha, España', 'charles-etoroma-95UF6LXe-Lo-unsplash.jpg', 'Representante de \"CleanPro S.A.\", empresa de limpieza que da servicio al conjunto residencial.', 'whatsapp', 1, '2025-06-06 04:24:21', '2025-06-06 04:24:21'),
(10, 'Lucía', 'Torres Benavides', 'LuciaTB', 'lucia123@gmail.com', '662245789', '$2y$10$D.4/s6R0U209LicLryb9a.7.c5OiKdci.2GhkXFstWNZgNICeqxo6', 'habitante', 'Badajoz, Tierra de Badajoz, Badajoz, Extremadura, España', 'michael-dam-mEZ3PoFGs_k-unsplash.jpg', 'Madre de familia que reside en el bloque B. Responsable del huerto comunitario.', 'mensaje', 1, '2025-06-06 04:26:53', '2025-06-06 04:26:53'),
(11, 'Paula', 'Gómez Gonzalez', 'PaulaGG', 'paula123@gmail.com', '666555444', '$2y$10$/fHe7V7AvOoNjpPdRyNnJuGyYLfvFamXDx6dxBoQD5tom0xlE/nQS', 'empresa', 'Almagro, Ciudad Real, Castilla-La Mancha, 13270, España', 'aiony-haust-3TLl_97HNJo-unsplash.jpg', 'Dueña de “SegurTech”, la empresa encargada de la vigilancia del condominio.', 'email', 1, '2025-06-06 04:30:45', '2025-06-06 04:30:45'),
(12, 'Alejandro', 'Suárez Molina', 'AlexSM', 'alejandro123@gmail.com', '654856987', '$2y$10$7C12NmyW9c/urJY31wt0NeQ2QsLy/2DKoN54E8oVQajW0H8eEdW/q', 'propietario', 'Cuenca, Castilla-La Mancha, España', 'photo-1539571696357-5a69c17a67c6.png', 'Dueño de tres propiedades, miembro activo de la junta de administración.', 'whatsapp', 1, '2025-06-06 04:34:03', '2025-06-06 04:34:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `guardados`
--
ALTER TABLE `guardados`
  ADD PRIMARY KEY (`id_usuario`,`id_publicacion`),
  ADD KEY `id_publicacion` (`id_publicacion`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `guardados`
--
ALTER TABLE `guardados`
  ADD CONSTRAINT `guardados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guardados_ibfk_2` FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
