<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Tienda Usuario</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Usuario)</h1>
    <p>Inicio de sesión exitoso.</p>
    
    <?php if (isset($_SESSION['mensaje_error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
    <?php endif; ?>
    
    <form action="../controllers/UsuarioController.php" method="post">
        <fieldset>
            <legend>Opciones de Usuario</legend>
            <button type="submit" name="action" value="ver_pedidos">Ver Pedidos</button>
            <button type="submit" name="action" value="usuario_modifica_datos">Modificar Datos</button>
            <button type="submit" name="action" value="logout">Logout</button>
        </fieldset>
    </form>
</body>
</html>