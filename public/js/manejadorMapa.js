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

  $(document).off("click", "#btn-toggle-mapa"); // Evitar handlers duplicados

  let bloqueado = false; // bandera para bloqueo temporal

  $(document).on("click", "#btn-toggle-mapa", async (event) => {
    event.preventDefault();
    event.stopPropagation();

    if (bloqueado) {
      console.log("Click ignorado porque está bloqueado");
      return; // ignorar si ya estamos procesando un click
    }

    bloqueado = true; // bloquear nuevos clicks

    console.log("Click recibido en btn-toggle-mapa");
    const $mapa = $("#mapa");

    if ($mapa.hasClass("visible")) {
      ocultarMapa();
      console.log("OCULTANDO MAPA");
    } else {
      await mostrarMapa();
      console.log("MOSTRANDO MAPA");
    }

    // desbloqueamos después de 500ms (ajustable)
    setTimeout(() => {
      bloqueado = false;
      console.log("Desbloqueado para nuevos clicks");
    }, 500);
  });
}
