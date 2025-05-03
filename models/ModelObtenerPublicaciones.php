<?php
require_once __DIR__ . '/../config/db/db.php';



class ModelObtenerPublicaciones
{
    private $conn;

    public function __construct()
    {

        $this->conn = Database::connect();
    }

    // Función para cargar las publicaciones
    public function obtenerPublicaciones($limite = 10, $offset = 0)
    {
        try {
            $sql = "SELECT * FROM publicaciones ORDER BY fecha_publicacion DESC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $limite, PDO::PARAM_INT);
            $stmt->bindParam(2, $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en obtenerPublicaciones: " . $e->getMessage());
            return [];
        }
    }



    // Función para cargar una publicación por fecha de publicación
    public function obtenerPublicacionesOfertas()
    {
        try {
            $sql = "SELECT * FROM publicaciones ORDER BY precio DESC LIMIT 10";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en obtenerPublicaciones: " . $e->getMessage());
            echo "Error al obtener las publicaciones.";
            return [];
        }
    }

    // Funcion para obtener publicaciones guardadas
    public function obtenerPublicacionesGuardadas()
    {
        if (!isset($_SESSION['id'])) {
            return [];
        }

        $id_usuario = $_SESSION['id'];

        // Selecciona todas las columnas de la tabla publicaciones
        $sql = "SELECT publicaciones.* FROM publicaciones 
            JOIN guardados ON publicaciones.id = guardados.id_publicacion 
            WHERE guardados.id_usuario = :id_usuario";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ); // Devuelve toda la información de las publicaciones guardadas
        } catch (PDOException $e) {
            error_log("Error en obtenerPublicacionesGuardadas: " . $e->getMessage());
            return [];
        }
    }


    // Funcion para mostrar publicaciones por filtros
    public function cargarPublicacionesFiltro($filtros)
    {
        try {
            $sql = "SELECT * FROM publicaciones WHERE 1=1";
            $params = [];

            // Filtrado por tipo de inmueble
            if (!empty($filtros['tipo-inmueble']) && $filtros['tipo-inmueble'] !== 'Alquiler, etc') {
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
            if (!empty($filtros['estado']) && is_array($filtros['estado']) && count($filtros['estado']) > 0) {
                $placeholders = implode(', ', array_fill(0, count($filtros['estado']), '?'));
                $sql .= " AND estado IN ($placeholders)";
                $params = array_merge($params, $filtros['estado']);
            }


            /* MODIFICAR TABLA DE DATOS PARA PODER TENER UNA COLUMNA POR CARACTERÍSTICA Y MODIFICAR ESTA MISMA OBRTENCION DE DATOS  */
            // Filtrado por características
            if (!empty($filtros['caracteristicas']) && is_array($filtros['caracteristicas']) && count($filtros['caracteristicas']) > 0) {
                $placeholders = implode(', ', array_fill(0, count($filtros['caracteristicas']), '?'));
                $sql .= " AND caracteristicas IN ($placeholders)";
                $params = array_merge($params, $filtros['caracteristicas']);
            }


            $sql .= " ORDER BY fecha_publicacion DESC";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error al cargar publicaciones: " . $e->getMessage());
            return [];
        }
    }
}
