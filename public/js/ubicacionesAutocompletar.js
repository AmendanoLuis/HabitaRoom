// public/js/ubicacionAutocompletar.js
import $ from "https://cdn.jsdelivr.net/npm/jquery@3.7.1/+esm";

export function geocode(query) {
  const url =
    "https://nominatim.openstreetmap.org/search" +
    "?format=json" +
    "&addressdetails=1" +
    "&limit=5" +
    "&countrycodes=es" +
    "&q=" +
    encodeURIComponent(query);

  return $.getJSON(url);
}

export function iniciarAutocompletarUbicacion({ inputSelector, onSelect }) {
  const $input = $(inputSelector);

  // contenedor de sugerencias aparecerá flotante debajo del input
  const $list = $(
    `<ul class="autocomplete-list list-group position-absolute"></ul>`
  )
    .css({
      zIndex: 9999,
      maxHeight: "200px",
      overflowY: "auto",
      width: $input.outerWidth(),
    })
    .insertAfter($input)
    .hide();

  let debounce;

  $input.on("input", function () {
    const term = this.value.trim();
    clearTimeout(debounce);
    if (term.length < 3) {
      return $list.hide();
    }
    debounce = setTimeout(async () => {
      const results = await geocode(term);
      $list.empty();
      if (results.length === 0) {
        $list.append(`<li class="list-group-item">Sin resultados</li>`);
      } else {
        results.forEach((r) => {
          const text = r.display_name;
          $("<li>")
            .addClass("list-group-item list-group-item-action")
            .text(text)
            .appendTo($list)
            .on("click", () => {
              $input.val(text);
              $list.hide();
              onSelect &&
                onSelect({
                  lat: parseFloat(r.lat),
                  lon: parseFloat(r.lon),
                  address: r.address,
                });
            });
        });
      }
      $list.show();
    }, 300);
  });

  $input.on("blur", () => setTimeout(() => $list.hide(), 200));
}
