<?php
session_start();

require_once '../models/User.php';

class LoginController
{

    // Función para cargar el formulario de inicio de sesión
    public function cargarLogin()
    {
        require_once '../views/LoginView.php';
    }

    // Función para iniciar sesión
    public function login($email, $password)
    {
        $userModel = new Usuario();
        $user = $userModel->obtenerUsuarioEmail($email);

        $respuesta = ['status' => false];

        // Verificar si el usuario existe y si la contraseña es correcta (compara contraseña ingresada texto plano con la contraseña encriptada en la base de datos)
        if ($user && password_verify($password, trim($user->contrasena))) {

            $_SESSION['id'] = $user->id;


            $respuesta['status'] = true;
        } else {
            $respuesta['status'] = false;
        }
        return $respuesta;
    }

    // Función para cerrar sesión
    public function logout()
    {
        session_destroy();

        header("Location: /HabitaRoom/login"); 

        exit();
    }
}

// Cerrar sesión
if (isset($_POST['logout'])) {
    $loginController = new LoginController();
    $loginController->logout();
}
