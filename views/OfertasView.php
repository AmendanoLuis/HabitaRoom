<div class="offer-wrapper mx-auto" id="ofertasContainer">

<!-- Contenido de la publicación -->
  <div class="container-fluid mt-4 text-light offer-container">
    <div class="row offer-row">

    <!-- Aquí se cargan las ofertas -->
      <?php if (!empty($ofertas)): ?>
        <?php foreach ($ofertas as $publicacion): ?>
          <div class="col-12 col-sm-6 col-md-3">

            <!-- Tarjeta de la oferta -->
            <div class="card mb-4 shadow-lg offer-card h-100 d-flex flex-column offerContenedorPublicacion" data-id="<?= $publicacion->id; ?>">
              <a href="/HabitaRoom/publicacionusuario?id=<?php echo $publicacion->id; ?>" class="text-decoration-none text-reset flex-grow-1 d-flex flex-column">

                <!-- Imagen de la propiedad -->
                <?php
                $imagenes = json_decode($publicacion->fotos);
                $primera = (!empty($imagenes) && is_array($imagenes)) ? $imagenes[0] : 'imgPublicacionBase.png';
                ?>
                <div class="card-img-top overflow-hidden" id="offer-img-container" style="height: 50%;">
                  <img src="assets/uploads/img_publicacion/<?= htmlspecialchars($primera); ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="Imagen de la propiedad">
                  <span class="badge shadow-sm position-absolute top-0 start-0 z-2 text-bg-light mt-3 ms-2 px-3">
                    <?= htmlspecialchars($publicacion->tipo_publicitante); ?>
                  </span>
                </div>

                <!-- Contenido de la publicación -->
                <div class="card-body mx-2 flex-grow-2 d-flex flex-column justify-content-between" style="height: 50%;">
                  <div>
                    <!-- Precio y título de la publicación -->
                    <h2 class="card-title text-start offer-price fs-4 mb-2"><?= number_format((float)$publicacion->precio, 2, ',', '.') . ' €'; ?></h2>
                    <h4 class="offer-title fs-5 mb-1"><?= htmlspecialchars($publicacion->titulo); ?></h4>
                    
                    <!-- Ubicación y detalles de la propiedad -->
                    <p class="text-muted offer-location fs-6 mb-1"><?= htmlspecialchars($publicacion->ubicacion); ?></p>
                    <p class="text-muted offer-info fs-6 mb-2">
                      <?php
                      $detalles = [];
                      if (!empty($publicacion->habitaciones)) {
                        $detalles[] = $publicacion->habitaciones . ' habs.';
                      }
                      if (!empty($publicacion->banos)) {
                        $detalles[] = $publicacion->banos . ' baños';
                      }
                      if (!empty($publicacion->superficie)) {
                        $detalles[] = $publicacion->superficie . ' m²';
                      }
                      echo !empty($detalles) ? implode(' | ', $detalles) : 'No disponible';
                      ?>
                    </p>
                  </div>

                  <!-- Descripción -->
                  <div class="offer-description-container flex-grow-1 d-flex flex-column justify-content-end mt-1">

                    <p class="card-text offer-description fs-6 mb-2"><?= nl2br(htmlspecialchars($publicacion->descripcion)); ?></p>
                    
                    <!-- Botones de contacto -->
                    <div class="d-flex gap-2">
                      <button class="btn btn-primary btn-sm disabled">Contactar</button>
                      <button class="btn btn-outline-secondary btn-sm disabled">Mensaje</button>
                      <button class="btn btn-outline-success btn-sm disabled">WhatsApp</button>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="alert alert-warning" role="alert">
          No hay ofertas disponibles.
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
