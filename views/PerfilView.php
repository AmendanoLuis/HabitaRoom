<?php

if (isset($_SESSION['id'])) {
    $userModel = new Usuario();
    $usuario = $userModel->obtenerUsuarioId($_SESSION['id']);

    $publicaciones = $userModel->obtenerPublicacionesUsuario($usuario->id);
}

?>

<div class="container w-75 text-dark my-5 d-flex flex-column justify-content-center z-0">

    <!-- Encabezado del perfil -->
    <div class="profile-header bg-light rounded text-center shadow-lg mt-5   m-3 p-3 d-flex">

        <!-- La imagen de perfil se mostrará aquí -->
        <div class="row w-100">

            <!-- Imagen de perfil -->
            <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                <img class="d-block border border-2 border-success"
                    src="<?php echo 'assets/uploads/img_perfil/' . $usuario->foto_perfil; ?>" alt="Foto de Perfil">
                <p class="fs-4 text-success-emphasis"><?php echo $usuario->nombre_usuario; ?></p>
            </div>

            <!-- Información del usuario -->
            <div class="col-8 d-flex flex-column position-relative">
                <div class="w-100 text-start ms-2 mt-4">
                    <h2><?php echo $usuario->nombre . ' ' . $usuario->apellidos; ?></h2>
                    <p class=""><?php echo $usuario->correo_electronico; ?></p>
                </div>

                <div class="w-100 text-start ms-2 mt-2">
                    <h4>Descripción</h4>
                    <div class="descripcion-perfil">
                        <p><?php echo $usuario->descripcion; ?></p>
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
    <div class="profile-info bg-light rounded shadow-lg mt-2 m-3 p-3">

        <!-- Información del usuario -->
        <div class="row my-3 d-flex align-items-center justify-content-between text-center">

            <!-- Ubicacion -->
            <div class="col">
                <p class="fs-5 fw-semibold">Ubicación</p>
                <address class="fs-6 fw-normal text-muted m-0"><?php echo $usuario->ubicacion; ?></address>
            </div>

            <!-- Tipo de contacto-->
            <div class="col">
                <p class="fs-5 fw-semibold">Contacto</p>
                <p class="fs-6 fw-normal text-capitalize text-muted m-0">
                    <?php if ($usuario->preferencia_contacto === "whatsapp"): ?>
                        <i class="bi bi-whatsapp"></i>
                    <?php elseif ($usuario->preferencia_contacto === "email"): ?>
                        <i class="bi bi-envelope-at"></i>
                    <?php else: ?>
                        <i class="bi bi-chat-dots"></i>
                    <?php endif; ?>
                    <?php echo $usuario->preferencia_contacto; ?>
                </p>
            </div>

            <!-- Teléfono -->
            <?php if ($usuario->preferencia_contacto === "whatsapp"): ?>
                <div class="col">
                    <p class="fs-5 fw-semibold">Número</p>
                    <p class="fs-6 fw-normal text-muted m-0"><?php echo $usuario->telefono; ?></p>
                </div>
            <?php endif; ?>

            <!-- Botones de accion-->
            <div class="col d-flex justify-content-end align-items-center gap-2 mt-3">
                <form method="POST">
                    <input type="hidden" name="ed_perfil" value="2">
                    <button type="submit" id="btn_accion_perfil" class="btn btn-success" style="width: 150px;">Editar
                        Perfil</button>
                </form>
                <form action="controllers/LoginController.php" method="POST">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" id="btn_accion_perfil" class="btn btn-danger" style="width: 150px;">Cerrar
                        sesión</button>
                </form>
            </div>
        </div>


    </div>

    <!-- Información del publicaciones -->
    <div class="profile-info bg-light rounded text-center shadow-lg mt-2 m-3 p-3">
        <div class="row">
            <div class="col">
                <h3>Publicaciones</h3>
            </div>
        </div>
        <hr>

        <div class="row">
            <?php foreach ($publicaciones as $publicacion): ?>
                <div class="col-4">
                    <a href="/HabitaRoom/publicacionusuario" class="contenedor-publicacion" data-id="<?php echo $publicacion->id_publicacion; ?>">
                        <div class="my-2 mx-auto" id="cont_img_publi_perfil">
                            <?php
                            $imagenes = json_decode($publicacion->fotos, true);

                            if (is_array($imagenes) && !empty($imagenes)): ?>
                                <img src="<?php echo 'assets/uploads/img_publicacion/' . trim($imagenes[0]); ?>"
                                    class="rounded border border-1 border-success-subtle" alt="Foto de la publicación"
                                    id="img_publi_perfil"
                                />
                            <?php else: ?>
                                <img src="assets/uploads/img_publicacion/imgPublicacionBase.png" 
                                class="img-fluid rounded border border-1 border-success-subtle" 
                                id="img_publi_perfil" 
                                alt="Imagen de la propiedad"
                                />
                            <?php endif; ?>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>

    </div>

</div>