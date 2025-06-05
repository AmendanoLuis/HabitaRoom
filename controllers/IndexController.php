<?php

/**
 * Archivo: IndexController.php
 *
 * Controlador principal para la página de inicio de HabitaRoom.
 * Gestiona la carga inicial de la vista, la obtención y filtrado de publicaciones,
 * así como la lógica de búsqueda y scroll infinito.
 *
 * @package HabitaRoom\Controllers
 */

// Determinar la página actual
$pagina_actual = trim(basename($_SERVER['PHP_SELF']));

require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/ModelObtenerPublicaciones.php';

/**
 * Class IndexController
 *
 * Controlador encargado de obtener y mostrar publicaciones en la página de inicio.
 * Incluye métodos para carga inicial, scroll infinito, filtros y búsqueda.
 */
class IndexController
{
    /**
     * @var ModelObtenerPublicaciones Instancia del modelo para obtener publicaciones.
     */
    private $model;

    /**
     * Constructor: instancia el modelo para publicaciones.
     */
    public function __construct()
    {
        $this->model = new ModelObtenerPublicaciones();
    }

    /**
     * Carga la vista principal de la página de inicio.
     * Incluye IndexView.php para mostrar la interfaz.
     *
     * @return void
     */
    public function cargarPagina()
    {
        require_once '../views/IndexView.php';
    }

    /**
     * Obtiene todas las publicaciones y las mostrará en la vista.
     * También obtiene las publicaciones guardadas para el usuario autenticado.
     *
     * @return void
     */
    public function cargarPublicaciones()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ruta = $_POST['ruta'] ?? '';

        // Obtener las publicaciones
        $publicaciones = $this->model->obtenerPublicaciones();
        $publicaciones_guardadas = $this->model->obtenerPublicacionesGuardadas();

        if ($publicaciones) {
            require_once '../views/PublicacionesView.php';
        } else {
            echo '<div class="alert alert-danger" role="alert"> A simple danger alert—check it out! </div>';
        }
    }

    /**
     * Carga más publicaciones para scroll infinito.
     * Recibe offset y límite por POST, obtiene más registros y retorna la vista parcial.
     *
     * @return void
     */
    public function cargarMasPublicaciones($id_publis_cargadas = [])
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $offset = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;
        $limite = isset($_POST['limite']) ? (int) $_POST['limite'] : 10;

        $publicaciones = $this->model->obtenerMasPublicaciones($limite, $offset, $id_publis_cargadas);

        if ($publicaciones) {
            // Incluye la vista parcial que renderiza SOLO las publicaciones (sin layout completo)
            require_once '../views/PublicacionesView.php';
        } else {
            // Devuelve vacío o algún indicador para que el JS deje de hacer peticiones
            echo '';
        }
        exit;
    }


    /**
     * Obtiene y muestra publicaciones filtradas según parámetros.
     *
     * @param array $filtros Array asociativo con claves de campo y valor a filtrar.
     * @return void
     */
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

    /**
     * Busca publicaciones por término de título.
     * Utiliza LIKE u otros algoritmos según el modelo.
     *
     * @param string $q Palabra o frase a buscar.
     * @return void
     */
    public function buscarAnuncios($q)
    {
        // Lógica de búsqueda en el modelo (LIKE, SOUNDEX, Levenshtein…)
        $publicaciones = $this->model->obtenerPublicacionesTitulo($q);

        if ($publicaciones !== "") {
            require_once '../views/PublicacionesView.php';
        } else {
            echo `No hay publicaciones disponibles con los filtros`;
        }
    }
}


// -----------------------------------------------------------
// Lógica de enrutamiento y procesamiento de peticiones AJAX
// -----------------------------------------------------------



// Leer body JSON si existe
$raw = file_get_contents('php://input');
$datos = json_decode($raw, true);

$esFiltros = $datos['esFiltros'] ?? false;
$filtros = $datos['filtros'] ?? [];
$ruta = $_POST['ruta'] ?? $datos['ruta'] ?? '';
$accion = $_POST['accion'] ?? '';

// Búsqueda por título
if ($ruta === '/HabitaRoom/index' && $accion === 'buscar') {
    $q = trim(strtolower($_POST['q'] ?? ''));
    $ctl = new IndexController();
    ob_start();
    $ctl->buscarAnuncios($q);
    echo ob_get_clean();
    exit;
}

// Filtro por tipo de publicitante
if ((strpos($ruta, '/HabitaRoom/index') === 0) && $accion === 'filtrarTipoPublicitante') {
    $tipo = trim(strtolower($_POST['tipo_publicitante'] ?? ''));
    $ctl = new IndexController();
    ob_start();
    $ctl->cargarPublicacionesFiltro(['tipo_publicitante' => $tipo]);
    echo ob_get_clean();
    exit;
}

// Cargar más publicaciones (scroll infinito)
if ($ruta === '/HabitaRoom/index' && $accion === 'cargarMasPublicaciones') {
    $id_publis_cargadas = $_POST['id_publis_cargadas'] ?? [];
    $ctl = new IndexController();
    $ctl->cargarMasPublicaciones($id_publis_cargadas);
    exit;
}

// Lógica genérica de índice: carga inicial o con filtros
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