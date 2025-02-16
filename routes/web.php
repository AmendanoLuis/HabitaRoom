<?php
//web.php

return [
    '/HabitaRoom/index' => 'IndexController@cargarPagina',
    '/HabitaRoom/novedades' => 'NovedadesController@cargarNovedades',
    '/HabitaRoom/crearpublicacion' => 'CrearPublicacionController@cargarFormulario',
    '/HabitaRoom/guardados' => 'GuardadosController@cargarGuardados',
    '/HabitaRoom/perfil' => 'PerfilController@cargarPerfil',
    '/HabitaRoom/login' => 'LoginController@cargarFormulario',
];