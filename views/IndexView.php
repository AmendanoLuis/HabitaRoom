<?php

if (isset($_COOKIE['filtros'])) {
    $datos_filtros = json_decode($_COOKIE['filtros'], true);

    $tipo_inmueble = isset($datos_filtros['tipo-inmueble-desp']) ? $datos_filtros['tipo-inmueble-desp'] : (isset($datos_filtros['tipo-inmueble-lateral']) ? $datos_filtros['tipo-inmueble-lateral'] : '');

    $precio_min = isset($datos_filtros['precio-min-desp']) ? $datos_filtros['precio-min-desp'] : (isset($datos_filtros['precio-min-lateral']) ? $datos_filtros['precio-min-lateral'] : '500');
    $precio_max = isset($datos_filtros['precio-max-desp']) ? $datos_filtros['precio-max-desp'] : (isset($datos_filtros['precio-max-lateral']) ? $datos_filtros['precio-max-lateral'] : '20000');

    $habitaciones = isset($datos_filtros['habitaciones']) ? $datos_filtros['habitaciones'] : '';
    $banos = isset($datos_filtros['banos']) ? $datos_filtros['banos'] : '';

    $estado = isset($datos_filtros['estado']) ? $datos_filtros['estado'] : [];

    $caracteristicas = isset($datos_filtros['caracteristicas']) ? $datos_filtros['caracteristicas'] : [];
} else {
    echo "No se han encontrado los filtros en las cookies.";
}
?>

