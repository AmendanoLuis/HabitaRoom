// version: 1.0
// app.js - Archivo de configuración de la aplicación

$(document).ready(function () {

    // Función para cargar el contenido de la página
    function cargarContenido(url, newUrl = true) {
        $.ajax({
            url: 'routes/redireccionWeb.php',
            type: 'GET',
            data: { site: url },
            success: function (response) {

                $('#contenidoMain').html(response);
                console.log(response.slide(0,20))
                if (newUrl) {
                    window.history.pushState({ path: url }, '', url);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error: ' + error);
            }
        });


    }


    $("nav a").click(function (event) {
        event.preventDefault();

        // Obtener url del enlace
        var url = $(this).attr('href');

        cargarContenido(url);
    });

    // Cargar contenido de la página principal
    let ruta_actual = window.location.pathname;
    cargarContenido(ruta_actual, false)
    console.log('Página cargada: ' + ruta_actual);


});