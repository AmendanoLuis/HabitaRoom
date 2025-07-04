<?php
/**
 * Vista: Perfil View
 *
 * Muestra el perfil del usuario actualmente autenticado.
 * Incluye:
 * - Información personal: nombre, apellidos, correo electrónico, descripción y foto de perfil.
 * - Datos de contacto con iconos según preferencia (WhatsApp, email, mensaje).
 * - Ubicación del usuario.
 * - Listado de publicaciones asociadas al usuario con miniaturas.
 * - Botón para cerrar sesión (botón de editar perfil comentado, pendiente de implementar).
 *
 * Características:
 * - Diseño responsive y estilizado con Bootstrap 5.
 * - Gestión de la sesión para mostrar datos sólo si el usuario está logueado.
 * - Obtiene datos de usuario y publicaciones mediante el modelo ModelUsuario.
 * - Muestra imagen base si no hay fotos en las publicaciones.
 * 
 * Variables utilizadas:
 * - $_SESSION['id']: identificador del usuario logueado.
 * - $usuario: objeto con datos del usuario obtenido desde ModelUsuario.
 * - $publicaciones: array con las publicaciones asociadas al usuario.
 *
 * @package HabitaRoom\Views
 */

if (isset($_SESSION['id'])) {
    $userModel = new ModelUsuario();
    $usuario = $userModel->obtenerUsuarioId($_SESSION['id']);

    $publicaciones = $userModel->obtenerPublicacionesUsuario($usuario->id);
}

?>

