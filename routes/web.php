<?php
//web.php

return [
    '/HabitaRoom' => 'IndexController@cargarPublicaciones',
    '/HabitaRoom/index' => 'IndexController@cargarPublicaciones',
    '/HabitaRoom/novedades' => 'NovedadesController@cargarNovedades',
    '/HabitaRoom/crearpublicacion' => 'CrearPublicacionController@cargarFormulario',
    '/HabitaRoom/guardados' => 'GuardadosController@cargarGuardados',
    '/HabitaRoom/perfil' => 'PerfilController@cargarPerfil',
    '/HabitaRoom/login' => 'LoginController@cargarFormulario',
];