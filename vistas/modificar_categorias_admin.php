<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (!isset($categoria) || !is_array($categoria)) {
    $_SESSION['mensaje_error'] = "Categoría no encontrada.";
    header("Location: ../vistas/ver_categorias.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Categoría</title>
    <link rel="stylesheet" href="../styles/modificar_categorias_admin.css">
</head>
<body>
    <header>
        <h1>Modificar Categoría</h1>
    </header>
    <section>
        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <p style="color: green;"><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></p>
        <?php endif; ?>
        <form action="../controllers/CategoriaController.php" method="post">
            <fieldset>
                <legend>Modificar Categoría</legend>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($categoria['id']); ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($categoria['nombre']); ?>" required>
                <button type="submit" name="action" value="actualizar_categoria">Actualizar Categoría</button>
            </fieldset>
        </form>
        <button onclick="window.location.href='../vistas/ver_categorias.php'">Volver a Categorías</button>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>