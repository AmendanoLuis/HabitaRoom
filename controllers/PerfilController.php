<?php
session_start();

require_once '../models/ModelUsuario.php';

class PerfilController
{
    public function cargarPerfil()
    {
        require_once '../views/PerfilView.php';

    }
}
