<?php



// Determinar la página actual
$pagina_actual = trim(basename($_SERVER['PHP_SELF']));

require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/IndexModel.php';


class IndexController
{
    private $model;

    public function __construct()
    {
        // Instancia del modelo
        $this->model = new IndexModel(Database::connect());
    }

    // Función para cargar las publicaciones
    public function cargarPublicaciones()
    {
        // Obtener las publicaciones
        $publicaciones = $this->model->obtenerPublicaciones();

        // Verificamos si las publicaciones se obtuvieron
        if ($publicaciones) {

            // Pasamos las publicaciones a la vista
        include $_SERVER['DOCUMENT_ROOT'] .'/HabitaRoom/views/IndexView.php';

        } else {
            echo "No hay publicaciones disponibles.";
        }
    }

    // Función para cargar las publicaciones por filtro
    public function cargarPublicacionesFiltro($filtros)
    {
        // Obtener las publicaciones por filtro
        $publicaciones = $this->model->cargarPublicacionesFiltro($filtros);

        if($publicaciones){
        include $_SERVER['DOCUMENT_ROOT'] .'/HabitaRoom/views/IndexView.php';
            
        }else{
            echo "No hay publicaciones disponibles con filtros.";
        }
    }
}
