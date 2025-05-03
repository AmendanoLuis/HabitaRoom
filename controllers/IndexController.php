<?php
// Determinar la página actual
$pagina_actual = trim(basename($_SERVER['PHP_SELF']));

require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/ModelObtenerPublicaciones.php';


class IndexController
{
    private $model;

    public function __construct()
    {
        // Instancia del modelo
        $this->model = new ModelObtenerPublicaciones();
    }


    public function cargarPagina()
    {
        // Verificamos si las publicaciones se obtuvieron
        require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/views/IndexView.php';
    }

    public function cargarContenidoPagina()
    {
        // Obtener las publicaciones
        $publicaciones = $this->model->obtenerPublicaciones();
        $publicaciones_guardadas = $this->model->obtenerPublicacionesGuardadas();
        
        if ($publicaciones) {

            require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/views/PublicacionesView.php';
        } else {
            echo '<div class="alert alert-danger" role="alert"> A simple danger alert—check it out! </div>';
        }
    }


    // Función para cargar las publicaciones por filtro
    public function cargarPublicacionesFiltro($filtros)
    {
        // Obtener las publicaciones por filtro
        $publicaciones = $this->model->cargarPublicacionesFiltro($filtros);

        if ($publicaciones) {
            include $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/views/PublicacionesFiltrosView.php';
        } else {
            echo "No hay publicaciones disponibles con filtros.";
        }
    }
}


// Instanciar el controlador
if (isset($_POST['ruta']) && ($_POST['ruta'] === '/HabitaRoom/index' || $_POST['ruta'] === '/HabitaRoom/index.php')) {

    $indexController = new IndexController();
    $indexController->cargarContenidoPagina();
}
