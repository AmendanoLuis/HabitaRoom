<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/ModelInsertarPublicacion.php';

/**
 * Class CrearPublicacionController
 *
 * Controlador encargado de gestionar la lógica de creación de publicaciones en HabitaRoom.
 * Se encarga de cargar la vista del formulario, procesar y validar los datos recibidos,
 * así como manejar la subida de imágenes y videos.
 *
 * @package HabitaRoom\Controllers
 */
class CrearPublicacionController
{

    /**
     * @var ModelInsertarPublicacion Instancia del modelo para insertar publicaciones en la BD.
     */
    private $model;

    /**
     * Constructor del controlador.
     * Inicializa la instancia de ModelInsertarPublicacion.
     */
    public function __construct()
    {
        $this->model = new ModelInsertarPublicacion();
    }

    /**
     * Carga el formulario de creación de publicación.
     * Incluye la vista correspondiente para que el usuario ingrese los datos.
     *
     * @return void
     */
    public function cargarFormulario()
    {
        require_once '../views/crearPublicacionView.php';
    }

    /**
     * Procesa y valida las imágenes subidas en el formulario.
     * Guarda cada imagen en el directorio correspondiente y retorna un JSON con sus nombres.
     * Si no se sube ninguna imagen, devuelve null.
     *
     * @return string|null JSON con nombres de imágenes o null si no se subió ninguna.
     * @throws Exception Si no se puede crear el directorio o no hay imágenes válidas.
     */
    private function procesarImagen(): ?string
    {
        // Comprobar si se subieron imágenes
        if (empty($_FILES['imagenes'])) {
            return null;
        }

        $imagenesGuardadas = [];

        // Crear directorio de subida si no existe
        $uploadDir = '../assets/uploads/img_publicacion/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            throw new Exception('No se pudo crear directorio de imágenes.');
        }

        // Tipos de archivo permitidos
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        // Si se subió solo una imagen, normalizamos para manejarlo como array
        $files = $_FILES['imagenes'];
        $isMultiple = is_array($files['name']);

        // Si es un array, obtenemos la cantidad de archivos
        $n = $isMultiple ? count($files['name']) : 1;

