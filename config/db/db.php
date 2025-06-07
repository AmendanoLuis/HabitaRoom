<?php

class Database {
    private $host = 'localhost';
    private $usuario = 'root';
    private $contrasena = '';
    private $nombreBD = 'habitaroom';
    private $conexion;

    public function conectar() {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->nombreBD", $this->usuario, $this->contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }

    public function crearBaseDeDatos() {
        try {
            $dbName = $this->nombreBD;

            // Crear conexión sin seleccionar una base de datos todavía
            $conn = new PDO("mysql:host=$this->host", $this->usuario, $this->contrasena);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear base de datos si no existe
            $conn->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8 COLLATE utf8_spanish_ci");
            $conn->exec("USE `$dbName`");

            // Leer el contenido del archivo SQL
            $sqlFile = __DIR__ . '/habitaroom.sql';
            if (!file_exists($sqlFile)) {
                throw new Exception("El archivo habitaroom.sql no se encuentra en el directorio actual.");
            }
            $sql = file_get_contents($sqlFile);

            // Separar instrucciones (por ; + salto de línea)
            $commands = array_filter(array_map('trim', explode(";\n", $sql)));

            // Ejecutar cada instrucción individualmente
            foreach ($commands as $command) {
                if (!empty($command)) {
                    $conn->exec($command);
                }
            }

            echo "✅ Base de datos '$dbName' creada y poblada correctamente.";
        } catch (PDOException $e) {
            echo "❌ Error al crear la base de datos: " . $e->getMessage();
        } catch (Exception $e) {
            echo "⚠️ Error: " . $e->getMessage();
        }
    }
}
