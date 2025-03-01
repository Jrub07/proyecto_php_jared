<?php
session_start();

class UsuarioController {
    
    public function __construct() {
    }

    public function manejarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['action'];
            if ($accion === 'Iniciar sesión') {
                $this->iniciarSesion();
            } elseif ($accion === 'Registrarse' || $accion === 'Registro_usuario') {
                $this->registrarse();
            } elseif ($accion === 'logout') {
                $this->logout();
            } elseif ($accion === 'ver_usuarios') {
                $this->ver_usuarios();
            } elseif ($accion === 'modificar_usuario') {
                $this->modificar_usuario();
            } elseif ($accion === 'actualizar_usuario') {
                $this->actualizar_usuario();
            } elseif ($accion === 'eliminar_usuario') {
                $this->eliminar_usuario();
            } elseif ($accion === 'ver_pedidos') {
                $this->ver_pedidos();
            } elseif ($accion === 'usuario_modifica_datos') {
                $this->usuario_modifica_datos();
            } elseif ($accion === 'actualizar_datos') {
                $this->actualizar_datos();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $this->cargar_usuario($_GET['id']);
        } else {
            echo "No se recibió una solicitud POST<br>"; 
        }
    }

  
    private function cargar_usuario($user_id) {
        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("SELECT id, nombre, email, password, rol FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($dbId, $dbNombre, $dbEmail, $dbPassword, $dbRol);
        $stmt->fetch();
        $stmt->close();
        $conexion->close();

     
        $id = $dbId;
        $nombre = $dbNombre;
        $email = $dbEmail;
        $password = $dbPassword;
        $rol = $dbRol;

        include '../vistas/modificar_usu.php';
    }

   
    private function usuario_modifica_datos() {
        $usuario = $_SESSION['usuario'];

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("SELECT nombre, email, password FROM usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($nombre, $email, $password);
        $stmt->fetch();
        $stmt->close();
        $conexion->close();

    
        $_SESSION['nombre'] = $nombre;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        include '../vistas/usuario_modifica_datos.php';
    }

   
    private function actualizar_datos() {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $usuario = $_SESSION['usuario'];

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

      
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE nombre = ? AND nombre != ?");
        $stmt->bind_param("ss", $nombre, $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['mensaje_error'] = "El nombre de usuario ya está en uso. Por favor, elige otro.";
            $_SESSION['nombre'] = $nombre;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            header("Location: ../vistas/menu_tienda_usu.php");
            exit();
        }

        $stmt->close();

    
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE nombre = ?");
        $stmt->bind_param("ssss", $nombre, $email, $password, $usuario);

        if ($stmt->execute()) {
            $_SESSION['usuario'] = $nombre; // Actualizar el nombre de usuario en la sesión
            $_SESSION['mensaje_exito'] = "¡Datos modificados correctamente!";
            header("Location: ../vistas/menu_tienda_usu.php");
            exit(); 
        } else {
            echo "Error al modificar los datos<br>";
        }

        $stmt->close();
        $conexion->close();
    }


    private function guardar_usuario() {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rol = $_POST['rol'];

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ?, rol = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nombre, $email, $password, $rol, $id);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['mensaje_exito'] = "¡Usuario modificado correctamente!";
            header("Location: ../vistas/ver_usu.php");
            exit(); 
        } else {
            echo "Error al modificar el usuario<br>";
        }

        $stmt->close();
        $conexion->close();
    }


    private function iniciarSesion() {
        if (!isset($_POST['nombre']) || !isset($_POST['contrasena'])) {
            session_start();
            $_SESSION['mensaje_error'] = "Por favor, introduce tu nombre y contraseña.";
            header("Location: ../index.php");
            exit(); 
        }

        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("SELECT password, rol FROM usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password, $rol);
            $stmt->fetch();

            if ($contrasena === $stored_password) {
                session_start();
                $_SESSION['usuario'] = $nombre;
                $_SESSION['rol'] = $rol;
                setcookie('usuario', $nombre, time() + (86400 * 30), "/");

                $destino = ($rol === 'admin') ? "../vistas/menu_tienda_admin.php" : "../vistas/menu_tienda_usu.php";
                header("Location: $destino");
                exit(); 
            } else {
                session_start();
                $_SESSION['mensaje_error'] = "Contraseña incorrecta.";
                header("Location: ../index.php");
                exit();
            }
        } else {
            session_start();
            $_SESSION['mensaje_error'] = "Usuario no encontrado.";
            header("Location: ../index.php");
            exit(); 
        }

        $stmt->close();
        $conexion->close();
    }


    private function registrarse() {
        if (!isset($_POST['nombre']) || !isset($_POST['email']) || !isset($_POST['contrasena'])) {
            session_start();
            $_SESSION['mensaje_error'] = "Por favor, completa todos los campos del formulario.";
            header("Location: ../vistas/formulario_registro.php");
            exit(); 
        }

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $rol = 'usuario'; 

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            session_start();
            $_SESSION['mensaje_error'] = "El nombre de usuario ya está en uso. Por favor, elige otro.";
            header("Location: ../vistas/formulario_registro.php");
            exit(); 
        } else {
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nombre, $email, $contrasena, $rol);

            if ($stmt->execute()) {
                session_start();
                $_SESSION['mensaje_exito'] = "¡Usuario registrado correctamente!";
                header("Location: ../index.php");
                exit(); 
            } else {
                echo "Error al registrar el usuario<br>";
            }
        }

        $stmt->close();
        $conexion->close();
    }


    private function logout() {
        session_start();
        session_unset();
        session_destroy();
        setcookie('usuario', '', time() - 3600, "/");
        session_start();
        $_SESSION['mensaje_exito'] = "Usuario desconectado.";
        header("Location: ../index.php");
        exit();
    }


    private function ver_usuarios() {
        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->query("SELECT id, nombre, email, password, rol FROM usuarios");
        $usuarios = $stmt->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conexion->close();

        include '../vistas/ver_usu.php';
    }

    private function modificar_usuario() {
        $user_id = $_POST['id'];
        header("Location: ../controllers/UsuarioController.php?id=$user_id");
        exit();
    }

    private function actualizar_usuario() {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rol = $_POST['rol'];

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

     
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE nombre = ? AND id != ?");
        $stmt->bind_param("si", $nombre, $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            session_start();
            $_SESSION['mensaje_error'] = "El nombre de usuario ya está en uso. Por favor, elige otro.";
            header("Location: ../vistas/modificar_usu.php?id=$id");
            exit();
        }

        $stmt->close();


        $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ?, rol = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nombre, $email, $password, $rol, $id);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['mensaje_exito'] = "¡Usuario modificado correctamente!";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit(); 
        } else {
            echo "Error al modificar el usuario<br>";
        }

        $stmt->close();
        $conexion->close();
    }

    private function eliminar_usuario() {
        $id = $_POST['id'];

        $conexion = new mysqli('localhost', 'root', '', 'tienda_php');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['mensaje_exito'] = "¡Usuario eliminado correctamente!";
            header("Location: ../vistas/menu_tienda_admin.php");
            exit(); 
        } else {
            echo "Error al eliminar el usuario<br>";
        }

        $stmt->close();
        $conexion->close();
    }
}

$controlador = new UsuarioController();
$controlador->manejarSolicitud();

?>
