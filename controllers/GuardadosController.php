<?php
require_once '../models/ModelObtenerPublicaciones.php';
require_once '../models/ModelGuardados.php';

/**
 * Class GuardadosController
 *
 * Controlador encargado de gestionar las publicaciones guardadas de los usuarios en HabitaRoom.
 * Incluye lógica para mostrar las publicaciones guardadas y procesar acciones de guardar/quitar.
 *
 * @package HabitaRoom\Controllers
 */
class GuardadosController
{

    /**
     * Carga las publicaciones marcadas como guardadas por el usuario autenticado.
     * Si no hay un usuario autenticado, muestra una vista de error.
     *
     * @return void
     */
    public function cargarGuardados()
    {
        if (!isset($_SESSION['id'])) {
            require_once '../views/ViewErrorGuardados.php';
        }

        // Cargar el modelo de ofertas
        $publicacionesModel = new ModelObtenerPublicaciones();

        // Obtener las ofertas
        $guardados = $publicacionesModel->obtenerPublicacionesGuardadas();
        // Cargar la vista y pasarle las ofertas
        require_once '../views/ViewGuardados.php';
    }
}


// -----------------------------------------------------------
// Bloque de procesamiento para guardar o quitar una publicación como guardado
// -----------------------------------------------------------
session_start();
/**
 * Procesa la acción de guardar o quitar una publicación en la lista de guardados.
 * Responde con JSON indicando éxito o error.
 */
$path = $_POST['rutaGuardar'] ?? null;

// Verificar autenticación si la ruta es la principal
if ($path === '/HabitaRoom/index' && !isset($_SESSION['id'])) {
    echo json_encode([
        'status' => 'error',
        'auth' => false,
        'message' => 'No estás autenticado. Inicia sesión para continuar.'
    ]);
    exit;
} else {
    $id_usuario = $_SESSION['id'] ?? null;
}

$id_publicacion = $_POST['id_publicacion'] ?? null;

/**
 * Indica si se está guardando (false) o quitando (true) el guardado.
 * Recibe valor booleano desde el frontend.
 */
$guardar = isset($_POST['guardar']) ? filter_var($_POST['guardar'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : false;
$path = $_POST['rutaGuardar'] ?? null;

if ($path === '/HabitaRoom/index') {

    // Validar que se proporcionó ID de publicación
    if (!$id_publicacion) {
        echo json_encode(['status' => 'error', 'message' => 'Falta el ID de la publicación']);
        exit;
    }

    $model = new ModelGuardados();

    if (!$guardar) {
        // Acción: insertar guardado
        $resultado = $model->insertarGuardados($id_usuario, $id_publicacion);

        if ($resultado === true) {

            echo json_encode(['status' => 'success', 'message' => 'Publicación guardada']);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo guardar',
                'error' => $resultado
            ]);
        }
    } else {
        // Acción: quitar guardado
        $resultado = $model->quitarGuardado($id_usuario, $id_publicacion);

        if ($resultado === true) {

            echo json_encode(['status' => 'success', 'message' => 'Guardado eliminado']);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo eliminar',
                'error' => $resultado
            ]);
        }
    }
}
