<?php
/**
 * Class ModelInsertarPublicacion
 *
 * Modelo responsable de insertar nuevas publicaciones en la base de datos de HabitaRoom.
 * Proporciona un método para almacenar todas las propiedades de una publicación
 * y retorna el ID recién insertado junto con el estado de la operación.
 *
 * @package HabitaRoom\Models
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';

class ModelInsertarPublicacion
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
     * Inserta una nueva publicación en la tabla 'publicaciones'.
     *
     * Recibe un array asociativo con todos los datos de la publicación, ejecuta una consulta preparada
     * para evitar inyecciones SQL y retorna el ID de la nueva publicación y el estado de la operación.
     *
     * @param array $d Array asociativo con las claves:
     *      - usuario_id (int)
     *      - tipo_anuncio (string)
     *      - tipo_inmueble (string)
     *      - ubicacion (string)
     *      - titulo (string)
     *      - descripcion (string)
     *      - precio (float)
     *      - habitaciones (int)
     *      - banos (int)
     *      - estado (string)
     *      - ascensor (int)
     *      - piscina (int)
     *      - gimnasio (int)
     *      - garaje (int)
     *      - terraza (int)
     *      - jardin (int)
     *      - aire_acondicionado (int)
     *      - calefaccion (int)
     *      - tipo_publicitante (string)
     *      - superficie (float)
     *      - fotos (string|null) JSON con nombres de las imágenes
     *      - videos (string|null) JSON con nombres de los videos
     *
     * @return array [int $id_publicacion, bool $exito] ID y estado de la inserción.
     * @throws Exception Si ocurre un error al ejecutar la consulta.
     */
    public function insertarPublicacion(array $d)
    {
        $sql = "INSERT INTO publicaciones (
                usuario_id, tipo_anuncio, tipo_inmueble, ubicacion,
                titulo, descripcion, precio, habitaciones, banos,
                estado, ascensor, piscina, gimnasio, garaje, terraza,
                jardin, aire_acondicionado, calefaccion, tipo_publicitante,
                superficie, fotos, videos
            ) VALUES (
                :usuario_id, :tipo_anuncio, :tipo_inmueble, :ubicacion,
                :titulo, :descripcion, :precio, :habitaciones, :banos,
                :estado, :ascensor, :piscina, :gimnasio, :garaje, :terraza,
                :jardin, :aire_acondicionado, :calefaccion, :tipo_publicitante,
                :superficie, :fotos, :videos
            )";

        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            ':usuario_id'         => $d['usuario_id'],
            ':tipo_anuncio'       => $d['tipo_anuncio'],
            ':tipo_inmueble'      => $d['tipo_inmueble'],
            ':ubicacion'          => $d['ubicacion'],
            ':titulo'             => $d['titulo'],
            ':descripcion'        => $d['descripcion'],
            ':precio'             => $d['precio'],
            ':habitaciones'       => $d['habitaciones'],
            ':banos'              => $d['banos'],
            ':estado'             => $d['estado'],
            ':ascensor'           => $d['ascensor'],
            ':piscina'            => $d['piscina'],
            ':gimnasio'           => $d['gimnasio'],
            ':garaje'             => $d['garaje'],
            ':terraza'            => $d['terraza'],
            ':jardin'             => $d['jardin'],
            ':aire_acondicionado' => $d['aire_acondicionado'],
            ':calefaccion'        => $d['calefaccion'],
            ':tipo_publicitante'  => $d['tipo_publicitante'],
            ':superficie'         => $d['superficie'],
            ':fotos'              => $d['fotos'],
            ':videos'             => $d['videos']
        ]);

        if ($ok) {
            return [$this->db->lastInsertId(), $ok];
        } else {
            throw new Exception('Error al insertar la publicación: ' . implode(', ', $stmt->errorInfo()));
        }
    }
}
