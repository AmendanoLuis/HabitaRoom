<?php
$activeRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<!-- BARRA DE NAVEGACIÓN -->
<nav class="navbar d-block navbar-dark navbar-expand-lg color_fondo_header shadow fixed-top z-5 ">
    <div class="container-fluid">

        <!-- Botón menú lateral izquierdo -->
        <button class="navbar-toggler me-auto d-lg-none  " id="btnMenuLateralIzq" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbarLeft" aria-controls="offcanvasNavbarLeft"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon border-dark "></span>
        </button>

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-end" href="/HabitaRoom/index">
            <img class="ms-3" src="public/img/logo_HR_sinFondo.png" id="imgLogo" alt="Logo" width="65" height="65">
            <h2 for="imgLogo" class="ms-2 fs-1" id="text_logo">HabitaRoom</h2>
        </a>

        <!-- Botón menú lateral Derecho -->
        <button class="navbar-toggler ms-auto" id="btnMenuLateralDerch" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon "></span>

        </button>

        <!-- CONTENIDO MENU LATERAL DERECHO -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">

            <!-- Cabecera menú Derecho -->
            <div class="offcanvas-header ">
                <a class="navbar-brand text-dark ps-4 mt-4" href="/HabitaRoom/index">
                    <label for="imgLogo" class="offcanvas-title fs-2">HabitaRoom</label>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <!-- Cuerpo menú lateral Derecho -->
            <div class="offcanvas-body mx-auto">
                <hr>

                <!-- Usuario menú lateral Derecho -->
                <a class="navbar-brand me-auto d-lg-none text-dark " href="/HabitaRoom/perfil" id="usuarioMenuLateral">
                    <img src="public/img/imgUsuario.png" id="imgUsuario" alt="Logo" width="50" height="50"
                        class="d-inline-block align-text-center rounded-circle">
                    <label for="imgUsuario" class="fs-5 ">Usuario</label>
                </a>
                <hr>

                <!-- Menú Navegacion | Menu Lateral Derecho -->
                <ul class=" navbar-nav nav-underline justify-content-end flex-grow-1 ps-3 me-5" id="menuLateralIndex">

                    <!-- Inicio -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeRoute === '/HabitaRoom/index') ? 'active' : ''; ?>" aria-current="page" href="/HabitaRoom/index">
                            <i class="d-lg-none d-inline bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <!-- Publicacion -->

                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeRoute === '/HabitaRoom/crearpublicacion') ? 'active' : ''; ?>" href="/HabitaRoom/crearpublicacion">
                            <i class="d-lg-none d-inline bi bi-plus-square"></i> Publicación
                        </a>
                    </li>

                    <!-- Ofertas -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeRoute === '/HabitaRoom/ofertas') ? 'active' : ''; ?>" href="/HabitaRoom/ofertas">
                            <i class="d-lg-none d-inline bi bi-postcard"></i> Ofertas
                        </a>
                    </li>

                    <!-- Guardados -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeRoute === '/HabitaRoom/guardados') ? 'active' : ''; ?>" href="/HabitaRoom/guardados">
                            <i class="d-lg-none d-inline bi bi-bookmark"></i> Guardados
                        </a>
                    </li>
                </ul>
                <hr>

                <!-- Barra de búsqueda Lateral Derecho-->
                    <form class="d-flex ms-auto ps-3 <?php echo ($activeRoute === "/HabitaRoom/index") ? '' : 'invisible pe-none' ?>" id="formBuscarLateral" role="search">
                        <input id="inputBuscar" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                <hr>

                <!-- Contenedor Mapa en el Menú Lateral Derecho -->
                <div id="mapaMenuLateral" class="d-lg-none d-flex flex-column justify-content-center align-items-center flex-grow-1 p-2">
                    <iframe src="https://www.google.com/maps/embed?pb=..." class="w-100 h-75 px-2 mb-3" allowfullscreen="" loading="lazy"></iframe>
                    <div class="form w-100 p-2">
                        <input type="text" placeholder="Buscar" class="form-control mb-2">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                </div>
            </div>

        </div>

        <!-- CONTENIDO MENU LATERAL IZQUIERDO -->
        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbarLeft"
            aria-labelledby="offcanvasNavbarLeftLabel">

            <!-- Cabecera menú izquierdo -->
            <div class="offcanvas-header">
                <h5 class="offcanvas-title ">
                    <i class="bi bi-sliders"></i> Filtros
                </h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>

            <!-- Cuerpo menú lateral izquierdo -->
            <div class="offcanvas-body mx-auto">
                <!-- Formulario de Filtros -->


                <form id="form-filtros-lateral" method="POST">
                    <div class="container ps-lg-2 p-1">
                        <!-- Tipo Inmueble -->
                        <h5 class="fw-bold fs-md-6 fs-sm-5">Tipo de Inmueble</h5>
                        <select class="form-select" id="tipo-inmueble-lateral" name="tipo-inmueble-lateral">
                            <option value="Seleccionar">Seleccionar</option>
                            <option value="alquiler">Alquiler</option>
                            <option value="venta">Venta</option>
                            <option value="oficina">Oficina</option>
                        </select>

                        <!-- Precio Inmueble -->
                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Precio</h5>
                        <div class="row">
                            <div class="col">
                                <select class="form-select" id="precio-min-lateral" name="precio-min-lateral">
                                    <option value="Min">Min</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="2000">2000</option>
                                    <option value="3000">3000</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select" id="precio-max-lateral" name="precio-max-lateral">
                                    <option value="Max">Max</option>
                                    <option value="5000">5000</option>
                                    <option value="10000">10000</option>
                                    <option value="15000">15000</option>
                                    <option value="20000">20000</option>
                                </select>
                            </div>
                        </div>

                        <!-- Habitacion/es Inmueble -->
                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Habitación / Habitaciones</h5>
                        <div class="btn-group" role="group" aria-label="Grupo de habitaciones">
                            <input type="radio" class="btn-check" name="habitaciones" id="hab-lateral-1" value="1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hab-lateral-1">1</label>

                            <input type="radio" class="btn-check" name="habitaciones" id="hab-lateral-2" value="2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hab-lateral-2">+2</label>

                            <input type="radio" class="btn-check" name="habitaciones" id="hab-lateral-3" value="3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hab-lateral-3">+3</label>

                            <input type="radio" class="btn-check" name="habitaciones" id="hab-lateral-4" value="4" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hab-lateral-4">+4</label>
                        </div>

                        <!-- Baños Inmueble -->
                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Baños</h5>
                        <div class="btn-group" role="group" aria-label="Grupo de baños">
                            <input type="radio" class="btn-check" name="banos" id="bano-lateral-1" value="1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="bano-lateral-1">1</label>

                            <input type="radio" class="btn-check" name="banos" id="bano-lateral-2" value="2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="bano-lateral-2">+2</label>

                            <input type="radio" class="btn-check" name="banos" id="bano-lateral-3" value="3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="bano-lateral-3">+3</label>
                        </div>

                        <!-- Estado inmueble -->
                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Estado</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="estado-lateral-1" name="estado[]" value="nuevo">
                                    <label class="form-check-label" for="estado-lateral-1">Nuevo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="estado-lateral-2" name="estado[]" value="semi-nuevo">
                                    <label class="form-check-label" for="estado-lateral-2">Semi-nuevo</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="estado-lateral-3" name="estado[]" value="usado">
                                    <label class="form-check-label" for="estado-lateral-3">Usado</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="estado-lateral-4" name="estado[]" value="renovado">
                                    <label class="form-check-label" for="estado-lateral-4">Renovado</label>
                                </div>
                            </div>
                        </div>

                        <!-- Características inmueble -->
                        <h5 class="fw-bold mt-3 fs-md-6 fs-sm-5">Características</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="caracteristica-lateral-1" name="caracteristicas[]" value="ascensor">
                                    <label class="form-check-label" for="caracteristica-lateral-1">Ascensor</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="caracteristica-lateral-2" name="caracteristicas[]" value="piscina">
                                    <label class="form-check-label" for="caracteristica-lateral-2">Piscina</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="caracteristica-lateral-3" name="caracteristicas[]" value="gimnasio">
                                    <label class="form-check-label" for="caracteristica-lateral-3">Gimnasio</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="caracteristica-lateral-4" name="caracteristicas[]" value="garaje">
                                    <label class="form-check-label" for="caracteristica-lateral-4">Garaje</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="caracteristica-lateral-5" name="caracteristicas[]" value="terraza">
                                    <label class="form-check-label" for="caracteristica-lateral-5">Terraza</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="caracteristica-lateral-6" name="caracteristicas[]" value="jardin">
                                    <label class="form-check-label" for="caracteristica-lateral-6">Jardín</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="caracteristica-lateral-7" name="caracteristicas[]" value="aire_acondicionado">
                                    <label class="form-check-label" for="caracteristica-lateral-7">Aire acondicionado</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="caracteristica-lateral-8" name="caracteristicas[]" value="calefaccion">
                                    <label class="form-check-label" for="caracteristica-lateral-8">Calefacción</label>
                                </div>
                            </div>
                        </div>

                        <!-- Boton Aplicar Filtros -->
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" id="enviar-formulario-lateral" class="btn btn-primary">Aplicar Filtros</button>
                        </div>
                    </div>
                </form>



            </div>
        </div>

        <!-- Usuario Menú -->
        <div class="ms-2">
            <?php if (isset($usuario)): ?>
                <a class="navbar-brand d-lg-flex align-items-center d-none" id="usuario_header" href="/HabitaRoom/perfil">
                    <p for="imgUsuario" class="fs-4 me-2 mt-3 text-success"><?php echo $usuario->nombre_usuario; ?></p>
                    <img src="<?php echo 'assets/uploads/img_perfil/' . $usuario->foto_perfil; ?>" alt="Logo" id="imgUsuarioHeader" class="d-inline-block">
                </a>
            <?php else: ?>
                <a class="navbar-brand d-lg-flex align-items-center d-none" id="usuario_header" href="/HabitaRoom/login">
                    <p for="imgUsuario" class="fs-5 me-2 mt-3 text-success">Login</p>
                    <img src="public/img/imgUsuario.png" alt="Logo" width="50" height="50"
                        class="d-inline-block align-text-center  rounded-circle">
                </a>
            <?php endif; ?>
        </div>

    </div>
</nav>
<div class="bloque-menu-nav"> </div>