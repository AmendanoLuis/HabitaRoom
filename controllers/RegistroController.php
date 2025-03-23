<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/models/User.php';

class RegistroController
{
    // Mostrar el formulario de registro
    public function cargarRegistro()
    {
        require_once '../views/RegistroView.php';
    }

    // Validar Foto de perfil
    private function validarFotoPerfil()
    {
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
            var_dump($_FILES['foto_perfil']);

            $foto_tmp = $_FILES['foto_perfil']['tmp_name'];
            $foto_nombre = $_FILES['foto_perfil']['name'];
            $foto_extension = pathinfo($foto_nombre, PATHINFO_EXTENSION);

            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($foto_extension), $extensiones_permitidas)) {
                echo "Solo se permiten archivos de imagen (JPG, JPEG, PNG, GIF).";
                exit;
            }

            //$foto_nombre_final = $foto_nombre. uniqid() . '.' . $foto_extension;

            $directorio_destino = $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/assets/uploads/img_perfil/';

            if (!is_dir($directorio_destino)) {
                mkdir($directorio_destino, 0777, true);
                echo "Error: No se pudo crear el directorio de destino.";
                exit;
            }
            $ruta_final = $directorio_destino . $foto_nombre;

            // Mover la foto al directorio de destino
            if (move_uploaded_file($foto_tmp, $ruta_final)) {
                // Verificar si el archivo realmente se movió
                if (file_exists($ruta_final)) {
                    echo "La foto de perfil se ha subido correctamente: ";
                } else {
                    echo "Error: El archivo no se encuentra en la carpeta de destino.";
                }
                return $foto_nombre;
            } else {
                return null;
            }
        }
    }

    // Validar los datos del formulario
    public function validarRegistro()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger los datos del formulario
            $nombre = trim($_POST['nombre']);
            $apellidos = trim($_POST['apellidos']);
            $nombre_usuario = trim($_POST['nombre_usuario']);
            $correo_electronico = trim($_POST['correo_electronico']);
            $telefono = trim($_POST['telefono']);
            $contrasena = trim($_POST['contrasena']);
            $tipo_usuario = trim($_POST['tipo_usuario']);
            $ubicacion = trim($_POST['ubicacion']);
            $descripcion = trim($_POST['descripcion']);
            $preferencia_contacto = trim($_POST['preferencia_contacto']);
            $terminos_aceptados = isset($_POST['terminos_aceptados']) ? 1 : 0;

            // Validación de los datos
            $errores = [];

            if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
            if (empty($apellidos)) $errores[] = "Los apellidos son obligatorios.";
            if (empty($correo_electronico) || !filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) $errores[] = "El correo electrónico no es válido.";
            if (empty($contrasena)) $errores[] = "La contraseña es obligatoria.";
            if (strlen($contrasena) < 6) $errores[] = "La contraseña debe tener al menos 6 caracteres.";
            if (empty($tipo_usuario)) $errores[] = "El tipo de usuario es obligatorio.";
            if ($terminos_aceptados != 1) $errores[] = "Debes aceptar los términos y condiciones.";



            // Procesar la foto de perfil
            $foto_perfil = $this->validarFotoPerfil();
            if (empty($foto_perfil)) $errores[] = "Hubo un problema al subir la foto de perfil.";

            // Crear una instancia del modelo Usuario
            $usuario = new Usuario();

            // Verificar si el correo electrónico ya existe
            if ($usuario->obtenerUsuarioEmail($correo_electronico)) {
                $errores[] =  "El correo electrónico ya está registrado.";
                exit;
            }


            if (!empty($errores)) {
                foreach ($errores as $error) {
                    echo "<p>$error</p>";
                }
                exit;
            }
            // Llamar al método de registrarUsuario en el modelo, pasando los datos directamente
            if ($usuario->registrarUsuario(
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
            )) {

                // Si el registro es exitoso, redirigir a una página de éxito
                header('Location: /HabitaRoom/perfil.php');
                exit;
            } else {
                echo "Hubo un problema al registrar el usuario.";
                header('Location: /HabitaRoom/registro.php');
            }
        }
    }
}



if (isset($_POST['btn_registro'])) {
    $registroController = new RegistroController();
    $registroController->validarRegistro();
}
