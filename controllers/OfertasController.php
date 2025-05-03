<?php

require_once '../models/ModelObtenerPublicaciones.php';


class OfertasController {
    public function cargarOfertas() {
        // Cargar el modelo de ofertas
        $publicacionesModel = new ModelObtenerPublicaciones();

        // Obtener las ofertas
        $ofertas = $publicacionesModel->obtenerPublicacionesOfertas();

        // Cargar la vista y pasarle las ofertas
        require_once '../views/OfertasView.php';

    }
}