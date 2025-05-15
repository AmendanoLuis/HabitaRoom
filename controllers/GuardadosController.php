<?php
require_once '../models/ModelObtenerPublicaciones.php';
require_once '../models/ModelGuardados.php';

class GuardadosController
{

    // Método para cargar las publicaciones guardadas
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
// Controlador para manejar la acción de guardar o quitar guardado
// -----------------------------------------------------------
session_start();
$path = $_POST['rutaGuardar'] ?? null;
if ($path === '/HabitaRoom/index' && !isset($_SESSION['id'])) {
    echo json_encode([
        'status' => 'error',
        'auth' => false,
        'message' => 'No estás autenticado. Inicia sesión para continuar.'
    ]);
    exit;
}else{
    $id_usuario = $_SESSION['id'] ?? null;
}

$id_publicacion = $_POST['id_publicacion'] ?? null;

$guardar = isset($_POST['guardar']) ? filter_var($_POST['guardar'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : false;
$path = $_POST['rutaGuardar'] ?? null;

if ($path === '/HabitaRoom/index') {
    if (!$id_publicacion) {
        echo json_encode(['status' => 'error', 'message' => 'Falta el ID de la publicación']);
        exit;
    }

    $model = new ModelGuardados();

    if (!$guardar) {

        $resultado = $model->insertarGuardados($id_usuario, $id_publicacion);

        if ($resultado === true) {

            echo json_encode(['status' => 'success', 'message' => 'Publicación guardada']);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo guardar',
                'error' => $resultado // Imprimir el error devuelto por la función
            ]);
        }
    } else {

        $resultado = $model->quitarGuardado($id_usuario, $id_publicacion);
        
        if ($resultado === true) {
           
            echo json_encode(['status' => 'success', 'message' => 'Guardado eliminado']);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo eliminar',
                'error' => $resultado // Imprimir el error devuelto por la función
            ]);
        }

    }
}
