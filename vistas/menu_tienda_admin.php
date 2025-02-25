<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Tienda Admin</title>
    <link rel="stylesheet" href="../styles/menu_tienda_admin.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Admin)</h1>
    </header>
    <section>
        <form action="../controllers/AdminController.php" method="post">
            <fieldset>
                <legend>Opciones de Administración</legend>
                <button type="submit" name="action" value="ver_crear_categorias">Ver/Crear Categorías</button>
                <button type="submit" name="action" value="ver_crear_productos">Ver/Crear Productos</button>
                <button type="submit" name="action" value="ver_modificar_usuarios">Ver/Modificar Usuarios</button>
                <button type="submit" name="action" value="logout">Logout</button>
            </fieldset>
        </form>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>