<?php
/**
 * Vista: Index View
 *
 * Esta vista representa la página principal donde se muestran las publicaciones.
 * Incluye un sistema de filtros para refinar los resultados, opciones de categoría (habitantes, propietario, empresas),
 * y un mapa interactivo (Leaflet) para ubicar publicaciones geográficamente.
 *
 * Componentes principales:
 * - Barra lateral de filtros con formularios (sólo visible en escritorio).
 * - Versión responsive de categorías para móvil.
 * - Contenedor principal donde se cargan las publicaciones vía JS/AJAX.
 * - Contenedor para el mapa Leaflet con campos ocultos para latitud, longitud, dirección, etc.
 * - Botones de acción para abrir/cerrar el mapa.
 *
 * Esta vista no procesa datos directamente, sino que está diseñada para integrarse con scripts JS
 * que la dinamizan (como index.js, mapUtils.js, ubicacionesAutocompletar.js).
 *
 * Controlador relacionado:
 * - IndexController@cargarPagina
 */
?>
<div class="container-fluid ">
    <div class="row">

        <!-- Contenedores Filtros -->
        <div class="col-0 col-md-3">

            <div class="row position-fixed d-lg-block d-none bg-light shadow-lg" id="row_filtros">
                <div class="col ">

                    <!-- Categorias -->
                    <div class="mt-5 pt-5 px-5 mb-4   ">
                        <h4 class="my-3">Categoria Publicaciones</h4>

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
                        <form id="form-filtros-desp" method="POST" class="ps-4 d-none d-md-block">

                            <!-- Tipo de anuncio -->
                            <h6 class="fw-bold fs-6">Tipo de anuncio</h6>
                            <select class="form-select" id="tipo_anuncio" name="tipo_anuncio">
                                <option value="">Seleccionar...</option>
                                <option value="venta">Venta</option>
                                <option value="alquiler">Alquiler</option>
                            </select>

                            <!-- Tipo de Inmueble -->
                            <h6 class="fw-bold mt-3 fs-6">Tipo de inmueble</h6>
                            <select class="form-select" id="tipo_inmueble" name="tipo_inmueble">
                                <option value="">Seleccionar...</option>
                                <option value="garaje">Garaje</option>
                                <option value="apartamento">Apartamento</option>
                                <option value="piso">Piso</option>
                                <option value="casa">Casa</option>
                                <option value="local">Local</option>
                                <option value="oficina">Oficina</option>
                                <option value="terreno">Terreno</option>
                                <option value="otro">Otro...</option>
                            </select>

                            <!-- Precio Inmueble -->
                            <h6 class="fw-bold mt-3 fs-6">Precio</h6>
                            <div class="row">
                                <div class="col">
                                    <select class="form-select" id="precio_min" name="precio_min">
                                        <option value="">Min.</option>
                                        <option value="50000">50 000 €</option>
                                        <option value="100000">100 000 €</option>
                                        <option value="150000">150 000 €</option>
                                        <option value="200000">200 000 €</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="precio_max" name="precio_max">
                                        <option value="">Max.</option>
                                        <option value="250000">250 000 €</option>
                                        <option value="400000">400 000 €</option>
                                        <option value="600000">600 000 €</option>
                                        <option value="1000000">1 000 000 €</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Habitaciones -->
                            <h6 class="fw-semibold mt-3 fs-6">Habitaciones</h6>
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
                            <h6 class="fw-bold mt-3 fs-6">Baños</h6>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="banos" id="bano-1" value="1">
                                <label class="btn btn-outline-primary" for="bano-1">1</label>

                                <input type="radio" class="btn-check" name="banos" id="bano-2" value="2">
                                <label class="btn btn-outline-primary" for="bano-2">2</label>

                                <input type="radio" class="btn-check" name="banos" id="bano-3" value="3">
                                <label class="btn btn-outline-primary" for="bano-3">3+</label>
                            </div>

                            <!-- Estado inmueble -->
                            <h6 class="fw-bold mt-3 fs-6">Estado</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="estado-nuevo"
                                    value="nuevo">
                                <label class="form-check-label" for="estado-nuevo">Nuevo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="estado-semi"
                                    value="semi-nuevo">
                                <label class="form-check-label" for="estado-semi">Semi-nuevo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="estado-usado"
                                    value="usado">
                                <label class="form-check-label" for="estado-usado">Usado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="estado-renovado"
                                    value="renovado">
                                <label class="form-check-label" for="estado-renovado">Renovado</label>
                            </div>

                            <!-- Características -->
                            <h6 class="fw-bold mt-3 fs-6">Características</h6>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ascensor"
                                            id="carac-ascensor" value="1">
                                        <label class="form-check-label" for="carac-ascensor">Ascensor</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="piscina"
                                            id="carac-piscina" value="1">
                                        <label class="form-check-label" for="carac-piscina">Piscina</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gimnasio"
                                            id="carac-gimnasio" value="1">
                                        <label class="form-check-label" for="carac-gimnasio">Gimnasio</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="garaje" id="carac-garaje"
                                            value="1">
                                        <label class="form-check-label" for="carac-garaje">Garaje</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terraza"
                                            id="carac-terraza" value="1">
                                        <label class="form-check-label" for="carac-terraza">Terraza</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jardin" id="carac-jardin"
                                            value="1">
                                        <label class="form-check-label" for="carac-jardin">Jardín</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="aire_acondicionado"
                                            id="carac-acondicionado" value="1">
                                        <label class="form-check-label" for="carac-acondicionado">Aire
                                            acondicionado</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="calefaccion"
                                            id="carac-calefaccion" value="1">
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
            <div class="row my-2 pt-2 d-lg-none bg-light position-fixed w-100 rounded rounded-bottom z-3 shadow-lg">
                <div class="container pt-3 mb-3 mb-md-5 rounded-bottom text-center text-body-success">
                    <h6>Categoria Publicaciones</h6>
                    <div class="btn-group d-flex px-3" role="group"
                        aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btn-habitantes-mob"
                            autocomplete="off">
                        <label class="btn btn-outline-success py-1 rounded-0 rounded-top rounded-bottom"
                            for="btn-habitantes-mob">Habitantes</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-propietario-mob"
                            autocomplete="off">
                        <label class="btn btn-outline-success py-1 rounded-0 rounded-top rounded-bottom"
                            for="btn-propietario-mob">Propietario</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-empresa-mob" autocomplete="off">
                        <label class="btn btn-outline-success py-1 rounded-0 rounded-top rounded-bottom"
                            for="btn-empresa-mob">Empresas</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENIDO PUBLICACIONES -->
        <div class="col-12 p-0 col-md-9 py-5 mt-5 mt-lg-0 mb-5 d-flex flex-column align-items-center overflow-auto" id="contenedor-principal">
        </div>

        <!-- Contenedor Mapa -->
        <div id="mapa" class="position-fixed end-0 bg-body shadow-lg rounded-bottom p-0 mt-4">
            <div id="mapLeaflet" class="w-100 h-75 px-2 mb-2"></div>

            <form class="form p-3 h-25 d-flex justify-content-center align-items-center bg-success rounded-bottom"
                id="formBuscarMapa">
                <div style="position: relative; width: 100%;">
                    <input id="inputBuscarMapa" name="display_name" class="form-control me-2" type="search"
                        placeholder="Buscar" autocomplete="off" />
                </div>
                <button class="btn btn-primary" type="submit">Buscar</button>

                <input type="hidden" name="latitud" id="inputLatitud" />
                <input type="hidden" name="longitud" id="inputLongitud" />
                <input type="hidden" name="calle" id="inputCalle" />
                <input type="hidden" name="barrio" id="inputBarrio" />
                <input type="hidden" name="ciudad" id="inputCiudad" />
                <input type="hidden" name="provincia" id="inputProvincia" />
                <input type="hidden" name="codigo_postal" id="inputCP" />
            </form>


        </div>


        <!-- Contenedor Botones Accion -->
        <div class="botones_accion position-fixed bottom-0 end-0 m-3" id="cont_btns_index">

            <!-- Contenedor para el Chat
            <div id="map-container" class="position-absolute top-50 end-0 translate-middle-y "> <button class="btn btn-light p-2 px-3 rounded-circle border border-1 border-success">
                    <i class="bi bi-chat-dots" style="font-size: 30px;"></i>
                </button>
            </div>
            -->

            <!-- Contenedor para boton del Mapa  -->

            <div id="btn-toggle-mapa" class="position-absolute bottom-0 end-0 ">
                <button id="btn-toggle-mapa"
                    class="btn btn-light p-2 px-3 rounded-circle border border-1 border-success">
                    <i class="bi bi-map" style="font-size: 30px;"></i>
                </button>
            </div>


        </div>

    </div>
</div>