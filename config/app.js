import { mostrarCargando, ocultarCargando } from "../public/js/loadingPage.js";
import {
  procesarFormularioCrearPublicacion,
  asignarEventosForm,
  validarCampo,
} from "../public/js/crearPublicacion.js";
import {
  mostrarImagenPrevia,
  asignarEventosFormRegistro,
} from "../public/js/register.js";
import {
  inicializarToggleMapa,
  mostrarMapa,
} from "../public/js/manejadorMapa.js";
import { iniciarAutocompletarUbicacion } from "../public/js/ubicacionesAutocompletar.js";

import {
  detectarFinDePagina,
  guardarPublicacion,
  procesarFormularioFiltros,
  cargarFiltros,
  inicializarBuscadorLateral,
  filtrarTipoPublicitante,
} from "/HabitaRoom/public/js/index.js";

$(document).ready(function () {
  // ============ FUNCIONES ============

  // Cargar página principal
  async function cargarPagina(url) {
    try {
      const urlParams = new URLSearchParams(window.location.search);
      const id = urlParams.get("id");

      const data = { site: url };
      if (id) {
        data.id = id;
      }

      mostrarCargando();

      const response = await $.ajax({
        url: "routes/redireccionWeb.php",
        type: "POST",
        data: data,
      });

      if (response.includes("<!DOCTYPE html>")) {
        console.warn(
          "Respuesta no válida para AJAX, parece una página completa."
        );
        return;
      }

      $("#contenidoMain").html(response);

      if (url === "/HabitaRoom/index" || url === "/HabitaRoom/index.php") {
        asignarEventosFormularios();
        cargarFiltros();
      }
    } catch (error) {
      console.error("Error al cargar el contenido: ", error);
    } finally {
      ocultarCargando();
    }
  }

  // Cargar publicaciones en el index
  async function cargarPublicacionesIndex() {
    if (
      ruta_actual === "/HabitaRoom/index" ||
      ruta_actual === "/HabitaRoom/index.php"
    ) {
      try {
        mostrarCargando();

        const response = await $.ajax({
          url: "controllers/IndexController.php",
          type: "POST",
          data: { ruta: ruta_actual },
        });

        $("#contenedor-principal").html(response);
      } catch (error) {
        console.error("Error al cargar publicaciones: ", error);
      } finally {
        ocultarCargando();
      }
    }
  }

  // Asignar eventos a formularios en Index
  function asignarEventosFormularios() {
    $(document).on("submit", "#form-filtros-desp", function (event) {
      event.preventDefault();

      console.log("Formulario desp enviado.");
      procesarFormularioFiltros(this);
    });
  }

  // Validar formulario login
  function validarFormularioLogin() {
    $(document).on("submit", "#form_login", function (event) {
      event.preventDefault();

      const formulario = $("#form_login");

      mostrarCargando();

      $.ajax({
        url: "models/validarFormularioLogin.php",
        type: "POST",
        data: formulario.serialize(),
        dataType: "json",
        success: function (response) {
          if (response.status) {
            window.location.href = response.redirect;
          } else {
            alert("Error al iniciar sesión. Verifica tus credenciales.");
          }
        },
        error: function (xhr, status, error) {
          console.log("Error:", error);
          alert("Ocurrió un error al procesar la solicitud.");
        },
        complete: function () {
          ocultarCargando();
        },
      });
    });
  }

  // Observar carga de un elemento y ejecutar callback
  function observarCarga(selector, callback) {
    const contMain = document.getElementById("contenidoMain");
    if (!contMain) return;

    const observ = new MutationObserver(() => {
      if ($(selector).length > 0) {
        callback();
        observ.disconnect();
      }
    });

    observ.observe(contMain, { childList: true, subtree: true });
  }

  // Obtener y observar IDs de publicaciones
  function observarIdsPublicaciones(containerSelector, itemSelector) {
    observarCarga(containerSelector, () => {
      id_publis.length = 0;

      $(`${containerSelector} ${itemSelector}`).each(function () {
        const id_publi = $(this).data("id");
        if (id_publi) id_publis.push(id_publi);
      });

      sessionStorage.setItem("id_publis", JSON.stringify(id_publis));
      console.log("IDs guardados en sessionStorage:", id_publis);
    });

    $(document).off(`mouseover.${itemSelector}`);
    $(document).on(
      `mouseover.${itemSelector}`,
      `${itemSelector} a`,
      function () {
        const cont = $(this).closest(itemSelector);
        const id_publi = cont.data("id");

        if (id_publi && id_publis.includes(id_publi)) {
          console.log(`ID seleccionado en ${containerSelector}:`, id_publi);
          sessionStorage.setItem("id_publi", id_publi);
        }
      }
    );
  }

  // Manejar el evento de guardar publicación
  function accionGuardar(ruta_actual) {
    $(document).on("click", "#icono-guardar", function (e) {
      e.preventDefault();
      e.stopPropagation();

      guardarPublicacion(this, ruta_actual);
    });
  }

  // Iniciar mapa y autocompletar ubicación
  async function initUbicacionSection() {
    mostrarMapa();

    iniciarAutocompletarUbicacion({
      inputSelector: "#inputBuscarMapa",
      onSelect: ({ lat, lon, address, display_name }) => {
        // Recentrar el mapa y actualizar el marcador
        const map = window.mapInstance;
        if (map) {
          map.setView([lat, lon], 14);
          if (map.marker) {
            map.marker.setLatLng([lat, lon]);
          } else {
            map.marker = L.marker([lat, lon]).addTo(map);
          }
        }
      },
    });
  }

  function eventFormularioUbicacion() {
    // Cuando el formulario de búsqueda se haga submit
    $(document).off("submit", "#formBuscarMapa");
    $(document).on("submit", "#formBuscarMapa", function (event) {
      event.preventDefault();

      const lat = $("#inputLatitud").val();
      const lon = $("#inputLongitud").val();
      const address = {
        road: $("#inputCalle").val() || "",
        suburb: $("#inputBarrio").val() || "",
        city: $("#inputCiudad").val() || "",
        state: $("#inputProvincia").val() || "",
        postcode: $("#inputCP").val() || "",
      };
      if (
        !lat &&
        !lon &&
        !address.road &&
        !address.suburb &&
        !address.city &&
        !address.state &&
        !address.postcode
      ) {
        Swal.fire({
          icon: "warning",
          title: "Escribe la ubicación para buscar",
          confirmButtonText: "Aceptar",
        });
        return;
      }
      // recarga publicaciones filtradas
      $.ajax({
        url: "controllers/IndexController.php",
        type: "POST",
        data: {
          latitud: lat,
          longitud: lon,
          calle: address.road,
          barrio: address.suburb,
          ciudad: address.city,
          provincia: address.state,
          cp: address.postcode,
          ruta: ruta_actual,
        },
        beforeSend: () => {
          mostrarCargando();
        },
        success: (response) => {
          console.log("Buscar por ubicación:", response);
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

  // ============ MANEJO DE RUTAS ============

  async function manejarRuta(ruta_actual) {
    console.log("Ruta actual:", ruta_actual);

    if (ruta_actual === "/HabitaRoom/index") {
      await observarCarga("#contenedor-principal", async () => {
        inicializarToggleMapa();
        await cargarPublicacionesIndex();
        accionGuardar(ruta_actual);

        detectarFinDePagina();
        observarIdsPublicaciones(
          "#contenedor-principal",
          ".contenedor-publicacion"
        );

        // Aquí sí existe el formulario de búsqueda
        iniciarAutocompletarUbicacion({
          inputSelector: "#formBuscarMapa input[type='search']",
          onSelect: ({ lat, lon, address }) => {
            // recenter + marcador
            if (window.mapInstance) {
              window.mapInstance.setView([lat, lon], 14);
              if (window.mapInstance.marker) {
                window.mapInstance.marker.setLatLng([lat, lon]);
              } else {
                window.mapInstance.marker = L.marker([lat, lon]).addTo(
                  window.mapInstance
                );
              }
            }

            // recarga publicaciones filtradas
            $.ajax({
              url: "controllers/IndexController.php",
              type: "POST",
              data: {
                latitud: lat,
                longitud: lon,
                calle: address.road || "",
                barrio: address.suburb || "",
                ciudad: address.city || address.town || address.village || "",
                provincia: address.state || "",
                cp: address.postcode || "",
                ruta: ruta_actual,
              },
              beforeSend: () => {
                mostrarCargando();
              },
              success: (response) => {
                console.log("Buscar por ubicación:", response);
              },
              error: (xhr, status, error) => {
                console.error("Error al buscar por ubicación:", error);
              },
              complete: () => {
                ocultarCargando();
              },
            });
          },
        });

        // Asignar eventos al formularios
        eventFormularioUbicacion();
        inicializarBuscadorLateral();
        filtrarTipoPublicitante();
      });
    }

    // ---- LOGIN ----
    else if (ruta_actual === "/HabitaRoom/login") {
      observarCarga("#form_login", validarFormularioLogin);
    }

    // ---- REGISTRO ----
    else if (ruta_actual === "/HabitaRoom/registro") {
      observarCarga("#cont_registro", () => {
        asignarEventosFormRegistro();
        initUbicacionSection();
        mostrarImagenPrevia();
      });
    }

    // ---- PERFIL ----
    else if (ruta_actual === "/HabitaRoom/perfil") {
      observarIdsPublicaciones("#contenidoPerfil", ".contenedor-publicacion");
    }
    // CREAR PUBLICACION
    else if (ruta_actual === "/HabitaRoom/crearpublicacion") {
      observarCarga("#form_crear_publi", () => {
        asignarEventosForm();
        initUbicacionSection();

        $(document).off("submit", "#form_crear_publi");
        $(document).on("submit", "#form_crear_publi", function (event) {
          event.preventDefault();

          const form = document.getElementById("form_crear_publi");
          const campos = form.querySelectorAll("input, select, textarea");

          let formularioValido = true;

          campos.forEach((campo) => {
            if (!validarCampo(campo)) {
              formularioValido = false;
            }
          });

          if (formularioValido) {
            procesarFormularioCrearPublicacion();
          }
        });
      });
    }

    // PUBLICACION

    // ---- DETALLE DE PUBLICACIÓN DE USUARIO ----
    else if (ruta_actual.startsWith("/HabitaRoom/publicacionusuario")) {
      const urlParams = new URLSearchParams(window.location.search);
      const id_publi = urlParams.get("id");
      if (id_publi) {
        mostrarCargando();
        $.ajax({
          url: "controllers/PublicacionUsuarioController.php",
          type: "GET",
          data: { id_publi },
          success: (response) => $("#contenidoMain").html(response),
          error: () =>
            $("#contenidoMain").html("<p>Error al cargar la publicación.</p>"),
          complete: () => ocultarCargando(),
        });
      } else {
        $("#contenidoMain").html(
          "<p>No se encontró el ID de la publicación.</p>"
        );
      }
    }

    // ---- OFERTAS ----
    else if (ruta_actual === "/HabitaRoom/ofertas") {
      observarIdsPublicaciones(
        "#ofertasContainer",
        ".offerContenedorPublicacion"
      );
    }

    // ---- GUARDADOS ----
    else if (ruta_actual === "/HabitaRoom/guardados") {
      observarCarga("#contenidoGuardadas", () => {
        observarIdsPublicaciones(
          "#contenidoGuardadas",
          ".contenedor-publicacion"
        );
      });
    }

    // ---- RUTA NO MANEJADA ----
    else {
      console.warn("Ruta no manejada:", ruta_actual);
    }
  }

  // ============ INICIALIZACIÓN ============

  const ruta_actual = window.location.href.replace("http://localhost", "");
  const id_publis = [];
  const id_publi = null;

  cargarPagina(ruta_actual);
  manejarRuta(ruta_actual);

  window.addEventListener("popstate", function () {
    const ruta = window.location.pathname;
    console.log("Ruta actual (popstate): ", ruta);
    manejarRuta(ruta);
  });
});
