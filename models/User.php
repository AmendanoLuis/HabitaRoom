<?php
require_once  $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Funcion para obtener usuario por email
    public function obtenerUsuarioEmail($email)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE correo_electronico = :email');
        $query->execute(['email' => $email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // Funcion para obtener usuario por id
    public function obtenerUsuarioId($id)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // Funcion para registrar usuario
    public function registrarUsuario($formRegistro)
    {
        $query = $this->db->prepare('INSERT INTO usuarios (nombre, apellidos, nombre_usuario, correo_electronico, telefono, contrasena, tipo_usuario, ubicacion, foto_perfil, descripcion, preferencia_contacto, terminos_aceptados) VALUES (:nombre, :apellidos, :nombre_usuario, :correo_electronico, :telefono, :contrasena, :tipo_usuario, :ubicacion, :foto_perfil, :descripcion, :preferencia_contacto, :terminos_aceptados)');


        $query->execute([
            'nombre' => $formRegistro['nombre'],
            'apellidos' => $formRegistro['apellidos'],
            'nombre_usuario' => $formRegistro['nombre_usuario'],
            'correo_electronico' => $formRegistro['correo_electronico'],
            'telefono' => $formRegistro['telefono'],
            'contrasena' => password_hash($formRegistro['contrasena'], PASSWORD_BCRYPT),
            'tipo_usuario' => $formRegistro['tipo_usuario'],
            'ubicacion' => $formRegistro['ubicacion'],
            'foto_perfil' => $formRegistro['foto_perfil'],
            'descripcion' => $formRegistro['descripcion'],
            'preferencia_contacto' => $formRegistro['preferencia_contacto'],
            'terminos_aceptados' => $formRegistro['terminos_aceptados']
        ]);

        if ($query->rowCount() > 0) {
            echo "Usuario registrado correctamente";

            return true;
        } else {
            echo "Error al registrar usuario";
            return false;
        }
    }

    // Funcion para actualizar usuario
    public function actualizarUsuario($formActualizarUsuario, $id)
    {
        $campos = [];
        $params = ['id' => $id];

        $campos_permitidos = [
            'nombre',
            'apellidos',
            'nombre_usuario',
            'correo_electronico',
            'telefono',
            'contrasena',
            'tipo_usuario',
            'ubicacion',
            'foto_perfil',
            'descripcion',
            'preferencia_contacto',
            'terminos_aceptados'
        ];

        foreach ($formActualizarUsuario as $i => $campo) {
            if (in_array($i, $campos_permitidos)) {

                $campos[] = "$i = :$i";

                if ($i == 'contrasena') {
                    $campo = password_hash($campo, PASSWORD_BCRYPT);
                }

                $params[$i] = $campo;
            }
        }


        if (empty($campos)) {
            echo "No hay campos para actualizar";
            return false;
        }

        $queryStr = 'UPDATE usuarios SET ' . implode(', ', $campos) . ' WHERE id = :id';
        $query = $this->db->prepare($queryStr);
        $query->execute($params);

        if ($query->rowCount() > 0) {
            echo "Usuario actualizado correctamente";
            return true;
        } else {
            echo "Error al actualizar usuario";
            return false;
        }
    }

    // Funcion para obtener publicaciones de un usuario
    public function obtenerPublicacionesUsuario($id)
    {
        $query = $this->db->prepare('SELECT * FROM publicaciones WHERE usuario_id = :id');
        $query->execute(['id' => $id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
