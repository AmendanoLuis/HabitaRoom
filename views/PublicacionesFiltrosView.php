<?php
/**
 * Vista: Perfil View
 *

*/
 ?>

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
                                $imagenes = json_decode($publicacion->fotos); 

                                if (!empty($imagenes) && is_array($imagenes)): ?>
                                    <div id="carousel<?php echo $publicacion->id; ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php
                                            foreach ($imagenes as $index => $imagen): ?>
                                                <div class="carousel-item rounded-start <?php echo $index === 0 ? 'active' : ''; ?>">
                                                    <img src="assets/uploads/img_publicacion/<?php echo $imagen; ?>" class="rounded-start" id="imgPublicIndex" alt="Imagen de la propiedad">
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
                                    <img src="assets/uploads/img_publicacion/<?php echo $publicacion->fotos; ?>" class="img-fluid rounded" alt="Imagen de la propiedad">
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
                    No se encontraron publicaciones que coincidan con los filtros aplicados.
                    <?php if (!empty($filtros)): ?>
                        <div class="alert alert-info" role="alert">
                            <strong>Filtros aplicados:</strong>
                            <ul>
                                <?php foreach ($filtros as $clave => $valor): ?>
                                    <li><?php echo htmlspecialchars($clave); ?>: <?php echo htmlspecialchars($valor); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
