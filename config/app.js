$(document).ready(function () {

    // ============ FUNCIONES ============

    // Función para cargar el contenido de la página
    function cargarContenido(url, newUrl = true) {
        $.ajax({
            url: 'routes/redireccionWeb.php',
            type: 'POST',
            data: { site: url },
            success: function (response) {
                $('#contenidoMain').html(response);
                if (newUrl) {
                    window.history.pushState({ path: url }, '', url);
                }

                // Asignar el evento de envío a los formularios después de cargar el contenido
                asignarEventosFormularios();
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar el contenido: ', error);
            }
        });
    }

    // Asignar eventos de validación y envío a los formularios
    function asignarEventosFormularios() {

        // Evento para el formulario de la cabecera
        $(document).on("submit", "#form-filtros-cabecera", function (event) {
            console.log("Formulario cabecera enviado.");
            event.preventDefault();

            // Guardar filtros en cookies
            guardarFiltrosEnCookies(this);  // Cambié esto para pasar el formulario actual

            // Validar formulario de la cabecera
            validarFormularioFiltros('#form-filtros-cabecera');
        });

        // Evento para el formulario cargado por AJAX en el contenedor principal
        $(document).on("submit", "#form-filtros-desp", function (event) {
            console.log("Formulario desp enviado.");
            event.preventDefault();

            // Guardar filtros en cookies
            guardarFiltrosEnCookies(this);  // Cambié esto para pasar el formulario actual

            // Validar formulario cargado por AJAX
            validarFormularioFiltros('#form-filtros-desp');
        });
    }

    // Función para validar el formulario
    function validarFormularioFiltros(formulario) {
        var $formulario = $(formulario);
        console.log("Validando formulario: ", formulario);

        $.ajax({
            url: 'models/validarFormularioFiltros.php',
            type: 'POST',
            data: $formulario.serialize(),
            success: function (response) {
                $('#contenidoMain').html(response);
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
                console.log("Valores Input y select: " + name + "=>" + $(this).val())

                filtros[name].push($(this).val());
            }
        });

        console.log(filtros);

        Cookies.set('filtros', JSON.stringify(filtros), { expires: 1 });
    }

    // Función para cargar filtros desde cookies
    /*
    function cargarFiltrosDesdeCookies() {
        var filtros = Cookies.get('filtros');
        if (filtros) {
            filtros = JSON.parse(filtros);
    
            // Iterar sobre todos los formularios en la página
            $('form').each(function () {
                var form = $(this);
    
                // Asignar valores a los inputs de texto, número, y selects
                form.find('input[type="text"], input[type="number"], select').each(function () {
                    var name = $(this).attr('name');
                    if (filtros[name]) {
                        $(this).val(filtros[name]);
                    }
                });
    
                // Asignar valores a los checkboxes
                form.find('input[type="checkbox"]').each(function () {
                    var name = $(this).attr('name');
                    if (filtros[name] && filtros[name].includes($(this).val())) {
                        $(this).prop('checked', true);
                    }
                });
            });
    
            // Ver para depuración
            console.log("Filtros cargados desde cookies: ", filtros);
        } else {
            console.log("No se han cargado los filtros.")
        }
    }
     */

    // ============ INICIO ============

    // Cargar el contenido inicial de la página
    let ruta_actual = window.location.pathname;
    console.log('Ruta actual: ' + ruta_actual);
    cargarContenido(ruta_actual, false);

    // Navegación del menú
    $(".routes a").click(function () {
        cargarContenido($(this).attr('href'));
    });

    // Cargar filtros desde cookies al inicio


});
