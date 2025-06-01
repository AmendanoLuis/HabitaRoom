<?php
/**
 * Archivo: redireccionWeb.php
 *
 * Este script actúa como enrutador principal de la aplicación HabitaRoom.
 * Obtiene la ruta solicitada, verifica si coincide con las rutas definidas,
 * carga el controlador correspondiente y ejecuta la función deseada.
 *
 * @package HabitaRoom\Core
 */

// Incluir el archivo de rutas (web.php) que retorna un array ['/ruta' => 'Controlador@metodo', ...]
$rutas = require 'web.php';

require_once '../config/db/db.php';
require '../models/ModelObtenerPublicaciones.php';
require_once '../controllers/IndexController.php';

// Obtener la ruta solicitada: se prioriza POST['site'] si existe, de lo contrario se usa REQUEST_URI
$ruta_original = $_POST['site'] ?? $_SERVER['REQUEST_URI'];

// Normalizar la ruta eliminando extensión .php
$ruta_original = str_replace('.php', '', $ruta_original);

// Parsear URL para separar path y query string
$partes_url = parse_url($ruta_original);
$ruta_actual = $partes_url['path'];

// Extraer parámetro 'id' si existe en la query string o en POST
parse_str($partes_url['query'] ?? '', $query_params);
$id = $query_params['id'] ?? ($_POST['id'] ?? null);

// Verificar si la ruta solicitada existe en el array de rutas definidas
if (array_key_exists($ruta_actual, $rutas)) {
    // Obtener la acción (string "Controlador@metodo") definida para esa ruta
    $accion = $rutas[$ruta_actual] ?? 'PublicacionUsuarioController@mostrarPublicacionUsuario';

    // Separar controlador y método
    list($controlador, $funcion) = explode('@', $accion);

    // Construir ruta al archivo del controlador basado en el nombre
    $controlador_path = $_SERVER['DOCUMENT_ROOT'] . "/HabitaRoom/controllers/{$controlador}.php";

    if (!file_exists($controlador_path)) {
        die("Error: No se encontró el controlador {$controlador}.");
    }

    // Incluir el archivo del controlador
    require_once $controlador_path;

    if (!class_exists($controlador)) {
        die("Error: El controlador {$controlador} no está definido.");
    }

    // Instanciar el controlador
    $controlador_obj = new $controlador();

    // Verificar que el método exista en la clase
    if (method_exists($controlador_obj, $funcion)) {
        if ($id !== null) {
            // Llamar al método pasando el ID si existe
            $controlador_obj->$funcion($id);
        } else {
            // Llamar al método sin parámetros
            $controlador_obj->$funcion();
        }
    } else {
        echo "La función {$funcion} no existe en el controlador {$controlador}.";
    }
} else {
    echo "Página no encontrada.";
}
