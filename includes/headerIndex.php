<!-- BARRA DE NAVEGACIÓN -->
<nav class="navbar d-block navbar-dark navbar-expand-lg bg-black bg-opacity-100 shadow fixed-top z-2">
    <div class="container-fluid">

        <!-- Botón menú lateral izquierdo -->
        <button class="navbar-toggler me-auto d-lg-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbarLeft" aria-controls="offcanvasNavbarLeft"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo -->
        <a class="navbar-brand d-flex justify-content-center align-items-center" href="/HabitaRoom/index">
            <img src="public/img/logo.jpg" alt="Logo" width="65" height="65"
                class="d-inline-block align-text-center ms-3" id="imgLogo">
            <h2 for="imgLogo" class="ms-2">HabitaRoom</h2>
        </a>

        <!-- Botón menú lateral derecho -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido menú lateral derecho -->
        <div class="offcanvas offcanvas-end bg-dark  " tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">

            <!-- Cabecera menú derecho -->
            <div class="offcanvas-header">
                <a class="navbar-brand" href="/HabitaRoom/index">
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
                <a class="navbar-brand me-auto d-lg-none" href="/HabitaRoom/perfil">
                    <img src="public/img/imgUsuario.png" id="imgUsuario" alt="Logo" width="50" height="50"
                        class="d-inline-block align-text-center rounded-circle">
                    <label for="imgUsuario" class="fs-5">Usuario</label>
                </a>
                <hr>

                <!-- Menú -->
                <ul class="navbar-nav nav-underline justify-content-end flex-grow-1 pe-3 me-5">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/HabitaRoom/index">
                            <i class="d-lg-none d-inline bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/HabitaRoom/crearpublicacion">
                            <i class="d-lg-none d-inline bi bi-plus-square"></i> Publicación
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/HabitaRoom/novedades">
                            <i class="d-lg-none d-inline bi bi-postcard"></i> Novedades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/HabitaRoom/guardados">
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

        <!-- Contenido menú lateral izquierdo -->
        <div class="offcanvas offcanvas-start bg-dark text-light d-lg-none" tabindex="-1" id="offcanvasNavbarLeft"
            aria-labelledby="offcanvasNavbarLeftLabel">

            <!-- Cabecera menú izquierdo -->
            <div class="offcanvas-header">
                <h5 class="offcanvas-title ">
                    <i class="bi bi-sliders"></i> Filtros <!-- Icono de ajustes -->
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>

            <!-- Cuerpo menú lateral izquierdo -->
            <div class="offcanvas-body mx-auto">
                <!-- Formulario de Filtros -->
                <form action="#">
                    <div class="container p-3">
                        <h5 class="fw-bold fs-md-6 fs-sm-5">Tipo de Inmueble</h5>
                        <select class="form-select">
                            <option selected>Alquiler, etc</option>
                        </select>

                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Precio</h5>
                        <div class="row">
                            <div class="col">
                                <select class="form-select">
                                    <option selected>Min</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select">
                                    <option selected>Max</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Habitación / Habitaciones</h5>
                        <div class="btn-group" role="group" aria-label="Grupo de habitaciones">
                            <input type="radio" class="btn-check" name="habitaciones" id="hab1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hab1">1</label>

                            <input type="radio" class="btn-check" name="habitaciones" id="hab2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hab2">+2</label>

                            <input type="radio" class="btn-check" name="habitaciones" id="hab3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hab3">+3</label>

                            <input type="radio" class="btn-check" name="habitaciones" id="hab4" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hab4">+4</label>
                        </div>

                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Baños</h5>
                        <div class="btn-group" role="group" aria-label="Grupo de baños">
                            <input type="radio" class="btn-check" name="banos" id="bano1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="bano1">1</label>

                            <input type="radio" class="btn-check" name="banos" id="bano2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="bano2">+2</label>

                            <input type="radio" class="btn-check" name="banos" id="bano3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="bano3">+3</label>
                        </div>

                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Estado</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Características</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Usuario Menú -->
        <a class="navbar-brand me-3 d-lg-block d-none" href="/HabitaRoom/perfil">
            <label for="imgUsuario" class="fs-5 me-2">Usuario</label>
            <img src="public/img/imgUsuario.png" alt="Logo" width="50" height="50"
                class="d-inline-block align-text-center rounded-circle">
        </a>
    </div>
</nav>

<!-- BLOQUE ESPACIO -->