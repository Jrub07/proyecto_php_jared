<?php

require_once '../bd_controladores_principal.php';

use App\Database\Database;

class ProductoController {
    
    public function __construct() {
        
    }

    public function manejarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['action'];
            if ($accion === 'ver_productos') {
                $this->ver_productos();
            } elseif ($accion === 'crear_producto') {
                $this->crear_producto();
            } elseif ($accion === 'modificar_producto') {
                $this->mostrar_formulario_modificar();
            } elseif ($accion === 'actualizar_producto') {
                $this->actualizar_producto();
            } elseif ($accion === 'eliminar_producto') {
                $this->eliminar_producto($_POST['id']);
            }
        }
    }

    private function ver_productos() {
        $conexion = Database::connect();

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->query("SELECT id, categoria_id, nombre, precio, stock, oferta, descripcion, imagen FROM productos");
        $productos = $stmt->fetch_all(MYSQLI_ASSOC);

        $conexion->close();

        include '../vistas/ver_productos.php';
    }

    private function crear_producto() {
        session_start();

        $categoria_id = $_POST['categoria_id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $oferta = $_POST['oferta'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_path = "../uploads/" . basename($imagen);

        $conexion = Database::connect();

        if ($conexion->connect_error) {
            $_SESSION['mensaje_error'] = "Error de conexión: " . $conexion->connect_error;
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        if ($oferta > $stock) {
            $_SESSION['mensaje_error'] = "Tu stock es inferior a la oferta.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt = $conexion->prepare("SELECT id FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $_SESSION['mensaje_error'] = "La categoría no existe.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt->close();

        if (!is_dir('../uploads')) {
            mkdir('../uploads', 0777, true);
        }

        if (move_uploaded_file($imagen_tmp, $imagen_path)) {
            $stmt = $conexion->prepare("INSERT INTO productos (categoria_id, nombre, precio, stock, oferta, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                $_SESSION['mensaje_error'] = "Error en la preparación de la consulta: " . $conexion->error;
                header("Location: ../vistas/menu_tienda_admin.php");
                exit();
            }
            $stmt->bind_param("isdiiss", $categoria_id, $nombre, $precio, $stock, $oferta, $descripcion, $imagen_path);

            if ($stmt->execute()) {
                $_SESSION['mensaje_exito'] = "¡Producto creado correctamente!";
                header("Location: ../vistas/menu_tienda_admin.php");
                exit(); 
            } else {
                $_SESSION['mensaje_error'] = "Error al crear el producto.";
                header("Location: ../vistas/menu_tienda_admin.php");
                exit();
            }

            $stmt->close();
            $conexion->close();
        } else {
            $_SESSION['mensaje_error'] = "Error al subir la imagen.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }
    }

    private function mostrar_formulario_modificar() {
        $id = $_POST['id'];
        $conexion = Database::connect();

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("SELECT id, categoria_id, nombre, precio, stock, oferta, descripcion, imagen FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $producto = $resultado->fetch_assoc();

        $stmt->close();
        $conexion->close();

        include __DIR__ . '/../vistas/modificar_producto_admin.php';
    }

    private function actualizar_producto() {
        session_start();

        $id = $_POST['id'];
        $categoria_id = $_POST['categoria_id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $oferta = $_POST['oferta'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];

        $conexion = Database::connect();

        if ($conexion->connect_error) {
            $_SESSION['mensaje_error'] = "Error de conexión: " . $conexion->connect_error;
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        if ($oferta > $stock) {
            $_SESSION['mensaje_error'] = "Tu stock es inferior a la oferta.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt = $conexion->prepare("SELECT id FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $_SESSION['mensaje_error'] = "La categoría no existe.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt->close();

        if (!empty($imagen)) {
            $imagen_path = "../uploads/" . basename($imagen);
            if (move_uploaded_file($imagen_tmp, $imagen_path)) {
                $stmt = $conexion->prepare("UPDATE productos SET categoria_id = ?, nombre = ?, precio = ?, stock = ?, oferta = ?, descripcion = ?, imagen = ? WHERE id = ?");
                $stmt->bind_param("isdiissi", $categoria_id, $nombre, $precio, $stock, $oferta, $descripcion, $imagen_path, $id);
            } else {
                $_SESSION['mensaje_error'] = "Error al subir la imagen.";
                header("Location: ../vistas/menu_tienda_admin.php");
                exit();
            }
        } else {
            $stmt = $conexion->prepare("UPDATE productos SET categoria_id = ?, nombre = ?, precio = ?, stock = ?, oferta = ?, descripcion = ? WHERE id = ?");
            $stmt->bind_param("isdiisi", $categoria_id, $nombre, $precio, $stock, $oferta, $descripcion, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['mensaje_exito'] = "¡Producto actualizado correctamente!";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit(); 
        } else {
            $_SESSION['mensaje_error'] = "Error al actualizar el producto.";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt->close();
        $conexion->close();
    }

    private function eliminar_producto($id) {
        session_start(); 

        $conexion = Database::connect();

        if ($conexion->connect_error) {
            $_SESSION['mensaje_error'] = "Error de conexión: " . $conexion->connect_error;
            header("Location: ../vistas/menu_tienda_admin.php");
            exit();
        }

        $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['mensaje_exito'] = "¡Producto eliminado correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error al eliminar el producto: " . $stmt->error;
        }

        $stmt->close();
        $conexion->close();

        header("Location: ../vistas/menu_tienda_admin.php");
        exit();
    }

    public function obtenerProductos() {
        $conexion = Database::connect();

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->query("SELECT id, categoria_id, nombre, precio, stock, oferta, descripcion, imagen FROM productos");
        $productos = $stmt->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conexion->close();

        return $productos;
    }

    public function obtenerProductosPorCategoria($categoria_id) {
        $conexion = Database::connect();
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("SELECT * FROM productos WHERE categoria_id = ?");
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $productos = [];

        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        $stmt->close();
        $conexion->close();

        return $productos;
    }
}

$controlador = new ProductoController();
$controlador->manejarSolicitud();

?>
