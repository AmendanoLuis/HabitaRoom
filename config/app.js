import { mostrarCargando, ocultarCargando } from '../public/js/loadingPage.js';
import { procesarFormularioCrearPublicacion, asignarEventosForm, validarCampo } from '../public/js/crearPublicacion.js';
import { mostrarImagenPrevia, asignarEventosFormRegistro } from '../public/js/register.js';
import { detectarFinDePagina, guardarPublicacion, procesarFormularioFiltros, cargarFiltros, inicializarBuscadorLateral, filtrarTipoPublicitante } from '/HabitaRoom/public/js/index.js';

$(document).ready(function () {

    // ============ FUNCIONES ============

    // CARGAR PAGINA CON AJAX
    async function cargarPagina(url) {
        try {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');

            const data = { site: url };
            if (id) {
                data.id = id;
            }

            mostrarCargando();

            const response = await $.ajax({
                url: 'routes/redireccionWeb.php',
                type: 'POST',
                data: data
            });

            if (response.includes('<!DOCTYPE html>')) {
                console.warn("Respuesta no válida para AJAX, parece una página completa.");
                return;
            }

            $('#contenidoMain').html(response);

            if (url === '/HabitaRoom/index' || url === '/HabitaRoom/index.php') {
                asignarEventosFormularios();
                cargarFiltros();
            }

        } catch (error) {
            console.error('Error al cargar el contenido: ', error);
        } finally {
            ocultarCargando();
        }
    }



    // CARGAR PUBLICACIONES EN INDEX
    async function cargarPublicacionesIndex() {
        if (ruta_actual === '/HabitaRoom/index' || ruta_actual === '/HabitaRoom/index.php') {
            try {
                mostrarCargando();

                const response = await $.ajax({
                    url: 'controllers/IndexController.php',
                    type: 'POST',
                    data: { ruta: ruta_actual }
                });

                $('#contenedor-principal').html(response);
            } catch (error) {
                console.error('Error al cargar publicaciones: ', error);
            } finally {
                ocultarCargando();
            }
        }
    }


    // ASIGNAR EVENTOS A FORMULARIOS INDEX
    function asignarEventosFormularios() {
        $(document).on("submit", "#form-filtros-desp", function (event) {
            event.preventDefault();

            console.log("Formulario desp enviado.");
            procesarFormularioFiltros(this);
        });
    }

    // VALIDAR FORMULARIO LOGIN
    function validarFormularioLogin() {
        $(document).on("submit", "#form_login", function (event) {
            event.preventDefault();

            const formulario = $("#form_login");

            mostrarCargando();

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
                },
                complete: function () {
                    ocultarCargando();
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

    // OBTENER IDs DE PUBLICACIONES
    function observarIdsPublicaciones(containerSelector, itemSelector) {
        observarCarga(containerSelector, () => {
            id_publis.length = 0;

            $(`${containerSelector} ${itemSelector}`).each(function () {
                const id_publi = $(this).data('id');
                if (id_publi) id_publis.push(id_publi);
            });

            console.log(`IDs cargados en ${containerSelector}:`, id_publis);
        });

        $(document).off(`mouseover.${itemSelector}`);
        $(document).on(`mouseover.${itemSelector}`, `${itemSelector} a`, function () {
            const cont = $(this).closest(itemSelector);
            const id_publi = cont.data('id');

            if (id_publi && id_publis.includes(id_publi)) {
                console.log(`ID seleccionado en ${containerSelector}:`, id_publi);
                sessionStorage.setItem('id_publi', id_publi);
            }
        });
    }

    // MANEJAR ACCIONES DE GUARDAR PUBLICACION
    function accionGuardar(ruta_actual) {
        $(document).on("click", "#icono-guardar", function (e) {
            e.preventDefault();
            e.stopPropagation();

            guardarPublicacion(this, ruta_actual);
        });
    }

    // MANEJAR RUTAS
    async function manejarRuta(ruta_actual) {
        console.log("Ruta actual desde manejarRuta:", ruta_actual);

        // INDEX
        if (ruta_actual === '/HabitaRoom/index' || ruta_actual === '/HabitaRoom/index.php') {
            await observarCarga('#contenedor-principal', async () => {
                if ($('#contenedor-principal').length > 0) {

                    await cargarPublicacionesIndex();

                    detectarFinDePagina();
                    observarIdsPublicaciones('#contenedor-principal', '.contenedor-publicacion');

                    // Asignar evento a los iconos de guardar
                    accionGuardar(ruta_actual);

                    // Asignar evento a buscador
                    inicializarBuscadorLateral();

                    // Asignar evento a los filtros principales
                    filtrarTipoPublicitante();
                }
            });
        }

        // LOGIN
        else if (ruta_actual === '/HabitaRoom/login') {
            observarCarga('#form_login', validarFormularioLogin);
        }

        // REGISTRO
        else if (ruta_actual === '/HabitaRoom/registro') {
            observarCarga('#cont_registro', () => {
                console.log('Contenedor de registro detectado, asignando eventos');

                asignarEventosFormRegistro();
                mostrarImagenPrevia();
            });
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

        // PUBLICACION 
        else if (ruta_actual.startsWith('/HabitaRoom/publicacionusuario?id=')) {
            const urlParams = new URLSearchParams(window.location.search);
            const id_publi = urlParams.get('id');

            if (id_publi) {
                console.log("ID de la URL:", id_publi);
                mostrarCargando();

                $.ajax({
                    url: 'controllers/PublicacionUsuarioController.php',
                    type: 'GET',
                    data: { id_publi },
                    success: function (response) {
                        $('#contenidoMain').html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al cargar la publicación:', error);
                        $('#contenidoMain').html("<p>Error al cargar la publicación. Intenta nuevamente.</p>");
                    },
                    complete: function () {
                        ocultarCargando();
                    }
                });
            } else {
                $('#contenidoMain').html("<p>No se encontró el id de la publicación.</p>");
            }
        }


        else if (ruta_actual === '/HabitaRoom/ofertas') {
            observarIdsPublicaciones('#ofertasContainer', '.offerContenedorPublicacion');
        } else if (ruta_actual === '/HabitaRoom/guardados') {
            observarCarga('#contenidoGuardadas', () => {
                observarIdsPublicaciones('#contenidoGuardadas', '.contenedor-publicacion');
            });
        } else {
            console.warn("Ruta no manejada:", ruta_actual);
        }
    }

    // ============ INICIO ============

    const ruta_actual = window.location.href.replace('http://localhost', '');
    const id_publis = [];
    const id_publi = null;

    cargarPagina(ruta_actual);
    manejarRuta(ruta_actual);

    window.addEventListener('popstate', function () {
        const ruta = window.location.pathname;
        console.log("Ruta actual (popstate): ", ruta);
        manejarRuta(ruta);
    });
});
