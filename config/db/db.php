<?php
/**
 * Class Database
 *
 * Proporciona una conexión PDO persistente a la base de datos MySQL para la aplicación HabitaRoom.
 * Implementa el patrón Singleton para asegurar una única instancia de conexión.
 *
 * @package HabitaRoom\Core
 */
class Database
{
    /** @var string Host de la base de datos */
    private static $host = "localhost";

    /** @var string Nombre de la base de datos */
    private static $db = "habitaroom";

    /** @var string Usuario de la base de datos */
    private static $username = "root";

    /** @var string Contraseña de la base de datos */
    private static $password = "";

    /** @var PDO|null Instancia única de PDO */
    private static $conn = null;

    /**
     * Establece y devuelve la conexión PDO a la base de datos.
     *
     * Verifica si ya existe una conexión, si no, crea una nueva. En caso de que la base de datos
     * no exista (código de error 1049), intenta crearla y reconectar.
     *
     * @return PDO Instancia de PDO conectada a MySQL.
     * @throws PDOException Si ocurre un error de conexión diferente a inexistencia de base de datos.
     */
    public static function connect()
    {
        if (self::$conn === null) {
            try {
                // Intentar la conexión a la base de datos
                self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db, self::$username, self::$password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true
                ]);
            } catch (PDOException $exception) {
                // Si la base de datos no existe, se intenta crearla
                if ($exception->getCode() == 1049) {
                    self::createDatabase();
                    return self::connect(); // Intentar reconectar
                } else {
                    die("Error de conexión: " . $exception->getMessage());
                }
            }
        }
        return self::$conn;
    }

    /**
     * Cierra la conexión actual a la base de datos.
     */
    public static function disconnect()
    {
        self::$conn = null;
    }

    /**
     * Crea la base de datos si no existe.
     *
     * Se conecta al servidor sin especificar base de datos, crea la base de datos
     * con el nombre definido en la clase, y luego crea las tablas necesarias
     * para el funcionamiento de la aplicación.
     * Además, inserta datos de prueba en las tablas `usuarios` y `publicaciones`.
     * Esta función es llamada automáticamente si se detecta que la base de datos
     *
     * @return void
     */
    private static function createDatabase()
    {
        try {
            // 1. Conectar al servidor MySQL sin especificar base de datos
            $conn = new PDO(
                "mysql:host=" . self::$host,
                self::$username,
                self::$password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            // 2. Crear la base de datos si no existe
            $conn->exec("
            CREATE DATABASE IF NOT EXISTS `" . self::$db . "`
            CHARACTER SET utf8
            COLLATE utf8_spanish_ci
        ");
            echo '<script>console.log("Base de datos creada: ' . self::$db . '");</script>';

            // 3. Usar la base de datos creada
            $conn->exec("USE `" . self::$db . "`");

            // 4. Cargar el archivo SQL desde el mismo directorio
            $sqlFilePath = __DIR__ . '/habitaroom.sql';
            $sqlContent = file_get_contents($sqlFilePath);

            if ($sqlContent === false) {
                throw new Exception("No se pudo leer el archivo SQL.");
            }

            // 5. Ejecutar el contenido del archivo SQL
            $conn->exec($sqlContent);

        } catch (PDOException $e) {
            die("Error al crear la base de datos: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}