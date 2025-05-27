// manejadorMapa.js
import $ from "https://cdn.jsdelivr.net/npm/jquery@3.7.1/+esm";
import { obtenerMapaConGeolocalizacion } from "./mapUtils.js";

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
    setTimeout(() => {bloqueado = false;}, 500);
  });
}
