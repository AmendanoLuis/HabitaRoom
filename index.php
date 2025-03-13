<?php
// Sesion
require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/User.php';
session_start();

if(isset($_SESSION['id'])){
    $userModel = new Usuario();
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
</head>

<body class="bg-light-subtle">

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


    <!-- Scripts control contenido -->
    <script src="config/app.js"></script>
</body>

</html>