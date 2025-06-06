import $ from "https://cdn.jsdelivr.net/npm/jquery@3.7.1/+esm";
import { getMapInstance } from "./mapUtils.js";

//////////////////////////////////////
// Geocode con Nominatim
/////////////////////////////////////
async function geocode(query) {
  const url = new URL("https://nominatim.openstreetmap.org/search");
  url.searchParams.set("q", query);
  url.searchParams.set("format", "json");
  url.searchParams.set("addressdetails", "1");
  url.searchParams.set("limit", "15");
  url.searchParams.set("countrycodes", "es,pt");

  const resp = await fetch(url, {
    headers: {
      "User-Agent": "HabitaRoom/1.0 (https://github.com/AmendanoLuis)",
    },
  });
  const data = await resp.json();

  return data.map((r) => ({
    display_name: r.display_name,
    lat: parseFloat(r.lat),
    lon: parseFloat(r.lon),
    address: r.address,
  }));
}

//////////////////////////////////////
// Autocompletar ubicación
/////////////////////////////////////
let marcadorUbicacion = null;

export function iniciarAutocompletarUbicacion(
  { inputSelector, onSelect },
  ruta_actual
) {
  const $input = $(inputSelector);
  const $container = $input.parent();
  const $list = $('<ul class="autocomplete-list"></ul>').appendTo($container);

  let debounce;

  function ajustarAncho() {
    $list.width($input.outerWidth());
  }

  ajustarAncho();
  $(window).on("resize", ajustarAncho);

  let resultadosActuales = [];

  function seleccionarResultado(r) {
    $input.val(r.display_name);
    $("#inputLatitud").val(r.lat);
    $("#inputLongitud").val(r.lon);
    $("#inputCalle").val(r.address.road || "");
    $("#inputBarrio").val(r.address.suburb || "");
    $("#inputCiudad").val(
      r.address.city || r.address.town || r.address.village || ""
    );
    $("#inputProvincia").val(r.address.state || "");
    $("#inputCP").val(r.address.postcode || "");
    $list.hide();

    const map = getMapInstance();
    if (map) {
      map.setView([r.lat, r.lon], 16);
      if (marcadorUbicacion) map.removeLayer(marcadorUbicacion);
      marcadorUbicacion = L.marker([r.lat, r.lon])
        .addTo(map)
        .bindPopup(r.display_name)
        .openPopup();
    }

    if (onSelect) onSelect(r);
  }

  $input.on("input", function () {
    const term = this.value.trim();
    clearTimeout(debounce);
    if (term.length < 3) return $list.hide();

    debounce = setTimeout(async () => {
      const results = await geocode(term);
      resultadosActuales = results; // Guardar resultados visibles

      $list.empty();

      if (results.length === 0) {
        $('<li class="autocomplete-item">Sin resultados</li>').appendTo($list);
      } else {
        results.forEach((r, idx) => {
          $('<li class="autocomplete-item"></li>')
            .text(r.display_name)
            .appendTo($list)
            .on("click", () => seleccionarResultado(r));
        });
      }

      $list.show();
    }, 300);
  });
  console.log("Ruta actual" + ruta_actual);
  if (ruta_actual === "/HabitaRoom/index") {
    $("#inputBuscarMapa").on("search", function () {
      if (!this.value) {
        sessionStorage.setItem("mostrarMapaTrasReload", "1");
        location.reload();
      }
    });
  }

  // Al presionar Enter, selecciona el primer resultado visible
  $input.on("keydown", (e) => {
    if (e.key === "Enter" && resultadosActuales.length > 0) {
      e.preventDefault();
      seleccionarResultado(resultadosActuales[0]);
    }
  });

  $input.on("blur", () => setTimeout(() => $list.hide(), 200));
}
