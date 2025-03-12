<?php
session_start();

require_once '../models/User.php';

class PerfilController
{
    public function cargarPerfil()
    {
        require_once '../views/PerfilView.php';

    }
}
