<div class="container-fluid text-light content">
    <div class="row ">

        <!-- FILTROS -->
        <div class="col-0 col-md-3">

            <!-- Contenedor de Categoria | >= Medium -->
            <div class="row mb-auto position-fixed d-lg-block d-none z-1">
                <div class="container py-5 pb-4 px-5 bg-black bg-opacity-25 shadow-lg mb-5 rounded-bottom">
                    <h4 class="mb-3">Filtrar Publicaciones </h4>

                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1">Habitantes </label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">Propietario</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3">Empresas </label>
                    </div>
                </div>
            </div>

            <!-- Contenedor de Categoria | < Medium -->
            <div class="row mb-auto d-lg-none position-fixed z-1">
                <div class="container py-4 bg-black bg-opacity-25 shadow-lg mb-5 rounded-bottom text-center">
                    <h5>Filtrar</h5>
                    <h5 class="mb-3">Publicaciones</h5>
                    <div class="btn-group d-flex flex-column px-3" role="group"
                        aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                        <label class="btn btn-outline-primary py-2 rounded-0 rounded-top" for="btnradio1">Habitantes
                        </label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary py-2 rounded-0" for="btnradio2">Propietario</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary py-2 rounded-0 rounded-bottom"
                            for="btnradio3">Empresas
                        </label>
                    </div>
                </div>
            </div>

            <!-- Contenedor de Filtros | >= Medium -->
            <div class="row d-lg-block d-none position-fixed fixed-bottom " id="cont-filtros-desp">
                <div class="accordion accordion-flush">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-success bg-opacity-50 fs-md-6 fs-sm-5"
                                type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                aria-expanded="false" aria-controls="flush-collapseOne" id="btn-desp-filtros">
                                Filtros
                            </button>
                        </h2>
                        <!-- Formulario Filtros -->
                        <div id="flush-collapseOne" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <form action="#">
                                    <div class="container ps-lg-2 p-1">
                                        <h5 class="fw-bold fs-md-6 fs-sm-5">Tipo de Inmueble</h5>
                                        <select class="form-select">
                                            <option selected>Alquiler, etc</option>
                                        </select>

                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Precio</h5>
                                        <div class="row">
                                            <div class="col">
                                                <select class="form-select">
                                                    <option selected>Min</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select class="form-select">
                                                    <option selected>Max</option>
                                                </select>
                                            </div>
                                        </div>

                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Habitación / Habitaciones</h5>
                                        <div class="btn-group" role="group" aria-label="Grupo de habitaciones">
                                            <input type="radio" class="btn-check" name="habitaciones" id="hab1"
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="hab1">1</label>

                                            <input type="radio" class="btn-check" name="habitaciones" id="hab2"
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="hab2">+2</label>

                                            <input type="radio" class="btn-check" name="habitaciones" id="hab3"
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="hab3">+3</label>

                                            <input type="radio" class="btn-check" name="habitaciones" id="hab4"
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="hab4">+4</label>
                                        </div>

                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Baños</h5>
                                        <div class="btn-group" role="group" aria-label="Grupo de baños">
                                            <input type="radio" class="btn-check" name="banos" id="bano1"
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="bano1">1</label>

                                            <input type="radio" class="btn-check" name="banos" id="bano2"
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="bano2">+2</label>

                                            <input type="radio" class="btn-check" name="banos" id="bano3"
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="bano3">+3</label>
                                        </div>

                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Estado</h5>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                            </div>
                                        </div>

                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Características</h5>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">Checkbox</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- CONTENIDO PRINICIPAL -->
        <div class="col-12 col-md-9  mt-5 d-flex flex-column align-items-center">

            <!-- PUBLICACION -->
            <?php if ($publicaciones): ?>
                <?php foreach ($publicaciones as $publicacion): ?>

                    <div class="card my-2 shadow mx-auto" id="contPublicacion">
                        <div class="row g-0">

                            <!-- Imagen de la propiedad -->
                            <div class="col-lg-6 d-flex align-items-center justify-content-center" id="contImagenPubli">

                                <?php
                                $imagenes = json_decode($publicacion->imagenes); // Decodificar JSON -> PHP Array

                                if (!empty($imagenes) && is_array($imagenes)): ?>
                                    <div id="carousel<?php echo $publicacion->id; ?>" class="carousel slide carousel-fade">
                                        <div class="carousel-inner">
                                            <?php 
                                            foreach ($imagenes as $index => $imagen): ?>
                                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                    <img src="assets/uploads/<?php echo $imagen; ?>" class="d-block w-100 rounded" id="imgPublicIndex" alt="Imagen de la propiedad">
                                                </div>

                                            <?php endforeach; ?>

                                        </div>

                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $publicacion->id; ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>

                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $publicacion->id; ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>

                                <?php else: ?>
                                    <img src="assets/uploads/<?php echo $publicacion->imagenes; ?>" class="img-fluid rounded" alt="Imagen de la propiedad">
                                <?php endif; ?>

                            </div>


                            <!-- Contenido de la publicación -->
                            <div class="col-lg-6">

                                <!-- Tipo publicitsta -->
                                <span class="badge bg-primary mb-2 w-50"><?php echo $publicacion->tipo_usuario_publicacion; ?></span>

                                <!-- Titulo del precio -->
                                <h3 class="card-title precioPubli"><?php echo $publicacion->precio . "€"; ?></h3>

                                <!-- Título de la publicación -->
                                <h4 class="tituloPubli"><?php echo $publicacion->titulo; ?></h4>

                                <!-- Ubicación en color gris -->
                                <p class="text-muted ubicacionVivPubli"><?php echo $publicacion->direccion_ubicacion; ?></p>

                                <!-- Detalles adicionales -->
                                <p class="text-muted infoVivPubli">
                                    <?php echo $publicacion->habitaciones . " habs. | " . $publicacion->banos . " baños | " . $publicacion->superficie_m2 . " m²"; ?>
                                </p>

                                <!-- Descripción breve -->
                                <p class="card-text descripccionPubli "><?php echo $publicacion->descripcion; ?></p>

                                <!-- Botones de acción -->
                                <!-- Añadir funciones por boton -->
                                <div class="mt-auto d-flex gap-2 ">

                                    <!-- Abrir modulo, formulario de contacto del usuario de publicación -->
                                    <button class="btn btn-primary btn-sm">Contactar</button>

                                    <!-- Abrir mensaje directo con el usuario de la publicación -->
                                    <button class="btn btn-outline-secondary btn-sm">Mensaje</button>

                                    <!-- Abrir model con contacto de WhatsApp del usuario de la publicación , si este lo ha permitido -->
                                    <!-- Si no lo ha permitido aparecerá deshabilitado -->
                                    <button class="btn btn-outline-success btn-sm">WhatsApp</button>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    No hay publicaciones disponibles.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>