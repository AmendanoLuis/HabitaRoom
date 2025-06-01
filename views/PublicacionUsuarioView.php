<?php
/**
 * Vista: Publicacion Usuario View
 *
 * Muestra los detalles completos de una única publicación seleccionada.
 * 
 * Características principales:
 * - Carousel de imágenes de la publicación (usa Bootstrap Carousel)
 *   - Si no hay imágenes, muestra una imagen base por defecto.
 * - Muestra título y precio formateado en euros.
 * - Muestra ubicación con formato título.
 * - Lista de detalles: habitaciones, baños, superficie, con iconos.
 * - Descripción con salto de línea y escapado de HTML para seguridad.
 * - Botones para contactar y WhatsApp (funcionalidad no implementada aquí).
 * - Botón para volver al listado principal.
 *
 * Variables esperadas:
 * - $publicacion: objeto con los datos completos de la publicación, con propiedades:
 *      - titulo, precio, ubicacion, habitaciones, banos, superficie, descripcion, fotos (JSON string)
 *
 * Uso de constantes:
 * - BASE_URL para rutas base de la web.
 *
 * @package HabitaRoom\Views
 */

// Solo asignamos una vez el valor de $imgs.
$imgs = !empty($publicacion->fotos) ? json_decode($publicacion->fotos) : [];
?>

<div class="row justify-content-center mt-5">
    <div class="col-lg-9 mt-4">

        <!-- Card principal -->
        <div class="card mb-4 shadow">
            <div class="row g-0">

                <!-- Carousel imágenes -->
                <div class="col-md-7">
                    <?php if (count($imgs)): ?>
                        <div id="carouselPubli" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-inner h-100 rounded-start">
                                <?php foreach ($imgs as $i => $img): ?>
                                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?> h-100">
                                        <img src="<?= BASE_URL ?>/assets/uploads/img_publicacion/<?= $img ?>"
                                            class="d-block w-100 h-100 object-fit-cover"
                                            alt="Imagen <?= $i + 1 ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPubli" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselPubli" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    <?php else: ?>
                        <img src="<?= BASE_URL ?>/assets/uploads/img_publicacion/imgPublicacionBase.png"
                            class="img-fluid rounded-start" alt="Sin imágenes">
                    <?php endif; ?>

                </div>

                <!-- Contenido detalle -->
                <div class="col-md-5 p-4 d-flex flex-column">
                    <!-- Título y precio -->
                    <div class="mb-3">
                        <h3 class="card-title"><?= ucfirst(htmlspecialchars($publicacion->titulo)) ?></h3>
                        <h4 class="text-success"><?= number_format($publicacion->precio, 2, ',', '.') ?> €</h4>
                    </div>

                    <!-- Ubicación -->
                    <p class="text-muted mb-2">
                        <i class="bi bi-geo-alt"></i>
                        <?php
                        $ubic = htmlspecialchars($publicacion->ubicacion, ENT_QUOTES, 'UTF-8');
                        echo mb_convert_case($ubic, MB_CASE_TITLE, 'UTF-8');
                        ?>
                    </p>
                    <!-- Detalles -->
                    <ul class="list-inline mb-3">
                        <?php if ($publicacion->habitaciones): ?>
                            <li class="list-inline-item badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-door-closed"></i> <?= $publicacion->habitaciones ?> hab.
                            </li>
                        <?php endif; ?>
                        <?php if ($publicacion->banos): ?>
                            <li class="list-inline-item badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-badge-wc"></i> <?= $publicacion->banos ?> baños
                            </li>
                        <?php endif; ?>
                        <?php if ($publicacion->superficie): ?>
                            <li class="list-inline-item badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-arrows-fullscreen"></i> <?= $publicacion->superficie ?> m²
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Descripción -->
                    <div class="flex-fill mb-3">
                        <h5>Descripción</h5>
                        <p class="small"> <?= ucfirst(nl2br(htmlspecialchars($publicacion->descripcion))) ?></p>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-success"><i class="bi bi-chat-dots"></i> Contactar</button>
                        <button class="btn btn-outline-success"><i class="bi bi-whatsapp"></i> WhatsApp</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Volver al listado -->
        <div class="text-center">
            <a href="<?= BASE_URL ?>/index" class="btn btn-outline-success">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

    </div>
</div>