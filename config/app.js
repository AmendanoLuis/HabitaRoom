$(document).ready(function () {

    // ============ FUNCIONES ============

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

    // ============ INICIO ============
    let ruta_actual = window.location.pathname;
    console.log('Ruta actual: ' + ruta_actual);

    cargarPagina(ruta_actual);

    if (ruta_actual === '/HabitaRoom/index') {

        // Verificamos que contenidoMain exista
        const contMain = document.getElementById('contenidoMain');
        if (!contMain) {
            console.log("No se encontro contenidoMain");
            return
        }

        // Creamos el observador

        const observ = new MutationObserver(()=>{
            if($('#contenedor-principal')){
                console.log("¡#contenedor-principal detectado dentro de #contenidoMain!");
                cargarPublicacionesIndex();

                // Cerrar observador
                observ.disconnect(); 
            }
        });

        observ.observe(contMain, { childList: true, subtree: true });


    } else {
        $('#contenedor-principal').html(`
            <div class="alert alert-danger" role="alert"> No encontramos publicaciones disponibles. </div>
            `);

        console.log("PAGINA NO ES INDEX");
    }



    // Cargar filtros desde cookies al inicio


});
