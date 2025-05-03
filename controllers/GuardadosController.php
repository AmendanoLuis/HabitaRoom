<?php
require_once '../models/ModelObtenerPublicaciones.php';
require_once '../models/ModelGuardados.php';

session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

class GuardadosController
{

    // Método para cargar las publicaciones guardadas
    public function cargarGuardados()
    {
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
$id_usuario    = $_SESSION['id'];
$id_publicacion = $_POST['id_publicacion'] ?? null;
$guardar = $_POST['guardar'] ?? null;
$quitar  = $_POST['quitarGuardado'] ?? null;
$path = $_POST['rutaGuardar'] ?? null;


if ($path === '/HabitaRoom/index') {
    if (!$id_publicacion ) {
        echo json_encode(['status' => 'error', 'message' => 'Falta el ID de la publicación']);
        exit;
    }
    
    $model = new ModelGuardados();
    
    if (!$guardar ) {
    
        // Inserta solo si no existía ya
        if ($model->insertarGuardados($id_usuario, $id_publicacion)) {
            echo json_encode(['status' => 'success', 'message' => 'Publicación guardada']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo guardar']);
        }
    } else if ($quitar) {
        if ($model->quitarGuardado($id_usuario, $id_publicacion)) {
            echo json_encode(['status' => 'success', 'message' => 'Guardado eliminado']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar']);
        }
    } else {
        // Ni guardar ni quitar → petición inválida
        echo json_encode(['status' => 'error', 'message' => 'Acción no reconocida']);
    }
    
}