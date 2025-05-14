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

function formatearDatosPublicacion(form) {


    const getValue = (name, fallback = '') => {
        const el = form.querySelector(`[name="${name}"]`);
        return el ? el.value.trim() || fallback : fallback;
    };

    const getInt = (name, fallback = 0) => {
        const v = parseInt(getValue(name), 10);
        return isNaN(v) ? fallback : v;
    };

    const getFloat = (name, fallback = 0.0) => {
        const v = parseFloat(getValue(name));
        return isNaN(v) ? fallback : v;
    };

    const getBool = (name) => {
        const el = form.querySelector(`[name="${name}"]`);
        return el && el.checked ? 1 : 0;
    };

    const habitaciones = parseInt(
        document.getElementById('num_habitaciones')?.textContent.trim() || '0',
        10
    );
    const banos = parseInt(
        document.getElementById('num_banos')?.textContent.trim() || '0',
        10
    );

    return {
        usuario_id: getInt('usuario_id'),
        tipo_anuncio: getValue('tipo_anuncio', 'venta'),
        tipo_inmueble: getValue('tipo_inmueble', 'casa'),
        ubicacion: getValue('ubicacion', 'Sin especificar'),
        titulo: getValue('titulo', 'Título no proporcionado'),
        descripcion: getValue('descripcion', 'Sin descripción.'),
        precio: getFloat('precio'),
        habitaciones,
        banos,
        estado: getValue('estado', 'usado'),
        ascensor: getBool('ascensor'),
        piscina: getBool('piscina'),
        gimnasio: getBool('gimnasio'),
        garaje: getBool('garaje'),
        terraza: getBool('terraza'),
        jardin: getBool('jardin'),
        aire_acondicionado: getBool('aire_acondicionado'),
        calefaccion: getBool('calefaccion'),
        tipo_publicitante: getValue('tipo_publicitante', 'habitante'),
        superficie: getFloat('superficie')
    };
}

function agregarError(elemento, mensaje) {
    eliminarError(elemento);
    elemento.classList.add('is-invalid');
    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback d-block';
    feedback.textContent = mensaje;
    const wrapper = elemento.closest('.input-group') || elemento.parentNode;
    wrapper.parentNode.insertBefore(feedback, wrapper.nextSibling);
}

function eliminarError(elemento) {
    elemento.classList.remove('is-invalid');
    const wrapper = elemento.closest('.input-group') || elemento.parentNode;
    const fb = wrapper.parentNode.querySelector('.invalid-feedback');
    if (fb) fb.remove();
}

// ————————————————————————————————
//  Funciones de validación de campos
// ————————————————————————————————

export function validarCampo(campo) {
    const valor = campo.value.trim();
    let valido = true;

    if (campo.required && valor === '') {
        agregarError(campo, 'Este campo es obligatorio');
        valido = false;
    }
    else if (campo.name === 'precio' && (isNaN(valor) || valor === '')) {
        agregarError(campo, 'Por favor, ingresa un precio válido');
        valido = false;
    }
    else if (campo.name === 'superficie' && valor !== '' && isNaN(valor)) {
        agregarError(campo, 'Por favor, ingresa una superficie válida');
        valido = false;
    }
    else if (campo.name === 'descripcion' && valor.length < 10) {
        agregarError(campo, 'La descripción debe tener al menos 10 caracteres');
        valido = false;
    }

    if (valido) eliminarError(campo);
    return valido;
}

// ————————————————————————————————
//  Asignación de eventos al formulario
// ————————————————————————————————

export function asignarEventosForm() {

    // Asignar eventos a los campos de entrada
    controlValoresBanHab('#btn_menos_hab', '#num_habitaciones', '#btn_mas_hab', 4);
    controlValoresBanHab('#btn_menos_banos', '#num_banos', '#btn_mas_banos', 3);

    // Validación en tiempo real: al perder foco
    document
        .querySelectorAll('#form_crear_publi input, #form_crear_publi select, #form_crear_publi textarea')
        .forEach(campo => campo.addEventListener('blur', () => validarCampo(campo)));

    // PREVIEW de la imagen (solo la primera)
    const fileInput = document.getElementById('file_input');
    const previewArea = document.getElementById('preview-area');
    const placeholder = document.getElementById('upload-placeholder');

    fileInput.addEventListener('change', () => {
        // Limpiar vista previa
        previewArea.innerHTML = '';

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'img-fluid rounded shadow';
            img.style.maxHeight = '350px'; // Aumentamos el tamaño máximo
            img.style.objectFit = 'cover';

            previewArea.appendChild(img);
        } else {
            // Restaurar placeholder si no hay archivo
            previewArea.appendChild(placeholder);
            placeholder.style.display = 'block';
        }
    });

}

// ————————————————————————————————
//  Enviar el formulario de crear publicación
// ————————————————————————————————
export function procesarFormularioCrearPublicacion() {

    const form = document.getElementById('form_crear_publi');
    if (!form) return;

    // Obtengo datos limpios
    const datos = formatearDatosPublicacion(form);
    console.log("Datos formateados:", datos);

    // Creo FormData y lo lleno con esos valores
    const formData = new FormData();
    Object.entries(datos).forEach(([key, value]) => {
        formData.append(key, value);
    });

    // Agrego los datos de la imagen
    const fileInput = form.querySelector('#file_input');
    if (fileInput && fileInput.files.length) {
        Array.from(fileInput.files).forEach(file => {
            formData.append('imagenes[]', file, file.name);
        });
    }

    console.log("Formulario de crear publicación enviado.");
    for (const [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
    }

    // Agrego el botón de crear publicación
    formData.append('btn_crear_publi', '1');

    // Envío el formulario usando AJAX
    $.ajax({
        type: 'POST',
        url: 'controllers/CrearPublicacionController.php',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success(resp) {
            
            if (resp.success) {
                Swal.fire({
                    title: '¡Publicación creada!',
                    text: 'Tu anuncio se ha publicado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Ver mi anuncio'
                }).then(() => {
                    window.location.href = '/HabitaRoom/publicacionusuario?id=' + resp.id_publicacion;
                
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: resp.message || 'No estás Registrado.\nPor favor, inicia sesión para continuar.',
                    icon: 'error',
                    confirmButtonText: 'Registrarme'
                }).then(() => {
                    // Redirigir a la página de registro
                    window.location.href = '/HabitaRoom/registro';
                });
            }
            },
            error(xhr, status, error) {
                console.error('Error AJAX:', error);
                console.log('---- responseText crudo ----');
                console.log(xhr.responseText);
                console.log('-----------------------------');
            }
        });

}