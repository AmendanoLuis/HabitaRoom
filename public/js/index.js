import { mostrarCargando, ocultarCargando } from "./loadingPage.js";
import { actualizarIdPublicaciones } from "../../config/app.js";

//------------------------------------------------------------------
// FUNCION PARA GUARDAR DETECCION DE FIN DE PAGINA
//------------------------------------------------------------------
export function detectarFinDePagina() {
  let offset = $("#contenedor-publicacion").length;

  $(window).scroll(function () {
    if (
      $(window).scrollTop() + $(window).height() >=
      $(document).height() - 5
    ) {
      // Evitar llamadas múltiples rápidas
      if (!window.cargandoMas) {
        window.cargandoMas = true;
        offset = $("#contenedor-publicacion").length;

        const id_publis_cargadas = sessionStorage.getItem("id_publis");
        const timeoutId = mostrarCargandoConRetardo();

        $.ajax({
          url: "controllers/IndexController.php",
          method: "POST",
          data: {
            ruta: "/HabitaRoom/index",
            accion: "cargarMasPublicaciones",
            offset: offset,
            id_publis_cargadas: id_publis_cargadas
              ? JSON.parse(id_publis_cargadas)
              : [],
          },
          success: function (html) {
            if (html.trim().length > 0) {
              $("#contenedor-principal").append(html);
              actualizarIdPublicaciones(
                "#contenedor-principal",
                ".contenedor-publicacion"
              );

              offset += 10;
            }
            window.cargandoMas = false;
          },
          error: function () {
            console.error("Error cargando más publicaciones");
            window.cargandoMas = false;
          },
          complete: function () {
            clearTimeout(timeoutId);
            ocultarCargando();
          },
        });
      }
    } else {
      $("#row_filtros").addClass("position-fixed");
      $("#cont_btns_index").addClass("position-fixed");

      $("#footer_hbr").removeClass("footer_end_absolute");
      $("#row_filtros").removeClass("categoria_relative");
      $("#cont_btns_index").removeClass("btns_relative");
    }
  });
}

