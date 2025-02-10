// app.js - Archivo de configuración de la aplicación

$(document).ready(function () {

    // ============
    // FUNCIONES
    // ============

    // Función para cargar el contenido de la página
    function cargarContenido(url, newUrl = true) {
        $.ajax({
            url: 'routes/redireccionWeb.php',
            type: 'GET',
            data: { site: url },
            success: function (response) {

                $('#contenidoMain').html(response);
                if (newUrl) {
                    window.history.pushState({ path: url }, '', url);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error: ' + error);
            }
        });


    }

    // Funcion para validar formulario
    function validarFormularioFiltros() {
        var formulario = $("#form-filtros-desp"); // Asegúrate de que el selector sea correcto
        console.log("Formulario serializado:", formulario.serialize());
        $.ajax({
            url: 'models/validarFormularioFiltros.php',
            type: 'POST',
            data: formulario.serialize(),
            success: function (response) {
                console.log("Respueata " + response)
                // Mostrar errores
                $('#contenidoMain').html(response); // Reemplaza el contenido principal con las nuevas publicaciones
            },
            error: function (error) {
                console.error('Error en la validación Filtros: ' + error);
                alert("Ocurrió un error al procesar la solicitud.");

            }
        });
    }

    //  Funcion para cargar valor de filtros en cookies
    function cargarFiltrosDesdeCookies() {
        var filtros = Cookies.get('filtros'); // Obtener las cookies almacenadas
        if (filtros) {
            filtros = JSON.parse(filtros); // Convertir el valor de la cookie en objeto

            // Establecer los valores de los filtros en los campos correspondientes
            $('#tipo-inmueble').val(filtros['tipo-inmueble']);
            $('#precio-min').val(filtros['precio-min']);
            $('#precio-max').val(filtros['precio-max']);
            $('#habitaciones').val(filtros['habitaciones']);
            $('#banos').val(filtros['banos']);

            // Checkbox (Estado y Características)
            filtros['estado'].forEach(function (estado) {
                $('#estado' + (filtros['estado'].indexOf(estado) + 1)).prop('checked', true);
            });

            filtros['caracteristicas'].forEach(function (caracteristica) {
                $('#caracteristica' + (filtros['caracteristicas'].indexOf(caracteristica) + 1)).prop('checked', true);
            });

            // Radio buttons (Habitaciones, Baños)
            $('input[name="habitaciones"][value="' + filtros['habitaciones'] + '"]').prop('checked', true);
            $('input[name="banos"][value="' + filtros['banos'] + '"]').prop('checked', true);
        }
    }


    // Función para guardar las opciones del formulario en una cookie
    function guardarFiltrosEnCookies() {
        var filtros = {
            'tipo-inmueble': $('#tipo-inmueble').val(),
            'precio-min': $('#precio-min').val(),
            'precio-max': $('#precio-max').val(),
            'habitaciones': $('input[name="habitaciones"]:checked').val(),
            'banos': $('input[name="banos"]:checked').val(),
            'estado': [],
            'caracteristicas': []
        };

        // Recoger los valores de los checkboxes
        $('input[name="estado[]"]:checked').each(function () {
            filtros['estado'].push($(this).val());
        });
        $('input[name="caracteristicas[]"]:checked').each(function () {
            filtros['caracteristicas'].push($(this).val());
        });

        Cookies.set('filtros', JSON.stringify(filtros), { expires: 7 });
    }



    // ============
    // NAVEGACION
    // ============

    // Cargar contenido de la página principal
    let ruta_actual = window.location.pathname;
    cargarContenido(ruta_actual, false)
    cargarFiltrosDesdeCookies();

    console.log('Página cargada: ' + ruta_actual);


    // Navegacion menu
    $(".routes a").click(function (event) {
        event.preventDefault();

        cargarContenido($(this).attr('href'));
    });


    $("#enviar-formulario").submit(function(event) {
        console.log("Formulario enviado");
    
        // Guardamos los filtros en cookies
        guardarFiltrosEnCookies();
        console.log("Cookies guardadas");
    
        // Llamamos a la función de validación
        validarFormularioFiltros();
    });
    

});