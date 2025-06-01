<?php
/**
 * Class ModelPublicacion
 *
 * Modelo encargado de recuperar los detalles de una publicación específica de la base de datos de HabitaRoom.
 *
 * @package HabitaRoom\Models
 */

require_once '../config/db/db.php';

define('BASE_URL', '/HabitaRoom');

class ModelPublicacion
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

    /**
     * Obtiene una publicación por su ID.
     *
     * @param int $id ID de la publicación a recuperar.
     * @return object|null Objeto con los datos de la publicación o null si no existe.
     */
    public function obtenerPublicacionPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM publicaciones WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
