<?php

class UsuarioController {
    
    // Constructor
    public function __construct() {
        // Inicialización del controlador
    }

    // Método para manejar la solicitud del formulario
    public function manejarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['action'];
            echo "Acción recibida: $accion<br>"; 
            if ($accion === 'Iniciar sesión') {
                $this->iniciarSesion();
            } elseif ($accion === 'Registrarse' || $accion === 'Registro_usuario') {
                $this->registrarse();
            }
        } else {
            echo "No se recibió una solicitud POST<br>"; 
        }
    }

    // Método para iniciar sesión y que muestre error si peta
    private function iniciarSesion() {
        echo "Iniciando sesión...<br>";  
        if (!isset($_POST['nombre']) || !isset($_POST['contrasena'])) {
            session_start();
            $_SESSION['mensaje_error'] = "Por favor, introduce tu nombre y contraseña.";
            header("Location: ../index.php");
            exit(); 
        }

        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];
        echo "Nombre: $nombre, Contraseña: $contrasena<br>"; 

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
        echo "Registrando usuario...<br>";
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
            // Preparar sql
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
}


$controlador = new UsuarioController();
$controlador->manejarSolicitud();

?>
