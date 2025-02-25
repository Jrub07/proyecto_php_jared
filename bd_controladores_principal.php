<?php
session_start();
require_once 'autoload.php';
// require_once __DIR__ . '/config/db.php'; // Esta línea se comenta ya que no existe el archivo db.php

class Database {  
    public static function connect() {
        $connection = new mysqli('localhost', 'root', '', 'tienda_php');
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
} else {
    // Redirigir a index.php si la conexión es exitosa
    // header("Location: index.php");
    // exit();
}

/*
function show_error(){
    $error = new errorController();
    $error->index();
}

if(isset($_GET['controller'])){
    $nombre_controlador = $_GET['controller'].'Controller';

}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
    $nombre_controlador = controller_default;

}else{
    show_error();
    exit();
}

if(class_exists($nombre_controlador)){    
    $controlador = new $nombre_controlador();
    
    if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
        $action = $_GET['action'];
        $controlador->$action();
    }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
        $action_default = action_default;
        $controlador->$action_default();
    }else{
        show_error();
    }
}else{
    show_error();
}

require_once 'views/layout/footer.php';
*/


