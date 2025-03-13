<div class="container-fluid text-dark mt-5 ">
    <div class="container">
        <!-- Encabezado del perfil -->
        <div class="profile-header">
            <!-- La imagen de perfil se mostrará aquí -->
            <img src="ruta/a/la/foto_perfil.jpg" alt="Foto de Perfil">
            <h2 id="nombre_usuario">Nombre del Usuario</h2>
            <p>@nombre_usuario</p>
        </div>
        <!-- Información del perfil -->
        <div class="profile-info">
            <dl>
                <dt>Nombre Completo:</dt>
                <dd id="nombre_completo">Nombre del Usuario</dd>
                <dt>Correo Electrónico:</dt>
                <dd id="correo_electronico">usuario@ejemplo.com</dd>
                <dt>Teléfono:</dt>
                <dd id="telefono">123456789</dd>
                <dt>Ubicación:</dt>
                <dd id="ubicacion">Ciudad, País</dd>
                <dt>Descripción:</dt>
                <dd id="descripcion">Breve descripción del usuario.</dd>
                <dt>Preferencia de Contacto:</dt>
                <dd id="preferencia_contacto">WhatsApp</dd>
                <dt>Términos y Condiciones:</dt>
                <dd id="terminos_aceptados">Aceptados</dd>
            </dl>
        </div>
    </div>
    <form action="controllers/LoginController.php" method="POST">
        <input type="hidden" name="logout" value="1">
        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
    </form>
</div>