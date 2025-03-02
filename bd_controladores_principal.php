<?php
namespace App\Database;



class Database {  
    public static function connect() {
        $connection = new \mysqli('localhost', 'root', '', 'tienda_php');
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        return $connection;
    }
}

// Verificar la conexión a la base de datos
$connection = Database::connect();
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}