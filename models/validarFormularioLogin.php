<?php

require_once '../config/db/db.php';
require_once '../controllers/LoginController.php';
require_once '../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
    } else {
        $loginController = new LoginController();
        $loginController->login($email, $password);
    }
}

?>