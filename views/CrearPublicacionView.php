<div class="container my-5 d-flex flex-column align-items-center text-light crear-publicacion">
    <div class="row text-dark">
        <div class="col-auto mt-5 bg-light-subtle py-3 px-5 rounded shadow-lg" style="min-width:550px;">
         
            <!-- Formulario -->
            <form class="mt-4">

                <!-- Tipo de inmueble -->
                <div class="container form-group mb-4 position-relative mt-4 mb-3">
                    <label for="tipo-inmueble" class="position-absolute top-0 start-0 pt-2"
                        id="label-tipo-inmueble">Tipo de inmueble</label>
                    <select name="tipo-inmueble" class="form-select pt-4" id="tipo-inmueble">
                        <option value="garaje">Garaje</option>
                        <option value="apartamento">Apartamento</option>
                        <option value="piso">Piso</option>
                        <option value="casa">Casa</option>
                    </select>

                    <!-- Tipo de anuncio -->
                    <div class="mt-3 d-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="tipo-anuncio" id="tipo-alquiler" checked>
                            <label for="tipo-alquiler">Alquiler</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo-anuncio" id="tipo-venta">
                            <label for="tipo-venta">Venta</label>
                        </div>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class=" container my-3">
                    <h5 class="mb-3 fs-4">Ubicación</h5>
                    <div id="mapa" class="d-flex flex-column align-items-center mx-auto mt-3 w-100">
                        <iframe class="h-100 mb-3 border border-1" width="500px"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10694.649359839766!2d-3.584114235826003!3d37.16367693815794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71e3532fc629bb%3A0x3f04a1335378ec94!2sAsador%20Curro!5e0!3m2!1ses!2ses!4v1739023651029!5m2!1ses!2ses"></iframe>
                        <form
                            class=" p-3 d-flex justify-content-center align-items-center bg-success bg-opacity-75 rounded-bottom"
                            id="formBuscarMapa">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Buscar ubicación"
                                    aria-label="Buscar ubicación" aria-describedby="button-addon">

                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Titulo y Precio -->
                <div class="container mt-5 mb-3">
                    <div class="row">
                        <div class="col-6">
                            <!-- Titulo  -->
                            <h5 class="mb-3 fs-4">Título</h5>

                            <div class="input-group flex-nowrap ">
                                <input type="text" class="form-control" placeholder="Título" aria-label="Username"
                                    aria-describedby="addon-wrapping">
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Precio -->
                            <h5 class="mb-3 fs-4">Precio</h5>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Precio"
                                    aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text border border-end-0">.00 €</span>
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
                                <button class="btn btn-outline-success  fs-5 rounded-circle px-3 fw-bold"
                                    id="btn-menos-hab"> - </button>
                                <span id="num-habitaciones" class="mx-3 pe-1"> 1 </span>
                                <button class="btn btn-outline-success  fs-5 rounded-circle ps-3 pe-3 fw-bold"
                                    id="btn-mas-hab"> + </button>
                            </div>
                        </div>
                        <!-- Número de baños -->
                        <div class="ms-5">
                            <h5 class="mb-3 fs-4">Baños</h5>
                            <div class="d-flex align-items-center mt-2 ">
                                <button class="btn btn-outline-success  fs-5 rounded-circle px-3 fw-bold"
                                    id="btn-menos-banos">-</button>
                                <span id="num-banos" class="mx-3 pe-1">1</span>
                                <button class="btn btn-outline-success  fs-5 rounded-circle ps-3 pe-3 fw-bold"
                                    id="btn-mas-banos">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Características y estado vivienda-->
                <div class="container  my-5">
                    <div class="card">
                        <div class="card-body">

                            <!-- Sección de Características -->
                            <h5 class="card-title fs-4">Características</h5>
                            <div class="row g-0 mt-3 mb-4">

                                <!-- Ascensor -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="ascensor" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0 "
                                        for="ascensor">Ascensor</label>
                                </div>

                                <!-- Piscina -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="piscina" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="piscina">Piscina</label>
                                </div>

                                <!-- Gimnasio -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="gimnasio" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0"
                                        for="gimnasio">Gimnasio</label>
                                </div>

                                <!-- Garaje -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="garaje" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="garaje">Garaje</label>
                                </div>

                                <!-- Terraza -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="terraza" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="terraza">Terraza</label>
                                </div>

                                <!-- Jardin -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="jardin" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="jardin">Jardín</label>
                                </div>

                                <!-- Aire Acondicionado -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="aireAcondicionado" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0" for="aireAcondicionado">Aire
                                        Acondicionado</label>
                                </div>

                                <!-- Calefacción -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="calefaccion" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100 rounded-0"
                                        for="calefaccion">Calefacción</label>
                                </div>
                            </div>

                            <!-- Sección de Estado -->
                            <h5 class="card-title fs-4">Estado</h5>
                            <div class="mt-2 mb-3 btn-group flex-wrap" role="group" aria-label="Estado">
                                <input type="radio" class="btn-check" name="estado" id="nuevo" autocomplete="off">
                                <label class="btn btn-outline-success" for="nuevo">Nuevo</label>

                                <input type="radio" class="btn-check" name="estado" id="semi-nuevo" autocomplete="off">
                                <label class="btn btn-outline-success" for="semi-nuevo">Semi-nuevo</label>

                                <input type="radio" class="btn-check" name="estado" id="usado" autocomplete="off">
                                <label class="btn btn-outline-success" for="usado">Usado</label>

                                <input type="radio" class="btn-check" name="estado" id="renovado" autocomplete="off">
                                <label class="btn btn-outline-success" for="renovado">Renovado</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Superficie en m2 -->
                <div class="container mt-5 mb-3">
                    <h5 class="mb-3 fs-4">Superficie construida <span class="text-muted">(opcional)</span></h5>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border-end-0" id="superficie" name="superficie"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        <span class="input-group-text border-start-0"> m²</span>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="container mt-5 mb-3">
                    <h5 class="mb-3 fs-4">Descripción</h5>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="6"
                        placeholder="Proporciona una descripción detallada del inmueble, incluyendo su distribución, estado de conservación, características especiales y cualquier otra información relevante que pueda interesar a los posibles compradores o inquilinos."
                        required></textarea>
                </div>

                <!-- Subir imágenes -->
                <div class="container mt-5 mb-3">
                    <h5 class="mb-3 fs-4">Fotos y vídeos <span class="text-muted">(opcional)</span></h5>

                    <div class="border rounded p-4 text-center mt-3">
                        <i class="bi bi-camera fs-3"></i>
                        <p>Añade fotos de la vivienda</p>
                        <input class="d-none" type="file" id="fileInput" name="imagenes" multiple>
                        <label for="fileInput" class="btn btn-outline-dark">Seleccionar</label>
                    </div>
                </div>

                <!-- Método de mensajeria -->
                <div class="container mt-5 mb-3">
                    <h5 class="mb-3 fs-4">Contacto <span class="text-muted">(opcional)</span></h5>
                    <div class="card">
                        <div class="card-body">

                            <!-- Sección de Características -->
                            <h5 class="card-title fs-5 mb-2">Tipo de contacto</h5>
                            <div class="row g-0 mb-4">

                                <!-- Mensaje Interno -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="contacto-mensaje" autocomplete="off">
                                    <label class="btn btn-outline-success w-100 rounded-0 rounded-start-2 "
                                        for="contacto-mensaje">Mensaje</label>
                                </div>

                                <!-- Teléfono -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="contacto-email" autocomplete="off">
                                    <label class="btn btn-outline-success w-100 rounded-0"
                                        for="contacto-email">Email</label>
                                </div>

                                <!-- Whatsapp -->
                                <div class="col-md-3">
                                    <input type="checkbox" class="btn-check" id="contacto-wasap" autocomplete="off">
                                    <label class="btn btn-outline-success w-100 rounded-0 rounded-end-2 "
                                        for="contacto-wasap">Whatsapp</label>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- Botón de envío -->
                <div class="container mt-5 mb-3 text-center">
                    <button type="submit" class="btn w-100 p-2 shadow btn_soft_green_hr btn-success  ">Publicar anuncio</button>
                </div>

            </form>
        </div>
    </div>
</div>