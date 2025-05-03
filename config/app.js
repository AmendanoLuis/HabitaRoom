import { procesarFormularioCrearPublicacion, asignarEventosForm, validarCampo } from '../public/js/crearPublicacion.js';

$(document).ready(function () {

    // ============ FUNCIONES ============

    // CARGAR PAGINA CON AJAX
    function cargarPagina(url) {
        $.ajax({
            url: 'routes/redireccionWeb.php',
            type: 'POST',
            data: { site: url },
            success: function (response) {
                if (response.includes('<!DOCTYPE html>')) {
                    console.warn("Respuesta no válida para AJAX, parece una página completa.");
                    return;
                }

                $('#contenidoMain').html(response);

                if (url === '/HabitaRoom/index' || url === '/HabitaRoom/index.php') {
                    asignarEventosFormularios();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar el contenido: ', error);
            }
        });


    }

    // CARGAR PUBLICACIONES EN INDEX
    function cargarPublicacionesIndex() {
        if (ruta_actual === '/HabitaRoom/index' || ruta_actual === '/HabitaRoom/index.php') {

            $.ajax({
                url: 'controllers/IndexController.php',
                type: 'POST',
                data: { ruta: ruta_actual },
                success: function (response) {

                    $('#contenedor-principal').html(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error al cargar publicaciones: ', error);
                }
            });
        }
    }

    // ASIGNAR EVENTOS A FORMULARIOS INDEX
    function asignarEventosFormularios() {
        $(document).on("submit", "#form-filtros-desp", function (event) {
            event.preventDefault();
            console.log("Formulario desp enviado.");

            validarFormularioFiltros('#form-filtros-desp');
            guardarFiltrosEnCookies("#form-filtros-desp");
        });
    }

    // VALIDAR FORMULARIO FILTROS
    function validarFormularioFiltros(formulario) {
        const $formulario = $(formulario);
        console.log("Validando formulario: ", formulario);

        $.ajax({
            url: 'models/validarFormularioFiltros.php',
            type: 'POST',
            data: $formulario.serialize(),
            success: function (response) {
                $('#contenedor-principal').html(response);
            },
            error: function (error) {
                console.error('Error en la validación Filtros:', error);
                alert("Ocurrió un error al procesar la solicitud.");
            }
        });
    }

    // GUARDAR FILTROS EN COOKIES
    function guardarFiltrosEnCookies(formulario) {
        const filtros = {};
        const form = $(formulario);

        form.find('input[type="text"], input[type="number"], select').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();
            if (name) {
                filtros[name] = value;
            }
        });

        form.find('input[type="checkbox"]:checked').each(function () {
            const name = $(this).attr('name');
            if (name) {
                if (!filtros[name]) filtros[name] = [];
                filtros[name].push($(this).val());
            }
        });

        Cookies.set('filtros', JSON.stringify(filtros), { expires: 1 });
    }

    // VALIDAR FORMULARIO LOGIN
    function validarFormularioLogin() {
        $(document).on("submit", "#form_login", function (event) {
            event.preventDefault();

            const formulario = $("#form_login");

            $.ajax({
                url: 'models/validarFormularioLogin.php',
                type: 'POST',
                data: formulario.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        window.location.href = response.redirect;
                    } else {
                        alert("Error al iniciar sesión. Verifica tus credenciales.");
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error:', error);
                    alert("Ocurrió un error al procesar la solicitud.");
                }
            });
        });
    }

    // OBSERVAR CARGA DE ELEMENTOS
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

    // FUNCION 
    function observarIdsPublicaciones(containerSelector, itemSelector) {
        observarCarga(containerSelector, () => {
            id_publis.length = 0;
            $(`${containerSelector} ${itemSelector}`).each(function () {
                const id = $(this).data('id');
                if (id) id_publis.push(id);
            });
            console.log(`IDs cargados en ${containerSelector}:`, id_publis);
        });

        $(document).off(`mouseover.${itemSelector}`);
        $(document).on(`mouseover.${itemSelector}`, `${itemSelector} a`, function () {
            const cont = $(this).closest(itemSelector);
            const id = cont.data('id');
            if (id && id_publis.includes(id)) {
                console.log(`ID seleccionado en ${containerSelector}:`, id);
                sessionStorage.setItem('id_publi', id);
            }
        });

    }
    // MANEJAR RUTAS
    function manejarRuta(ruta_actual) {

        console.log("Ruta actual desde manejarRuta:", ruta_actual);

        // INDEX
        if (ruta_actual === '/HabitaRoom/index' || ruta_actual === '/HabitaRoom/index.php') {

            observarCarga('#contenedor-principal', () => {
                if ($('#contenedor-principal').length > 0) {
                    cargarPublicacionesIndex();
                    detectarFinDePagina();

                    observarIdsPublicaciones('#contenedor-principal', '.contenedor-publicacion');

                }
            });
        }

        // LOGIN
        else if (ruta_actual === '/HabitaRoom/login') {
            observarCarga('#form_login', validarFormularioLogin);
        }

        // PERFIL
        else if (ruta_actual === '/HabitaRoom/perfil') {
            observarIdsPublicaciones('#contenidoPerfil', '.contenedor-publicacion');
        }

        // CREAR PUBLICACION
        else if (ruta_actual === '/HabitaRoom/crearpublicacion') {
            observarCarga('#form_crear_publi', () => {
                asignarEventosForm();

                $(document).off("submit", "#form_crear_publi");
                $(document).on("submit", "#form_crear_publi", function (event) {
                    event.preventDefault();

                    const form = document.getElementById('form_crear_publi');
                    const campos = form.querySelectorAll('input, select, textarea');

                    let formularioValido = true;

                    campos.forEach(campo => {
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

        // PUBLICACION DE USUARIO
        else if (ruta_actual.startsWith('/HabitaRoom/publicacionusuario')) {

            const id = sessionStorage.getItem('id_publi');
            console.log("ID de publicación desde sessionStorage:", id);

            // Hacemos la solicitud AJAX para obtener la publicación
            $.ajax({
                url: 'controllers/PublicacionUsuarioController.php',
                type: 'POST',
                data: { id_publi: id },  // Enviamos el id de la publicación
                success: function (response) {
                    $('#contenidoMain').html(response);
                    console.log("Publicación cargada con éxito.");
                    window.scrollTo(0, 0);

                },
                error: function (xhr, status, error) {
                    console.error('Error al cargar la publicación:', error);
                    $('#contenidoMain').html("<p>Error al cargar la publicación. Intenta nuevamente.</p>");
                }
            });
        }

        // OFERTAS
        else if (ruta_actual === '/HabitaRoom/ofertas') {
            observarIdsPublicaciones('#ofertasContainer', '.offerContenedorPublicacion');
        }
        else {
            console.warn("Ruta no manejada:", ruta_actual);
        }
    }




    // ============ INICIO ============

    const ruta_actual = window.location.pathname;
    const id_publis = [];
    const id = null;
    var id_publi = null;

    cargarPagina(ruta_actual);
    manejarRuta(ruta_actual);


    window.addEventListener('popstate', function () {
        const ruta = window.location.pathname;
        console.log("Ruta actual (popstate): ", ruta);
        manejarRuta(ruta);
    });

});
