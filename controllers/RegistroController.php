<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/ModelUsuario.php';

class RegistroController
{
    public function cargarRegistro()
    {
        require_once '../views/RegistroView.php';
    }

    private function validarFotoPerfil()
    {
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
            $foto_tmp = $_FILES['foto_perfil']['tmp_name'];
            $foto_nombre = basename($_FILES['foto_perfil']['name']);
            $foto_extension = pathinfo($foto_nombre, PATHINFO_EXTENSION);

            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($foto_extension), $extensiones_permitidas)) {
                return ['error' => 'Solo se permiten archivos JPG, JPEG, PNG o GIF.'];
            }

            $directorio_destino = $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/assets/uploads/img_perfil/';
            if (!is_dir($directorio_destino)) {
                if (!mkdir($directorio_destino, 0777, true)) {
                    return ['error' => 'No se pudo crear el directorio de destino.'];
                }
            }

            $ruta_final = $directorio_destino . $foto_nombre;

            if (move_uploaded_file($foto_tmp, $ruta_final)) {
                return ['filename' => $foto_nombre];
            } else {
                return ['error' => 'Error al mover el archivo subido.'];
            }
        }

        return ['filename' => null]; // Foto opcional
    }

    public function validarRegistro()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido.'
            ]);
            exit;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
        $correo_electronico = trim($_POST['correo_electronico'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $contrasena = trim($_POST['contrasena'] ?? '');
        $tipo_usuario = trim($_POST['tipo_usuario'] ?? '');
        $ubicacion = trim($_POST['ubicacion'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $preferencia_contacto = trim($_POST['preferencia_contacto'] ?? '');
        $terminos_aceptados = isset($_POST['terminos_aceptados']) ? 1 : 0;

        $errores = [];

        if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
        if (empty($apellidos)) $errores[] = "Los apellidos son obligatorios.";
        if (!filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) $errores[] = "El correo electrónico no es válido.";
        if (empty($contrasena)) $errores[] = "La contraseña es obligatoria.";
        if (strlen($contrasena) < 8) $errores[] = "La contraseña debe tener al menos 8 caracteres.";
        if (empty($tipo_usuario)) $errores[] = "El tipo de usuario es obligatorio.";
        if (strlen($descripcion) < 10 || strlen($descripcion) > 500) $errores[] = "La descripción debe tener entre 10 y 500 caracteres.";
        if ($terminos_aceptados !== 1) $errores[] = "Debes aceptar los términos y condiciones.";

        // Validar imagen
        $foto_perfil = $this->validarFotoPerfil();
        if (isset($foto_perfil['error'])) {
            $errores[] = $foto_perfil['error'];
        } else {
            $foto_perfil = $foto_perfil['filename'];
        }

        // Comprobar si ya existe el correo
        $usuario = new ModelUsuario();
        if ($usuario->obtenerUsuarioEmail($correo_electronico)) {
            $errores[] = "El correo electrónico ya está registrado.";
        }

        if (!empty($errores)) {
            echo json_encode([
                'success' => false,
                'message' => implode(" ", $errores)
            ]);
            exit;
        }

        $registrado = $usuario->registrarUsuario(
            $nombre,
            $apellidos,
            $nombre_usuario,
            $correo_electronico,
            $telefono,
            $contrasena,
            $tipo_usuario,
            $ubicacion,
            $foto_perfil,
            $descripcion,
            $preferencia_contacto,
            $terminos_aceptados
        );

        if ($registrado) {
            echo json_encode([
                'success' => true,
                'message' => 'Registro completado con éxito.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Hubo un error al registrar el usuario.'
            ]);
        }

        exit;
    }
}

if (isset($_POST['btn_registro'])) {
    $registroController = new RegistroController();
    $registroController->validarRegistro();
}
