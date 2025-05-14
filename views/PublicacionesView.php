<!-- PUBLICACION -->
<?php if ($publicaciones): ?>
    <?php
    // Asegurarse de que $publicaciones_guardadas esté definido y sea un array
    $publicaciones_guardadas = $publicaciones_guardadas ?? [];

    // Obtener los IDs de publicaciones guardadas (solo si hay alguna)
    $ids_guardados = array_map(
        function ($pub) {
            return $pub->id;
        },
        $publicaciones_guardadas
    );

    foreach ($publicaciones as $publicacion):
        $isGuardado = in_array($publicacion->id, $ids_guardados);
    ?>
        <div class="card mb-4 shadow mx-auto ms-5 contenedor-publicacion" data-id="<?php echo $publicacion->id; ?>">
            <!-- Enlace solo para la parte que debe ser clicable -->
            <a href="/HabitaRoom/publicacionusuario?id=<?php echo $publicacion->id; ?>" class="text-decoration-none text-reset">
                <div class="row g-0 rounded-2">

                    <!-- Imagen de la propiedad -->
                    <div class="col-md-6 d-flex align-items-center justify-content-center position-relative" id="contImagenPubli">
                        <span class="badge shadow-sm position-absolute top-0 start-0 z-2 text-bg-light mt-3 ms-2 px-5">
                            <?php echo $publicacion->tipo_publicitante; ?>
                        </span>

                        <?php
                        $imagenes = json_decode($publicacion->fotos);
                        if (!empty($imagenes) && is_array($imagenes)): ?>
                            <div id="carousel<?php echo $publicacion->id; ?>" class="carousel slide carousel-fade " data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($imagenes as $index => $imagen): ?>
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
                            <img src="assets/uploads/img_publicacion/imgPublicacionBase.png" class="img-fluid rounded" alt="Imagen de la propiedad">
                        <?php endif; ?>
                    </div>

                    <!-- Contenido de la publicación -->
                    <div class="col-md-6 ps-3 pt-3 mb-3">
                        <h2 class="card-title precioPubli">
                            <?php echo number_format((float)$publicacion->precio, 2, ',', '.') . " €"; ?>
                        </h2>

                        <h4 class="tituloPubli"><?php echo htmlspecialchars(ucfirst(strtolower($publicacion->titulo))); ?></h4>

                        <p class="text-muted ubicacionVivPubli"><?php echo htmlspecialchars($publicacion->ubicacion); ?></p>

                        <p class="text-muted infoVivPubli">
                            <?php
                            $detalles = [];

                            if (!empty($publicacion->habitaciones) && $publicacion->habitaciones > 0) {
                                $detalles[] = $publicacion->habitaciones . " habs.";
                            }

                            if (!empty($publicacion->banos) && $publicacion->banos > 0) {
                                $detalles[] = $publicacion->banos . " baños";
                            }

                            if (!empty($publicacion->superficie) && $publicacion->superficie > 0) {
                                $detalles[] = $publicacion->superficie . " m²";
                            }

                            echo !empty($detalles) ? implode(" | ", $detalles) : "No disponible";
                            ?>
                        </p>

                        <p class="card-text descripccionPubli">
                            <?php echo nl2br(htmlspecialchars($publicacion->descripcion)); ?>
                        </p>

                        <!-- Opcional: Botones dentro del enlace, aunque no recomendado si quieres interacción separada -->
                        <div class="mt-auto d-flex gap-2">
                            <span class="btn btn-primary btn-sm disabled">Contactar</span>
                            <span class="btn btn-outline-secondary btn-sm disabled">Mensaje</span>
                            <span class="btn btn-outline-success btn-sm disabled">WhatsApp</span>
                        </div>
                    </div>

                </div>
            </a>

            <div class="icono-guardar position-absolute top-0 end-0 m-3 me-4 z-999"
                id="icono-guardar"
                data-id-publicacion="<?php echo $publicacion->id; ?>">
                <i class="guardar-icono fs-3 bi <?php echo $isGuardado ? 'bi-bookmark-fill text-warning' : 'bi-bookmark'; ?>"
                    style="cursor: pointer;"></i>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-warning w-75 mx-auto" role="alert">
        <?php if (!empty($filtros)): ?>
            <div class="text-center">
                <h4 class="alert-heading"><i class="bi bi-exclamation-triangle-fill me-2"></i>No se encontraron resultados</h4>
                <p class="mb-3">No se encontraron publicaciones que coincidan con los filtros aplicados.</p>
            </div>
        <?php else: ?>
            <div class="text-center">
                <h4 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i>Sin publicaciones disponibles</h4>
                <p>Actualmente no hay publicaciones para mostrar.</p>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>