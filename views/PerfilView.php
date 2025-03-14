<?php

if (isset($_SESSION['id'])) {
    $userModel = new Usuario();
    $usuario = $userModel->obtenerUsuarioId($_SESSION['id']);
}

?>

<div class="container w-75 text-dark mt-5 d-flex flex-column justify-content-center z-0">

    <!-- Encabezado del perfil -->
    <div class="profile-header bg-light rounded text-center shadow-lg mt-5 m-3 p-3 d-flex">

        <!-- La imagen de perfil se mostrará aquí -->
        <div class="row w-100">

            <!-- Imagen de perfil -->
            <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                <img class="d-block border border-2 border-success" src="<?php echo 'assets/uploads/img_perfil/' . $usuario->foto_perfil; ?>" alt="Foto de Perfil">
                <p class="fs-4 text-success-emphasis"><?php echo  $usuario->nombre_usuario; ?></p>
            </div>

            <!-- Información del usuario -->
            <div class="col-8 d-flex flex-column position-relative">
                <div class="w-100 text-start ms-2 mt-4">
                    <div>
                        <h2><?php echo  $usuario->nombre . ' ' .  $usuario->apellidos; ?></h2>
                        <p class=""><?php echo  $usuario->correo_electronico; ?></p>
                    </div>

                </div>

                <div class="w-100 text-start ms-2 mt-2">
                    <div class="descripcion-perfil">
                        <h4>Descripción</h4>
                        <p><?php echo  $usuario->descripcion; ?></p>
                    </div>
                </div>

                <div class="position-absolute end-0 top-0 text-center">
                    <button type="button" class="btn btn-outline-success py-1 px-3 mt-4 fw-semibold" disabled>
                        <?php echo "Propietario"; ?>
                    </button>
                </div>

            </div>
        </div>

    </div>

    <!-- Información del perfil -->
    <div class="profile-info bg-light rounded text-center shadow-lg mt-2 m-3 pt-4 p-3">

        <div class="row">
            <div class="col">
                <h3>Información del Perfil</h3>
                <dl>
                    <dt>Ubicacion: </dt>
                    <dd id="ubicacion">Ciudad, País</dd>
                    <dt>Telefono</dt>
                    <dt>Preferencia contacto</dt>

                </dl>
            </div>
            <div class="col">
                <button class="btn btn-success">Editar Perfil</button>
                <form class="mt-3" action="controllers/LoginController.php" method="POST">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col">

            </div>
        </div>
    </div>
    <!-- Información del publicaciones -->

    <div class="profile-info bg-light rounded text-center shadow-lg mt-2 m-3 pt-4 p-3">
        <div class="row">
            <div class="col">
                <h3>Publicaciones</h3>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col">

            </div>
            <div>

            </div>
        </div>

    </div>

</div>