        // Iteramos sobre cada archivo subido
        for ($i = 0; $i < $n; $i++) {
            $name = $isMultiple ? $files['name'][$i] : $files['name'];
            $tmp = $isMultiple ? $files['tmp_name'][$i] : $files['tmp_name'];
            $error = $isMultiple ? $files['error'][$i] : $files['error'];

            if ($error !== UPLOAD_ERR_OK)
                continue;

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed))
                continue;

            // Generar nombre único para evitar colisiones
            // Usamos uniqid para generar un ID único basado en el tiempo actual
            $filename = uniqid('pub_') . ".$ext";
            $dest = $uploadDir . $filename;

            // Mover el archivo subido al directorio de destino
            if (move_uploaded_file($tmp, $dest)) {
                $imagenesGuardadas[] = $filename;
            }
        }

        // Devuelve JSON para guardar en base de datos
        return !empty($imagenesGuardadas) ? json_encode($imagenesGuardadas) : null;
    }


    /**
     * Procesa y valida video subido, devuelve nombre o lanza excepción en error.
     * Si se subieron varios videos, los guarda todos y devuelve JSON con sus nombres.
     * Si no se subió ningún video, devuelve null.
     * @return string|null JSON con nombres de videos o null si no se subió ninguno.
     * @throws Exception Si no se pudo crear el directorio o si no se subieron videos válidos.
     */
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
            $tmp = $isMultiple ? $files['tmp_name'][$i] : $files['tmp_name'];
            $error = $isMultiple ? $files['error'][$i] : $files['error'];

            if ($error !== UPLOAD_ERR_OK)
                continue;

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed))
                continue;

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
     * Prepara los datos del formulario para insertar en la base de datos.
     * Recoge los datos del formulario, los valida y los formatea.
     * @return array Datos preparados para insertar.
     * @throws Exception Si falta algún dato obligatorio o si el usuario no está autenticado.
     */
    private function prepararDatos(): array
    {
        // Comprobar si el usuario está autenticado
        session_start();
        $usuarioId = $_SESSION['id'] ?? null;
        if (!$usuarioId) {
            throw new Exception('No estás Registrado.\nPor favor, inicia sesión para continuar.');
        }

        // Ubicacion geográfica
        $ubicacionGeografica = $_POST['ubicacion_geografica'] ?? null;
        if ($ubicacionGeografica) {
            if (is_string($ubicacionGeografica)) {
                $ubicacionGeografica = json_decode($ubicacionGeografica, true);
            }

            if (!is_array($ubicacionGeografica)) {
                throw new Exception('Ubicación geográfica inválida.');
            }

            // Validar y asignar con valores por defecto si falta alguno
            $campos = [
                'latitud' => null,
                'longitud' => null,
                'road' => '',
                'suburb' => '',
                'city' => '',
                'state' => '',
                'postcode' => '',
            ];

            foreach ($campos as $campo => $default) {
                $ubicacionGeografica[$campo] = $ubicacionGeografica[$campo] ?? $default;
            }
        } else {
            // Si no se envió nada, establecer todos los campos como nulos o vacíos
            $ubicacionGeografica = [
                'latitud' => null,
                'longitud' => null,
                'road' => '',
                'suburb' => '',
                'city' => '',
                'state' => '',
                'postcode' => '',
            ];
        }


        // Recoger y sanear campos
        $datos = [
            'usuario_id' => intval($usuarioId),
            'tipo_anuncio' => $_POST['tipo_anuncio'] ?? '',
            'tipo_inmueble' => $_POST['tipo_inmueble'] ?? '',
            'ubicacion' => trim($_POST['ubicacion'] ?? ''),
            'titulo' => trim($_POST['titulo'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => floatval($_POST['precio'] ?? 0),
            'habitaciones' => intval($_POST['habitaciones'] ?? 0),
            'banos' => intval($_POST['banos'] ?? 0),
            'estado' => $_POST['estado'] ?? '',
            'ascensor' => isset($_POST['ascensor']) ? 1 : 0,
            'piscina' => isset($_POST['piscina']) ? 1 : 0,
            'gimnasio' => isset($_POST['gimnasio']) ? 1 : 0,
            'garaje' => isset($_POST['garaje']) ? 1 : 0,
            'terraza' => isset($_POST['terraza']) ? 1 : 0,
            'jardin' => isset($_POST['jardin']) ? 1 : 0,
            'aire_acondicionado' => isset($_POST['aire_acondicionado']) ? 1 : 0,
            'calefaccion' => isset($_POST['calefaccion']) ? 1 : 0,
            'tipo_publicitante' => $_SESSION['tipo_usuario'] ?? '',
            'superficie' => floatval($_POST['superficie'] ?? 0),
            // Agregas los campos de ubicación
            'latitud' => floatval($ubicacionGeografica['latitud']),
            'longitud' => floatval($ubicacionGeografica['longitud']),
            'calle' => trim($ubicacionGeografica['road']),
            'barrio' => trim($ubicacionGeografica['suburb']),
            'ciudad' => trim($ubicacionGeografica['city']),
            'provincia' => trim($ubicacionGeografica['state']),
            'codigo_postal' => trim($ubicacionGeografica['postcode']),
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


    /**
     * Valida el formulario y guarda la publicación en la base de datos.
     * @return array Resultado de la operación, incluyendo estado y mensaje.
     * @throws Exception Si ocurre un error al procesar los datos o al insertar en la base de datos.
     */
    public function validarFormulario(): array
    {
        try {
            $datos = $this->prepararDatos();
            list($id_publicacion, $exito) = $this->model->insertarPublicacion($datos);

            return [
                'estado' => $exito ? 'ok' : 'error',
                'mensaje' => $exito ? 'Publicación creada con éxito.' : 'Error al crear la publicación.',
                'id_publicacion' => $id_publicacion,
                'success' => true,
            ];
        } catch (\Exception $e) {

            return [
                'estado' => 'error',
                'success' => false,
                'mensaje' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'linea' => $e->getLine(),
                'codigo' => $e->getCode()
            ];
        }
    }
}


// Instanciar el controlador y procesar el formulario

$controller = new CrearPublicacionController();

if (isset($_POST['btn_crear_publi'])) {
    // Cabecera JSON
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($controller->validarFormulario());
    exit;
} else {
    $controller->cargarFormulario();
}
