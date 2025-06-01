<?php
/**
 * Class PublicacionUsuarioController
 *
 * Controlador encargado de mostrar los detalles de una publicación específica en HabitaRoom.
 * Recupera la publicación según su ID y carga la vista correspondiente.
 *
 * @package HabitaRoom\Controllers
 */

require_once '../models/ModelPublicacion.php';

class PublicacionUsuarioController
{
    /**
     * Carga los datos de la publicación con el ID proporcionado.
     * Si la publicación no existe, muestra un mensaje de error.
     *
     * @param int $id ID de la publicación a obtener.
     * @return void
     */
    public function cargarPublicacion($id)
    {
        $modelo = new ModelPublicacion();

        // Obtener la publicación por ID
        $publicacion = $modelo->obtenerPublicacionPorId($id);

        if (!$publicacion) {
            echo 'Publicación no encontrada';
            return;
        }

        // Cargar la vista con los datos de la publicación
        require_once '../views/PublicacionUsuarioView.php';
    }
}

// ------------------------------------------------------
// Bloque de inicialización: carga de la publicación desde GET
// ------------------------------------------------------
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $controller = new PublicacionUsuarioController();
    $controller->cargarPublicacion($id);
}
