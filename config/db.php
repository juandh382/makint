<?php



class Connection extends PDO
{

    private static $database = 'makint';
    private static $dbHost = 'localhost';
    private static $userName = 'root';
    private static $password = '';

    public function __construct()
    {

        try {

            $dsn = "mysql:dbname=${self::$database};host=${self::$dbHost}";
            parent::__construct($dsn, self::$userName, self::$password);

        }
        catch (PDOException $e) {

            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}