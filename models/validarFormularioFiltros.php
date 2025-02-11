<?php

// Incluir el controlador principal
require_once  '../config/db/db.php';
require '../models/IndexModel.php';
require_once  '../controllers/IndexController.php';

$filtros = $_POST;

$errores = [];

if (isset($filtros['tipo-inmueble'])) {
    if ($filtros['tipo-inmueble'] == 'Seleccionar') {
        $filtros['tipo-inmueble'] = '';
    }
}

if (isset($filtros['precio-min'])) {
    if ($filtros['precio-min'] == 'Min') {
        $filtros['precio-min'] = '';
    }
}

if (isset($filtros['precio-max'])) {
    if ($filtros['precio-max'] == 'Max') {
        $filtros['precio-max'] = '';
    }
}

if (!empty($filtros['precio-min']) && !empty($filtros['precio-max'])) {
    if ($filtros['precio-min'] >=  $filtros['precio-max']) {
        $errores[] = "El precio mínimo no puede ser mayor al máximo.";
    }
}

if (isset($filtros['habitaciones']) && !empty($filtros['habitaciones'])) {
    if (!is_numeric($filtros['habitaciones'])) {
        $errores[] = "El número de habitaciones no es válido.";
    }
}

if (isset($filtros['banos']) && !empty($filtros['banos'])) {
    if (!is_numeric($filtros['banos'])) {
        $errores[] = "El número de baños no es válido.";
    }
}

if (isset($filtros['estado']) && is_array($filtros['estado'])) {

    $estados_validos = ['nuevo', 'semi-nuevo', 'usado', 'renovado'];

    foreach ($filtros['estado'] as $estado) {
        if (!in_array($estado, $estados_validos)) {
            $errores[] = "Estado '$estado' no es válido.";
        }
    }
}

if (isset($filtros['caracteristicas']) && is_array($filtros['caracteristicas'])) {

    $caract_validos = ['ascensor', 'piscina', 'gimnasio', 'garaje', 'terraza', 'jardin', 'acondicionado', 'calefaccion'];

    foreach ($filtros['caracteristicas'] as $caract) {
        if (!in_array($caract, $caract_validos)) {
            $errores[] = "Caracteristica '$caract' no es válido.";
        }
    }
}



// Si hay errores se muestran en el contenedor con name errores
if (!empty($errores)) {

    echo '<div class="alert alert-danger">';
    foreach ($errores as $error) {
        echo "<h1>Error</h1>
        <p>$error</p>";
    }
    echo '</div>';
    exit;
}


// Si la validación es correcta
$indexController = new IndexController();
$indexController->cargarPublicacionesFiltro($filtros);