//------------------------------------------------------------------
// FUNCION PARA GUARDAR PUBLICACION
//------------------------------------------------------------------
export function guardarPublicacion(elemento, ruta_actual) {
  const icono = $(elemento).find("i");
  const id_publicacion = $(elemento).data("id-publicacion");
  const esGuardado = icono.hasClass("bi-bookmark-fill");

  console.log("ID de publicación:", id_publicacion);
  console.log("Es guardado:", esGuardado);

  $.ajax({
    url: "controllers/GuardadosController.php",
    type: "POST",
    data: {
      id_publicacion,
      guardar: esGuardado,
      rutaGuardar: ruta_actual,
    },
    dataType: "json",
    success: function (response) {
      console.log(
        "Respuesta del servidor:",
        response.auth,
        response.status,
        response.message
      );
      if (response.auth === false) {
        Swal.fire({
          title: "Error",
          text:
            response.message ||
            "No estás registrado. Por favor, inicia sesión para continuar.",
          icon: "error",
          confirmButtonText: "Iniciar sesión",
        }).then(() => {
          window.location.href = "/HabitaRoom/login";
        });
        return;
      }

      if (response.status === "success") {
        if (esGuardado) {
          icono
            .removeClass("bi-bookmark-fill text-warning")
            .addClass("bi-bookmark");
          console.log("Publicación eliminada de favoritos.");
        } else {
          icono
            .removeClass("bi-bookmark")
            .addClass("bi-bookmark-fill text-warning");
          console.log("Publicación guardada como favorita.");
        }
      } else {
        console.error("Error al guardar la publicación:", response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud AJAX:", error);
      console.log("Respuesta recibida:", xhr.responseText);
    },
  });
}

//------------------------------------------------------------------
// FUNCION PARA PROCESAR EL FORMULARIO DE FILTROS
//------------------------------------------------------------------
export function procesarFormularioFiltros(form) {
  const formData = new FormData(form);
  const filtros = {};
  const ruta = window.location.pathname;

  // Recorremos *todos* los campos, incluidos checkbox individuales
  for (const [name, value] of formData.entries()) {
    filtros[name] = value;
  }

  // Ahora añadimos explícitamente los que no vinieron (los unchecked)
  [
    "ascensor",
    "piscina",
    "gimnasio",
    "garaje",
    "terraza",
    "jardin",
    "aire_acondicionado",
    "calefaccion",
  ].forEach((c) => {
    filtros[c] = filtros[c] === "1" ? "1" : "0";
  });

  sessionStorage.setItem("filtrosBusqueda", JSON.stringify(filtros));

  const esFiltros = Object.values(filtros).some((v) => v !== "" && v !== "0");
  console.log("Datos a enviar en AJAX:", filtros, esFiltros, ruta);

  const timeoutId = mostrarCargandoConRetardo();

  $.ajax({
    url: "controllers/IndexController.php",
    type: "POST",
    data: JSON.stringify({ filtros, esFiltros, ruta }),
    contentType: "application/json",
    success: (resp) => {
      $("#contenedor-principal").html(resp);
      actualizarIdPublicaciones(
        "#contenedor-principal",
        ".contenedor-publicacion"
      );
    },
    error: (xhr, status, err) => console.error("Error AJAX:", err),
    complete: function () {
      clearTimeout(timeoutId);
      ocultarCargando();
    },
  });
}

//------------------------------------------------------------------
// FUNCION PARA CARGAR LOS FILTROS
//------------------------------------------------------------------
export function cargarFiltros() {
  const raw = sessionStorage.getItem("filtrosBusqueda");
  if (!raw) return;
  const filtros = JSON.parse(raw);
  const form = document.getElementById("form-filtros-desp");
  if (!filtros) return;

  // Campos de texto, selects y radios
  [
    "tipo_anuncio",
    "tipo_inmueble",
    "precio_min",
    "precio_max",
    "habitaciones",
    "banos",
    "estado",
  ].forEach((name) => {
    const field = form.querySelector(`[name="${name}"]`);
    if (!field) return;
    if (field.type === "radio" || field.type === "select-one") {
      field.value = filtros[name] || "";
    } else {
      field.value = filtros[name] || "";
    }
  });

  // Checkbox individuales
  [
    "ascensor",
    "piscina",
    "gimnasio",
    "garaje",
    "terraza",
    "jardin",
    "aire_acondicionado",
    "calefaccion",
  ].forEach((name) => {
    const cb = form.querySelector(`[name="${name}"]`);
    if (!cb) return;
    cb.checked = filtros[name] === "1";
  });
}

//------------------------------------------------------------------
// FUNCION PARA CARGAR INICIALIZAR EL BUSCADOR LATERAL
//------------------------------------------------------------------
export function inicializarBuscadorLateral() {
  // Delegación directa, el formulario está en el layout y siempre presente
  $(document).on("submit", "#formBuscarLateral", function (e) {
    e.preventDefault();
    const $form = $(this);
    const $input = $form.find("#inputBuscar");
    let q = $input.val()?.trim();

    if (!q) {
      Swal.fire({
        icon: "warning",
        title: "Atención",
        text: "Introduce un término para buscar.",
      });
      return;
    }

    q = q.toLowerCase();

    const timeoutId = mostrarCargandoConRetardo();

    $.ajax({
      url: "controllers/IndexController.php",
      type: "POST",
      data: { accion: "buscar", q, ruta: window.location.pathname },
      success: function (html) {
        $("#contenedor-principal").html(html);
        actualizarIdPublicaciones(
          "#contenedor-principal",
          ".contenedor-publicacion"
        );
      },
      error: function (xhr, status, err) {
        console.error("Error en búsqueda:", err);
        $("#contenedor-principal").html(
          '<div class="alert alert-danger">Error al buscar publicaciones.</div>'
        );
      },
      complete: function () {
        clearTimeout(timeoutId);
        ocultarCargando();
      },
    });
  });
}

//------------------------------------------------------------------
// Inicializa el filtro de tipo de publicitante
//------------------------------------------------------------------
export function filtrarTipoPublicitante(inputBuscar) {
  // Delegación para móviles
  $(document).on(
    "click",
    "#btn-habitantes-mob, #btn-propietario-mob, #btn-empresa-mob",
    filtrar
  );

  // Delegación para escritorio
  $(document).on(
    "click",
    "#btn-habitantes-desk, #btn-propietario-desk, #btn-empresa-desk",
    filtrar
  );

  inputBuscar.on("search", function () {
    if (!this.value) {
      location.reload();
    }
  });
  // Función para filtrar por tipo de publicitante
  function filtrar() {
    let tipo;
    switch (this.id) {
      case "btn-habitantes-mob":
      case "btn-habitantes-desk":
        tipo = "habitante";
        break;
      case "btn-propietario-mob":
      case "btn-propietario-desk":
        tipo = "propietario";
        break;
      case "btn-empresa-mob":
      case "btn-empresa-desk":
        tipo = "empresa";
        break;
      default:
        return;
    }

    const timeoutId = mostrarCargandoConRetardo();

    $.ajax({
      url: "controllers/IndexController.php",
      type: "POST",
      data: {
        accion: "filtrarTipoPublicitante",
        tipo_publicitante: tipo,
        ruta: window.location.pathname,
      },
      success: function (html) {
        $("#contenedor-principal").html(html);
        actualizarIdPublicaciones(
          "#contenedor-principal",
          ".contenedor-publicacion"
        );
      },
      error: function (xhr, status, err) {
        console.error("Error al filtrar tipo publicitante:", err);
        $("#contenedor-principal").html(
          '<div class="alert alert-danger">Error al cargar las publicaciones.</div>'
        );
      },
      complete: function () {
        clearTimeout(timeoutId);
        ocultarCargando();
      },
    });
  }
}

function mostrarCargandoConRetardo(delay = 500) {
  const id = setTimeout(() => mostrarCargando(), delay);
  return id;
}
