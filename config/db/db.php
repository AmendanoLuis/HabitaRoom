<?php

class Database
{
    // Variables de conexión
    private static  $host = "localhost";
    private static $db = "habitaroomtest";
    private static $username = "root";
    private static $password = "root";
    private static $conn = null;

    // Función para conectar a la base de datos
    public static function connect()
    {
        if (self::$conn === null) {
            try {

                // Conexión a la base de datos
                self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db, self::$username, self::$password, [
                    PDO::ATTR_PERSISTENT => true
                ]);
                
                // Configuración de la conexión
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$conn;
            
            } catch (PDOException $exception) {
                echo "Error de conexión: " . $exception->getMessage();
                echo "Hubo un problema al conectar a la base de datos.";
                exit();
            }
        } else {

            // Si ya existe la conexión retornar la conexión
            return self::$conn;
        }
    }

    // Función para desconectar de la base de datos
    public static function disconnect()
    {
        self::$conn = null;
    }

    
}
