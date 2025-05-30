<?php
// Sesion
require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/ModelUsuario.php';
session_start();

if (isset($_SESSION['id'])) {
    $userModel = new ModelUsuario();
    $usuario = $userModel->obtenerUsuarioId($_SESSION['id']);
}

// Incluir las rutas
$rutas = require 'routes/web.php';

// Obtener la ruta actual
$url = $_SERVER['REQUEST_URI'];

// Incluir el controlador y la conexión a la base de datos
require_once  'controllers/IndexController.php';
require_once  'config/db/db.php';

// Crear la conexión
$dbConnection = Database::connect();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabitaRoom</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="icon" href="public/img/logo_HR_sinFondo.png">
</head>

<body class="color_fondo_web">

    <!-- Barra de Navegación | Header -->

    <?php

    if ($url == '/HabitaRoom/login' || $url == '/HabitaRoom/registro') {
    } else {
        include __DIR__ . '/includes/headerIndex.php';
    }

    ?>

    <!-- Contenido principal -->
    <div class="contenidoMain" id="contenidoMain">
        <!-- aqui se carga contenido dinamico -->
    </div>
    <div id="pantalla-cargando" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- Footer -->
    <?php

    if ($url == '/HabitaRoom/login' || $url == '/HabitaRoom/registro') {
    } else {
        include __DIR__ . '/includes/footer.php';
    }

    ?>


    <!--SCRIPTS-->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Cookies para AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Leaflet + Nominatim -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


    <!-- Scripts control contenido -->
    <!-- En tu HTML principal -->
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