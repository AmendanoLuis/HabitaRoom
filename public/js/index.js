// Detecta cuando el usuario ha llegado al final de la página

import { mostrarCargando, ocultarCargando } from "./loadingPage.js";


function observarCarga(selector, callback) {
    const contMain = document.getElementById('contenidoMain');
    if (!contMain) return;

    const observ = new MutationObserver(() => {
        if ($(selector).length > 0) {
            callback();
            observ.disconnect();
        }
    });

    observ.observe(contMain, { childList: true, subtree: true });
}

export function detectarFinDePagina() {
    var ancho_cont_categ = $('#row_filtros').outerWidth();
    var alturaFooter = $('#footer_hbr').outerHeight();

    $('#row_filtros').css('width', ancho_cont_categ + 'px');

    $(window).scroll(function () {
        // Si el usuario ha llegado al final de la pagina
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - alturaFooter) {

            $('#row_filtros').removeClass('position-fixed');
            $('#cont_btns_index').removeClass('position-fixed');

            $('#footer_hbr').addClass('footer_end_absolute');
            $('#row_filtros').addClass('categoria_relative');
            $('#cont_btns_index').addClass('btns_relative');

        } else {

            $('#row_filtros').addClass('position-fixed');
            $('#cont_btns_index').addClass('position-fixed');

            $('#footer_hbr').removeClass('footer_end_absolute');
            $('#row_filtros').removeClass('categoria_relative');
            $('#cont_btns_index').removeClass('btns_relative');

        }
    });
}

////////////////////////////////////////////////////////////////
// FUNCION PARA GUARDAR PUBLICACION
////////////////////////////////////////////////////////////////
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
            rutaGuardar: ruta_actual
        },
        dataType: "json",
        success: function (response) {

            console.log("Respuesta del servidor:", response);

            if (response.auth === false) {
                Swal.fire({
                    title: 'Error',
                    text: response.message || 'No estás registrado. Por favor, inicia sesión para continuar.',
                    icon: 'error',
                    confirmButtonText: 'Iniciar sesión'
                }).then(() => {
                    window.location.href = '/HabitaRoom/login';
                });
                return;
            }

            if (response.status === "success") {
                if (esGuardado) {
                    icono.removeClass("bi-bookmark-fill text-warning").addClass("bi-bookmark");
                    console.log("Publicación eliminada de favoritos.");
                } else {
                    icono.removeClass("bi-bookmark").addClass("bi-bookmark-fill text-warning");
                    console.log("Publicación guardada como favorita.");
                }
            } else {
                console.error("Error al guardar la publicación:", response.message);
            }

        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}



////////////////////////////////////////////////////////////////
// FUNCION PARA PROCESAR EL FORMULARIO DE FILTROS
////////////////////////////////////////////////////////////////
export function procesarFormularioFiltros(elemento) {
    const todasCaracteristicas = [
        'ascensor',
        'piscina',
        'gimnasio',
        'garaje',
        'terraza',
        'jardin',
        'aire_acondicionado',
        'calefaccion'
    ];

    const form = elemento;
    if (!form) return;

    const formData = new FormData(form);
    const filtros = {};
    const ruta = window.location.pathname;

    // Recogemos y normalizamos los datos del formulario
    for (const [name, value] of formData.entries()) {
        const key = name.replace(/-/g, '_'); // Reemplaza guiones por guiones bajos

        if (filtros.hasOwnProperty(key)) {
            if (!Array.isArray(filtros[key])) filtros[key] = [filtros[key]];
            filtros[key].push(value);
        } else {
            filtros[key] = value;
        }

        console.log(`${key}:`, value);
    }

    const guardadas = filtros['caracteristicas'] || [];
    todasCaracteristicas.forEach(carac => {
        filtros[carac] = guardadas.includes(carac) ? '1' : '0';
    });

    delete filtros['caracteristicas'];

    // Guardamos en sessionStorage
    sessionStorage.setItem('filtrosBusqueda', JSON.stringify(filtros));

    const esFiltros = Object.values(filtros).some(value => {
        if (Array.isArray(value)) return value.length > 0;
        return value !== '' && value !== '0';
    });

    console.log("Datos a enviar en AJAX:", filtros, esFiltros, ruta);

    // Enviar por AJAX
    $.ajax({
        url: 'controllers/IndexController.php',
        type: 'POST',
        data: JSON.stringify({
            filtros,
            esFiltros,
            ruta
        }),
        contentType: 'application/json',
        beforeSend: () => mostrarCargando(),
        success: function (response) {
            const contenedor = $('#contenedor-principal');
            console.log('Respuesta AJAX:', response);
            contenedor.html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
        },
        complete: function () {
            ocultarCargando();
        }
    });
}




