<?php

require_once '../controllers/ProductoController.php';
$productoController = new ProductoController();
$productos = $productoController->obtenerProductos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/menu_opciones.css">
    <title>Menú Tienda Usuario</title>
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Usuario)</h1>
    </header>
    <div class="content">
        <section>
            <div class="productos">
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <img src="../uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p>Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <aside>
            <form action="../controllers/UsuarioController.php" method="post">
                <fieldset>
                    <legend>Opciones de Usuario</legend>
                    <button type="submit" name="action" value="ver_pedidos">Ver Pedidos</button>
                    <button type="submit" name="action" value="usuario_modifica_datos">Modificar Datos</button>
                    <button type="submit" name="action" value="logout">Logout</button>
                </fieldset>
            </form>
        </aside>
    </div>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>