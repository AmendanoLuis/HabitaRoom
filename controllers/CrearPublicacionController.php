<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';

class CrearPublicacionController
{
    public function cargarFormulario()
    {
        require_once '../views/crearPublicacionView.php';
    }

    // Validar Imagenes Publicacion
    private function validarImagenesPublicacion()
    {
        // Comprobar si hay una imagen
        if (isset($_FILES['imagen_publicacion']) && $_FILES['imagen_publicacion']['error'] == 0) {
            $imagen_tmp = $_FILES['imagen_publicacion']['tmp_name'];
            $imagen_nombre = $_FILES['imagen_publicacion']['name'];
            $imagen_extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);

            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($imagen_extension), $extensiones_permitidas)) {
                return "Solo se permiten archivos de imagen (JPG, JPEG, PNG, GIF).";
            }

            $directorio_destino = $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/assets/uploads/img_publicacion/';
            if (!is_dir($directorio_destino)) {
                mkdir($directorio_destino, 0777, true);
                return "Error: No se pudo crear el directorio de destino.";
            }

            $ruta_final = $directorio_destino . $imagen_nombre;

            if (move_uploaded_file($imagen_tmp, $ruta_final)) {
                return $imagen_nombre;  // Imagen subida correctamente
            } else {
                return "Error: No se pudo mover la imagen al directorio de destino.";
            }
        }
        return null;  // No se subió ninguna imagen
    }

    // Validar Formulario
    public function validarFormulario()
    {
        $mensaje = ''; 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger datos
            $tipo_inmueble = $_POST["tipo_inmueble"] ?? "";
            $tipo_anuncio = $_POST["tipo_anuncio"] ?? "";
            $titulo = $_POST["titulo"] ?? "";
            $precio = $_POST["precio"] ?? "";
            $num_habitaciones = $_POST["num_habitaciones"] ?? "";
            $num_banos = $_POST["num_banos"] ?? "";
            $estado = $_POST["estado"] ?? "";
            $superficie = $_POST["superficie"] ?? "";
            $descripcion = $_POST["descripcion"] ?? "";
            $ubicacion = $_POST["ubicacion"] ?? "";

            // Validar que no falten campos obligatorios
            if (empty($tipo_inmueble) || empty($tipo_anuncio) || empty($titulo) || empty($precio)) {
                $mensaje = "Faltan datos obligatorios.";
            }

            // Validar imagen
            $imagen_publicacion = $this->validarImagenesPublicacion();
            if ($imagen_publicacion === null) {
                $mensaje = "No se ha subido ninguna imagen de publicación.";
            } elseif (is_string($imagen_publicacion)) {
                // Si es un mensaje de error de la imagen
                $mensaje = $imagen_publicacion;
            }

            // Si todo está bien, insertamos la publicación
            if (empty($mensaje)) {
                $conn = Database::connect();
                $sql = "INSERT INTO publicaciones (tipo_inmueble, tipo_anuncio, titulo, precio, num_habitaciones, num_banos, estado, superficie, descripcion, ubicacion, imagen_publicacion) 
                    VALUES (:tipo_inmueble, :tipo_anuncio, :titulo, :precio, :num_habitaciones, :num_banos, :estado, :superficie, :descripcion, :ubicacion, :imagen_publicacion)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':tipo_inmueble', $tipo_inmueble);
                $stmt->bindParam(':tipo_anuncio', $tipo_anuncio);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':num_habitaciones', $num_habitaciones, PDO::PARAM_INT);
                $stmt->bindParam(':num_banos', $num_banos, PDO::PARAM_INT);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':superficie', $superficie);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':ubicacion', $ubicacion);
                $stmt->bindParam(':imagen_publicacion', $imagen_publicacion);

                if ($stmt->execute()) {
                    $mensaje = "Publicación creada con éxito.";
                } else {
                    $mensaje = "Error al crear la publicación.";
                }
            }
        }

        // Devolver solo el mensaje
        return $mensaje;
    }
}

// Instanciar el controlador y procesar el formulario
$controller = new CrearPublicacionController();
if (isset($_POST['btn_crear_publi'])) {
    echo $controller->validarFormulario();
}
