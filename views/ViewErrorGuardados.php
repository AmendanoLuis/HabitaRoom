<?php
/**
 * Vista: Error Sesión Guardados View
 *
 * Muestra un mensaje de error cuando un usuario intenta acceder a la sección de artículos guardados
 * sin estar registrado o haber iniciado sesión.
 *
 * Características:
 * - Diseño centrado vertical y horizontalmente en pantalla completa (vh-100).
 * - Mensaje claro indicando que el usuario no está registrado.
 * - Enlace al formulario de registro con texto y botón llamativo.
 * - Imagen ilustrativa con enlace también al registro.
 * - Uso de Bootstrap para estilos responsivos, bordes y centrado.
 *
 * @package HabitaRoom\Views
 */
?>

<div class="container-fluid bg-white">
  <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
    <div class="row w-100">
      <div class="col-12 col-sm-10 col-md-8 col-lg-5 mx-auto border border-success rounded p-4">
        <div class="text-center my-5">

          <!-- Espacio para la imagen -->
          <h1 class="text-success mb-5">No estás <a href="/HabitaRoom/registro" class="text-success text-decoration-none">registrado</a></h1>
          <div class="mb-4">
            <a href="/HabitaRoom/registro">
              <img src="public/img/noGuardados.png" alt="Imagen de registro" class="img-fluid w-25 mx-auto d-block">
            </a>
          </div>
          <p class="mb-4">¡Registrate! Guarda tus artículos favoritos y accede a ellos cuando quieras.</p>
          <a href="/HabitaRoom/registro" class="btn btn-success">Ir a registro</a>
        </div>
      </div>
    </div>
  </div>
</div>
