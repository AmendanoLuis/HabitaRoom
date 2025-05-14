<?php if (isset($_SESSION['id'])): ?>

<div class="saved-wrapper mx-auto" id="guardadosContainer">

  <!-- Contenido de los guardados -->
  <div class="container-fluid mt-4 text-light saved-container">
    <div class="row saved-row">

      <!-- Aquí se cargan los guardados -->
      <?php if (!empty($guardados)): ?>
        <?php foreach ($guardados as $publicacion): ?>
          <div class="col-12 col-sm-6 col-md-3">

            <!-- Tarjeta del guardado -->
            <div class="card mb-4 shadow-lg saved-card h-100 d-flex flex-column" data-id="<?= $publicacion->id; ?>">
              <a href="/HabitaRoom/publicacionusuario?id=<?php echo $publicacion->id; ?>" class="text-decoration-none text-reset flex-grow-1 d-flex flex-column">

                <!-- Imagen de la propiedad -->
                <?php
                $imagenes = json_decode($publicacion->fotos);
                $primera = (!empty($imagenes) && is_array($imagenes)) ? $imagenes[0] : 'imgPublicacionBase.png';
                ?>
                <div class="card-img-top overflow-hidden" id="saved-img-container" style="height: 50%;">
                  <img src="assets/uploads/img_publicacion/<?= htmlspecialchars($primera); ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="Imagen de la propiedad">
                  <span class="badge shadow-sm position-absolute top-0 start-0 z-2 text-bg-light mt-3 ms-2 px-3">
                    <?= htmlspecialchars($publicacion->tipo_publicitante); ?>
                  </span>
                </div>

                <!-- Contenido de la publicación -->
                <div class="card-body mx-2 flex-grow-2 d-flex flex-column justify-content-between" style="height: 50%;">
                  <div>
                    <!-- Precio y título -->
                    <h2 class="card-title text-start saved-price fs-4 mb-2"><?= number_format((float)$publicacion->precio, 2, ',', '.') . ' €'; ?></h2>
                    <h4 class="saved-title fs-5 mb-1"><?= htmlspecialchars($publicacion->titulo); ?></h4>

                    <!-- Ubicación y detalles -->
                    <p class="text-muted saved-location fs-6 mb-1"><?= htmlspecialchars($publicacion->ubicacion); ?></p>
                    <p class="text-muted saved-info fs-6 mb-2">
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

                  <!-- Descripción y botones -->
                  <div class="saved-description-container flex-grow-1 d-flex flex-column justify-content-end mt-1">
                    <p class="card-text saved-description fs-6 mb-2"><?= nl2br(htmlspecialchars($publicacion->descripcion)); ?></p>
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
          <div class="alert alert-info" role="alert">
            No tienes guardados.
          </div>
      <?php endif; ?>

    </div>
  </div>
</div>
<?php endif; ?>