<div class="container w-md-75 text-dark my-md-5 d-flex flex-column justify-content-center z-0" id="contenidoPerfil">

    <!-- ORDENADOR -->
    <div class="d-none d-md-block">
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

                        <!-- Numero -->
                        <?php if ($usuario->preferencia_contacto === "whatsapp"): ?>
                            <i class="bi bi-whatsapp"></i>
                            <?php echo $usuario->telefono; ?>
                            <!-- Email-->
                        <?php elseif ($usuario->preferencia_contacto === "email"): ?>
                            <i class="bi bi-envelope-at"></i>
                            <?php echo $usuario->correo_electronico; ?>
                            <!-- Mensaje-->
                        <?php else: ?>
                            <i class="bi bi-chat-dots"></i>
                            <?php echo $usuario->preferencia_contacto; ?>

                        <?php endif; ?>
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
                    <!-- 
                <form method="POST">
                        <input type="hidden" name="ed_perfil" value="2">
                        <button type="submit" id="btn_accion_perfil" class="btn btn-success" style="width: 150px;">Editar Perfil</button>
                </form>
                -->
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

            <!-- Publicaciones del usuario -->
            <div class="row contenedor-publicaciones">
                <?php if (empty($publicaciones)): ?>
                    <div class="col d-flex justify-content-center align-items-center">
                        <img src="public/img/noPublicaciones.png" alt="Sin publicaciones" class="img-fluid opacity-50"
                            style="max-height: 450px;">
                    </div>
                <?php else: ?>
                    <?php foreach ($publicaciones as $publicacion): ?>
                        <div class="col-4 contenedor-publicacion">
                            <a href="/HabitaRoom/publicacionusuario?id=<?php echo $publicacion->id; ?>"
                                data-id="<?php echo $publicacion->id; ?>">
                                <div class="my-2 mx-auto" id="cont_img_publi_perfil">
                                    <?php
                                    $imagenes = json_decode($publicacion->fotos, true);
                                    $foto = (is_array($imagenes) && !empty($imagenes))
                                        ? trim($imagenes[0])
                                        : 'imgPublicacionBase.png';
                                    ?>
                                    <img src="assets/uploads/img_publicacion/<?php echo $foto; ?>"
                                        class="rounded border border-1 border-success-subtle" id="img_publi_perfil"
                                        alt="Foto de la publicación" />
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- MOVIL -->
    <div class="d-block d-md-none">

        <!-- Encabezado del perfil -->
        <div class="profile-header bg-light rounded text-center shadow-lg mt-5 py-5 my-4 mx-3">
            <div class="row gy-3 align-items-center">

                <!-- Imagen de perfil -->
                <div class="col-12 col-md-3 text-center">
                    <img class="border border-2 border-success img-fluid rounded-circle mb-2"
                        src="<?php echo 'assets/uploads/img_perfil/' . $usuario->foto_perfil; ?>" alt="Foto de Perfil"
                        style="max-width: 150px;">
                    <p class="fs-4 text-success-emphasis mb-0"><?php echo $usuario->nombre_usuario; ?></p>
                </div>

                <!-- Información del usuario -->
                <div class="col-12 col-md-9 text-md-start text-center px-4">
                    <h2><?php echo $usuario->nombre . ' ' . $usuario->apellidos; ?></h2>
                    <p><?php echo $usuario->correo_electronico; ?></p>

                    <h4 class="mt-3">Descripción</h4>
                    <p><?php echo $usuario->descripcion; ?></p>

                    <div class="mt-3">
                        <button type="button" class="btn btn-outline-success fw-semibold" disabled>
                            <?php echo "Propietario"; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del perfil -->
        <div class="profile-info bg-light rounded shadow-lg mt-3 m-3 p-3">
            <div class="row gy-3 text-center text-md-start">

                <!-- Ubicación -->
                <div class="col-12 col-md-4">
                    <p class="fs-5 fw-semibold">Ubicación</p>
                    <address class="fs-6 text-muted"><?php echo $usuario->ubicacion; ?></address>
                </div>

                <!-- Contacto -->
                <div class="col-6 col-md-4">
                    <p class="fs-5 fw-semibold">Contacto</p>
                    <p class="fs-6 text-capitalize text-muted">
                        <?php if ($usuario->preferencia_contacto === "whatsapp"): ?>
                            <i class="bi bi-whatsapp"></i> <?php echo $usuario->telefono; ?>
                        <?php elseif ($usuario->preferencia_contacto === "email"): ?>
                            <i class="bi bi-envelope-at"></i> <?php echo $usuario->correo_electronico; ?>
                        <?php else: ?>
                            <i class="bi bi-chat-dots"></i> <?php echo $usuario->preferencia_contacto; ?>
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Botones -->
                <div class="col-6 d-flex justify-content-center justify-content-md-end gap-2 mt-5">
                    <!-- 
            <form method="POST">
                <input type="hidden" name="ed_perfil" value="2">
                <button type="submit" class="btn btn-success">Editar Perfil</button>
            </form>
            -->
                    <form action="controllers/LoginController.php" method="POST">
                        <input type="hidden" name="logout" value="1">
                        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Publicaciones del usuario -->
        <div class="row contenedor-publicaciones gy-4 px-4">
            <div class="bg-light rounded rounded-2 py-4">

                <?php if (empty($publicaciones)): ?>
                    <div class="col d-flex justify-content-center align-items-center">
                        <img src="public/img/noPublicaciones.png" alt="Sin publicaciones" class="img-fluid opacity-50"
                            style="max-height: 300px;">
                    </div>
                <?php else: ?>
                    <?php foreach ($publicaciones as $publicacion): ?>
                        <div class="col-12">
                            <a href="/HabitaRoom/publicacionusuario?id=<?php echo $publicacion->id; ?>"
                                class="text-decoration-none">
                                <div class="mx-auto" id="cont_img_publi_perfil">
                                    <?php
                                    $imagenes = json_decode($publicacion->fotos, true);
                                    $foto = (is_array($imagenes) && !empty($imagenes)) ? trim($imagenes[0]) : 'imgPublicacionBase.png';
                                    ?>
                                    <img src="assets/uploads/img_publicacion/<?php echo $foto; ?>"
                                        class="img-fluid rounded border border-1 border-success shadow shadow-xl"
                                        alt="Foto de la publicación">
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>

    </div>

</div>