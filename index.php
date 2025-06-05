<?php
/**
 * Archivo: index.php
 *
 * Punto de entrada principal de la aplicación HabitaRoom.
 * Inicializa la sesión, establece la conexión a la base de datos,
 * obtiene la ruta actual y prepara el entorno visual cargando el header/footer dinámicamente.
 *
 * @package HabitaRoom\Core
 */

// Cargar modelo de usuario y comenzar sesión
require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/ModelUsuario.php';
session_start();

if (isset($_SESSION['id'])) {
    $userModel = new ModelUsuario();
    $usuario = $userModel->obtenerUsuarioId($_SESSION['id']);
}

// Cargar rutas
$rutas = require 'routes/web.php';

// Obtener la URL actual
$url = $_SERVER['REQUEST_URI'];

// Conexión a la base de datos y controlador principal
require_once 'controllers/IndexController.php';
require_once 'config/db/db.php';
$dbConnection = Database::connect();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabitaRoom</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="public/css/styles.css">

    <!-- Leaflet (mapas) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="icon" href="public/img/logo_HR_sinFondo.png">
</head>

<body class="color_fondo_web">
    <!-- Header dinámico -->
    <?php if ($url !== '/HabitaRoom/login' && $url !== '/HabitaRoom/registro') {
        include __DIR__ . '/includes/headerIndex.php';
    } ?>

    <!-- Contenido dinámico -->
    <div class="contenidoMain" id="contenidoMain"></div>
    <div id="pantalla-cargando" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- Footer dinámico -->
    <?php if ($url !== '/HabitaRoom/index' && $url !== '/HabitaRoom/login' && $url !== '/HabitaRoom/registro') {
        include __DIR__ . '/includes/footer.php';
    } ?>

    <!-- Librerías y scripts externos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Módulos JS propios -->
    <script type="module" src="public/js/loadingPage.js"></script>
    <script type="module" src="public/js/index.js"></script>
    <script type="module" src="public/js/crearPublicacion.js"></script>
    <script type="module" src="public/js/register.js"></script>
    <script type="module" src="public/js/mapUtils.js"></script>
    <script type="module" src="public/js/manejadorMapa.js"></script>
    <script type="module" src="public/js/ubicacionesAutocompletar.js"></script>
    <script type="module" src="config/app.js"></script>
</body>

</html>
