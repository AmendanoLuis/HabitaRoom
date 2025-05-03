<?php

require_once '../models/ModelPublicacion.php';

class PublicacionUsuarioController
{

    public function cargarPublicacion($id)
    {

        $modelo = new ModelPublicacion();

        $publicacion = $modelo->obtenerPublicacionPorId($id);

        if (!$publicacion) {
            echo 'Publicación no encontrada';
            return;
        }

        require_once '../views/PublicacionUsuarioView.php';
    }
}


//------------------------------------------------------
// INICIO DE LA CARGA DE PUBLICACION
//------------------------------------------------------


if (isset($_GET['id']) ) {
    $id = $_GET['id'];

    $controller = new PublicacionUsuarioController();
    $controller->cargarPublicacion($id);
}

