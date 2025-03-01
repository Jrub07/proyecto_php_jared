<?php
session_start();

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

    private function crear_producto() {
        $categoria_id = $_POST['categoria_id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $oferta = $_POST['oferta'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_path = "../uploads/" . basename($imagen);

        if (!is_dir('../uploads')) {
            mkdir('../uploads', 0777, true);
        }

        if (move_uploaded_file($imagen_tmp, $imagen_path)) {
            $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $stmt = $conexion->prepare("INSERT INTO productos (categoria_id, nombre, precio, stock, oferta, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
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
        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

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
        $id = $_POST['id'];
        $categoria_id = $_POST['categoria_id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $oferta = $_POST['oferta'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

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
        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
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
        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->query("SELECT nombre, descripcion, precio, imagen FROM productos");
        $productos = $stmt->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conexion->close();

        return $productos;
    }
}

$controlador = new ProductoController();
$controlador->manejarSolicitud();

?>
