<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once '../controllers/ProductoController.php';
require_once '../controllers/CategoriaController.php';

$productoController = new ProductoController();
$categoriaController = new CategoriaController();

$categorias = $categoriaController->obtenerCategorias();

$categoriaSeleccionada = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : null;
if ($categoriaSeleccionada) {
    $productos = $productoController->obtenerProductosPorCategoria($categoriaSeleccionada);
} else {
    $productos = $productoController->obtenerProductos();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/menu_opciones.css">
    <title>Menú Tienda Admin</title>
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> (Admin)</h1>
        <nav>
            <ul>
                <li><a href="menu_tienda_admin.php">Inicio</a></li>
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
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p class="precio">Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                        <p class="stock">Stock: <?php echo htmlspecialchars($producto['stock']); ?></p>
                        <p class="oferta">Oferta: <?php echo htmlspecialchars($producto['oferta']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Mensajes de error o éxito dentro del aside -->
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

            <!-- Formulario de opciones de usuario y categorías -->
            <form action="../controllers/UsuarioController.php" method="post">
                <fieldset>
                    <legend>Opciones de Usuario</legend>
                    <button type="submit" name="action" value="ver_usuarios">Modificar Datos</button>
                    <button type="submit" name="action" value="logout">Logout</button>
                </fieldset>
            </form>
            <form action="../controllers/CategoriaController.php" method="post">
                <fieldset>
                    <legend>Opciones de Categorías</legend>
                    <button type="submit" name="action" value="ver_categorias">Ver/Crear Categorías</button>
                </fieldset>
            </form>
            <form action="../controllers/ProductoController.php" method="post">
                <fieldset>
                    <legend>Opciones de Productos</legend>
                    <button type="submit" name="action" value="ver_productos">Ver Productos</button>
                </fieldset>
            </form>
        </aside>
    </div>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>
