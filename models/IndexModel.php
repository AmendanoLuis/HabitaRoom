<?php
class IndexModel
{
    // Variable de conexión
    private $conn;

    // Constructor
    public function __construct($database)
    {

        $this->conn = $database;
    }

    // Función para cargar las publicaciones
    public function obtenerPublicaciones()
    {
        // Consulta SQL
        $sql = "SELECT * FROM publicaciones ORDER BY fecha_publicacion DESC";

        // Preparar la consulta
        $stmt = $this->conn->prepare($sql);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_OBJ );
        } else {
            return false;
        }
    }

    // Funcion para mostrar publicaciones por filtros
    public function cargarPublicacionesFiltro($filtros)
    {
        // Consulta SQL
        $sql = "SELECT * FROM publicaciones WHERE tipo_publicacion = :filtros ORDER BY fecha_publicacion DESC";

        // Preparar la consulta
        $stmt = $this->conn->prepare($sql);

        // Asignar valores
        $stmt->bindParam(':filtros', $filtros, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_OBJ );
        } else {
            return false;
        }
    }

}
