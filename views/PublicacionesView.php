<?php
/**
 * Vista: Publicaciones View
 *
 * Muestra una lista de publicaciones disponibles o guardadas por el usuario.
 * Cada publicación se representa en una tarjeta con:
 * - Imagen principal (la primera del array de fotos o imagen base si no hay)
 * - Tipo de publicitante mostrado en un badge
 * - Precio formateado en euros
 * - Título capitalizado y seguro contra XSS
 * - Ubicación en formato título
 * - Detalles de la propiedad (habitaciones, baños, superficie) o "No disponible"
 * - Descripción segura con saltos de línea
 * - Botones visuales (deshabilitados) para acciones de contacto
 * - Icono de guardado (bookmark) que cambia según si la publicación está guardada por el usuario
 *
 * Soporta:
 * - Comprobación si existen publicaciones para mostrar
 * - Mensajes informativos si no hay resultados, con distinción si se usaron filtros o no
 * - Seguridad con htmlspecialchars y manejo seguro de JSON en fotos
 *
 * Variables esperadas:
 * - $publicaciones: array de objetos con las publicaciones a mostrar
 * - $publicaciones_guardadas: array con publicaciones guardadas por el usuario (opcional)
 * - $filtros: array con filtros aplicados (opcional)
 *
 * @package HabitaRoom\Views
 */
?>

<!-- PUBLICACION -->
<?php if ($publicaciones): ?>
    <?php
    $publicaciones_guardadas = $publicaciones_guardadas ?? [];
    $ids_guardados = array_map(fn($pub) => $pub->id, $publicaciones_guardadas);
    foreach ($publicaciones as $publicacion):
        $isGuardado = in_array($publicacion->id, $ids_guardados);
        // Decode fotos safely, default to empty array
        $rawFotos = isset($publicacion->fotos) && !empty($publicacion->fotos) ? $publicacion->fotos : '[]';
        $imagenes = json_decode($rawFotos, true) ?: [];
    ?>
        <div class="card mb-4 shadow mx-auto mt-5 mt-md-0 ms-md-5 contenedor-publicacion" data-id="<?php echo $publicacion->id; ?>">
            <!-- Enlace solo para la parte que debe ser clicable -->
            <a href="/HabitaRoom/publicacionusuario?id=<?php echo $publicacion->id; ?>" class="text-decoration-none text-reset">
                <div class="row g-0 rounded-2">

                    <!-- Imagen de la propiedad -->
                    <div class="col-md-6 d-flex align-items-center justify-content-center position-relative p-0" id="contImagenPubli">
                        <span class="badge shadow-sm position-absolute top-0 start-0 z-2 text-bg-light mt-3 ms-2 px-5">
                            <?php echo $publicacion->tipo_publicitante; ?>
                        </span>

                        <?php
                        $imagenes = isset($publicacion->fotos) ? json_decode($publicacion->fotos) : [];
                        if (!empty($imagenes) && is_array($imagenes)): ?>
                            <div id="<?php echo $publicacion->id; ?>">
                                <div class=" <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="assets/uploads/img_publicacion/<?php echo $imagenes[0]; ?>" class="w-100 h-100 rounded-start" style="object-fit: cover;" id="imgPublicIndex" alt="Imagen de la propiedad">
                                </div>
                            </div>
                        <?php else: ?>
                            <img src="assets/uploads/img_publicacion/imgPublicacionBase.png" class="img-fluid rounded" alt="Imagen de la propiedad">
                        <?php endif; ?>
                    </div>

                    <!-- Contenido de la publicación -->
                    <div class="col-md-6 ps-3 pt-3 mb-3">

                        <!-- Precio de la publicación -->
                        <h2 class="card-title precioPubli">
                            <?php echo number_format((float)$publicacion->precio, 2, ',', '.') . " €"; ?>
                        </h2>

                        <!-- Título de la publicación -->
                        <h4 class="tituloPubli"><?php echo htmlspecialchars(ucfirst($publicacion->titulo)); ?></h4>

                        <!-- Ubicación de la propiedad -->
                        <p class="text-muted ubicacionVivPubli">
                            <?php
                            $ubic = htmlspecialchars($publicacion->ubicacion, ENT_QUOTES, 'UTF-8');
                            echo mb_convert_case($ubic, MB_CASE_TITLE, 'UTF-8');
                            ?>
                        </p>

                        <!-- Detalles de la propiedad -->
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

                        <!-- Descripción de la publicación -->
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