<?php
/**
 * Class PerfilController
 *
 * Controlador encargado de manejar la visualización del perfil de usuario en HabitaRoom.
 * Se asegura de cargar la vista correspondiente al perfil.
 *
 * @package HabitaRoom\Controllers
 */

session_start();

require_once '../models/ModelUsuario.php';

class PerfilController
{
    /**
     * Carga la vista del perfil de usuario.
     * Si el usuario no está autenticado, la vista deberá gestionar la redirección o mostrar error.
     *
     * @return void
     */
    public function cargarPerfil()
    {
        require_once '../views/PerfilView.php';
    }
}
