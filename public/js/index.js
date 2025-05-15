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
export function procesarFormularioFiltros(form) {
    const formData = new FormData(form);
    const filtros = {};
    const ruta = window.location.pathname;

    // Recorremos *todos* los campos, incluidos checkbox individuales
    for (const [name, value] of formData.entries()) {
        filtros[name] = value;
    }

    // Ahora añadimos explícitamente los que no vinieron (los unchecked)
    ['ascensor', 'piscina', 'gimnasio', 'garaje', 'terraza', 'jardin', 'aire_acondicionado', 'calefaccion']
        .forEach(c => {
            filtros[c] = filtros[c] === '1' ? '1' : '0';
        });

    sessionStorage.setItem('filtrosBusqueda', JSON.stringify(filtros));

    const esFiltros = Object.values(filtros).some(v => v !== '' && v !== '0');
    console.log('Datos a enviar en AJAX:', filtros, esFiltros, ruta);

    $.ajax({
        url: 'controllers/IndexController.php',
        type: 'POST',
        data: JSON.stringify({ filtros, esFiltros, ruta }),
        contentType: 'application/json',
        beforeSend: mostrarCargando,
        success: resp => $('#contenedor-principal').html(resp),
        error: (xhr, status, err) => console.error('Error AJAX:', err),
        complete: ocultarCargando
    });
}





////////////////////////////////////////////////////////////////
// FUNCION PARA CARGAR LOS FILTROS
////////////////////////////////////////////////////////////////
export function cargarFiltros() {
    const raw = sessionStorage.getItem('filtrosBusqueda');
    if (!raw) return;
    const filtros = JSON.parse(raw);
    const form = document.getElementById('form-filtros-desp');
    if (!form) return;

    // Campos de texto, selects y radios
    ['tipo_anuncio', 'tipo_inmueble', 'precio_min', 'precio_max', 'habitaciones', 'banos', 'estado']
        .forEach(name => {
            const field = form.querySelector(`[name="${name}"]`);
            if (!field) return;
            if (field.type === 'radio' || field.type === 'select-one') {
                field.value = filtros[name] || '';
            } else {
                field.value = filtros[name] || '';
            }
        });

    // Checkbox individuales
    ['ascensor', 'piscina', 'gimnasio', 'garaje', 'terraza', 'jardin', 'aire_acondicionado', 'calefaccion']
        .forEach(name => {
            const cb = form.querySelector(`[name="${name}"]`);
            if (!cb) return;
            cb.checked = filtros[name] === '1';
        });
}




////////////////////////////////////////////////////////////////
// FUNCION PARA CARGAR INICIALIZAR EL BUSCADOR LATERAL
////////////////////////////////////////////////////////////////
export function inicializarBuscadorLateral() {
    // Delegación directa, el formulario está en el layout y siempre presente
    $(document).on('submit', '#formBuscarLateral', function (e) {
        e.preventDefault();
        const $form = $(this);
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
            success: function (html) {
                console.log('Resultados de búsqueda:', html);
                $('#contenedor-principal').html(html);
            },
            error: function (xhr, status, err) {
                console.error('Error en búsqueda:', err);
                $('#contenedor-principal').html(
                    '<div class="alert alert-danger">Error al buscar publicaciones.</div>'
                );
            },
            complete: function () {
                ocultarCargando();
            }
        });
    });
}


////////////////////////////////////////////////////////////////
// Inicializa el filtro de tipo de publicitante
////////////////////////////////////////////////////////////////
export function filtrarTipoPublicitante() {

    // Delegación para móviles
    $(document).on('click', '#btn-habitantes-mob, #btn-propietario-mob, #btn-empresa-mob', filtrar);

    // Delegación para escritorio
    $(document).on('click', '#btn-habitantes-desk, #btn-propietario-desk, #btn-empresa-desk', filtrar);

    // Función para filtrar por tipo de publicitante
    function filtrar() {

        let tipo;
        switch (this.id) {
            case 'btn-habitantes-mob':
            case 'btn-habitantes-desk':
                tipo = 'habitante';
                break;
            case 'btn-propietario-mob':
            case 'btn-propietario-desk':
                tipo = 'propietario';
                break;
            case 'btn-empresa-mob':
            case 'btn-empresa-desk':
                tipo = 'empresa';
                break;
            default:
                return;
        }

        mostrarCargando();
        $.ajax({
            url: 'controllers/IndexController.php',
            type: 'POST',
            data: {
                accion: 'filtrarTipoPublicitante',
                tipo_publicitante: tipo,
                ruta: window.location.pathname
            },
            dataType: 'html',
            beforeSend: () => mostrarCargando(),
            success: function (html) {
                $('#contenedor-principal').html(html);
            },
            error: function (xhr, status, err) {
                console.error('Error al filtrar tipo publicitante:', err);
                $('#contenedor-principal').html(
                    '<div class="alert alert-danger">Error al cargar las publicaciones.</div>'
                );
            },
            complete: function () {
                ocultarCargando();
            }
        });
    }
}
