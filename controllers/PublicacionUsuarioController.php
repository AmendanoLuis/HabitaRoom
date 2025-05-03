<?php

require_once '../models/ModelPublicacion.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PublicacionUsuarioController
{

    public function cargarPublicacion($id)
    {
        if (!is_numeric($id)) {
            die('ID inválido');
        }

        $modelo = new ModelPublicacion();

        $publicacion = $modelo->obtenerPublicacionPorId($id);

        if (!$publicacion) {
            echo 'Publicación no encontrada';
            return;
        }

        require_once '../views/PublicacionUsuarioView.php';
    }
}
if (isset($_POST['id_publi'])) {
    $id = $_POST['id_publi'];

    $controller = new PublicacionUsuarioController();
    $controller->cargarPublicacion($id);
} else {
    echo 'ID de publicación no proporcionado';
}
