<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badulake</title>
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
    <header>        
        <img src="./img/logo.png" alt="logo">
        <nav>
            <ul>
                <li><a href="#">Categoria 1</a></li>
                <li><a href="#">Categoria 2</a></li>
                <li><a href="#">Carrito</a></li>
            </ul>
        </nav>
        
    </header>

    <aside>
        <form action="" method="post">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario">
            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena">
            <input type="submit" value="Iniciar sesión">
            <input type="button" value="Registrarse">
        </form>
    </aside>

    <?php
    require_once 'bd_controladores_principal.php';

    // Verificar la conexión a la base de datos
    $connection = Database::connect();
    if ($connection->connect_error) {
        die("Error al conectar: " . $connection->connect_error);
    } else {
        echo "<p>Conexion exitosa</p>";
    }
    ?>

    <footer>
        <p>Badulake - 2020</p>
    </footer>
    
</body>
</html>