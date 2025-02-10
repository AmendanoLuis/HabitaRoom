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
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    // Funcion para mostrar publicaciones por filtros
    public function cargarPublicacionesFiltro($filtros)
    {
        try {
            $sql = "SELECT * FROM publicaciones WHERE 1=1";
            $params = [];

            // Filtrado por tipo de inmueble
            if (!empty($filtros['tipo-inmueble']) && $filtros['tipo-inmueble'] != 'Alquiler, etc') {
                $sql .= " AND tipo_inmueble = ?";
                $params[] = $filtros['tipo-inmueble'];
            }
            // Filtrado por precio mínimo
            if (!empty($filtros['precio-min']) && is_numeric($filtros['precio-min'])) {
                $sql .= " AND precio >= ?";
                $params[] = $filtros['precio-min'];
            }
            // Filtrado por precio máximo
            if (!empty($filtros['precio-max']) && is_numeric($filtros['precio-max'])) {
                $sql .= " AND precio <= ?";
                $params[] = $filtros['precio-max'];
            }
            // Filtrado por estado
            if (!empty($filtros['estado']) && count($filtros['estado']) > 0) {
                $estados = implode(',', array_fill(0, count($filtros['estado']), '?'));
                $sql .= " AND estado IN ($estados)";
                $params = array_merge($params, $filtros['estado']);
            }
            // Filtrado por características
            if (!empty($filtros['caracteristicas']) && count($filtros['caracteristicas']) > 0) {
                $caracteristicas = implode(',', array_fill(0, count($filtros['caracteristicas']), '?'));
                $sql .= " AND caracteristicas IN ($caracteristicas)";
                $params = array_merge($params, $filtros['caracteristicas']);
            }

            $sql .= " ORDER BY fecha_publicacion DESC";

            // Preparamos consulta
            $stmt = $this->conn->prepare($sql);
            
            // Ejecutamos con los parámetros
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error en cargarPublicacionesFiltro: " . $e->getMessage());
            echo $e;
            return false;
        }
    }
}
