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
        require_once '../views/IndexView.php';
    }

    public function cargarPublicaciones()
    {
        session_start();
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['id'])) {
            /* echo json_encode([
            'status' => 'error',
                'message' => 'Usuario no autenticado'
            ]); 
            exit;*/
        }
        // Obtener las publicaciones
        $publicaciones = $this->model->obtenerPublicaciones();
        $publicaciones_guardadas = $this->model->obtenerPublicacionesGuardadas();

        if ($publicaciones) {
            require_once '../views/PublicacionesView.php';
        } else {
            echo '<div class="alert alert-danger" role="alert"> A simple danger alert—check it out! </div>';
        }
    }


    // Función para cargar las publicaciones por filtro
    public function cargarPublicacionesFiltro($filtros)
    {

        // Obtener las publicaciones por filtro
        $publicaciones = $this->model->obtenerPublicacionesFiltro($filtros);

        if ($publicaciones !== "") {
            require_once '../views/PublicacionesView.php';
        
        } else {
            echo `No hay publicaciones disponibles con los filtros`;
        }
    }

    // Función para cargar las publicaciones por titulo
    public function buscarAnuncios($q)
    {
        // Lógica de búsqueda en el modelo (LIKE, SOUNDEX, Levenshtein…)
        $publicaciones = $this->model->buscarAnuncios($q);

        if ($publicaciones !== "") {
            require_once '../views/PublicacionesView.php';
        
        } else {
            echo `No hay publicaciones disponibles con los filtros`;
        }
    }
}



$raw   = file_get_contents('php://input');
$datos = json_decode($raw, true);

$esFiltros = $datos['esFiltros'] ?? false;
$filtros   = $datos['filtros']   ?? [];
$ruta      = $_POST['ruta']      ?? $datos['ruta'] ?? '';
$accion    = $_POST['accion']    ?? '';

if ($ruta === '/HabitaRoom/index' && $accion === 'buscar') {
    $q = trim(strtolower($_POST['q'] ?? ''));
    $ctl = new IndexController();
    ob_start();
      $ctl->buscarAnuncios($q);
    echo ob_get_clean();
    exit;
}

if ($ruta === '/HabitaRoom/index' || $ruta === '/HabitaRoom/index.php') {
    $ctl = new IndexController();
    ob_start();
      if ($esFiltros) {
          $ctl->cargarPublicacionesFiltro($filtros);
      } else {
          $ctl->cargarPublicaciones();
      }
    echo ob_get_clean();
    exit;
}