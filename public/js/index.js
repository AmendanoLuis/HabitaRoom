
// Detecta cuando el usuario ha llegado al final de la página
function detectarFinDePagina() {

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





