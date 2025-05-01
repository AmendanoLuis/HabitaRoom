<?php
//redireccionWeb.php

// Incluir las rutas
$rutas = require 'web.php';

// Incluir el controlador principal
require_once  '../config/db/db.php';
require '../models/IndexModel.php';
require_once  '../controllers/IndexController.php';

// Obtener la ruta actual
$ruta_actual = $_POST['site'] ?? '/';


// Eliminar .php de la ruta
$ruta_actual = str_replace('.php', '', $ruta_actual);
// Extraer el ID si está presente en la URL
$id = $_POST['publi_id'] ?? null;

// Comprobar si la ruta existe en las rutas definidas
if (array_key_exists($ruta_actual, $rutas)) {



    // Obtener la acción o función a ejecutar (Controlador@Funcion)
    $accion = $rutas[$ruta_actual];

    // Dividir en controlador y método usando el separador @
    list($controlador, $funcion) = explode('@', $accion);

    // Incluir el archivo del controlador correspondiente
    $controlador_path = $_SERVER['DOCUMENT_ROOT'] . "/HabitaRoom/controllers/{$controlador}.php";

    if (!file_exists($controlador_path)) {
        die("Error: No se encontró el controlador {$controlador}.");
    }
    require_once $controlador_path;

    // Instanciar el controlador 
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

        // Si la función no se encuentra, error 
        echo "La función no existe.";
    }
} else {
    // Si la ruta no se encuentra, error 
    echo "Página no encontrada.";
}
