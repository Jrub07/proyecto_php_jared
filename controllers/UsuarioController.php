<?php
session_start();

class UsuarioController {
    
    // Constructor
    public function __construct() {
        // Inicialización del controlador
    }

    // Método para manejar la solicitud del formulario
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
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $this->cargar_usuario($_GET['id']);
        } else {
            echo "No se recibió una solicitud POST<br>"; 
        }
    }

    // Método para cargar datos del usuario
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

        // Asignamos los valores a variables que espera modificar_usu.php
        $id = $dbId;
        $nombre = $dbNombre;
        $email = $dbEmail;
        $password = $dbPassword;
        $rol = $dbRol;

        include '../vistas/modificar_usu.php';
    }

    // Método para guardar usuario modificado
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

    // Método para iniciar sesión y que muestre error si peta
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

    // Método para registrar un nuevo usuario
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

    // Método para cerrar sesión
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

    // Método para ver usuarios
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
    // Método para modificar usuario
    private function modificar_usuario() {
        $user_id = $_POST['user_id'];
        // Redirigir a la página de edición de usuario con el ID del usuario seleccionado
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

        // Verificar si el nombre de usuario ya existe
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

        // Actualizar los datos del usuario
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
}

$controlador = new UsuarioController();
$controlador->manejarSolicitud();

?>