<div class="container-fluid text-light content">
    <div class="row ">

        <!-- Contenedores Filtros -->
        <div class="col-2 col-md-3">

            <!-- Categoria | >= Medium -->
            <div class="row mb-auto position-fixed d-lg-block d-none z-1 bg-light shadow-lg">
                <div class="container mt-4 pt-5 pb-4 px-5  mb-5 rounded-bottom text-body-secondary">
                    <h4 class="mb-3">Categoria Publicaciones</h4>

                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btn-habitantes-desk" autocomplete="off">
                        <label class="btn btn-outline-success" for="btn-habitantes-desk">Habitantes</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-propietario-desk" autocomplete="off">
                        <label class="btn btn-outline-success" for="btn-propietario-desk">Propietario</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-empresa-desk" autocomplete="off">
                        <label class="btn btn-outline-success" for="btn-empresa-desk">Empresas</label>
                    </div>
                </div>
            </div>

            <!-- Categoria | < Medium -->
            <div class="row my-2 pt-2 d-lg-none bg-light position-fixed z-1 shadow-lg">
                <div class="container py-4  mb-5 rounded-bottom text-center text-body-secondary">
                    <h5>Categoria</h5>
                    <h5 class="mb-3">Publicaciones</h5>
                    <div class="btn-group d-flex flex-column px-3" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btn-habitantes-mob" autocomplete="off">
                        <label class="btn btn-outline-secondary py-2 rounded-0 rounded-top" for="btn-habitantes-mob">Habitantes</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-propietario-mob" autocomplete="off">
                        <label class="btn btn-outline-secondary py-2 rounded-0" for="btn-propietario-mob">Propietario</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-empresa-mob" autocomplete="off">
                        <label class="btn btn-outline-secondary py-2 rounded-0 rounded-bottom" for="btn-empresa-mob">Empresas</label>
                    </div>
                </div>
            </div>

            <!-- Filtros | >= Medium -->
            <div class="row d-lg-block d-none position-fixed fixed-top" id="cont-filtros-desp">
                <div class="accordion accordion-flush">
                    <div class="accordion-item">

                        <!-- Cabecera Desplegable Formulario -->
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-success bg-opacity-75 p-3 rounded-end text-light fs-md-6 fs-sm-5"
                                type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                aria-expanded="true" aria-controls="flush-collapseOne" id="btn-desp-filtros">
                                Filtrar publicaciones
                            </button>
                        </h2>

                        <!-- Contenedor Desplegable Formulario -->
                        <div id="flush-collapseOne" class="accordion-collapse collapse show">
                            <div class="accordion-body">

                                <!-- Formulario Filtros -->
                                <form id="form-filtros-desp" method="POST">
                                    <div class="container ps-lg-2 p-1">
                                        <!-- Tipo Inmueble -->
                                        <h5 class="fw-bold fs-md-6 fs-sm-5">Tipo de Inmueble</h5>
                                        <select class="form-select" id="tipo-inmueble-desp" name="tipo-inmueble-desp">
                                            <option value="Seleccionar" <?php echo ($tipo_inmueble == 'Seleccionar') ? 'selected' : ''; ?>>Seleccionar</option>
                                            <option value="alquiler" <?php echo ($tipo_inmueble == 'alquiler') ? 'selected' : ''; ?>>Alquiler</option>
                                            <option value="venta" <?php echo ($tipo_inmueble == 'venta') ? 'selected' : ''; ?>>Venta</option>
                                            <option value="oficina" <?php echo ($tipo_inmueble == 'oficina') ? 'selected' : ''; ?>>Oficina</option>
                                        </select>

                                        <!-- Precio Inmueble -->
                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Precio</h5>
                                        <div class="row">
                                            <div class="col">
                                                <select class="form-select" id="precio-min-desp" name="precio-min-desp">
                                                    <option value="500" <?php echo ($precio_min == '500') ? 'selected' : ''; ?>>500</option>
                                                    <option value="1000" <?php echo ($precio_min == '1000') ? 'selected' : ''; ?>>1000</option>
                                                    <option value="2000" <?php echo ($precio_min == '2000') ? 'selected' : ''; ?>>2000</option>
                                                    <option value="3000" <?php echo ($precio_min == '3000') ? 'selected' : ''; ?>>3000</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select class="form-select" id="precio-max-desp" name="precio-max-desp">
                                                    <option value="5000" <?php echo ($precio_max == '5000') ? 'selected' : ''; ?>>5000</option>
                                                    <option value="10000" <?php echo ($precio_max == '10000') ? 'selected' : ''; ?>>10000</option>
                                                    <option value="15000" <?php echo ($precio_max == '15000') ? 'selected' : ''; ?>>15000</option>
                                                    <option value="20000" <?php echo ($precio_max == '20000') ? 'selected' : ''; ?>>20000</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Habitaciones -->
                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Habitación / Habitaciones</h5>
                                        <div class="btn-group" role="group" aria-label="Grupo de habitaciones">
                                            <input type="radio" class="btn-check" name="habitaciones" id="hab-desp-1" value="1" autocomplete="off" <?php echo ($habitaciones == '1') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="hab-desp-1">1</label>

                                            <input type="radio" class="btn-check" name="habitaciones" id="hab-desp-2" value="2" autocomplete="off" <?php echo ($habitaciones == '2') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="hab-desp-2">+2</label>

                                            <input type="radio" class="btn-check" name="habitaciones" id="hab-desp-3" value="3" autocomplete="off" <?php echo ($habitaciones == '3') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="hab-desp-3">+3</label>

                                            <input type="radio" class="btn-check" name="habitaciones" id="hab-desp-4" value="4" autocomplete="off" <?php echo ($habitaciones == '4') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="hab-desp-4">+4</label>
                                        </div>

                                        <!-- Baños -->
                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Baños</h5>
                                        <div class="btn-group" role="group" aria-label="Grupo de baños">
                                            <input type="radio" class="btn-check" name="banos" id="bano-desp-1" value="1" autocomplete="off" <?php echo ($banos == '1') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="bano-desp-1">1</label>

                                            <input type="radio" class="btn-check" name="banos" id="bano-desp-2" value="2" autocomplete="off" <?php echo ($banos == '2') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="bano-desp-2">+2</label>

                                            <input type="radio" class="btn-check" name="banos" id="bano-desp-3" value="3" autocomplete="off" <?php echo ($banos == '3') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="bano-desp-3">+3</label>
                                        </div>

                                        <!-- Estado inmueble -->
                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Estado</h5>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="estado-desp-1" name="estado[]" value="nuevo" <?php echo (in_array('nuevo', $estado)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="estado-desp-1">Nuevo</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="estado-desp-2" name="estado[]" value="semi-nuevo" <?php echo (in_array('semi-nuevo', $estado)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="estado-desp-2">Semi-nuevo</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="estado-desp-3" name="estado[]" value="usado" <?php echo (in_array('usado', $estado)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="estado-desp-3">Usado</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="estado-desp-4" name="estado[]" value="renovado" <?php echo (in_array('renovado', $estado)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="estado-desp-4">Renovado</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Características -->
                                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Características</h5>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="caracteristica-desp-1" name="caracteristicas[]" value="ascensor" <?php echo (in_array('ascensor', $caracteristicas)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="caracteristica-desp-1">Ascensor</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="caracteristica-desp-2" name="caracteristicas[]" value="piscina" <?php echo (in_array('piscina', $caracteristicas)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="caracteristica-desp-2">Piscina</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="caracteristica-desp-3" name="caracteristicas[]" value="gimnasio" <?php echo (in_array('gimnasio', $caracteristicas)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="caracteristica-desp-3">Gimnasio</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="caracteristica-desp-4" name="caracteristicas[]" value="garaje" <?php echo (in_array('garaje', $caracteristicas)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="caracteristica-desp-4">Garaje</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="caracteristica-desp-5" name="caracteristicas[]" value="terraza" <?php echo (in_array('terraza', $caracteristicas)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="caracteristica-desp-5">Terraza</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="caracteristica-desp-6" name="caracteristicas[]" value="jardin" <?php echo (in_array('jardin', $caracteristicas)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for "caracteristica-desp-6">Jardín</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="caracteristica-desp-7" name="caracteristicas[]" value="acondicionado" <?php echo (in_array('acondicionado', $caracteristicas)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="caracteristica-desp-7">Aire acondicionado</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="caracteristica-desp-8" name="caracteristicas[]" value="calefaccion" <?php echo (in_array('calefaccion', $caracteristicas)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="caracteristica-desp-8">Calefacción</label>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <!-- Boton Aplicar Filtros -->
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" id="enviar-formulario-desp" class="btn btn-primary">Aplicar Filtros</button>
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
        <div class="col-10 col-md-9  mt-5 d-flex flex-column align-items-center">

            <!-- PUBLICACION -->
            <?php if ($publicaciones): ?>
                <?php foreach ($publicaciones as $publicacion): ?>

                    <div class="card mb-4 shadow mx-auto ms-5 " id="contPublicacion">
                        <div class="row g-0 rounded-2">

                            <!-- Imagen de la propiedad -->
                            <div class="col-md-6 d-flex align-items-center justify-content-center position-relative" id="contImagenPubli">

                                <!-- Tipo publicitsta -->
                                <span class="badge position-absolute top-0 start-0 z-2 text-bg-light mt-3 ms-2 px-5"><?php echo $publicacion->tipo_publicitante; ?></span>

                                <?php
                                $imagenes = json_decode($publicacion->fotos); // Decodificar JSON -> PHP Array

                                if (!empty($imagenes) && is_array($imagenes)): ?>
                                    <div id="carousel<?php echo $publicacion->id; ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php
                                            foreach ($imagenes as $index => $imagen): ?>
                                                <div class="carousel-item rounded-start <?php echo $index === 0 ? 'active' : ''; ?>">
                                                    <img src="assets/uploads/<?php echo $imagen; ?>" class="rounded-start" id="imgPublicIndex" alt="Imagen de la propiedad">
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
                                    <img src="assets/uploads/<?php echo $publicacion->fotos; ?>" class="img-fluid rounded" alt="Imagen de la propiedad">
                                <?php endif; ?>

                            </div>


                            <!-- Contenido de la publicación -->
                            <div class="col-md-6 ps-3 pt-3 mb-3">


                                <!-- Titulo del precio -->
                                <h2 class="card-title precioPubli"><?php echo $publicacion->precio . "€"; ?></h2>

                                <!-- Título de la publicación -->
                                <h4 class="tituloPubli"><?php echo $publicacion->titulo; ?></h4>

                                <!-- Ubicación en color gris -->
                                <p class="text-muted ubicacionVivPubli"><?php echo $publicacion->ubicacion; ?></p>

                                <!-- Detalles adicionales -->
                                <p class="text-muted infoVivPubli">
                                    <?php echo $publicacion->habitaciones . " habs. | " . $publicacion->banos . " baños | " . $publicacion->superficie . " m²"; ?>
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

        <!-- Contenedor Mapa Ordenador-->
        <div id="mapa" class="position-fixed end-0 d-none d-xxl-block bg-light shadow-lg rounded-bottom p-0 pt-4">
            <iframe class="w-100 h-75 px-2 mb-2" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10694.649359839766!2d-3.584114235826003!3d37.16367693815794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71e3532fc629bb%3A0x3f04a1335378ec94!2sAsador%20Curro!5e0!3m2!1ses!2ses!4v1739023651029!5m2!1ses!2ses"></iframe>
            <form class="form p-3 d-flex justify-content-center align-items-center bg-success bg-opacity-75 rounded-bottom" id="formBuscarMapa">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </form>
        </div>

        <!-- Contenedor para el Chat flotante redondo -->
        <div id="chat" class="position-fixed bottom-0 end-0 m-3">
            <button class="btn btn-light p-0" style="border-radius: 50%; width: 100%; height: 100%;">
                <i class="bi bi-chat-dots" style="font-size: 30px;"></i> <!-- Icono del chat -->
            </button>
        </div>

    </div>
</div>