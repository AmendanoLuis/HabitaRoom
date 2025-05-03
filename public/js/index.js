
// Detecta cuando el usuario ha llegado al final de la página
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

export function guardarPublicacion(elemento, ruta_actual) {

    const icono = $(elemento).find("i");
    const id_publicacion = $(elemento).data("id-publicacion");
    const esGuardado = $(elemento).find("i").hasClass("bi-bookmark-fill");

    // Mostrar loading
    mostrarCargando();

    $.ajax({
        url: "controllers/GuardadosController.php",
        type: "POST",
        data: {
            id_publicacion,
            guardar: !esGuardado,
            quitarGuardado: esGuardado,
            rutaGuardar: ruta_actual
        },
        dataType: "json",
        success: function (response) {

            if (response.status === "success") {
                if (esGuardado) {
                    icono.removeClass("bi-bookmark-fill text-warning").addClass("bi-bookmark");
                } else {
                    icono.removeClass("bi-bookmark").addClass("bi-bookmark-fill text-warning");
                }
            } else {
                console.error("Error al guardar la publicación:", response.message);
            }

        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        },
        // Es importante ocultar el loading tanto si la solicitud tiene éxito como si falla
        complete: function () {
            ocultarCargando();
        }
    });
}




