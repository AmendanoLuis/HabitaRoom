<?php

require_once '../config/db/db.php';
define('BASE_URL', '/HabitaRoom');


class ModelPublicacion
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function obtenerPublicacionPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM publicaciones WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);

    }
}