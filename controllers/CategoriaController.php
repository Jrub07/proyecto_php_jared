<?php
session_start();

require_once '../bd_controladores_principal.php';

use App\Database\Database;

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
            } elseif ($accion === 'modificar_categoria') {
                $this->mostrar_formulario_modificar();
            } elseif ($accion === 'actualizar_categoria') {
                $this->actualizar_categoria();
            } elseif ($accion === 'eliminar_categoria') {
                $this->eliminar_categoria($_POST['id']);
            } elseif ($accion === 'ver_crear_productos') {
                $this->ver_crear_productos();
            }
        }
    }

    private function ver_categorias() {
        $conexion = Database::connect();

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

        $conexion = Database::connect();

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

    private function mostrar_formulario_modificar() {
        $id = $_POST['id'];
        $conexion = Database::connect();

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("SELECT id, nombre FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $categoria = $resultado->fetch_assoc();

        $stmt->close();
        $conexion->close();

        include __DIR__ . '/../vistas/modificar_categorias_admin.php';
    }

    private function actualizar_categoria() {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        $conexion = Database::connect();

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nombre, $id);

        if ($stmt->execute()) {
            $_SESSION['mensaje_exito'] = "¡Categoría actualizada correctamente!";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit(); 
        } else {
            $_SESSION['mensaje_error'] = "Error al actualizar la categoría.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt->close();
        $conexion->close();
    }

    private function eliminar_categoria($id) {
        $conexion = Database::connect();

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("DELETE FROM productos WHERE categoria_id = ?");
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $_SESSION['mensaje_error'] = "Error al eliminar los productos de la categoría: " . $stmt->error;
            $stmt->close();
            $conexion->close();
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }
        $stmt->close();

        $stmt = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['mensaje_exito'] = "¡Categoría eliminada correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error al eliminar la categoría: " . $stmt->error;
        }

        $stmt->close();
        $conexion->close();

        header("Location: ../vistas/menu_tienda_admin.php");
        exit();
    }

    private function ver_crear_productos() {
        echo "Ver/Crear Productos - A implementar";
    }
}

$controlador = new CategoriaController();
$controlador->manejarSolicitud();

?>