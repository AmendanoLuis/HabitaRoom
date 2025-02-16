<?php
// Incluir el controlador principal
require_once  '../config/db/db.php';
require '../models/IndexModel.php';
require_once  '../controllers/IndexController.php';


// Si la validación es correcta
$indexController = new IndexController();
$indexController->cargarContenidoPagina();


?>