<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="../styles/modificar_producto.css">
</head>
<body>
    <header>
        <h1>Modificar Producto</h1>
    </header>
    <section>
        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
        <?php endif; ?>
        <form action="../controllers/ProductoController.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Modificar Producto</legend>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                <label for="categoria_id">Categoría ID:</label>
                <input type="number" id="categoria_id" name="categoria_id" value="<?php echo htmlspecialchars($producto['categoria_id']); ?>" required>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
                <label for="oferta">Oferta:</label>
                <input type="number" id="oferta" name="oferta" value="<?php echo htmlspecialchars($producto['oferta']); ?>" required>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
                <p>Imagen actual:</p>
                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" width="100">
                <button type="submit" name="action" value="actualizar_producto">Actualizar Producto</button>
            </fieldset>
        </form>
        <button onclick="window.location.href='../vistas/menu_tienda_admin.php'">Volver al Menú</button>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>