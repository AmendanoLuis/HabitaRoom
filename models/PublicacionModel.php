<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/HabitaRoom/config/db/db.php';


class PublicacionModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function insertarPublicacion(array $d): bool
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
        return $stmt->execute([
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
            ':videos'              => $d['videos']
        ]);
    }
}
