<?php
/**
 * Vista: Guardados View
 *
 * Muestra la lista de publicaciones que un usuario ha guardado como favoritas.
 * 
 * Características principales:
 * - Solo se muestra si el usuario ha iniciado sesión (verifica $_SESSION['id']).
 * - Presenta las publicaciones guardadas en tarjetas responsive con Bootstrap.
 * - Cada tarjeta muestra:
 *   - Imagen principal de la publicación (o imagen base si no hay fotos).
 *   - Tipo de publicitante en un badge.
 *   - Precio formateado en euros con dos decimales y separadores de miles.
 *   - Título de la publicación con la primera letra en mayúscula.
 *   - Ubicación formateada en formato título.
 *   - Detalles: habitaciones, baños y superficie, si están disponibles.
 *   - Descripción con saltos de línea preservados y escapada para seguridad.
 *   - Botones deshabilitados para Contactar, Mensaje y WhatsApp (funcionalidad pendiente).
 * - Si no hay guardados, muestra un mensaje informativo.
 *
 * Variables esperadas:
 * - $_SESSION['id']: Indica que el usuario está autenticado.
 * - $guardados: array de objetos con las publicaciones guardadas, cada objeto contiene propiedades:
 *      - id, fotos (JSON), tipo_publicitante, precio, titulo, ubicacion, habitaciones, banos, superficie, descripcion.
 *
 * Seguridad:
 * - Escapado de salida con htmlspecialchars para prevenir XSS.
 * - nl2br para preservar saltos de línea en descripciones.
 *
 * Uso en MVC:
 * - El controlador debe pasar la variable $guardados con los datos de las publicaciones guardadas.
 * - La vista se encarga de mostrar los datos de forma visual.
 *
 * @package HabitaRoom\Views
 */
?>

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
                      <h4 class="saved-title fs-5 mb-1"><?= ucfirst(htmlspecialchars($publicacion->titulo)); ?></h4>

                      <!-- Ubicación y detalles -->
                      <p class="text-muted saved-location fs-6 mb-1">
                        <?php
                        $ubic = htmlspecialchars($publicacion->ubicacion, ENT_QUOTES, 'UTF-8');
                        echo mb_convert_case($ubic, MB_CASE_TITLE, 'UTF-8');
                        ?>
                      </p>
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
                      <p class="card-text saved-description fs-6 mb-2 descripccionPubli"><?= ucfirst(nl2br(htmlspecialchars($publicacion->descripcion))); ?></p>
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