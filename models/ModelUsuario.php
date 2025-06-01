<?php

/**
 * Class ModelUsuario
 *
 * Modelo encargado de gestionar las operaciones relacionadas con los usuarios en la base de datos de HabitaRoom.
 * Proporciona métodos para obtener usuarios, registrar nuevos usuarios, actualizar datos existentes y obtener publicaciones de un usuario.
 *
 * @package HabitaRoom\Models
 */

require_once  $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';

class ModelUsuario
{
    /**
     * @var PDO Instancia de la conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor: establece la conexión a la base de datos utilizando la clase Database.
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    // ----------------------------------------
    // Obtener usuario por correo electrónico
    // ----------------------------------------
    /**
     * Obtiene un usuario según su correo electrónico.
     *
     * @param string $email Correo electrónico del usuario a buscar.
     * @return object|null Objeto con los datos del usuario o null si no existe.
     */
    public function obtenerUsuarioEmail($email)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE correo_electronico = :email');
        $query->execute(['email' => $email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // ----------------------------------------
    // Obtener usuario por ID
    // ----------------------------------------
    /**
     * Obtiene un usuario según su ID.
     *
     * @param int $id ID del usuario a buscar.
     * @return object|null Objeto con los datos del usuario o null si no existe.
     */
    public function obtenerUsuarioId($id)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }


    /**
     * Registra un nuevo usuario en la base de datos.
     *
     * @param string $nombre Nombre del usuario.
     * @param string $apellidos Apellidos del usuario.
     * @param string $nombre_usuario Nombre de usuario.
     * @param string $correo_electronico Correo electrónico del usuario.
     * @param string $telefono Teléfono del usuario.
     * @param string $contrasena Contraseña del usuario (se guardará hasheada).
     * @param string $tipo_usuario Tipo de usuario (ej. 'habitante', 'agencia').
     * @param string $ubicacion Ubicación del usuario.
     * @param string|null $foto_perfil Ruta de la foto de perfil (opcional).
     * @param string|null $descripcion Descripción del usuario (opcional).
     * @param string|null $preferencia_contacto Preferencia de contacto (opcional).
     * @param bool $terminos_aceptados Indica si el usuario aceptó los términos y condiciones.
     *
     * @return array Resultado de la operación con claves 'success' y 'message'.
     */
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


     /**
     * Actualiza los datos de un usuario existente según los campos proporcionados.
     *
     * @param array $formActualizarUsuario Array asociativo con campos a actualizar.
     * @param int $id ID del usuario a actualizar.
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
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

    
    /**
     * Obtiene todas las publicaciones asociadas a un usuario.
     *
     * @param int $id ID del usuario cuyas publicaciones se desean obtener.
     * @return array Lista de objetos con los datos de las publicaciones.
     */
    public function obtenerPublicacionesUsuario($id)
    {
        $query = $this->db->prepare('SELECT * FROM publicaciones WHERE usuario_id = :id');
        $query->execute(['id' => $id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
