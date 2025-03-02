<?php
session_start();

require_once '../controllers/ProductoController.php';
require_once '../controllers/CategoriaController.php';

$productoController = new ProductoController();
$categoriaController = new CategoriaController();

$productos = $productoController->obtenerProductos();
$categorias = $categoriaController->obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/tienda_usu.css">
    <title>Menú Tienda Usuario</title>
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Invitado'; ?> (Usuario)</h1>
        <nav>
            <ul>
                <li><a href="menu_tienda_usu.php">Inicio</a></li>
                <?php if (is_array($categorias) && count($categorias) > 0): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <li><a href="#"><?php echo htmlspecialchars($categoria['nombre']); ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No hay categorías disponibles</li>
                <?php endif; ?>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <div class="content">
        <section>
            <div class="productos">
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <img src="../uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p class="precio">Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                        <p class="stock">Stock: <?php echo htmlspecialchars($producto['stock']); ?></p>
                        <p class="oferta">Oferta: <?php echo htmlspecialchars($producto['oferta']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <aside>
            <?php if (isset($_SESSION['mensaje_error'])): ?>
                <div class="mensaje error">
                    <p><?php echo htmlspecialchars($_SESSION['mensaje_error']); unset($_SESSION['mensaje_error']); ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensaje_exito'])): ?>
                <div class="mensaje exito">
                    <p><?php echo htmlspecialchars($_SESSION['mensaje_exito']); unset($_SESSION['mensaje_exito']); ?></p>
                </div>
            <?php endif; ?>

            <form action="../controllers/UsuarioController.php" method="post">
                <fieldset>
                    <legend>Opciones de Usuario</legend>
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