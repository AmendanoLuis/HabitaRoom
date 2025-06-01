<?php
/**
 * Archivo: validarFormularioLogin.php
 *
 * Script encargado de procesar la solicitud de inicio de sesión.
 * Recibe las credenciales por POST, valida campos, invoca al controlador de login
 * y retorna una respuesta JSON indicando éxito o error.
 *
 * @package HabitaRoom\Controllers
 */

require_once '../controllers/LoginController.php';
header('Content-Type: application/json');

// Estructura de la respuesta por defecto
$respuesta = [
    'status' => false,
    'mensaje' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        $respuesta['error_campos_vacios'] = "Correo y contraseña necesarios";
    } else {
        // Instanciar el controlador de login y verificar credenciales
        $loginController = new LoginController();
        $loginExitoso  = $loginController->login($email, $password);

        if ($loginExitoso['status']) {
            $respuesta['status'] = true;
            $respuesta['mensaje'] = 'Sesión iniciada correctamente';
            // URL de redirección tras login exitoso
            $respuesta['redirect'] = '/HabitaRoom/index';
        } else {
            $respuesta['status'] = false;
            $respuesta['mensaje'] = 'Error al iniciar sesión';
        }
    }
}

// Enviar respuesta en JSON al cliente
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
