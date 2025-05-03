<?php

class ModelGuardados{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::connect(); 
    }

    // Función para insertar una publicación guardada
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
            return false;
        }
    }

    // Función para quitar una publicación guardada
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
            return false;
        }
    }
}