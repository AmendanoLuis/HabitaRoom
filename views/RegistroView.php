<?php
/**
 * Vista: Registro View
 *
 * Muestra el formulario para que un nuevo usuario pueda registrarse en la plataforma HabitaRoom.
 * 
 * Estructura y características:
 * - Formulario con método POST y enctype multipart/form-data para permitir carga de imagen.
 * - Campos del formulario:
 *     - Nombre (texto, obligatorio, validación de letras y espacios)
 *     - Apellidos (texto, obligatorio, validación de letras y espacios)
 *     - Nombre de Usuario (texto, obligatorio, solo letras, números y guion bajo)
 *     - Correo Electrónico (email, obligatorio)
 *     - Teléfono (tel, obligatorio, solo números entre 7 y 15 dígitos)
 *     - Contraseña (password, obligatorio, mínimo 8 caracteres)
 *     - Repetir Contraseña (password, obligatorio, mínimo 8 caracteres)
 *     - Tipo de Usuario (select, obligatorio, opciones: habitante, propietario, empresa)
 *     - Ubicación (input de búsqueda integrada con mapa Leaflet para selección)
 *     - Foto de Perfil (input file, acepta imágenes, con vista previa)
 *     - Descripción (textarea, obligatorio, min 10 caracteres, max 500)
 *     - Preferencia de Contacto (select, obligatorio, opciones: whatsapp, email, mensaje)
 *     - Aceptación de Términos y Condiciones (checkbox obligatorio)
 * - Botón de envío para guardar el registro.
 * - Enlaces para recuperación de contraseña y login.
 * - Diseño responsive:
 *     - Formulario ocupa la mitad izquierda en pantallas md+.
 *     - La mitad derecha muestra un video de fondo con logo, texto y redes sociales (oculto en móviles).
 *
 * Uso de clases Bootstrap para estilos y validaciones HTML5.
 * Se espera que la lógica de validación y procesamiento esté en el controlador correspondiente.
 *
 * @package HabitaRoom\Views
 */
?>

