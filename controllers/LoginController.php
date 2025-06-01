<?php
/**
 * Class LoginController
 *
 * Controlador encargado de gestionar la autenticación de usuarios en HabitaRoom.
 * Proporciona métodos para cargar el formulario de login, iniciar y cerrar sesión.
 *
 * @package HabitaRoom\Controllers
 */
session_start();

require_once '../models/ModelUsuario.php';

class LoginController
{
    /**
     * Carga la vista del formulario de inicio de sesión.
     *
     * @return void
     */
    public function cargarLogin()
    {
        require_once '../views/LoginView.php';
    }

    /**
     * Intenta iniciar sesión con las credenciales proporcionadas.
     * Verifica que el usuario exista y que la contraseña coincida usando password_verify.
     *
     * @param string $email    Email ingresado por el usuario.
     * @param string $password Contraseña ingresada por el usuario (texto plano).
     * @return array Array asociativo con clave 'status' (true si el login fue exitoso).
     */
    public function login($email, $password)
    {
        $userModel = new ModelUsuario();
        $user = $userModel->obtenerUsuarioEmail($email);

        $respuesta = ['status' => false];

        // Verificar si el usuario existe y la contraseña coincide
        if ($user && password_verify($password, trim($user->contrasena))) {
            $_SESSION['id'] = $user->id;
            $respuesta['status'] = true;
        } else {
            $respuesta['status'] = false;
        }
        return $respuesta;
    }

    /**
     * Cierra la sesión actual y redirige al formulario de login.
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();

        header("Location: /HabitaRoom/login");
        exit();
    }
}

// Procesamiento de form de logout
if (isset($_POST['logout'])) {
    $loginController = new LoginController();
    $loginController->logout();
}
