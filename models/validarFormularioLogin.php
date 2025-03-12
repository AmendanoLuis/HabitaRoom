<?php


require_once '../controllers/LoginController.php';

header('Content-Type: application/json'); 

$respuesta = ['status' => false, 'mensaje' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $respuesta['error_campos_vacios'] = "Correo y contrasena necesarios";

    } else {
        $loginController = new LoginController();
        $loginExitoso  = $loginController->login($email, $password);
    
        if ($loginExitoso['status']) {
            $respuesta['status'] = true;
            $respuesta['mensaje'] = 'Sesión iniciada correctamente';
            $respuesta['redirect'] = '/HabitaRoom/index';
        } else {
            $respuesta['status'] = false;
            $respuesta['mensaje'] = 'Error al iniciar sesión';
        }
    }
}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

exit();
?>