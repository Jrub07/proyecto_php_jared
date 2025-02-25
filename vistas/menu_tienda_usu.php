
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
    
</body>
</html>