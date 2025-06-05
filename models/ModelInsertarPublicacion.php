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
    * Inserta una nueva publicación en la base de datos.
    *   * @param array $d Datos de la publicación a insertar. Debe contener las claves: 
    * 'usuario_id', 'tipo_anuncio', 'tipo_inmueble', 'ubicacion', 'titulo', 'descripcion',
    * 'precio', 'habitaciones', 'banos', 'estado', 'ascensor', 'piscina', 'gimnasio',
    * 'garaje', 'terraza', 'jardin', 'aire_acondicionado', 'calefaccion', 'tipo_publicitante',
    * 'superficie', 'latitud', 'longitud', 'calle', 'barrio', 'ciudad', 'provincia',
    * 'codigo_postal', 'fotos', 'videos'.
    * @return array Retorna un array con el ID de la nueva publicación y un booleano indicando el éxito de la operación.
    * @throws Exception Si ocurre un error al ejecutar la consulta SQL.
    */
    public function insertarPublicacion(array $d)
    {
        $sql = "INSERT INTO publicaciones (
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
                latitud,
                longitud,
                calle,
                barrio,
                ciudad,
                provincia,
                codigo_postal,
                fotos,
                videos
            ) VALUES (
                :usuario_id,
                :tipo_anuncio,
                :tipo_inmueble,
                :ubicacion,
                :titulo,
                :descripcion,
                :precio,
                :habitaciones,
                :banos,
                :estado,
                :ascensor,
                :piscina,
                :gimnasio,
                :garaje,
                :terraza,
                :jardin,
                :aire_acondicionado,
                :calefaccion,
                :tipo_publicitante,
                :superficie,
                :latitud,
                :longitud,
                :calle,
                :barrio,
                :ciudad,
                :provincia,
                :codigo_postal,
                :fotos,
                :videos
            )";

        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            ':usuario_id' => $d['usuario_id'],
            ':tipo_anuncio' => $d['tipo_anuncio'],
            ':tipo_inmueble' => $d['tipo_inmueble'],
            ':ubicacion' => $d['ubicacion'],
            ':titulo' => $d['titulo'],
            ':descripcion' => $d['descripcion'],
            ':precio' => $d['precio'],
            ':habitaciones' => $d['habitaciones'],
            ':banos' => $d['banos'],
            ':estado' => $d['estado'],
            ':ascensor' => $d['ascensor'],
            ':piscina' => $d['piscina'],
            ':gimnasio' => $d['gimnasio'],
            ':garaje' => $d['garaje'],
            ':terraza' => $d['terraza'],
            ':jardin' => $d['jardin'],
            ':aire_acondicionado' => $d['aire_acondicionado'],
            ':calefaccion' => $d['calefaccion'],
            ':tipo_publicitante' => $d['tipo_publicitante'],
            ':superficie' => $d['superficie'],

            // Asignación de los nuevos campos de ubicación
            ':latitud' => $d['latitud'],
            ':longitud' => $d['longitud'],
            ':calle' => $d['calle'],
            ':barrio' => $d['barrio'],
            ':ciudad' => $d['ciudad'],
            ':provincia' => $d['provincia'],
            ':codigo_postal' => $d['codigo_postal'],

            ':fotos' => $d['fotos'],
            ':videos' => $d['videos'],
        ]);

        if ($ok) {
            return [$this->db->lastInsertId(), $ok];
        } else {
            throw new Exception('Error al insertar la publicación: ' . implode(', ', $stmt->errorInfo()));
        }
    }
}