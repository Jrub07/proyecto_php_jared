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
    <title>Ver Productos</title>
    <link rel="stylesheet" href="../styles/ver_productos.css">
</head>
<body>
    <header>
        <h1>Listado de Productos</h1>
    </header>
    <section>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoría ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Oferta</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($productos) && is_array($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id']); ?></td>
                            <td><?php echo htmlspecialchars($producto['categoria_id']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                            <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                            <td><?php echo htmlspecialchars($producto['oferta']); ?></td>
                            <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" width="50"></td>
                            <td>
                                <form action="../controllers/ProductoController.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                    <button type="submit" name="action" value="modificar_producto">Modificar</button>
                                </form>
                                <form action="../controllers/ProductoController.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                    <button type="submit" name="action" value="eliminar_producto">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No se encontraron productos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <form action="../controllers/ProductoController.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Crear Nuevo Producto</legend>
                <label for="categoria_id">Categoría ID:</label>
                <input type="number" id="categoria_id" name="categoria_id" required>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" id="precio" name="precio" required>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>
                <label for="oferta">Oferta:</label>
                <input type="number" id="oferta" name="oferta" required>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                <button type="submit" name="action" value="crear_producto">Crear Producto</button>
            </fieldset>
        </form>
        <button onclick="window.location.href='../vistas/menu_tienda_admin.php'">Volver al Menú</button>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>