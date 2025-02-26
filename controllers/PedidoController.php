<?php
session_start();

class PedidoController {
    
    public function __construct() {
    }

    public function manejarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['action'];
            if ($accion === 'ver_productos') {
                $this->ver_productos();
            }
        }
    }

    private function ver_productos() {
        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->query("SELECT id, categoria_id, nombre, precio, stock, oferta, descripcion, imagen FROM productos");
        $productos = $stmt->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conexion->close();

        include '../vistas/ver_productos.php';
    }
}

$controlador = new PedidoController();
$controlador->manejarSolicitud();

?>