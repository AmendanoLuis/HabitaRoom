
// ————————————————————————————————
// Función para asignar eventos al formulario de registro
// ————————————————————————————————
export function asignarEventosFormRegistro() {
    $('#cont_registro').on('submit', function (event) {
        event.preventDefault();
        const form = this;

        if (validarFormularioRegistro(form)) {
            enviarFormularioRegistro(form);
        }
    });
}


// ————————————————————————————————
// Mostrar la imagen previa de perfil
// ————————————————————————————————
export function mostrarImagenPrevia() {
    const fileInput = document.getElementById('fileInput');
    const previewArea = document.getElementById('perfil-preview');

    // Placeholder para cuando no hay imagen
    const placeholder = document.createElement('div');
    placeholder.className = 'text-secondary';
    placeholder.innerHTML = `
        <i class="bi bi-camera fs-3"></i>
        <p>Añade una foto de perfil</p>
    `;

    // Mostrar placeholder inicialmente
    previewArea.innerHTML = '';
    previewArea.appendChild(placeholder);

    fileInput.addEventListener('change', () => {
        previewArea.innerHTML = '';

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'img-fluid rounded shadow';
            img.style.maxHeight = '350px';
            img.style.objectFit = 'cover';

            previewArea.appendChild(img);

            img.onload = () => URL.revokeObjectURL(img.src);
        } else {
            previewArea.appendChild(placeholder);
        }
    });
}


// ————————————————————————————————
// Validar el formulario de registro
// ————————————————————————————————
function validarFormularioRegistro(form) {
    // Nombre
    const nombre = form.nombre.value.trim();
    if (nombre.length < 2 || nombre.length > 50 || !/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(nombre)) {
        mostrarError("El nombre debe tener entre 2 y 50 caracteres y solo contener letras y espacios.", form.nombre);
        return false;
    }

    // Apellidos
    const apellidos = form.apellidos.value.trim();
    if (apellidos.length < 2 || apellidos.length > 50 || !/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(apellidos)) {
        mostrarError("Los apellidos deben tener entre 2 y 50 caracteres y solo contener letras y espacios.", form.apellidos);
        return false;
    }

    // Nombre de Usuario
    const nombre_usuario = form.nombre_usuario.value.trim();
    if (nombre_usuario.length < 3 || nombre_usuario.length > 20 || !/^[a-zA-Z0-9_]+$/.test(nombre_usuario)) {
        mostrarError("El nombre de usuario debe tener entre 3 y 20 caracteres y solo puede contener letras, números y guion bajo.", form.nombre_usuario);
        return false;
    }

    // Correo Electrónico
    const correo_electronico = form.correo_electronico.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo_electronico)) {
        mostrarError("Ingresa un correo electrónico válido.", form.correo_electronico);
        return false;
    }

    // Teléfono
    const telefono = form.telefono.value.trim();
    if (!/^\d{7,15}$/.test(telefono)) {
        mostrarError("El teléfono debe contener solo números y tener entre 7 y 15 dígitos.", form.telefono);
        return false;
    }

    // Contraseña
    const contrasena = form.contrasena.value;
    if (contrasena.length < 8 || contrasena.length > 50) {
        mostrarError("La contraseña debe tener entre 8 y 50 caracteres.", form.contrasena);
        return false;
    }

    // Repetir contraseña
    const repContrasena = form.repContrasena.value;
    if (contrasena !== repContrasena) {
        mostrarError("Las contraseñas no coinciden. Por favor, repítela correctamente.", form.repContrasena);
        return false;
    }

    // Tipo de Usuario
    if (!form.tipo_usuario.value) {
        mostrarError("Debes seleccionar un tipo de usuario.", form.tipo_usuario);
        return false;
    }

    // Ubicación
    const ubicacion = form.ubicacion.value.trim();
    if (ubicacion && (ubicacion.length < 2 || ubicacion.length > 100)) {
        mostrarError("La ubicación debe tener entre 2 y 100 caracteres.", form.ubicacion);
        return false;
    }

    // Foto de Perfil
    const foto_perfil = form.foto_perfil.files[0];
    if (foto_perfil) {
        const validTypes = ["image/jpeg", "image/png", "image/gif"];
        if (!validTypes.includes(foto_perfil.type)) {
            mostrarError("La foto de perfil debe ser JPG, PNG o GIF.", form.foto_perfil);
            return false;
        }
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (foto_perfil.size > maxSize) {
            mostrarError("La foto de perfil debe pesar menos de 2MB.", form.foto_perfil);
            return false;
        }
    }

    // Descripción
    const descripcion = form.descripcion.value.trim();
    if (descripcion.length < 10 || descripcion.length > 500) {
        mostrarError("La descripción debe tener entre 10 y 500 caracteres.", form.descripcion);
        return false;
    }

    // Preferencia de Contacto
    if (!form.preferencia_contacto.value) {
        mostrarError("Debes seleccionar una preferencia de contacto.", form.preferencia_contacto);
        return false;
    }

    // Términos y condiciones
    if (!form.terminos_aceptados.checked) {
        mostrarError("Debes aceptar los términos y condiciones.", form.terminos_aceptados);
        return false;
    }

    return true;
}

// ————————————————————————————————
// Enviar el formulario de registro
// ————————————————————————————————
function enviarFormularioRegistro(form) {
    Swal.fire({
        title: 'Registrando...',
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: false
    });

    const formData = new FormData(form);
    formData.append('btn_registro', '1');

    $.ajax({
        url: 'controllers/RegistroController.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.close();

            if (response.success) {
                Swal.fire('¡Éxito!', response.message || 'Registro completado.', 'success')
                    .then(() => {
                        window.location.href = '/HabitaRoom/login';
                    });
                form.reset();
            } else {
                Swal.fire('Error', response.message || 'Hubo un problema con el registro.', 'error');
            }
        },
        error: function (xhr, status, error) {
            Swal.close();
            Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
            console.error('Error AJAX:', error);
        }
    });
}

// ————————————————————————————————
// Mostrar mensaje de error
// ————————————————————————————————
function mostrarError(mensaje, campo) {
  Swal.fire({
    title: 'Error',
    text: mensaje,
    icon: 'error',
    confirmButtonText: 'Aceptar'
  }).then(() => {
    campo.focus();
  });
}