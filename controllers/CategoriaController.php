<?php
session_start();

class CategoriaController {
    

    public function __construct() {
        
    }


    public function manejarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['action'];
            if ($accion === 'ver_categorias') {
                $this->ver_categorias();
            } elseif ($accion === 'crear_categoria') {
                $this->crear_categoria();
            } elseif ($accion === 'ver_crear_productos') {
                $this->ver_crear_productos();
            }
        }
    }


    private function ver_categorias() {
        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->query("SELECT id, nombre FROM categorias");
        $categorias = $stmt->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conexion->close();

        include '../vistas/ver_categorias.php';
    }


    private function crear_categoria() {
        $nombre = $_POST['nombre'];

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

 
        $stmt = $conexion->prepare("SELECT id FROM categorias WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['mensaje_error'] = "El nombre de la categoría ya está en uso. Por favor, elige otro.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt->close();

    
        $stmt = $conexion->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);

        if ($stmt->execute()) {
            $_SESSION['mensaje_exito'] = "¡Categoría creada correctamente!";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit(); 
        } else {
            $_SESSION['mensaje_error'] = "Error al crear la categoría.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt->close();
        $conexion->close();
    }

  
    private function ver_crear_productos() {
     
        echo "Ver/Crear Productos - A implementar";
    }
}

$controlador = new CategoriaController();
$controlador->manejarSolicitud();

?>