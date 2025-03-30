<div class="container my-5 d-flex flex-column align-items-center text-light " id="contenedor-principal">
    <!-- Modal -->
    <div id="modalMensaje" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background-color:rgba(0,0,0,0.7); color:white; padding:20px; border-radius:10px;">
        <p id="mensajeModal"></p>
        <button onclick="cerrarModal()">Cerrar</button>
    </div>

    <div class="row text-dark">
        <div class="col-auto mt-5 bg-white py-3 px-5 rounded shadow-lg" style="min-width:550px;">

            <!-- Formulario -->
            <form class="mt-4" method="POST" id="form_crear_publi" action="controllers/CrearPublicacionController.php" >

                <!-- Tipo de inmueble -->
                <div class="container form-group mb-4 position-relative mt-4 mb-3">
                    <label for="tipo_inmueble" id="label_tipo_inmueble" class="position-absolute top-0 start-0 pt-2">Tipo de inmueble</label>
                    <select name="tipo_inmueble" class="form-select pt-4" id="tipo_inmueble">
                        <option value="garaje">Garaje</option>
                        <option value="apartamento">Apartamento</option>
                        <option value="piso">Piso</option>
                        <option value="casa">Casa</option>
                    </select>

                    <!-- Tipo de anuncio -->
                    <div class="mt-3 d-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="tipo_anuncio" id="tipo_alquiler" checked>
                            <label for="tipo_alquiler">Alquiler</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_anuncio" id="tipo_venta">
                            <label for="tipo_venta">Venta</label>
                        </div>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="container my-3">
                    <h5 class="mb-3 fs-4">Ubicación</h5>
                    <div id="mapa" class="d-flex flex-column align-items-center mx-auto mt-3 w-100">

                        <iframe class="h-100 mb-3 border border-1 " width="500px"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10694.649359839766!2d-3.584114235826003!3d37.16367693815794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71e3532fc629bb%3A0x3f04a1335378ec94!2sAsador%20Curro!5e0!3m2!1ses!2ses!4v1739023651029!5m2!1ses!2ses"></iframe>

                        <div
                            class="p-3 d-flex justify-content-center align-items-center"
                            id="formBuscarMapa">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Donde se encuentra su inmueble..."
                                    aria-label="Buscar ubicación">

                                <button class="btn btn-primary" onclick="buscarUbicacion()">Buscar</button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Titulo y Precio -->
                <div class="container mt-5 mb-3">
                    <div class="row">
                        <div class="col-6">
                            <!-- Titulo  -->
                            <h5 class="mb-3 fs-4">Título</h5>
                            <div class="input-group flex-nowrap ">
                                <input type="text" class="form-control" placeholder="Piso en el dentro de..." aria-label="Username"
                                    aria-describedby="addon-wrapping">
                            </div>
                        </div>

                        <div class="col-6 d-flex flex-column align-items-end">
                            <!-- Precio -->
                            <div class="w-75 mb-3">
                                <h5 class="mb-3 fs-4">Precio</h5>
                                <div class="input-group">
                                    <input type="text" class="form-control " placeholder="400">
                                    <span class="input-group-text border border-1">.00 €</span>
                                </div>
                            </div>

                        </div>
                    </div>




                </div>

                <!-- Habitaciones y Baños-->
                <div class="container mt-5 mb-3">
                    <div class="d-flex justify-content-start align-items-center">
                        <!-- Número de habitaciones -->
                        <div class="me-5 ">
                            <h5 class="mb-3 fs-4">Habitacion</h5>
                            <div class="d-flex align-items-center mt-2 ">
                                <button type="button" class="btn btn-outline-success  fs-5 rounded-circle px-3 fw-bold"
                                    id="btn_menos_hab"> - </button>
                                <span id="num_habitaciones" class="mx-3 pe-1"> 1 </span>
                                <button type="button" class="btn btn-outline-success  fs-5 rounded-circle ps-3 pe-3 fw-bold"
                                    id="btn_mas_hab"> + </button>
                            </div>
                        </div>
                        <!-- Número de baños -->
                        <div class="ms-5">
                            <h5 class="mb-3 fs-4">Baños</h5>
                            <div class="d-flex align-items-center mt-2 ">
                                <button type="button" class="btn btn-outline-success  fs-5 rounded-circle px-3 fw-bold"
                                    id="btn_menos_banos">-</button>
                                <span id="num_banos" class="mx-3 pe-1">1</span>
                                <button type="button" class="btn btn-outline-success  fs-5 rounded-circle ps-3 pe-3 fw-bold"
                                    id="btn_mas_banos">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Características y estado vivienda-->
                <div class="container my-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fs-4">Características</h5>
                            <div class="row g-0 mt-3 mb-4">
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="ascensor" name="ascensor" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="ascensor">Ascensor</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="piscina" name="piscina" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="piscina">Piscina</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="gimnasio" name="gimnasio" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="gimnasio">Gimnasio</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="garaje" name="garaje" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="garaje">Garaje</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="terraza" name="terraza" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="terraza">Terraza</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="jardin" name="jardin" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="jardin">Jardín</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="aire_acondicionado" name="aire_acondicionado" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="aire_acondicionado">Aire Acondicionado</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="calefaccion" name="calefaccion" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="calefaccion">Calefacción</label>
                                </div>
                            </div>
                            <h5 class="card-title fs-4">Estado</h5>
                            <div class="mt-2 mb-3 btn-group flex-wrap" role="group" aria-label="Estado">
                                <input type="radio" class="btn-check" name="estado" id="nuevo" value="nuevo" autocomplete="off">
                                <label class="btn btn-outline-success" for="nuevo">Nuevo</label>
                                <input type="radio" class="btn-check" name="estado" id="semi_nuevo" value="semi_nuevo" autocomplete="off">
                                <label class="btn btn-outline-success" for="semi_nuevo">Semi-nuevo</label>
                                <input type="radio" class="btn-check" name="estado" id="usado" value="usado" autocomplete="off">
                                <label class="btn btn-outline-success" for="usado">Usado</label>
                                <input type="radio" class="btn-check" name="estado" id="renovado" value="renovado" autocomplete="off">
                                <label class="btn btn-outline-success" for="renovado">Renovado</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-5 mb-3">
                    <h5 class="mb-3 fs-4">Superficie construida <span class="text-muted">(opcional)</span></h5>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border border-1" id="superficie" name="superficie" aria-label="Superficie">
                        <span class="input-group-text border border-1"> m²</span>
                    </div>
                </div>
                <div class="container mt-5 mb-3">
                    <h5 class="mb-3 fs-4">Descripción</h5>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="6" placeholder="Proporciona una descripción detallada..."></textarea>
                </div>
                <div class="container mt-5 mb-3">
                    <h5 class="mb-3 fs-4">Fotos y vídeos <span class="text-muted">(opcional)</span></h5>
                    <div class="border rounded p-4 text-center mt-3">
                        <i class="bi bi-camera fs-3"></i>
                        <p>Añade fotos de la vivienda</p>
                        <input class="d-none" type="file" id="file_input" name="imagenes" multiple>
                        <label for="file_input" class="btn btn-outline-dark">Seleccionar</label>
                    </div>
                </div>
                <div class="container mt-5 mb-3">
                    <h5 class="mb-3 fs-4">Contacto <span class="text-muted">(opcional)</span></h5>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fs-5 mb-2">Tipo de contacto</h5>
                            <div class="row g-0 mb-4">
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="contacto_mensaje" name="contacto_mensaje" autocomplete="off">
                                    <label class="btn btn-outline-success w-100 rounded-0" for="contacto_mensaje">Mensaje</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="contacto_email" name="contacto_email" autocomplete="off">
                                    <label class="btn btn-outline-success w-100 rounded-0" for="contacto_email">Email</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="contacto_whatsapp" name="contacto_whatsapp" autocomplete="off">
                                    <label class="btn btn-outline-success w-100 rounded-0" for="contacto_whatsapp">Whatsapp</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de envío -->
                <div class="container mt-5 mb-3 text-center">
                    <button type="submit" class="btn w-100 p-2 shadow btn_soft_green_hr btn-success" id="btn_crear_publi" name="btn_crear_publi">Publicar anuncio</button>
                </div>

            </form>
        </div>
    </div>
</div>