<!-- BARRA DE NAVEGACIÓN -->
<nav class="navbar d-block navbar-dark navbar-expand-lg bg-body-tertiary shadow fixed-top z-5 ">

    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand d-flex justify-content-center align-items-center" href="/index">
            <img src="public/img/logo.jpg" alt="Logo" width="65" height="65"
                class="d-inline-block align-text-center ms-3" id="imgLogo">
            <h2 for="imgLogo" class="ms-2">HabitaRoom</h2>
        </a>

        <!-- Botón menú lateral -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido menú lateral -->
        <div class="offcanvas offcanvas-end bg-dark  " tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">

            <!-- Cabecera menú derecho -->
            <div class="offcanvas-header">
                <a class="navbar-brand" href="/index">
                    <img src="public/img/logo.jpg" alt="Logo" width="65" height="65"
                        class="d-inline-block align-text-center" id="imgLogo">
                    <label for="imgLogo" class="offcanvas-title">HabitaRoom</label>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <!-- Cuerpo menú lateral derecho -->
            <div class="offcanvas-body mx-auto">
                <hr>

                <!-- Usuario menú lateral -->
                <a class="navbar-brand me-auto d-lg-none" href="/perfil">
                    <img src="public/img/imgUsuario.png" alt="Logo" width="50" height="50"
                        class="d-inline-block align-text-center rounded-circle">
                    <label for="imgUsuario" class="fs-5">Usuario</label>
                </a>
                <hr>

                <!-- Menú -->
                <ul class="navbar-nav nav-underline justify-content-end flex-grow-1 pe-3 me-5">
                    <li class="nav-item">
                        <a class="nav-link active"  href="/index">
                            <i class="d-lg-none d-inline bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/crearpublicacion">
                            <i class="d-lg-none d-inline bi bi-plus-square"></i> Publicación
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/novedades">
                            <i class="d-lg-none d-inline bi bi-postcard"></i> Novedades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/guardados">
                            <i class="d-lg-none d-inline bi bi-bookmark"></i> Guardados
                        </a>
                    </li>
                </ul>
                <hr>

                <!-- Barra de búsqueda -->
                <form class="d-flex ms-auto" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>

        <!-- Usuario Menú -->
        <a class="navbar-brand me-3 d-lg-block d-none" href="/perfil">
            <label for="imgUsuario" class="fs-5 me-2">Usuario</label>
            <img src="public/img/imgUsuario.png" alt="Logo" width="50" height="50"
                class="d-inline-block align-text-center rounded-circle">
        </a>
    </div>
</nav>

<!-- BLOQUE ESPACIO -->
<div class="bloque-menu-nav"></div>
