<?php
/**
 * Class ModelObtenerPublicaciones
 *
 * Modelo encargado de recuperar publicaciones desde la base de datos de HabitaRoom.
 * Proporciona métodos para obtener listas de publicaciones, ofertas, búsquedas,
 * guardados y filtros avanzados.
 *
 * @package HabitaRoom\Models
 */

require_once __DIR__ . '/../config/db/db.php';

class ModelObtenerPublicaciones
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
     * Obtiene un conjunto de publicaciones ordenadas por fecha de publicación descendente.
     *
     * @param int $limite Número máximo de registros a devolver (por defecto 10).
     * @param int $offset Desplazamiento para paginación (por defecto 0).
     * @return array Lista de objetos con los datos de las publicaciones o array vacío en caso de error.
     */
    public function obtenerPublicaciones(int $limite = 10, int $offset = 0): array
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
    public function obtenerMasPublicaciones(int $limite = 10, int $offset = 0, array $id_publis_cargadas = []): array
    {
        try {
            $params = [];
            $sql = "SELECT * FROM publicaciones";

            // Si hay publicaciones ya cargadas, las excluimos
            if (!empty($id_publis_cargadas)) {
                // Convertir todos los IDs a enteros
                $id_publis_cargadas = array_map('intval', $id_publis_cargadas);

                $placeholders = implode(',', array_fill(0, count($id_publis_cargadas), '?'));
                $sql .= " WHERE id NOT IN ($placeholders)";
                $params = array_merge($params, $id_publis_cargadas);
            }

            // Añadir orden y paginación
            $sql .= " ORDER BY fecha_publicacion DESC LIMIT ? OFFSET ?";
            $params[] = $limite;
            $params[] = $offset;

            $stmt = $this->conn->prepare($sql);

            // Bind dinámico
            foreach ($params as $i => $param) {
                $stmt->bindValue($i + 1, $param, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];

        } catch (PDOException $e) {
            error_log("Error en obtenerMasPublicaciones: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene las publicaciones con precio más bajo (ofertas) limitadas a 12.
     *
     * @return array Lista de objetos con los datos de las publicaciones en oferta o array vacío en caso de error.
     */
    public function obtenerPublicacionesOfertas()
    {
        try {
            $sql = "SELECT * FROM publicaciones ORDER BY precio LIMIT 12";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en obtenerPublicacionesOfertas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca publicaciones cuyo título coincida parcial o fonéticamente con el término dado.
     *
     * @param string $q Término de búsqueda (palabra o frase).
     * @return array Lista de objetos con publicaciones encontradas o array vacío en caso de error.
     */
    public function obtenerPublicacionesTitulo(string $q): array
    {
        try {
            $sql = "SELECT * FROM publicaciones
                    WHERE LOWER(titulo) LIKE :like_q
                       OR SOUNDEX(titulo) = SOUNDEX(:q)
                    ORDER BY fecha_publicacion";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':like_q' => "%{$q}%",
                ':q' => $q
            ]);
            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en buscarAnuncios: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene las publicaciones marcadas como guardadas por el usuario autenticado.
     *
     * @return array Lista de objetos con las publicaciones guardadas o array vacío si no hay usuario autenticado o error.
     */
    public function obtenerPublicacionesGuardadas()
    {
        if (!isset($_SESSION['id'])) {
            return [];
        }

        $id_usuario = $_SESSION['id'];

        $sql = "SELECT publicaciones.* FROM publicaciones 
                JOIN guardados ON publicaciones.id = guardados.id_publicacion 
                WHERE guardados.id_usuario = :id_usuario";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error en obtenerPublicacionesGuardadas: " . $e->getMessage());
            return [];
        }
    }


    /**
     * Busca publicaciones que coincidan EXACTAMENTE en ciudad.
     *
     * @param string $ciudad
     * @return array Array de objetos con las publicaciones encontradas.
     */
    public function buscarPorCiudad(string $ciudad): array
    {
        try {
            $sql = "
            SELECT
                id,
                usuario_id,
                tipo_anuncio,
                tipo_inmueble,
                ubicacion,
                titulo,
                descripcion,
                precio,
                habitaciones,
                banos,
                estado,
                ascensor,
                piscina,
                gimnasio,
                garaje,
                terraza,
                jardin,
                aire_acondicionado,
                calefaccion,
                tipo_publicitante,
                superficie,
                fotos,
                videos,
                latitud,
                longitud,
                calle,
                barrio,
                ciudad,
                provincia,
                codigo_postal
            FROM publicaciones
            WHERE ciudad = :ciudad
            ORDER BY fecha_publicacion DESC
        ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ciudad' => $ciudad
            ]);

            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en buscarPorCiudad: " . $e->getMessage());
            return [];
        }
    }


    /**
     * Busca publicaciones que coincidan EXACTAMENTE en provincia.
     *
     * @param string $provincia
     * @return array Array de objetos con las publicaciones encontradas.
     */
    public function buscarPorProvincia(string $provincia): array
    {
        try {
            $sql = "
            SELECT
                id,
                usuario_id,
                tipo_anuncio,
                tipo_inmueble,
                ubicacion,
                titulo,
                descripcion,
                precio,
                habitaciones,
                banos,
                estado,
                ascensor,
                piscina,
                gimnasio,
                garaje,
                terraza,
                jardin,
                aire_acondicionado,
                calefaccion,
                tipo_publicitante,
                superficie,
                fotos,
                videos,
                latitud,
                longitud,
                calle,
                barrio,
                ciudad,
                provincia,
                codigo_postal
            FROM publicaciones
            WHERE provincia = :provincia
            ORDER BY fecha_publicacion DESC
        ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':provincia' => $provincia
            ]);

            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en buscarPorProvincia: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca publicaciones que coincidan EXACTAMENTE en barrio, ciudad y provincia.
     *
     * @param string $barrio
     * @param string $ciudad
     * @param string $provincia
     * @return array Array de objetos (PDO::FETCH_OBJ) con las publicaciones encontradas.
     */
    public function buscarPorBarrioCiudadProvincia(string $barrio, string $ciudad, string $provincia): array
    {
        try {
            $sql = "
            SELECT
                id,
                usuario_id,
                tipo_anuncio,
                tipo_inmueble,
                ubicacion,
                titulo,
                descripcion,
                precio,
                habitaciones,
                banos,
                estado,
                ascensor,
                piscina,
                gimnasio,
                garaje,
                terraza,
                jardin,
                aire_acondicionado,
                calefaccion,
                tipo_publicitante,
                superficie,
                fotos,
                videos,
                latitud,
                longitud,
                calle,
                barrio,
                ciudad,
                provincia,
                codigo_postal
            FROM publicaciones
            WHERE barrio    = :barrio
              AND ciudad    = :ciudad
              AND provincia = :provincia
            ORDER BY fecha_publicacion DESC
        ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':barrio' => $barrio,
                ':ciudad' => $ciudad,
                ':provincia' => $provincia
            ]);

            return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log("Error en buscarPorBarrioCiudadProvincia: " . $e->getMessage());
            return [];
        }
    }


    /**
     * Obtiene publicaciones según un conjunto de filtros avanzados.
     * Los filtros pueden incluir tipo de anuncio, tipo de inmueble, rango de precio,
     * número mínimo de habitaciones/baños, estado, características booleanas,
     * búsqueda parcial en ubicación/título/descripcion, rango de fechas,
     * ordenamiento y paginación.
     *
     * @param array $filtros Array asociativo con las claves posibles: 
     *      - tipo_anuncio (string)
     *      - tipo_inmueble (string)
     *      - tipo_publicitante (string)
     *      - precio_min (numeric)
     *      - precio_max (numeric)
     *      - habitaciones (int)
     *      - banos (int)
     *      - estado (string)
     *      - ascensor, piscina, gimnasio, garaje, terraza, jardin, aire_acondicionado, calefaccion (valores '1' para true)
     *      - ubicacion, titulo, descripcion (string para búsqueda LIKE)
     *      - order_by (string: 'precio', 'fecha_publicacion', 'superficie')
     *      - order_dir (string: 'ASC' o 'DESC')
     *      - limit (int)
     *      - offset (int)
     * @return array Lista de objetos con las publicaciones filtradas o array con clave 'error' en caso de fallo.
     */
    public function obtenerPublicacionesFiltro(array $filtros)
    {
        try {
            $columns = ['*'];
            $select = "SELECT " . implode(", ", $columns) . " FROM publicaciones WHERE 1=1";
            $sql = $select;
            $params = [];

            // Filtros de tipo de anuncio e inmueble
            if (!empty($filtros['tipo_anuncio'])) {
                $sql .= " AND tipo_anuncio = :tipo_anuncio";
                $params[':tipo_anuncio'] = $filtros['tipo_anuncio'];
            }
            if (!empty($filtros['tipo_inmueble'])) {
                $sql .= " AND tipo_inmueble = :tipo_inmueble";
                $params[':tipo_inmueble'] = $filtros['tipo_inmueble'];
            }

            // Filtro de tipo de publicitante
            if (!empty($filtros['tipo_publicitante'])) {
                $sql .= " AND tipo_publicitante = :tipo_publicitante";
                $params[':tipo_publicitante'] = $filtros['tipo_publicitante'];
            }

            // Rango de precio
            if (isset($filtros['precio_min']) && $filtros['precio_min'] !== '') {
                $sql .= " AND precio >= :precio_min";
                $params[':precio_min'] = $filtros['precio_min'];
            }
            if (isset($filtros['precio_max']) && $filtros['precio_max'] !== '') {
                $sql .= " AND precio <= :precio_max";
                $params[':precio_max'] = $filtros['precio_max'];
            }

            // Habitaciones y baños mínimos
            if (isset($filtros['habitaciones']) && $filtros['habitaciones'] !== '') {
                $sql .= " AND habitaciones >= :habitaciones";
                $params[':habitaciones'] = $filtros['habitaciones'];
            }
            if (isset($filtros['banos']) && $filtros['banos'] !== '') {
                $sql .= " AND banos >= :banos";
                $params[':banos'] = $filtros['banos'];
            }

            // Estado exacto
            if (!empty($filtros['estado'])) {
                $sql .= " AND estado = :estado";
                $params[':estado'] = $filtros['estado'];
            }

            // Características booleanas
            foreach (['ascensor', 'piscina', 'gimnasio', 'garaje', 'terraza', 'jardin', 'aire_acondicionado', 'calefaccion'] as $c) {
                if (!empty($filtros[$c]) && $filtros[$c] === '1') {
                    $sql .= " AND {$c} = 1";
                }
            }

            // Búsqueda parcial en ubicación, título y descripción
            foreach (['ubicacion', 'titulo', 'descripcion'] as $campo) {
                if (!empty($filtros[$campo])) {
                    $valor = addcslashes($filtros[$campo], '%_');
                    $sql .= " AND {$campo} LIKE :{$campo} ESCAPE '\\'";
                    $params[":{$campo}"] = "%{$valor}%";
                }
            }


            // Ordenamiento seguro con whitelist
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

            // Paginación: limit y offset
            $limit = isset($filtros['limit']) && is_numeric($filtros['limit']) ? (int) $filtros['limit'] : 20;
            $offset = isset($filtros['offset']) && is_numeric($filtros['offset']) ? (int) $filtros['offset'] : 0;
            $sql .= " LIMIT {$limit} OFFSET {$offset}";

            $stmt = $this->conn->prepare($sql);

            // Vincular parámetros (excluyendo limit y offset)
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
