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
    </header>

    <?php
    session_start();
    var_dump($_SESSION);
    ?>

    <section>
        <?php
        if (isset($_SESSION['mensaje_error'])) {
            echo "<p style='color: red; text-align: center;'>" . $_SESSION['mensaje_error'] . "</p>";
            unset($_SESSION['mensaje_error']);  
        }

        if (isset($_SESSION['mensaje_exito'])) {
            echo "<p style='color: green; text-align: center;'>" . $_SESSION['mensaje_exito'] . "</p>";
            unset($_SESSION['mensaje_exito']);  
        }
        ?>
        
        <form id="loginForm" action="controllers/UsuarioController.php" method="post">
            <fieldset>
                <legend>Iniciar Sesión</legend>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" >
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" >
                <input type="hidden" name="action" id="action" value="Iniciar sesión">
                <button type="submit" onclick="document.getElementById('action').value='Iniciar sesión'">Iniciar sesión</button>
                <button type="submit" onclick="document.getElementById('action').value='Registrarse'">Registrarme</button>
            </fieldset>
        </form>
    </section>

    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>
