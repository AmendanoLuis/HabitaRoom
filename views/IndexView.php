<div class="container-fluid ">
    <div class="row ">

        <!-- Contenedores Filtros -->
        <div class="col-3">

            <div class="row position-fixed d-lg-block d-none bg-light shadow-lg" id="row_filtros">
                <div class="col ">

                    <!-- Categorias -->
                    <div class="mt-5 pt-5 px-5 mb-4   ">
                        <h4 class="mt-4 my-3">Categoria Publicaciones</h4>

                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btn-habitantes-desk"
                                autocomplete="off">
                            <label class="btn btn-outline-success" for="btn-habitantes-desk">Habitantes</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btn-propietario-desk"
                                autocomplete="off">
                            <label class="btn btn-outline-success" for="btn-propietario-desk">Propietario</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btn-empresa-desk"
                                autocomplete="off">
                            <label class="btn btn-outline-success" for="btn-empresa-desk">Empresas</label>
                        </div>
                    </div>
                    <hr class="text-dark">

                    <!-- Filtros -->
                    <div class="d-lg-block d-none text-dark mb-2 z-3">
                        <!-- Formulario Filtros -->
                        <form id="form-filtros-desp" method="POST" class="ps-4">

                            <!-- Tipo de anuncio -->
                            <h5 class="fw-bold fs-md-6 fs-sm-5">Tipo de anuncio</h5>
                            <select class="form-select" id="tipo_anuncio" name="tipo_anuncio">
                                <option value="">Cualquiera</option>
                                <option value="venta">Venta</option>
                                <option value="alquiler">Alquiler</option>
                            </select>

                            <!-- Tipo de Inmueble -->
                            <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Tipo de inmueble</h5>
                            <select class="form-select" id="tipo_inmueble" name="tipo_inmueble">
                                <option value="">Cualquiera</option>
                                <option value="apartamento">Apartamento</option>
                                <option value="casa">Casa</option>
                                <option value="oficina">Oficina</option>
                                <option value="local">Local</option>
                                <option value="terreno">Terreno</option>
                            </select>

                            <!-- Precio Inmueble -->
                            <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Precio (€)</h5>
                            <div class="row">
                                <div class="col">
                                    <select class="form-select" id="precio_min" name="precio_min">
                                        <option value="">Min.</option>
                                        <option value="50000">50 000</option>
                                        <option value="100000">100 000</option>
                                        <option value="150000">150 000</option>
                                        <option value="200000">200 000</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="precio_max" name="precio_max">
                                        <option value="">Max.</option>
                                        <option value="250000">250 000</option>
                                        <option value="400000">400 000</option>
                                        <option value="600000">600 000</option>
                                        <option value="1000000">1 000 000</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Habitaciones -->
                            <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Habitaciones (≥)</h5>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="habitaciones" id="hab-1" value="1">
                                <label class="btn btn-outline-primary" for="hab-1">1</label>

                                <input type="radio" class="btn-check" name="habitaciones" id="hab-2" value="2">
                                <label class="btn btn-outline-primary" for="hab-2">2</label>

                                <input type="radio" class="btn-check" name="habitaciones" id="hab-3" value="3">
                                <label class="btn btn-outline-primary" for="hab-3">3</label>

                                <input type="radio" class="btn-check" name="habitaciones" id="hab-4" value="4">
                                <label class="btn btn-outline-primary" for="hab-4">4+</label>
                            </div>

                            <!-- Baños -->
                            <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Baños (≥)</h5>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="banos" id="bano-1" value="1">
                                <label class="btn btn-outline-primary" for="bano-1">1</label>

                                <input type="radio" class="btn-check" name="banos" id="bano-2" value="2">
                                <label class="btn btn-outline-primary" for="bano-2">2</label>

                                <input type="radio" class="btn-check" name="banos" id="bano-3" value="3">
                                <label class="btn btn-outline-primary" for="bano-3">3+</label>
                            </div>

                            <!-- Estado inmueble -->
                            <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Estado</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="estado-nuevo" value="nuevo">
                                <label class="form-check-label" for="estado-nuevo">Nuevo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="estado-semi" value="semi-nuevo">
                                <label class="form-check-label" for="estado-semi">Semi-nuevo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="estado-usado" value="usado">
                                <label class="form-check-label" for="estado-usado">Usado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="estado-renovado" value="renovado">
                                <label class="form-check-label" for="estado-renovado">Renovado</label>
                            </div>

                            <!-- Características -->
                            <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Características</h5>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ascensor" id="carac-ascensor" value="1">
                                        <label class="form-check-label" for="carac-ascensor">Ascensor</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="piscina" id="carac-piscina" value="1">
                                        <label class="form-check-label" for="carac-piscina">Piscina</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gimnasio" id="carac-gimnasio" value="1">
                                        <label class="form-check-label" for="carac-gimnasio">Gimnasio</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="garaje" id="carac-garaje" value="1">
                                        <label class="form-check-label" for="carac-garaje">Garaje</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terraza" id="carac-terraza" value="1">
                                        <label class="form-check-label" for="carac-terraza">Terraza</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jardin" id="carac-jardin" value="1">
                                        <label class="form-check-label" for="carac-jardin">Jardín</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="aire_acondicionado" id="carac-acondicionado" value="1">
                                        <label class="form-check-label" for="carac-acondicionado">Aire acondicionado</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="calefaccion" id="carac-calefaccion" value="1">
                                        <label class="form-check-label" for="carac-calefaccion">Calefacción</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón Aplicar Filtros -->
                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

                <!-- Categoria |  MOVIL -->
                <div class="row my-2 pt-2 d-lg-none bg-light position-fixed z-1 shadow-lg">
                    <div class="container py-4  mb-5 rounded-bottom text-center text-body-secondary">
                        <h5>Categoria</h5>
                        <h5 class="mb-3">Publicaciones</h5>
                        <div class="btn-group d-flex flex-column px-3" role="group"
                            aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btn-habitantes-mob"
                                autocomplete="off">
                            <label class="btn btn-outline-secondary py-2 rounded-0 rounded-top"
                                for="btn-habitantes-mob">Habitantes</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btn-propietario-mob"
                                autocomplete="off">
                            <label class="btn btn-outline-secondary py-2 rounded-0"
                                for="btn-propietario-mob">Propietario</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btn-empresa-mob" autocomplete="off">
                            <label class="btn btn-outline-secondary py-2 rounded-0 rounded-bottom"
                                for="btn-empresa-mob">Empresas</label>
                        </div>
                    </div>
                </div>

        </div>

        <!-- CONTENIDO PRINICIPAL -->
        <div class=" col-9 pt-2 mt-5 d-flex flex-column align-items-center" id="contenedor-principal">

        </div>

        <!-- Contenedor Mapa Ordenador-->
        <div id="mapa" class="position-fixed end-0 d-none d-xxl-block bg-light shadow-lg rounded-bottom p-0 pt-4">
            <iframe class="w-100 h-75 px-2 mb-2"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10694.649359839766!2d-3.584114235826003!3d37.16367693815794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71e3532fc629bb%3A0x3f04a1335378ec94!2sAsador%20Curro!5e0!3m2!1ses!2ses!4v1739023651029!5m2!1ses!2ses"></iframe>
            <form
                class="form p-3 d-flex justify-content-center align-items-center bg-success bg-opacity-75 rounded-bottom"
                id="formBuscarMapa">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </form>
        </div>


        <!-- Contenedor Botones Accion -->
        <div class="botones_accion position-fixed bottom-0 end-0 m-3" id="cont_btns_index">

            <!-- Contenedor para el Chat -->
            <div id="map-container" class="position-absolute top-50 end-0 translate-middle-y "> <button class="btn btn-light p-2 px-3 rounded-circle border border-1 border-success">
                    <i class="bi bi-chat-dots" style="font-size: 30px;"></i>
                </button>
            </div>

            <!-- Contenedor para el Mapa  -->

            <div id="filters-container" class="position-absolute bottom-0 end-0 ">
                <button class="btn btn-light p-2 px-3 rounded-circle border border-1 border-success">
                    <i class="bi bi-map" style="font-size: 30px;"></i>
                </button>
            </div>


        </div>

    </div>
</div>