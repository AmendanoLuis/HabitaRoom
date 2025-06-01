<?php
/**
 * Class ModelGuardados
 *
 * Modelo encargado de gestionar las publicaciones guardadas en HabitaRoom.
 * Proporciona métodos para insertar y eliminar registros de guardados en la base de datos.
 *
 * @package HabitaRoom\Models
 */
class ModelGuardados
{
    /**
     * @var PDO Instancia de la conexión a la base de datos.
     */
    private $conn;

    /**
     * Constructor: establece la conexión a la base de datos utilizando la clase Database.
     */
    public function __construct()
    {
        $this->conn = Database::connect();
    }

    /**
     * Inserta un registro en la tabla 'guardados' para marcar una publicación como guardada por un usuario.
     *
     * @param int $id_usuario ID del usuario que guarda la publicación.
     * @param int $id_publicacion ID de la publicación que se guarda.
     * @return bool|string Retorna true si la operación fue exitosa, o un mensaje de error en caso contrario.
     */
    public function insertarGuardados($id_usuario, $id_publicacion)
    {
        try {
            $sql = "INSERT INTO guardados (id_usuario, id_publicacion) VALUES (:id_usuario, :id_publicacion)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_publicacion', $id_publicacion, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en insertarGuardados: " . $e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * Elimina un registro de la tabla 'guardados', removiendo la marca de guardado de una publicación.
     *
     * @param int $id_usuario ID del usuario que elimina el guardado.
     * @param int $id_publicacion ID de la publicación que se elimina de guardados.
     * @return bool|string Retorna true si la operación fue exitosa, o un mensaje de error en caso contrario.
     */
    public function quitarGuardado($id_usuario, $id_publicacion)
    {
        try {
            $sql = "DELETE FROM guardados WHERE id_usuario = :id_usuario AND id_publicacion = :id_publicacion";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_publicacion', $id_publicacion, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en quitarGuardado: " . $e->getMessage());
            return $e->getMessage();
        }
    }
}
