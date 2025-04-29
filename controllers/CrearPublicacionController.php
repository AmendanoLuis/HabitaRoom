<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/PublicacionModel.php';

class CrearPublicacionController
{

    private $model;

    public function __construct()
    {
        $this->model = new PublicacionModel();
    }
    public function cargarFormulario()
    {
        require_once '../views/crearPublicacionView.php';
    }

    /**
     * Procesa y valida imagen subida, devuelve nombre o lanza excepción en error.
     */
    private function procesarImagen(): ?string
    {
        if (empty($_FILES['imagenes'])) {
            return null;
        }

        $imagenesGuardadas = [];

        $uploadDir = '../assets/uploads/img_publicacion/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            throw new Exception('No se pudo crear directorio de imágenes.');
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        // Si se subió solo una imagen, normalizamos para manejarlo como array
        $files = $_FILES['imagenes'];
        $isMultiple = is_array($files['name']);

        $n = $isMultiple ? count($files['name']) : 1;

        for ($i = 0; $i < $n; $i++) {
            $name = $isMultiple ? $files['name'][$i] : $files['name'];
            $tmp  = $isMultiple ? $files['tmp_name'][$i] : $files['tmp_name'];
            $error = $isMultiple ? $files['error'][$i] : $files['error'];

            if ($error !== UPLOAD_ERR_OK) continue;

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) continue;

            $filename = uniqid('pub_') . ".$ext";
            $dest = $uploadDir . $filename;

            if (move_uploaded_file($tmp, $dest)) {
                $imagenesGuardadas[] = $filename;
            }
        }

        // Devuelve JSON para guardar en base de datos
        return !empty($imagenesGuardadas) ? json_encode($imagenesGuardadas) : null;
    }


    private function procesarVideo(): ?string
    {
        if (empty($_FILES['videos'])) {
            return null;
        }

        $videosGuardados = [];

        $uploadDir = '../assets/uploads/videos_publicacion/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            throw new Exception('No se pudo crear directorio de videos.');
        }

        $allowed = ['mp4', 'avi', 'mov', 'mkv'];

        // Si se subió solo un video, normalizamos para manejarlo como array
        $files = $_FILES['videos'];
        $isMultiple = is_array($files['name']);

        $n = $isMultiple ? count($files['name']) : 1;

        for ($i = 0; $i < $n; $i++) {
            $name = $isMultiple ? $files['name'][$i] : $files['name'];
            $tmp  = $isMultiple ? $files['tmp_name'][$i] : $files['tmp_name'];
            $error = $isMultiple ? $files['error'][$i] : $files['error'];

            if ($error !== UPLOAD_ERR_OK) continue;

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) continue;

            $filename = uniqid('vid_') . ".$ext";
            $dest = $uploadDir . $filename;

            if (move_uploaded_file($tmp, $dest)) {
                $videosGuardados[] = $filename;
            }
        }

        // Devuelve JSON para guardar en base de datos
        return !empty($videosGuardados) ? json_encode($videosGuardados) : null;
    }


    /**
     * Valida y prepara datos de publicación, lanza excepción si faltan obligatorios.
     */
    private function prepararDatos(): array
    {
        // Comprobar si el usuario está autenticado
        session_start();
        $usuarioId = $_SESSION['id'] ?? null;
        if (!$usuarioId) {
            throw new Exception('Usuario no autenticado.');
        }

        // Recoger y sanear campos
        $datos = [
            'usuario_id'         => intval($usuarioId),
            'tipo_anuncio'       => $_POST['tipo_anuncio']                ?? '',
            'tipo_inmueble'      => $_POST['tipo_inmueble']               ?? '',
            'ubicacion'          => trim($_POST['ubicacion']     ?? ''),
            'titulo'             => trim($_POST['titulo']        ?? ''),
            'descripcion'        => trim($_POST['descripcion']   ?? ''),
            'precio'             => floatval($_POST['precio']      ?? 0),
            'habitaciones'       => intval($_POST['habitaciones']  ?? 0),
            'banos'              => intval($_POST['banos']         ?? 0),
            'estado'             => $_POST['estado']                      ?? '',
            'ascensor'           => isset($_POST['ascensor'])           ? 1 : 0,
            'piscina'            => isset($_POST['piscina'])            ? 1 : 0,
            'gimnasio'           => isset($_POST['gimnasio'])           ? 1 : 0,
            'garaje'             => isset($_POST['garaje'])             ? 1 : 0,
            'terraza'            => isset($_POST['terraza'])            ? 1 : 0,
            'jardin'             => isset($_POST['jardin'])             ? 1 : 0,
            'aire_acondicionado' => isset($_POST['aire_acondicionado']) ? 1 : 0,
            'calefaccion'        => isset($_POST['calefaccion'])        ? 1 : 0,
            'tipo_publicitante'  => $_POST['tipo_publicitante'] ?? '',
            'superficie'         => floatval($_POST['superficie'] ?? 0),
        ];

        // Campos obligatorios
        if (
            empty($datos['tipo_inmueble'])
            || empty($datos['tipo_anuncio'])
            || empty($datos['titulo'])
            || $datos['precio'] <= 0
        ) {
            throw new Exception('Faltan datos obligatorios.');
        }

        // Procesar imagen y/o video (opcional)
        $datos['fotos'] = $this->procesarImagen();
        $datos['videos'] = $this->procesarVideo();

        return $datos;
    }



    public function validarFormulario(): array
    {
        try {
            $datos = $this->prepararDatos();
            $ok = $this->model->insertarPublicacion($datos);
            return [
                'estado'  => $ok ? 'ok' : 'error',
                'mensaje' => $ok ? 'Publicación creada con éxito.' : 'Error al crear la publicación.',
                'success' => true,
            ];
        } catch (\Exception $e) {

            return [
                'estado'  => 'error',
                'success' => false,
                'mensaje' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'linea'   => $e->getLine(),
                'codigo'  => $e->getCode()
            ];
        }
    }
}


// Instanciar el controlador y procesar el formulario
$controller = new CrearPublicacionController();

if (isset($_POST['btn_crear_publi'])) {
    // Cabecera JSON
    header('Content-Type: application/json; charset=utf-8');
    // Esto debe imprimir SOLO el JSON, nada más
    echo json_encode($controller->validarFormulario());
    exit;
} else {
    // Lod’e la vista solo si es GET
    $controller->cargarFormulario();
}
