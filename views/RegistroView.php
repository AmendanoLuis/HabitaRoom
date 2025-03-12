<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- Columna de Registro -->
        <div class="col col-md-6 bg-light">
            <div class="d-flex flex-column justify-content-center align-items-center h-100" >
                <h2 class="mb-4 mt-3">Registrate</h2>

                <!-- Formulario de inicio de sesión -->
                <form id="cont_registro">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_usuario">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario">
                    </div>
                    <div class="form-group">
                        <label for="correo_electronico">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_usuario">Tipo de Usuario</label>
                        <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                            <option value="habitante">Habitante</option>
                            <option value="propietario">Propietario</option>
                            <option value="empresa">Empresa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                    </div>
                    <div class="form-group">
                        <label for="foto_perfil">Foto de Perfil</label>
                        <input type="file" class="form-control-file" id="foto_perfil" name="foto_perfil">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="preferencia_contacto">Preferencia de Contacto</label>
                        <select class="form-control" id="preferencia_contacto" name="preferencia_contacto" required>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="email">Email</option>
                            <option value="mensaje">Mensaje</option>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="terminos_aceptados" name="terminos_aceptados" required>
                        <label class="form-check-label" for="terminos_aceptados">Acepto los términos y condiciones</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>

                <div class="mt-4 d-flex justify-content-between w-75">
                    <a href="/HabitaRoom/register" class="link-dark ">¿Has olvidado la contraseña?</a>

                    <a href="/HabitaRoom/login" class="link-dark">¿Ya tienes cuenta?</a>

                </div>
            </div>
        </div>


        <!-- Columna fondo video -->
        <div class="col-6 bg-dark d-none d-md-flex text-light d-flex flex-column justify-content-center position-relative overflow-hidden">
            <!-- Video de fondo -->
            <video autoplay loop muted class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" src="public/img/videoLogin.mp4"></video>

            <!-- Contenido encima del video -->
            <div class="position-relative z-index-2 bg-dark bg-opacity-75 rounded p-4 mx-2 " style="height: 420px;">

                <!-- Logo -->
                <div>
                    <div id="cont_logo">
                        <a class="link-light link-underline-opacity-0 mh-100" href="/HabitaRoom/index">
                            <h1 class="text-light rounded  text-end text-uppercase fw-bold" style="font-size: 4.8em;" id="logo_login">Habita Room</h1>
                        </a>
                    </div>

                    <hr class="me-3 bg-light" style="height: 2px;">
                    <p class="mt-3 fs-5 pe-1 text-end text-break">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo iusto corporis in voluptas maxime
                        velit rem eligendi repudiandae qui soluta, ipsum, odio quas. Porro modi non eos quia veniam
                        laborum?
                    </p>
                </div>

                <!-- Redes sociales -->
                <div class="mt-5 position-relative z-index-2 d-flex flex-column align-items-end">
                    <div class="row">
                        <p class="fs-5">Nos puedes encontrar en:</p>
                    </div>
                    <div class="row w-25 ps-1 ">
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


    </div>
</div>