<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- Sección de Registro -->
        <div class="col col-md-6 bg-light">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <h2 class="mb-3 mt-5 fs-1">Regístrate</h2>

                <!-- Formulario de Registro -->
                <form class="w-75" id="cont_registro" method="POST" enctype="multipart/form-data" novalidate>

                    <!-- Nombre -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="nombre">Nombre</label>
                        <input type="text" class="form-control border border-1 border-success-subtle" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required minlength="2" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+">
                    </div>

                    <!-- Apellidos -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="apellidos">Apellidos</label>
                        <input type="text" class="form-control border border-1 border-success-subtle" id="apellidos" name="apellidos" placeholder="Ingresa tus apellidos" required minlength="2" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+">
                    </div>

                    <!-- Nombre de Usuario -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="nombre_usuario">Nombre de Usuario</label>
                        <input type="text" class="form-control border border-1 border-success-subtle" id="nombre_usuario" name="nombre_usuario" placeholder="Elige un nombre de usuario" required minlength="3" maxlength="20" pattern="^[a-zA-Z0-9_]+$" title="Solo letras, números y guion bajo">
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="correo_electronico">Correo Electrónico</label>
                        <input type="email" class="form-control border border-1 border-success-subtle" id="correo_electronico" name="correo_electronico" placeholder="Ingresa tu correo electrónico" required>
                    </div>

                    <!-- Teléfono -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="telefono">Teléfono</label>
                        <input type="tel" class="form-control border border-1 border-success-subtle" id="telefono" name="telefono" placeholder="Ingresa tu número de teléfono" pattern="^\d{7,15}$" title="Ingresa solo números, entre 7 y 15 dígitos" required>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="contrasena">Contraseña</label>
                        <input type="password" class="form-control border border-1 border-success-subtle" id="contrasena" name="contrasena" placeholder="Escribe una contraseña" required minlength="8" maxlength="50" title="Mínimo 8 caracteres">
                    </div>

                    <!-- Repetir contraseña -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="repContrasena">Repetir contraseña</label>
                        <input type="password" class="form-control border border-1 border-success-subtle" id="repContrasena" name="repContrasena" placeholder="Repite la contraseña" required minlength="8" maxlength="50" title="Igual a la contraseña">
                    </div>

                    <!-- Tipo de Usuario -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="tipo_usuario">Tipo de Usuario</label>
                        <select class="form-control border border-1 border-success-subtle" id="tipo_usuario" name="tipo_usuario" required>
                            <option value="" disabled selected>Selecciona un tipo</option>
                            <option value="habitante">Habitante</option>
                            <option value="propietario">Propietario</option>
                            <option value="empresa">Empresa</option>
                        </select>
                    </div>

                    <!-- Ubicación -->
                    <div class="my-3 form-group">
                        <h5 class="py-2 fs-5">Ubicación</h5>
                        <div class="d-flex flex-column align-items-center mx-auto mt-3 w-100">

                            <div id="mapLeaflet" class="w-100 rounded"></div>

                            <div id="formBuscarMapa" class="d-flex justify-content-center align-items-center">
                                <div class="input-group mb-3">
                                    <input
                                        id="inputBuscarMapa"
                                        class="form-control rounded border border-1 border-success-subtle"
                                        type="search"
                                        name="ubicacion"
                                        placeholder="Buscar"
                                        autocomplete="off" />
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Foto de Perfil -->
                    <div class="form-group my-3">
                        <label class="pt-2 fs-5" for="foto_perfil">Foto de Perfil</label>
                        <div class="border border-1 border-success-subtle rounded p-4 text-center text-secondary mt-3 bg-white">
                            <div id="perfil-preview" class="mb-3"></div>
                            <input class="d-none" type="file" id="fileInput" name="foto_perfil" accept="image/*">
                            <label for="fileInput" class="btn btn-outline-dark">Seleccionar</label>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="descripcion">Descripción</label>
                        <textarea class="form-control border border-1 border-success-subtle" id="descripcion" name="descripcion" placeholder="Describe algo sobre ti" required minlength="10" maxlength="500"></textarea>
                    </div>

                    <!-- Preferencia de Contacto -->
                    <div class="form-group my-3">
                        <label class="py-2 fs-5" for="preferencia_contacto">Preferencia de Contacto</label>
                        <select class="form-control border border-1 border-success-subtle" id="preferencia_contacto" name="preferencia_contacto" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="email">Email</option>
                            <option value="mensaje">Mensaje</option>
                        </select>
                    </div>

                    <!-- Términos y Condiciones -->
                    <div class="form-group ms-2 mt-5 my-2 form-check">
                        <input type="checkbox" class="form-check-input border border-1 border-success-subtle" id="terminos_aceptados" name="terminos_aceptados" required>
                        <label class="form-check-label" for="terminos_aceptados">Acepto los términos y condiciones</label>
                    </div>

                    <!-- Botón -->
                    <button type="submit" name="btn_registro" class="w-100 my-3 btn btn-outline-success">Guardar</button>
                </form>


                <!-- Enlaces de Ayuda -->
                <div class="my-5 d-flex justify-content-between w-75">
                    <a href="/HabitaRoom/register" class="link-success">¿Has olvidado la contraseña?</a>
                    <a href="/HabitaRoom/login" class="link-success">¿Ya tienes cuenta?</a>
                </div>
            </div>
        </div>

        <!-- Sección con Video de Fondo -->
        <div class="col-6 bg-dark d-none d-md-flex text-light d-flex flex-column justify-content-center position-fixed overflow-hidden end-0 h-100">

            <!-- Video de Fondo -->
            <video autoplay loop muted class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" src="public/img/videoLogin.mp4"></video>

            <!-- Contenedor de Información -->
            <div class="position-relative z-index-2 bg-dark bg-opacity-75 rounded p-4 mx-2" style="height: 420px;">
                <div>
                    <!-- Logo -->
                    <div id="cont_logo">
                        <a class="link-light link-underline-opacity-0 mh-100" href="/HabitaRoom/index">
                            <h1 class="text-light rounded text-end text-uppercase fw-bold" style="font-size: 4.8em;" id="logo_login">Habita Room</h1>
                        </a>
                    </div>

                    <!-- Línea Divisoria -->
                    <hr class="me-3 bg-light" style="height: 2px;">

                    <!-- Descripción -->
                    <p class="mt-3 fs-5 pe-1 text-end text-break">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo iusto corporis in voluptas maxime
                        velit rem eligendi repudiandae qui soluta, ipsum, odio quas. Porro modi non eos quia veniam
                        laborum?
                    </p>
                </div>

                <!-- Sección de Redes Sociales -->
                <div class="mt-5 position-relative z-index-2 d-flex flex-column align-items-end">
                    <div class="row">
                        <p class="fs-5">Nos puedes encontrar en:</p>
                    </div>
                    <div class="row w-25 ps-1">
                        <!-- Iconos de Redes Sociales -->
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

        </div> <!-- Fin de la Sección con Video -->
    </div>
</div> <!-- Fin del Contenedor Principal -->