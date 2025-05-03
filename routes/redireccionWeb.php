<?php
// redireccionWeb.php

// Incluir las rutas
$rutas = require 'web.php';

// Incluir el controlador principal
require_once '../config/db/db.php';
require '../models/ModelObtenerPublicaciones.php';
require_once '../controllers/IndexController.php';

// Obtener la ruta actual desde POST o desde REQUEST_URI si es GET
$ruta_original = $_POST['site'] ?? $_SERVER['REQUEST_URI'];

// Normalizar la ruta (eliminar .php)
$ruta_original = str_replace('.php', '', $ruta_original);

// Parsear la URL si viene con parámetros (GET)
$partes_url = parse_url($ruta_original);
$ruta_actual = $partes_url['path'];

// Extraer el ID si está en la query string
parse_str($partes_url['query'] ?? '', $query_params);
$id = $query_params['id'] ?? ($_POST['id'] ?? null);

// Verificar si la ruta existe en las rutas definidas o coincide con patrón especial
if (array_key_exists($ruta_actual, $rutas)) {
    // Obtener acción a ejecutar (Controlador@Funcion)
    $accion = $rutas[$ruta_actual] ?? 'PublicacionUsuarioController@mostrarPublicacionUsuario'; // fallback si es por patrón

    list($controlador, $funcion) = explode('@', $accion);

    $controlador_path = $_SERVER['DOCUMENT_ROOT'] . "/HabitaRoom/controllers/{$controlador}.php";

    if (!file_exists($controlador_path)) {
        die("Error: No se encontró el controlador {$controlador}.");
    }

    require_once $controlador_path;

    if (!class_exists($controlador)) {
        die("Error: El controlador {$controlador} no está definido.");
    }

    $controlador_obj = new $controlador();

    if (method_exists($controlador_obj, $funcion)) {
        if ($id !== null) {
            $controlador_obj->$funcion($id);
        } else {
            $controlador_obj->$funcion();
        }
    } else {
        echo "La función no existe.";
    }
} else {
    echo "Página no encontrada.";
}
