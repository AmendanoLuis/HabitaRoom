<?php
/**
 * Vista: Login View
 *
 * Esta vista muestra el formulario de inicio de sesión para los usuarios.
 * Está dividida en dos columnas:
 * - Izquierda: video de fondo con información general y enlaces a redes sociales.
 * - Derecha: formulario de inicio de sesión con email y contraseña.
 *
 * Características:
 * - Compatible con Bootstrap 5 y responsive.
 * - Estilizada con clases personalizadas y componentes de Bootstrap.
 * - El formulario es procesado vía POST por LoginController@login.
 *
 * JS asociado:
 * - login.js (validaciones y envío AJAX si se desea).
 *
 * @package HabitaRoom\Views
 */
?>
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Columna con video como fondo -->
        <div class="col-6 bg-dark d-none d-md-flex text-light d-flex flex-column justify-content-center position-relative overflow-hidden">
            <!-- Video de fondo -->
            <video autoplay loop muted class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" src="public/img/videoLogin.mp4"></video>

            <!-- Contenido encima del video -->
            <div class="position-relative z-index-2 bg-dark bg-opacity-75 rounded p-4 mx-2 " style="height: 420px;">

                <!-- Logo -->
                <div>
                    <div id="cont_logo">
                        <a class="link-light link-underline-opacity-0 mh-100" href="/HabitaRoom/index">
                            <h1 class="text-light rounded text-uppercase fw-bold" style="font-size: 4.8em;" id="logo_login">Habita Room</h1>
                        </a>
                    </div>

                    <hr class="me-3 bg-light" style="height: 2px;">
                    <p class="mt-3 fs-5 pe-1">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo iusto corporis in voluptas maxime
                        velit rem eligendi repudiandae qui soluta, ipsum, odio quas. Porro modi non eos quia veniam
                        laborum?
                    </p>
                </div>

                <!-- Redes sociales -->
                <div class="mt-5 position-relative z-index-2">
                    <p class="fs-5">Nos puedes encontrar en:</p>
                    <div class="row w-25 ps-1">
                        <div class="col fs-5">
                            <a class="link-light" href="https://www.instagram.com/">
                                <i class="bi bi-instagram"></i>
                            </a>
                        </div>
                        <div class="col fs-5">
                            <a class="link-light" href="https://x.com/">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                        </div>
                        <div class="col fs-5">
                            <a class="link-light" href="https://www.facebook.com">
                                <i class="bi bi-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Columna de inicio de sesión -->
        <div class="col-6 bg-light">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <h2 class="mb-4">Iniciar Sesión</h2>

                <!-- Formulario de inicio de sesión -->
                <form method="POST" class="w-75 mx-5" id="form_login">

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fs-6">Correo electrónico: </label>
                        <input type="email" class="form-control border border-success" id="email" name="email" required>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="passwd" class="form-label fs-6">Contraseña:</label>
                        <input type="password" class="form-control border border-success" id="passwd" name="password" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100 ">Ingresar</button>
                    </div>
                </form>

                <div class="mt-4 d-flex justify-content-between w-75">
                    <a href="/HabitaRoom/login" class="link-dark ">¿Has olvidado la contraseña?</a>

                    <a href="/HabitaRoom/registro" class="link-dark">¿No estás registrado?</a>

                </div>
            </div>
        </div>
    </div>
</div>