<?php

require_once '../config/db/db.php';
require_once '../models/User.php';

class LoginController
{

    // Función para cargar el formulario de inicio de sesión
    public function cargarFormulario()
    {
        require_once '../views/LoginView.php';
    }

    // Función para iniciar sesión
    public function login($email, $password)
    {
        $userModel = new Usuario();
        $user = $userModel->obtenerUsuarioEmail($email);

        if ($user && password_verify($password, $user->contrasena)) {

            $_SESSION['user'] = $user;
            $_SESSION['nombre'] = $user->nombre;
            $_SESSION['apellidos'] = $user->apellidos;
            $_SESSION['nombre_usuario'] = $user->nombre_usuario;
            $_SESSION['correo_electronico'] = $user->correo_electronico;
            $_SESSION['telefono'] = $user->telefono;
            $_SESSION['tipo_usuario'] = $user->tipo_usuario;
            $_SESSION['ubicacion'] = $user->ubicacion;
            $_SESSION['foto_perfil'] = $user->foto_perfil;
            $_SESSION['descripcion'] = $user->descripcion;
            $_SESSION['preferencia_contacto'] = $user->preferencia_contacto;
            $_SESSION['terminos_aceptados'] = $user->terminos_aceptados;
            
            // Añadir loading spinner
            


            // Redirigir a la página principal
            header('Location: /HabitaRoom/index');
        } else {
            echo 'Usuario o contraseña incorrectos';
        }
    }

    // Función para cerrar sesión
    public function logout()
    {
        session_destroy();

        header("Location: /HabitaRoom/index");
        exit();
    }
}
