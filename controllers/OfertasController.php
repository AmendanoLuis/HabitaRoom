<?php
/**
 * Class OfertasController
 *
 * Controlador encargado de gestionar la visualización de publicaciones en oferta en HabitaRoom.
 * Obtiene las publicaciones marcadas como ofertas y las envía a la vista correspondiente.
 *
 * @package HabitaRoom\Controllers
 */

require_once '../models/ModelObtenerPublicaciones.php';

class OfertasController {
    /**
     * Carga las publicaciones que están en oferta.
     *
     * Este método instancia el modelo correspondiente para obtener las publicaciones en oferta,
     * almacena el resultado en la variable $ofertas y luego incluye la vista 'OfertasView.php'
     * para mostrar dichos resultados al usuario.
     *
     * @return void
     */
    public function cargarOfertas() {
        // Instanciar el modelo para obtener publicaciones
        $publicacionesModel = new ModelObtenerPublicaciones();

        // Obtener las publicaciones marcadas como ofertas
        $ofertas = $publicacionesModel->obtenerPublicacionesOfertas();

        // Cargar la vista y pasar las ofertas obtenidas
        require_once '../views/OfertasView.php';
    }
}
