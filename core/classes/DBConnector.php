<?php
namespace MyApp;
use PDO;
use PDOException;

class DBConnector{
    private static $host = "localhost";
    private static $db_name = "mhs";
    private static $db_user = "root";
    private static $db_password = "";

    public static function getConnection(){
        $dsn = "mysql:host=".self::$host.";dbname=".self::$db_name;
        try {
            $con = new PDO($dsn,self::$db_user,self::$db_password);
            return $con;
        } catch (PDOException $ex) {
            die("Error : ".$ex->getMessage());
        }
    }
}


