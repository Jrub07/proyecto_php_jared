

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Categorías</title>
    <link rel="stylesheet" href="../styles/ver_categorias.css">
</head>
<body>
    <header>
        <h1>Listado de Categorías</h1>
    </header>
    <section>
        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <p style="color: green;"><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($categorias) && is_array($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                            <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No se encontraron categorías.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <form action="../controllers/CategoriaController.php" method="post">
            <fieldset>
                <legend>Crear Nueva Categoría</legend>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <button type="submit" name="action" value="crear_categoria">Crear Categoría</button>
            </fieldset>
        </form>
        <button onclick="window.location.href='../vistas/menu_tienda_admin.php'">Volver al Menú</button>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>