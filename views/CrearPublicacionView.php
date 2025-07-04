<?php
/**
 * Vista: Crear Publicación
 *
 * Esta vista contiene el formulario para que un usuario pueda crear una nueva publicación de vivienda.
 * Está diseñada con Bootstrap 5 y conectada a scripts que validan y procesan el formulario (crearPublicacion.js).
 *
 * Elementos destacados:
 * - Selección de tipo de inmueble y tipo de anuncio.
 * - Mapa Leaflet para ubicación.
 * - Campos para habitaciones, baños, precio, título, superficie y descripción.
 * - Características adicionales (checkboxes).
 * - Carga de imágenes y selección del tipo de contacto deseado.
 *
 * Dependencias:
 * - JavaScript: crearPublicacion.js (validación, envío AJAX, preview de imágenes)
 * - Bootstrap + Bootstrap Icons
 * - Leaflet.js para el mapa interactivo
 *
 * Requiere autenticación del usuario y es cargada por CrearPublicacionController@cargarFormulario.
 */
?>

<div class="container my-md-5 d-flex flex-column align-items-center text-light " id="contenedor-principal">

    <div class="row text-dark">
        <div class="col-auto mt-3 bg-white py-md-3 px-5 rounded shadow-lg" style="min-width:550px;">

            <!-- Formulario -->
            <form class="col-12 mt-md-4 bg-white py-3 px-3 px-md-5 rounded shadow-lg" method="POST" id="form_crear_publi" enctype="multipart/form-data">
                <!-- Tipo de inmueble -->
                <div>

                    <div class="container">
                        <h5 class="mt-3 fs-4">Tipo de inmueble</h5>

                        <div class="form-group mb-4 position-relative mt-4 mb-3">

                            <div class="mb-3 position-relative">
                                <label for="tipo_inmueble" id="label_tipo_inmueble"
                                    class="position-absolute top-0 start-0 pt-2">Tipo de inmueble</label>
                                <select name="tipo_inmueble" class="form-select pt-4 tipo_inmueble " id="tipo_inmueble">
                                    <option value="garaje">Garaje</option>
                                    <option value="apartamento">Apartamento</option>
                                    <option value="piso">Piso</option>
                                    <option value="casa">Casa</option>
                                    <option value="local">Local</option>
                                    <option value="oficina">Oficina</option>
                                    <option value="terreno">Terreno</option>
                                    <option value="otro">Otro...</option>
                                </select>
                            </div>

                            <!-- Tipo de anuncio -->
                            <div class="mt-4 mb-3">
                                <h5 for="tipo_anuncio" id="label_tipo_anuncio" class="mt-4 fs-4">Tipo de anuncio</h5>

                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="tipo_anuncio"
                                            id="tipo_alquiler" value="alquiler" checked>
                                        <label for="tipo_alquiler">Alquiler</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo_anuncio" value="venta"
                                            id="tipo_venta">
                                        <label for="tipo_venta">Venta</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- Ubicación -->
                    <div class="container my-3 mt-4">
                        <h5 class="mb-3 fs-4">Ubicación</h5>
                        <div class="d-flex flex-column align-items-center mx-auto mt-3 w-100">

                            <div id="mapLeaflet" class="w-100 rounded"></div>

                            <div id="formBuscarMapa"
                                class="d-flex flex-column justify-content-center align-items-center">
                                <div class="input-group mb-3">
                                    <input id="inputBuscarMapa" class="form-control rounded" type="search"
                                        name="ubicacion" placeholder="Buscar" autocomplete="off" required />
                                </div>

                                <input type="hidden" name="latitud" id="inputLatitud" />
                                <input type="hidden" name="longitud" id="inputLongitud" />
                                <input type="hidden" name="calle" id="inputCalle" />
                                <input type="hidden" name="barrio" id="inputBarrio" />
                                <input type="hidden" name="ciudad" id="inputCiudad" />
                                <input type="hidden" name="provincia" id="inputProvincia" />
                                <input type="hidden" name="codigo_postal" id="inputCP" />
                            </div>

                        </div>
                    </div>

                    <!-- Titulo y Precio -->
                    <div class="container mt-4 mb-3">
                        <div class="row">
                            <div class="col-6">

                                <!-- Titulo  -->
                                <h5 class="mb-3 fs-4">Título</h5>
                                <div class="input-group flex-nowrap ">
                                    <input type="text" class="form-control" placeholder="Piso en el dentro de..."
                                        aria-label="Username" aria-describedby="addon-wrapping" name="titulo"
                                        id="titulo" required>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column align-items-end">

                                <!-- Precio -->
                                <div class="w-75 mb-3">
                                    <h5 class="mb-3 fs-4">Precio</h5>
                                    <div class="input-group">
                                        <input type="number" class="form-control " placeholder="400" name="precio"
                                            id="precio" aria-label="Precio" aria-describedby="addon-wrapping" required>
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
                                    <button type="button"
                                        class="btn btn-outline-success  fs-5 rounded-circle px-3 fw-bold"
                                        id="btn_menos_hab"> - </button>
                                    <span id="num_habitaciones" class="mx-3 pe-1" data-name="num_habitaciones"> 0
                                    </span>
                                    <button type="button"
                                        class="btn btn-outline-success  fs-5 rounded-circle ps-3 pe-3 fw-bold"
                                        id="btn_mas_hab"> + </button>
                                </div>
                            </div>
                            <!-- Número de baños -->
                            <div class="ms-5">
                                <h5 class="mb-3 fs-4">Baños</h5>
                                <div class="d-flex align-items-center mt-2 ">
                                    <button type="button"
                                        class="btn btn-outline-success  fs-5 rounded-circle px-3 fw-bold"
                                        id="btn_menos_banos">-</button>
                                    <span id="num_banos" class="mx-3 pe-1" data-name="num_banos">0</span>
                                    <button type="button"
                                        class="btn btn-outline-success  fs-5 rounded-circle ps-3 pe-3 fw-bold"
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
                                        <input type="checkbox" class="btn-check" id="ascensor" name="ascensor"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 rounded-0"
                                            for="ascensor">Ascensor</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="piscina" name="piscina"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 rounded-0"
                                            for="piscina">Piscina</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="gimnasio" name="gimnasio"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 rounded-0"
                                            for="gimnasio">Gimnasio</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="garaje" name="garaje"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 rounded-0"
                                            for="garaje">Garaje</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="terraza" name="terraza"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 rounded-0"
                                            for="terraza">Terraza</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="jardin" name="jardin"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 rounded-0"
                                            for="jardin">Jardín</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="aire_acondicionado"
                                            name="aire_acondicionado" autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 rounded-0"
                                            for="aire_acondicionado">Aire Acondicionado</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="calefaccion" name="calefaccion"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 rounded-0"
                                            for="calefaccion">Calefacción</label>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <h5 class="card-title fs-4">Estado</h5>
                                <div class="mt-2 mb-3 btn-group flex-wrap" role="group" aria-label="Estado">
                                    <input type="radio" class="btn-check" name="estado" id="nuevo" value="nuevo"
                                        autocomplete="off">
                                    <label class="btn btn-outline-success" for="nuevo">Nuevo</label>
                                    <input type="radio" class="btn-check" name="estado" id="semi_nuevo"
                                        value="semi_nuevo" autocomplete="off" checked>
                                    <label class="btn btn-outline-success" for="semi_nuevo">Semi-nuevo</label>
                                    <input type="radio" class="btn-check" name="estado" id="usado" value="usado"
                                        autocomplete="off">
                                    <label class="btn btn-outline-success" for="usado">Usado</label>
                                    <input type="radio" class="btn-check" name="estado" id="renovado" value="renovado"
                                        autocomplete="off">
                                    <label class="btn btn-outline-success" for="renovado">Renovado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Superficie construida -->
                    <div class="container mt-5 mb-3">
                        <h5 class="mb-3 fs-4">Superficie construida <span class="text-muted">(opcional)</span></h5>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control border border-1" id="superficie" name="superficie"
                                aria-label="Superficie">
                            <span class="input-group-text border border-1"> m²</span>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="container mt-5 mb-3">
                        <h5 class="mb-3 fs-4">Descripción</h5>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="6"
                            placeholder="Proporciona una descripción detallada..." required></textarea>
                    </div>

                    <!-- Fotos y vídeos -->
                    <div class="container mt-5 mb-3">
                        <h5 class="mb-3 fs-4">Fotos y vídeos <span class="text-muted">(opcional)</span></h5>
                        <div class="border rounded p-4 text-center mt-3 position-relative" id="upload-box">

                            <!-- Contenedor para imagen o placeholder -->
                            <div id="preview-area" class="mb-3">
                                <div id="upload-placeholder">
                                    <i class="bi bi-camera fs-1 d-block mb-2"></i>
                                    <p class="mb-0">Añade fotos de la vivienda</p>
                                </div>
                            </div>

                            <!-- Input y label -->
                            <input class="d-none" type="file" id="file_input" name="imagenes" multiple>
                            <label for="file_input" class="btn btn-outline-dark">Seleccionar</label>

                        </div>
                    </div>


                    <!-- Contacto -->
                    <div class="container mt-5 mb-3">
                        <h5 class="mb-3 fs-4">Contacto <span class="text-muted">(opcional)</span></h5>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fs-5 mb-2">Tipo de contacto</h5>
                                <div class="row g-0 mb-4">
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="contacto_mensaje"
                                            name="contacto_mensaje" autocomplete="off" checked>
                                        <label class="btn btn-outline-success w-100 rounded-0"
                                            for="contacto_mensaje">Mensaje</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="contacto_email"
                                            name="contacto_email" autocomplete="off">
                                        <label class="btn btn-outline-success w-100 rounded-0"
                                            for="contacto_email">Email</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="btn-check" id="contacto_whatsapp"
                                            name="contacto_whatsapp" autocomplete="off">
                                        <label class="btn btn-outline-success w-100 rounded-0"
                                            for="contacto_whatsapp">Whatsapp</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="container my-5 mb-3 text-center">
                        <button type="submit" class="btn w-100 p-2 shadow btn_soft_green_hr btn-success"
                            id="btn_crear_publi" name="btn_crear_publi">Publicar</button>
                    </div>

            </form>
        </div>
    </div>
</div>