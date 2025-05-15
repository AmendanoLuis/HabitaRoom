<?php
require_once  $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';

class ModelUsuario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // ----------------------------------------
    // Obtener usuario por correo electrónico
    // ----------------------------------------
    public function obtenerUsuarioEmail($email)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE correo_electronico = :email');
        $query->execute(['email' => $email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }


    // ----------------------------------------
    // Obtener usuario por ID
    // ----------------------------------------
    public function obtenerUsuarioId($id)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }


    // ----------------------------------------
    // Registrar nuevo usuario en la base de datos
    // ----------------------------------------
    public function registrarUsuario($nombre, $apellidos, $nombre_usuario, $correo_electronico, $telefono, $contrasena, $tipo_usuario, $ubicacion, $foto_perfil, $descripcion, $preferencia_contacto, $terminos_aceptados)
    {
        try {
            $query = $this->db->prepare('
            INSERT INTO usuarios 
            (nombre, apellidos, nombre_usuario, correo_electronico, telefono, contrasena, tipo_usuario, ubicacion, foto_perfil, descripcion, preferencia_contacto, terminos_aceptados)
            VALUES 
            (:nombre, :apellidos, :nombre_usuario, :correo_electronico, :telefono, :contrasena, :tipo_usuario, :ubicacion, :foto_perfil, :descripcion, :preferencia_contacto, :terminos_aceptados)
        ');

            $query->execute([
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'nombre_usuario' => $nombre_usuario,
                'correo_electronico' => $correo_electronico,
                'telefono' => $telefono,
                'contrasena' => password_hash($contrasena, PASSWORD_BCRYPT),
                'tipo_usuario' => $tipo_usuario,
                'ubicacion' => $ubicacion,
                'foto_perfil' => $foto_perfil,
                'descripcion' => $descripcion,
                'preferencia_contacto' => $preferencia_contacto,
                'terminos_aceptados' => $terminos_aceptados
            ]);

            if ($query->rowCount() > 0) {
                return ['success' => true, 'message' => 'Usuario registrado correctamente'];
            } else {
                return ['success' => false, 'message' => 'Error al registrar usuario'];
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                if (strpos($e->getMessage(), 'nombre_usuario') !== false) {
                    return ['success' => false, 'message' => 'El nombre de usuario ya está registrado.'];
                }
                if (strpos($e->getMessage(), 'correo_electronico') !== false) {
                    return ['success' => false, 'message' => 'El correo electrónico ya está registrado.'];
                }
                return ['success' => false, 'message' => 'Error: entrada duplicada en la base de datos.'];
            }
            return ['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()];
        }
    }




    // ----------------------------------------
    // Actualizar datos de un usuario existente
    // ----------------------------------------
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

    // ----------------------------------------
    // Obtener publicaciones de un usuario
    // ----------------------------------------
    public function obtenerPublicacionesUsuario($id)
    {
        $query = $this->db->prepare('SELECT * FROM publicaciones WHERE usuario_id = :id');
        $query->execute(['id' => $id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
