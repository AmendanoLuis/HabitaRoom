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
        echo "<script>console.log(" . json_encode($publicaciones) . ");</script>";
        if ($publicaciones !== "") {
            require_once '../views/PublicacionesView.php';
        } else {
            echo `No hay publicaciones disponibles con los filtros`;
        }
    }

    public function cargarPublicacionesPorUbicacion()
    {
        // 1) Recoger y sanear parámetros
        $latitud = isset($_POST['latitud']) ? floatval($_POST['latitud']) : null;
        $longitud = isset($_POST['longitud']) ? floatval($_POST['longitud']) : null;
        $calle = trim($_POST['calle'] ?? '');
        $barrio = trim($_POST['barrio'] ?? '');
        $ciudad = trim($_POST['ciudad'] ?? '');
        $provincia = trim($_POST['provincia'] ?? '');
        $cp = trim($_POST['cp'] ?? '');

        // 2) Validaciones mínimas: ciudad y provincia son obligatorios
        if (empty($ciudad) || empty($provincia)) {
            echo '<div class="alert alert-warning">';
            echo 'Debes indicar al menos ciudad y provincia para filtrar.';
            echo '</div>';
            return;
        }

        $publicaciones = [];
        if (!empty($barrio) && !empty($ciudad) && !empty($provincia)) {
            $publicaciones = $this->model->buscarPorBarrioCiudadProvincia($barrio, $ciudad, $provincia);
        }

        // 4) Intento 2: si no hay resultados (o no había barrio), buscamos sólo por ciudad
        if (empty($publicaciones) && !empty($ciudad)) {
            $publicaciones = $this->model->buscarPorCiudad($ciudad);
        }

        // 5) Intento 3: si sigue vacío, buscamos sólo por provincia
        if (empty($publicaciones) && !empty($provincia)) {
            $publicaciones = $this->model->buscarPorProvincia($provincia);
        }
        // 4) Si hay resultados, incluimos la vista parcial
        if (!empty($publicaciones)) {
            // La vista "PublicacionesView.php" debe usar la variable $publicaciones
            require_once '../views/PublicacionesView.php';
        } else {
            // 5) Si no hay publicaciones, mostramos un mensaje en HTML
            echo '<div class="alert alert-info">';
            echo 'No hay publicaciones disponibles con los filtros.';
            echo '</div>';
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
// Leer body JSON si existe (lo usas para otros filtros, no para ubicación)
$raw = file_get_contents('php://input');
$datos = json_decode($raw, true);

// Estas variables vendrán bien en POST o en body JSON
$esFiltros = $datos['esFiltros'] ?? false;
$filtros = $datos['filtros'] ?? [];
$ruta = $_POST['ruta'] ?? $datos['ruta'] ?? '';
$accion = $_POST['accion'] ?? '';

// —————————————————————————————————————————————————————————————————————————
// 1) Búsqueda por título
// —————————————————————————————————————————————————————————————————————————
if ($ruta === '/HabitaRoom/index' && $accion === 'buscar') {
    $q = trim(strtolower($_POST['q'] ?? ''));
    $ctl = new IndexController();
    ob_start();
    $ctl->buscarAnuncios($q);
    echo ob_get_clean();
    exit;
}

// —————————————————————————————————————————————————————————————————————————
// 2) Filtro por tipo de publicitante
// —————————————————————————————————————————————————————————————————————————
if (strpos($ruta, '/HabitaRoom/index') === 0 && $accion === 'filtrarTipoPublicitante') {
    $tipo = trim(strtolower($_POST['tipo_publicitante'] ?? ''));
    $ctl = new IndexController();
    ob_start();
    $ctl->cargarPublicacionesFiltro(['tipo_publicitante' => $tipo]);
    echo ob_get_clean();
    exit;
}

// —————————————————————————————————————————————————————————————————————————
// 3) Búsqueda POR UBICACIÓN GEOGRÁFICA
//    Aquí es donde debemos llamar a cargarPublicacionesPorUbicacion()
// —————————————————————————————————————————————————————————————————————————
if (strpos($ruta, '/HabitaRoom/index') === 0 && $accion === 'buscarPorUbicacion') {
    $ctl = new IndexController();
    ob_start();
    $ctl->cargarPublicacionesPorUbicacion();
    echo ob_get_clean();
    exit;
}

// —————————————————————————————————————————————————————————————————————————
// 4) Scroll infinito: cargar más publicaciones
// —————————————————————————————————————————————————————————————————————————
if ($ruta === '/HabitaRoom/index' && $accion === 'cargarMasPublicaciones') {
    $id_publis_cargadas = $_POST['id_publis_cargadas'] ?? [];
    $ctl = new IndexController();
    $ctl->cargarMasPublicaciones($id_publis_cargadas);
    exit;
}

// —————————————————————————————————————————————————————————————————————————
// 5) Carga inicial o con filtros genéricos
// —————————————————————————————————————————————————————————————————————————
if (($ruta === '/HabitaRoom/index' || $ruta === '/HabitaRoom/index.php')) {
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