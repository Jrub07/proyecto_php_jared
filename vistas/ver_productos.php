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
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No se encontraron productos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button onclick="window.location.href='../vistas/menu_tienda_admin.php'">Volver al Menú</button>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>