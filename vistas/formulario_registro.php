<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="../styles/formulario_registro.css">
</head>
<body>
    <header>
        <h1>Registro de Usuario</h1>
    </header>
    <section>
        <?php
        session_start();
        if (isset($_SESSION['mensaje_error'])) {
            echo "<p style='color: red;'>" . $_SESSION['mensaje_error'] . "</p>";
            unset($_SESSION['mensaje_error']);
        }
        ?>
        <form id="registroForm" action="../controllers/UsuarioController.php" method="post">
            <fieldset>
                <legend>Registrar Nuevo Usuario</legend>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Introduce tu nombre" required>
                
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Introduce tu email" required>
                
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Introduce tu contraseña" required>
                
                <input type="hidden" name="action" id="action" value="Registro_usuario">
                <button type="submit">Registrar</button>
                <button type="button" onclick="window.location.href='../index.php'">Volver a Inicio</button>
            </fieldset>
        </form>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>
