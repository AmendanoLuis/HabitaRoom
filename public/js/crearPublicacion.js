function cambiarValor(numero, incremento, maximo) {
    let valorActual = parseInt($(numero).text());
    let nuevoValor = valorActual + incremento;

    if (nuevoValor >= 1 && nuevoValor <= maximo) {
        $(numero).text(nuevoValor);
    }
}

function controlValoresBanHab(selectorMenos, selectorNumero, selectorMas, maximo) {
    $(document).on("click", selectorMenos, function () {
        cambiarValor(selectorNumero, -1, maximo);
    });

    $(document).on("click", selectorMas, function () {
        cambiarValor(selectorNumero, 1, maximo);
    });
}

function mostrarModal(mensaje) {

    document.getElementById('mensajeModal').style.display = 'block';
    document.getElementById('mensajeModal').style.zIndex = '10000';
    document.getElementById('mensajeModal').style.backgroundColor = 'rgba(0,0,0,0.7)';
    document.getElementById('mensajeModal').style.color = 'white';
    document.getElementById('mensajeModal').style.padding = '20px';
    document.getElementById('mensajeModal').style.borderRadius = '10px';
    document.getElementById('mensajeModal').style.fontSize = '16px';

    document.getElementById('mensajeModal').querySelector('#mensajeModal').innerHTML = mensaje;
}

function cerrarModal() {
    document.getElementById('mensajeModal').style.display = 'none';
}


function asignarEventosForm() {
    controlValoresBanHab('#btn_menos_hab', '#num_habitaciones', '#btn_mas_hab', 4); 
    controlValoresBanHab('#btn_menos_banos', '#num_banos', '#btn_mas_banos', 3); 
}