////////////////////////////////////////////////////////////////
// FUNCION PARA CARGAR LOS FILTROS
////////////////////////////////////////////////////////////////
export async function cargarFiltros() {
    let hayFiltros = false;

    const todasCaracteristicas = [
        'ascensor', 'piscina', 'gimnasio', 'garaje',
        'terraza', 'jardin', 'aire_acondicionado', 'calefaccion'
    ];

    const filtrosJSON = sessionStorage.getItem('filtrosBusqueda');
    if (!filtrosJSON) {
        console.warn('No hay filtros guardados en sessionStorage.');
        return;
    }

    const filtros = JSON.parse(filtrosJSON);
    console.log('Filtros recuperados:', filtros);

    const form = document.getElementById('form-filtros-desp');
    if (!form) {
        console.warn('Formulario de filtros no encontrado.');
        return;
    }

    const caracteristicasGuardadas = filtros["caracteristicas[]"];
    if (Array.isArray(caracteristicasGuardadas)) {
        caracteristicasGuardadas.forEach(carac => {
            if (todasCaracteristicas.includes(carac)) {
                const checkbox = form.querySelector(`[name="caracteristicas[]"][value="${carac}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                    hayFiltros = true;
                }
            }
        });
    }

    Object.entries(filtros).forEach(([key, value]) => {

        if (todasCaracteristicas.includes(key) || key === "caracteristicas[]") return;

        const fields = form.querySelectorAll(`[name="${key}"]`);
        fields.forEach(field => {
            if (field.type === 'checkbox') {
                field.checked = value === '1' || value === true;
                if (field.checked) hayFiltros = true;
            } else if (field.type === 'radio') {
                const checked = field.value === value;
                field.checked = checked;
                if (checked) hayFiltros = true;
            } else {
                if (value !== '' && value !== null) {
                    field.value = value;
                    hayFiltros = true;
                }
            }
        });
    });
}



////////////////////////////////////////////////////////////////
// FUNCION PARA CARGAR INICIALIZAR EL BUSCADOR LATERAL
////////////////////////////////////////////////////////////////
export function inicializarBuscadorLateral() {
    // Delegación directa, el formulario está en el layout y siempre presente
    $(document).on('submit', '#formBuscarLateral', function(e) {
      e.preventDefault();
      const $form  = $(this);
      const $input = $form.find('#inputBuscar');
      let q = $input.val()?.trim();
  
      if (!q) {
        Swal.fire({
          icon: 'warning',
          title: 'Atención',
          text: 'Introduce un término para buscar.'
        });
        return;
      }
  
      q = q.toLowerCase();
      mostrarCargando();
  
      $.ajax({
        url: 'controllers/IndexController.php',
        type: 'POST',
        data: { accion: 'buscar', q, ruta: window.location.pathname },
        beforeSend: () => mostrarCargando(),
        success: function(html) {
          console.log('Resultados de búsqueda:', html);
          $('#contenedor-principal').html(html);
        },
        error: function(xhr, status, err) {
          console.error('Error en búsqueda:', err);
          $('#contenedor-principal').html(
            '<div class="alert alert-danger">Error al buscar publicaciones.</div>'
          );
        },
        complete: function() {
          ocultarCargando();
        }
      });
    });
  }