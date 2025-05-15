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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
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

    // Función para cargar más publicaciones (infinite scroll)
    public function cargarMasPublicaciones()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;
        $limite = isset($_POST['limite']) ? (int)$_POST['limite'] : 10;

        $publicaciones = $this->model->obtenerPublicaciones($limite, $offset);

        if ($publicaciones) {
            // Incluye la vista parcial que renderiza SOLO las publicaciones (sin layout completo)
            require_once '../views/PublicacionesView.php';
        } else {
            // Devuelve vacío o algún indicador para que el JS deje de hacer peticiones
            echo '';
        }
        exit;
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

// Búsqueda por título
if ($ruta === '/HabitaRoom/index' && $accion === 'buscar') {
    $q   = trim(strtolower($_POST['q'] ?? ''));
    $ctl = new IndexController();
    ob_start();
    $ctl->buscarAnuncios($q);
    echo ob_get_clean();
    exit;
}

// Filtro por tipo de publicitante
if ((strpos($ruta, '/HabitaRoom/index') === 0) && $accion === 'filtrarTipoPublicitante') {
    $tipo = trim(strtolower($_POST['tipo_publicitante'] ?? ''));
    $ctl  = new IndexController();
    ob_start();
    $ctl->cargarPublicacionesFiltro(['tipo_publicitante' => $tipo]);
    echo ob_get_clean();
    exit;
}

// Cargar más publicaciones (infinite scroll)
if ($ruta === '/HabitaRoom/index' && $accion === 'cargarMasPublicaciones') {
    $ctl = new IndexController();
    $ctl->cargarMasPublicaciones();
    exit;
}


// Lógica genérica de índice
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

