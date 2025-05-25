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
            $sql = "SELECT * FROM publicaciones ORDER BY precio LIMIT 12";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en obtenerPublicaciones: " . $e->getMessage());
            echo "Error al obtener las publicaciones.";
            return [];
        }
    }

    // Funcion para obtener publicaciones por titulo
    public function buscarAnuncios(string $q): array
    {
        try {
            $sql = "SELECT * FROM publicaciones
                    WHERE LOWER(titulo) LIKE :like_q
                       OR SOUNDEX(titulo) = SOUNDEX(:q)
                    ORDER BY fecha_publicacion";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':like_q' => "%{$q}%",
                ':q'      => $q
            ]);
            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en buscarAnuncios: " . $e->getMessage());
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

    public function obtenerPublicacionesFiltro(array $filtros)
    {
        try {
            // Columnas explícitas para mejor rendimiento
            $columns = ['*'];

            $select = "SELECT " . implode(", ", $columns) . " FROM publicaciones WHERE 1=1";
            $sql = $select;
            $params = [];

            // 1. Tipo de anuncio e inmueble
            if (!empty($filtros['tipo_anuncio'])) {
                $sql .= " AND tipo_anuncio = :tipo_anuncio";
                $params[':tipo_anuncio'] = $filtros['tipo_anuncio'];
            }
            if (!empty($filtros['tipo_inmueble'])) {
                $sql .= " AND tipo_inmueble = :tipo_inmueble";
                $params[':tipo_inmueble'] = $filtros['tipo_inmueble'];
            }

            // 1.b Tipo de publicitante
            if (!empty($filtros['tipo_publicitante'])) {
                $sql .= " AND tipo_publicitante = :tipo_publicitante";
                $params[':tipo_publicitante'] = $filtros['tipo_publicitante'];
            }

            // 2. Rango de precio
            if (isset($filtros['precio_min']) && $filtros['precio_min'] !== '') {
                $sql .= " AND precio >= :precio_min";
                $params[':precio_min'] = $filtros['precio_min'];
            }
            if (isset($filtros['precio_max']) && $filtros['precio_max'] !== '') {
                $sql .= " AND precio <= :precio_max";
                $params[':precio_max'] = $filtros['precio_max'];
            }

            // 3. Habitaciones y baños como mínimos
            if (isset($filtros['habitaciones']) && $filtros['habitaciones'] !== '') {
                $sql .= " AND habitaciones >= :habitaciones";
                $params[':habitaciones'] = $filtros['habitaciones'];
            }
            if (isset($filtros['banos']) && $filtros['banos'] !== '') {
                $sql .= " AND banos >= :banos";
                $params[':banos'] = $filtros['banos'];
            }

            // 4. Estado exacto
            if (!empty($filtros['estado'])) {
                $sql .= " AND estado = :estado";
                $params[':estado'] = $filtros['estado'];
            }

            // 5. Características booleanas
            foreach (
                [
                    'ascensor',
                    'piscina',
                    'gimnasio',
                    'garaje',
                    'terraza',
                    'jardin',
                    'aire_acondicionado',
                    'calefaccion'
                ] as $c
            ) {
                if (!empty($filtros[$c]) && $filtros[$c] === '1') {
                    $sql .= " AND {$c} = 1";
                }
            }

            // 6. Búsqueda parcial con escape de caracteres
            foreach (['ubicacion', 'titulo', 'descripcion'] as $campo) {
                if (!empty($filtros[$campo])) {
                    // Escapa % y _
                    $valor = addcslashes($filtros[$campo], '%_');
                    $sql .= " AND {$campo} LIKE :{$campo} ESCAPE '\\'";
                    $params[":{$campo}"] = "%{$valor}%";
                }
            }

            // 7. Rango de fechas
            if (!empty($filtros['fecha_desde']) && DateTime::createFromFormat('Y-m-d', $filtros['fecha_desde'])) {
                $sql .= " AND fecha_publicacion >= :fecha_desde";
                $params[':fecha_desde'] = $filtros['fecha_desde'];
            }
            if (!empty($filtros['fecha_hasta']) && DateTime::createFromFormat('Y-m-d', $filtros['fecha_hasta'])) {
                $sql .= " AND fecha_publicacion <= :fecha_hasta";
                $params[':fecha_hasta'] = $filtros['fecha_hasta'];
            }

            // 8. Ordenamiento seguro con whitelist
            $orderByWhitelist = ['precio', 'fecha_publicacion', 'superficie'];
            $orderDirWhitelist = ['ASC', 'DESC'];
            $orderBy = 'fecha_publicacion';
            $orderDir = 'DESC';
            if (!empty($filtros['order_by']) && in_array($filtros['order_by'], $orderByWhitelist, true)) {
                $orderBy = $filtros['order_by'];
            }
            if (!empty($filtros['order_dir']) && in_array(strtoupper($filtros['order_dir']), $orderDirWhitelist, true)) {
                $orderDir = strtoupper($filtros['order_dir']);
            }
            $sql .= " ORDER BY {$orderBy} {$orderDir}";

            // 9. Paginación (Directo en la query para evitar problemas con MySQL y PDO)
            $limit = isset($filtros['limit']) && is_numeric($filtros['limit']) ? (int)$filtros['limit'] : 20;
            $offset = isset($filtros['offset']) && is_numeric($filtros['offset']) ? (int)$filtros['offset'] : 0;
            $sql .= " LIMIT {$limit} OFFSET {$offset}";

            $stmt = $this->conn->prepare($sql);

            // Vincular el resto de parámetros (excepto limit y offset que van directos)
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return ['error' => 'Error al cargar las publicaciones con filtros. ' . $e->getMessage()];
        }
    }
}
