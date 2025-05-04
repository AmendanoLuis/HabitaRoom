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

    public function obtenerPublicacionesFiltro($filtros)
{
    // Depuración de filtros entrantes
    echo "<h3>🟡 DEPURACIÓN DE FILTROS ENTRANTES</h3><pre>";
    print_r($filtros);
    echo "</pre>";

    try {
        $sql = "SELECT * FROM publicaciones WHERE 1=1";
        $params = [];

        echo "<h4>📌 SQL inicial:</h4><pre>$sql</pre>";

        // 1. Identificadores y relaciones
        if (!empty($filtros['id'])) {
            $sql .= " AND id = :id";
            $params[':id'] = $filtros['id'];
        }
        if (!empty($filtros['usuario_id'])) {
            $sql .= " AND usuario_id = :usuario_id";
            $params[':usuario_id'] = $filtros['usuario_id'];
        }

        // 2. Tipo de anuncio, inmueble y publicitante
        foreach (['tipo_anuncio', 'tipo_inmueble', 'tipo_publicitante'] as $campo) {
            if (!empty($filtros[$campo])) {
                $sql .= " AND {$campo} = :{$campo}";
                $params[":{$campo}"] = $filtros[$campo];
            }
        }

        // 3. Búsqueda parcial en ubicación, título y descripción
        foreach (['ubicacion', 'titulo', 'descripcion'] as $campo) {
            if (!empty($filtros[$campo])) {
                $sql .= " AND {$campo} LIKE :{$campo}";
                $params[":{$campo}"] = '%' . $filtros[$campo] . '%';
            }
        }

        // 4. Filtros numéricos mínimos y máximos
        if (!empty($filtros['precio_min'])) {
            $sql .= " AND precio >= :precio_min";
            $params[':precio_min'] = $filtros['precio_min'];
        }
        if (!empty($filtros['precio_max'])) {
            $sql .= " AND precio <= :precio_max";
            $params[':precio_max'] = $filtros['precio_max'];
        }
        if (!empty($filtros['habitaciones'])) {
            $sql .= " AND habitaciones >= :habitaciones";
            $params[':habitaciones'] = $filtros['habitaciones'];
        }
        if (!empty($filtros['banos'])) {
            $sql .= " AND banos >= :banos";
            $params[':banos'] = $filtros['banos'];
        }
        if (!empty($filtros['superficie_min'])) {
            $sql .= " AND superficie >= :superficie_min";
            $params[':superficie_min'] = $filtros['superficie_min'];
        }
        if (!empty($filtros['superficie_max'])) {
            $sql .= " AND superficie <= :superficie_max";
            $params[':superficie_max'] = $filtros['superficie_max'];
        }

        // 5. Estado
        if (!empty($filtros['estado'])) {
            $sql .= " AND estado = :estado";
            $params[':estado'] = $filtros['estado'];
        }

        // 6. Características booleanas
        $caracteristicas = [
            'ascensor', 'piscina', 'gimnasio', 'garaje',
            'terraza', 'jardin', 'aire_acondicionado', 'calefaccion'
        ];
        foreach ($caracteristicas as $c) {
            if (isset($filtros[$c]) && $filtros[$c] === '1') {
                $sql .= " AND {$c} = 1";
            }
        }

        // 7. Rango de fechas de publicación
        if (!empty($filtros['fecha_desde'])) {
            $sql .= " AND fecha_publicacion >= :fecha_desde";
            $params[':fecha_desde'] = $filtros['fecha_desde'];
        }
        if (!empty($filtros['fecha_hasta'])) {
            $sql .= " AND fecha_publicacion <= :fecha_hasta";
            $params[':fecha_hasta'] = $filtros['fecha_hasta'];
        }

        echo "<h4>✅ SQL FINAL CONSTRUCTED:</h4><pre>$sql</pre>";
        echo "<h4>📦 PARÁMETROS BIND:</h4><pre>";
        print_r($params);
        echo "</pre>";

        // Mostrar SQL con valores para depuración
        $debug_sql = $sql;
        foreach ($params as $key => $value) {
            $safe = is_numeric($value) ? $value : "'" . addslashes($value) . "'";
            $debug_sql = str_replace($key, $safe, $debug_sql);
        }
        echo "<h4>🧪 SQL SIMULADA PARA MYSQL:</h4><pre>$debug_sql</pre>";

        // Preparar y ejecutar
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "<p style='color:red;'>❌ Error al preparar la consulta SQL.</p>";
        }
        $stmt->execute($params);

        // Resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo "<h4>📊 RESULTADOS DE CONSULTA:</h4><pre>";
        print_r($resultados);
        echo "</pre>";

        return $resultados;

    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Error en la consulta: " . $e->getMessage() . "</p>";
        return ['error' => 'Error al cargar las publicaciones con filtros. ' . $e->getMessage()];
    }
}

}
