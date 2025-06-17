<?php
$activeRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<!-- BARRA DE NAVEGACIÓN -->
<nav class="navbar d-flex justify-content-between navbar-dark navbar-expand-lg color_fondo_header shadow fixed-top z-5 ">
    <div class="container-fluid">


        <!-- Botón menú lateral izquierdo: solo en /HabitaRoom/index -->
        <?php if ($activeRoute === '/HabitaRoom/index'): ?>
            <button class="navbar-toggler me-auto d-lg-none" id="btnMenuLateralIzq" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarLeft"
                    aria-controls="offcanvasNavbarLeft" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon mt-2 pe-3">
                    <!-- SVG del icono -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="text-success" viewBox="0 0 50 50">
                        <path d="M 0 7.5 L 0 12.5 L 50 12.5 L 50 7.5 Z 
                                 M 0 22.5 L 0 27.5 L 50 27.5 L 50 22.5 Z 
                                 M 0 37.5 L 0 42.5 L 50 42.5 L 50 37.5 Z" />
                    </svg>
                </span>
            </button>
        <?php endif; ?>

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-end" href="/HabitaRoom/index">
            <img class="ms-3" src="public/img/logo_HR_sinFondo.png" id="imgLogo" alt="Logo" width="65" height="65">
            <h2 for="imgLogo" class="ms-1 fs-1" id="text_logo">HabitaRoom</h2>
        </a>

        <!-- Botón menú lateral Derecho: SIEMPRE -->
        <button class="navbar-toggler <?php echo ($activeRoute === '/HabitaRoom/crearpublicacion') ? 'mx-auto' : 'ms-auto';?>" id="btnMenuLateralDerch" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2 pe-3">
                <!-- SVG del icono -->
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="text-success" viewBox="0 0 50 50">
                    <path d="M 0 7.5 L 0 12.5 L 50 12.5 L 50 7.5 Z 
                             M 0 22.5 L 0 27.5 L 50 27.5 L 50 22.5 Z 
                             M 0 37.5 L 0 42.5 L 50 42.5 L 50 37.5 Z" />
                </svg>
            </span>
        </button>

        <!-- CONTENIDO MENU LATERAL DERECHO -->
        <div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">

            <!-- Cabecera menú Derecho -->
            <div class="offcanvas-header m-0">
                <a class="navbar-brand text-dark ps-4 mt-4 d-flex" href="/HabitaRoom/index">
                    <img class="ms-3" src="public/img/logo_HR_sinFondo.png" id="imgLogo" alt="Logo" width="65"
                        height="65">
                    <h1 for="imgLogo" class="ms-2 mt-4" id="text_logo">HabitaRoom</h1>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <!-- Cuerpo menú lateral Derecho -->
            <div class="offcanvas-body mx-auto">
                <hr>

                <!-- Usuario menú lateral Derecho -->
                <?php if (isset($usuario)): ?>
                    <a class="navbar-brand me-auto d-lg-none text-dark" href="/HabitaRoom/perfil" id="usuarioMenuLateral">
                        <img
                            src="<?php echo 'assets/uploads/img_perfil/' . $usuario->foto_perfil; ?>"
                            id="imgUsuario" alt="Logo"
                            width="60" height="60"
                            class="d-inline-block align-text-center img-thumbnail rounded-circle shadow">
                        <label for="imgUsuario" class="fs-5"><?php echo $usuario->nombre_usuario; ?></label>
                    </a>
                <?php else: ?>
                    <a class="navbar-brand me-auto d-lg-none text-dark" href="/HabitaRoom/login" id="usuarioMenuLateral">
                        <img src="public/img/imgUsuario.png" id="imgUsuario" alt="Logo" width="50" height="55"
                            class="d-inline-block align-text-center rounded-circle shadow">
                        <label for="imgUsuario" class="fs-5">Login</label>
                    </a>
                <?php endif; ?>

                <hr>

                <!-- Menú Navegacion | Menu Lateral Derecho -->
                <ul class=" navbar-nav nav-underline justify-content-end flex-grow-1 ps-3 me-5 w-75"
                    id="menuLateralIndex">

                    <!-- Inicio -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeRoute === '/HabitaRoom/index') ? 'active' : ''; ?>"
                            aria-current="page" href="/HabitaRoom/index">
                            <i class="d-lg-none d-inline bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <!-- Publicacion -->

                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeRoute === '/HabitaRoom/crearpublicacion') ? 'active' : ''; ?>"
                            href="/HabitaRoom/crearpublicacion">
                            <i class="d-lg-none d-inline bi bi-plus-square"></i> Publicación
                        </a>
                    </li>

                    <!-- Ofertas -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeRoute === '/HabitaRoom/ofertas') ? 'active' : ''; ?>"
                            href="/HabitaRoom/ofertas">
                            <i class="d-lg-none d-inline bi bi-postcard"></i> Ofertas
                        </a>
                    </li>

                    <!-- Guardados -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeRoute === '/HabitaRoom/guardados') ? 'active' : ''; ?>"
                            href="/HabitaRoom/guardados">
                            <i class="d-lg-none d-inline bi bi-bookmark"></i> Guardados
                        </a>
                    </li>
                </ul>
                <hr>

                <!-- Barra de búsqueda Lateral Derecho-->
                <form
                    class="d-flex ms-auto ps-3 <?php echo ($activeRoute === "/HabitaRoom/index") ? '' : 'invisible pe-none' ?>"
                    id="formBuscarLateral" role="search">
                    <input id="inputBuscar" class="form-control me-2" type="search" placeholder="Buscar"
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>

            </div>

        </div>

        <!-- CONTENIDO MENU LATERAL IZQUIERDO -->
        <div class="offcanvas offcanvas-start bg-light d-lg-none" tabindex="-1" id="offcanvasNavbarLeft"
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
                <form id="form-filtros-desp" method="POST" class="ps-4 d-block d-md-none">

                    <!-- Tipo de anuncio -->
                    <h6 class="fw-bold fs-6">Tipo de anuncio</h6>
                    <select class="form-select" id="tipo_anuncio" name="tipo_anuncio">
                        <option value="">Seleccionar...</option>
                        <option value="venta">Venta</option>
                        <option value="alquiler">Alquiler</option>
                    </select>

                    <!-- Tipo de Inmueble -->
                    <h6 class="fw-bold mt-3 fs-6">Tipo de inmueble</h6>
                    <select class="form-select" id="tipo_inmueble" name="tipo_inmueble">
                        <option value="">Seleccionar...</option>
                        <option value="garaje">Garaje</option>
                        <option value="apartamento">Apartamento</option>
                        <option value="piso">Piso</option>
                        <option value="casa">Casa</option>
                        <option value="local">Local</option>
                        <option value="oficina">Oficina</option>
                        <option value="terreno">Terreno</option>
                        <option value="otro">Otro...</option>
                    </select>

                    <!-- Precio Inmueble -->
                    <h6 class="fw-bold mt-3 fs-6">Precio</h6>
                    <div class="row">
                        <div class="col">
                            <select class="form-select" id="precio_min" name="precio_min">
                                <option value="">Min.</option>
                                <option value="50000">50 000 €</option>
                                <option value="100000">100 000 €</option>
                                <option value="150000">150 000 €</option>
                                <option value="200000">200 000 €</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select" id="precio_max" name="precio_max">
                                <option value="">Max.</option>
                                <option value="250000">250 000 €</option>
                                <option value="400000">400 000 €</option>
                                <option value="600000">600 000 €</option>
                                <option value="1000000">1 000 000 €</option>
                            </select>
                        </div>
                    </div>

                    <!-- Habitaciones -->
                    <h6 class="fw-semibold mt-3 fs-6">Habitaciones</h6>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="habitaciones" id="hab-1" value="1">
                        <label class="btn btn-outline-primary" for="hab-1">1</label>

                        <input type="radio" class="btn-check" name="habitaciones" id="hab-2" value="2">
                        <label class="btn btn-outline-primary" for="hab-2">2</label>

                        <input type="radio" class="btn-check" name="habitaciones" id="hab-3" value="3">
                        <label class="btn btn-outline-primary" for="hab-3">3</label>

                        <input type="radio" class="btn-check" name="habitaciones" id="hab-4" value="4">
                        <label class="btn btn-outline-primary" for="hab-4">4+</label>
                    </div>

                    <!-- Baños -->
                    <h6 class="fw-bold mt-3 fs-6">Baños</h6>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="banos" id="bano-1" value="1">
                        <label class="btn btn-outline-primary" for="bano-1">1</label>

                        <input type="radio" class="btn-check" name="banos" id="bano-2" value="2">
                        <label class="btn btn-outline-primary" for="bano-2">2</label>

                        <input type="radio" class="btn-check" name="banos" id="bano-3" value="3">
                        <label class="btn btn-outline-primary" for="bano-3">3+</label>
                    </div>

                    <!-- Estado inmueble -->
                    <h6 class="fw-bold mt-3 fs-6">Estado</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado-nuevo" value="nuevo">
                        <label class="form-check-label" for="estado-nuevo">Nuevo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado-semi" value="semi-nuevo">
                        <label class="form-check-label" for="estado-semi">Semi-nuevo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado-usado" value="usado">
                        <label class="form-check-label" for="estado-usado">Usado</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado-renovado"
                            value="renovado">
                        <label class="form-check-label" for="estado-renovado">Renovado</label>
                    </div>

                    <!-- Características -->
                    <h6 class="fw-bold mt-3 fs-6">Características</h6>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ascensor" id="carac-ascensor"
                                    value="1">
                                <label class="form-check-label" for="carac-ascensor">Ascensor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="piscina" id="carac-piscina"
                                    value="1">
                                <label class="form-check-label" for="carac-piscina">Piscina</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="gimnasio" id="carac-gimnasio"
                                    value="1">
                                <label class="form-check-label" for="carac-gimnasio">Gimnasio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="garaje" id="carac-garaje"
                                    value="1">
                                <label class="form-check-label" for="carac-garaje">Garaje</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terraza" id="carac-terraza"
                                    value="1">
                                <label class="form-check-label" for="carac-terraza">Terraza</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="jardin" id="carac-jardin"
                                    value="1">
                                <label class="form-check-label" for="carac-jardin">Jardín</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="aire_acondicionado"
                                    id="carac-acondicionado" value="1">
                                <label class="form-check-label" for="carac-acondicionado">Aire
                                    acondicionado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="calefaccion"
                                    id="carac-calefaccion" value="1">
                                <label class="form-check-label" for="carac-calefaccion">Calefacción</label>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Aplicar Filtros -->
                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Usuario Menú -->
        <div class="ms-2">
            <?php if (isset($usuario)): ?>
                <a class="navbar-brand d-lg-flex align-items-center d-none" id="usuario_header" href="/HabitaRoom/perfil">
                    <p for="imgUsuario" class="fs-4 me-2 mt-3 text-success"><?php echo $usuario->nombre_usuario; ?></p>
                    <img src="<?php echo 'assets/uploads/img_perfil/' . $usuario->foto_perfil; ?>" alt="Logo"
                        id="imgUsuarioHeader" class="d-inline-block">
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