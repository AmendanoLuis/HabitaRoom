$(document).ready(function () {

    // ============ FUNCIONES INDEX ============

    // Función para cargar el contenido de una página en el contenedor principal
    function cargarPagina(url) {
        $.ajax({
            url: 'routes/redireccionWeb.php',
            type: 'POST',
            data: { site: url },
            success: function (response) {
                $('#contenidoMain').html(response);

                // Asignar el evento de envío a los formularios después de cargar el contenido
                asignarEventosFormularios();
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar el contenido: ', error);
            }
        });

    }

    // Función para cargar las publicaciones en la página principal
    function cargarPublicacionesIndex() {

        $.ajax({
            url: 'models/cargarPublicaciones.php',
            type: 'POST',
            success: function (response) {

                $('#contenedor-principal').html(response);

            },
            error: function (xhr, status, error) {
                console.log('Error al cargar el publicaciones: ', error);
            }
        });
    }

    // Función para asignar eventos a los formularios cargados por AJAX
    function asignarEventosFormularios() {


        // Evento para el formulario cargado por AJAX en el contenedor principal
        $(document).on("submit", "#form-filtros-desp", function (event) {
            event.preventDefault();
            console.log("Formulario desp enviado.");

            // Validar formulario cargado por AJAX
            validarFormularioFiltros('#form-filtros-desp');

            // Guardar filtros en cookies
            guardarFiltrosEnCookies("#form-filtros-desp");

        });
    }

    // Función para validar el formulario de filtros
    function validarFormularioFiltros(formulario) {
        var $formulario = $(formulario);
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

    // Función para guardar los filtros en cookies
    function guardarFiltrosEnCookies(formulario) {
        var filtros = {};

        // Recoger los valores de los inputs del formulario específico
        var form = $(formulario);

        // Recoger los campos de texto (inputs) y valores seleccionados
        form.find('input[type="text"], input[type="number"], select').each(function () {
            var name = $(this).attr('name');
            var value = $(this).val();
            console.log("Valores Input y select: " + name + "=>" + value)
            if (name) {
                filtros[name] = value;
            }
        });

        // Recoger los valores de los checkboxes (con el atributo name[])
        form.find('input[type="checkbox"]:checked').each(function () {
            var name = $(this).attr('name');
            if (name) {
                if (!filtros[name]) {
                    filtros[name] = [];
                }
                console.log("Valores Check: " + name + "=>" + $(this).val())

                filtros[name].push($(this).val());
            }
        });

        console.log(filtros);

        Cookies.set('filtros', JSON.stringify(filtros), { expires: 1 });
    }

    // ============ FUNCIONES LOGIN ============

    function validarFormularioLogin() {

        // Evento para el formulario de login
        $(document).on("submit", "#form_login", function (event) {
            event.preventDefault();

            var formulario = $("#form_login");

            console.log("Formulario de login enviado.");

            $.ajax({
                url: 'models/validarFormularioLogin.php',
                type: 'POST',
                data: formulario.serialize(),
                dataType: 'json',
                success: function (response) {
                    console.log("Respuesta del servidor:", response);

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

    // ============ INICIO ============
    let ruta_actual = window.location.pathname;
    console.log('Ruta actual: ' + ruta_actual);

    cargarPagina(ruta_actual);

    // INDEX
    if (ruta_actual === '/HabitaRoom/index' || ruta_actual === '/HabitaRoom/index.php') {

        const contMain = document.getElementById('contenidoMain');
        if (!contMain) {
            console.log("No se encontro contenidoMain");
            return
        }

        // Observador
        const observ = new MutationObserver(() => {
            if ($('#contenedor-principal').length > 0) {

                cargarPublicacionesIndex();
                detectarFinDePagina();

                // Cerrar observador
                observ.disconnect();
            }

        });

        observ.observe(contMain, { childList: true, subtree: true });


    } else {
        $('#contenedor-principal').html(`
            <div class="alert alert-danger" role="alert"> No encontramos publicaciones disponibles. </div>
            `);
    }

    // LOGIN
    if (ruta_actual === '/HabitaRoom/login') {
        validarFormularioLogin();
    }

   // CREAR PUBLICACION
if (ruta_actual === '/HabitaRoom/crearpublicacion') {

    const contMain = document.getElementById('contenidoMain');
    if (!contMain) {
        console.log("No se encontró contenidoMain");
        return;
    }

    const observ = new MutationObserver(() => {

        if ($('#form_crear_publi').length > 0) {

            asignarEventosForm();

            $(document).on("submit", "#form_crear_publi", function (event) {
                event.preventDefault();

                const formData = new FormData(this); // Usamos FormData para manejar formularios con archivos

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'), 
                    data: formData,
                    processData: false, // Necesario para enviar las imágenes de publicación
                    contentType: false,  // Necesario para evitar el formato JQUERY como contentType
                    success: function(response) {
                        console.log(response); // Imprimir el mensaje en la consola
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al enviar el formulario:", error);
                    }
                });

            });

            observ.disconnect();
        }

    });

    observ.observe(contMain, { childList: true, subtree: true });

}


    // NOVEDADES

    // GUARDADOS

});


