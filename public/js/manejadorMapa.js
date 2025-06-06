// manejadorMapa.js
import $ from "https://cdn.jsdelivr.net/npm/jquery@3.7.1/+esm";
import { obtenerMapaConGeolocalizacion } from "./mapUtils.js";
import { mostrarCargando, ocultarCargando } from "./loadingPage.js";
import { actualizarIdPublicaciones } from "../../config/app.js";

export async function mostrarMapa() {
  const $mapa = $("#mapa");
  $mapa.addClass("visible");
  await obtenerMapaConGeolocalizacion();
}

export function ocultarMapa() {
  $("#mapa").removeClass("visible");
}

export function inicializarToggleMapa() {
  console.log("Inicializando toggle mapa...");

  $(document).off("click", "#btn-toggle-mapa");

  let bloqueado = false;

  $(document).on("click", "#btn-toggle-mapa", async (event) => {
    event.preventDefault();
    event.stopPropagation();

    if (bloqueado) {
      return;
    }

    bloqueado = true;

    console.log("Click recibido en btn-toggle-mapa");
    const $mapa = $("#mapa");

    if ($mapa.hasClass("visible")) {
      ocultarMapa();
    } else {
      await mostrarMapa();
    }

    // desbloqueamos después de 500ms (ajustable)
    setTimeout(() => {
      bloqueado = false;
    }, 500);
  });
}

export function eventFormularioUbicacion() {
  // Cuando el formulario de búsqueda se haga submit

  $(document).off("submit", "#formBuscarMapa");
  $(document).on("submit", "#formBuscarMapa", function (event) {
    event.preventDefault();

    const lat = $("#inputLatitud").val();
    const lon = $("#inputLongitud").val();
    const ubicacionGeografica = obtenerDireccionDesdeInputs();
    if (
      !lat &&
      !lon &&
      !ubicacionGeografica.road &&
      !ubicacionGeografica.suburb &&
      !ubicacionGeografica.city &&
      !ubicacionGeografica.state &&
      !ubicacionGeografica.postcode
    ) {
      Swal.fire({
        icon: "warning",
        title: "Escribe la ubicación para buscar",
        confirmButtonText: "Aceptar",
      });
      return;
    }
    $.ajax({
      url: "controllers/IndexController.php",
      type: "POST",
      data: {
        latitud: lat,
        longitud: lon,
        calle: ubicacionGeografica.road,
        barrio: ubicacionGeografica.suburb,
        ciudad: ubicacionGeografica.city,
        provincia: ubicacionGeografica.state,
        cp: ubicacionGeografica.postcode,
      },
      beforeSend: () => {
        mostrarCargando();
      },
      success: (response) => {
        $("#contenedor-principal").html(response);
        actualizarIdPublicaciones(
          "#contenedorPrincipal",
          ".contenedor-publicacion"
        );
      },
      error: (xhr, status, error) => {
        console.error("Error al buscar por ubicación:", error);
      },
      complete: () => {
        ocultarCargando();
      },
    });
  });
}

export function obtenerDireccionDesdeInputs() {
  return {
    latitud: $("#inputLatitud").val() || "",
    longitud: $("#inputLongitud").val() || "",
    road: $("#inputCalle").val() || "",
    suburb: $("#inputBarrio").val() || "",
    city: $("#inputCiudad").val() || "",
    state: $("#inputProvincia").val() || "",
    postcode: $("#inputCP").val() || "",
  };
}
