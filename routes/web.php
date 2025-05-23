<?php

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