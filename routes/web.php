<?php
/**
 * Archivo: web.php
 *
 * Este archivo define el sistema de rutas para la aplicación HabitaRoom.
 * Cada entrada del array asocia una URL a una acción específica en un controlador.
 *
 * La acción tiene el formato 'NombreControlador@metodo', lo que permite que el router
 * (redireccionWeb.php) cargue dinámicamente el controlador y ejecute el método correspondiente.
 *
 * @return array Array asociativo de rutas => acciones.
 */

return [
    '/HabitaRoom/index.php' => 'IndexController@cargarPagina',
    '/HabitaRoom/index' => 'IndexController@cargarPagina',
    '/HabitaRoom/ofertas' => 'OfertasController@cargarOfertas',
    '/HabitaRoom/crearpublicacion' => 'CrearPublicacionController@cargarFormulario',
    '/HabitaRoom/guardados' => 'GuardadosController@cargarGuardados',
    '/HabitaRoom/perfil' => 'PerfilController@cargarPerfil',
    '/HabitaRoom/login' => 'LoginController@cargarLogin',
    '/HabitaRoom/registro' => 'RegistroController@cargarRegistro',
    '/HabitaRoom/publicacionusuario' => 'PublicacionUsuarioController@cargarPublicacion',
];