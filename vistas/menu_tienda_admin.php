<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once '../controllers/ProductoController.php';
$productoController = new ProductoController();
$productos = $productoController->obtenerProductos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Tienda Admin</title>
    <link rel="stylesheet" href="../styles/menu_opciones.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Admin)</h1>
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

        <!-- Mensajes de error o éxito dentro del aside -->
        <aside>
            <?php if (isset($_SESSION['mensaje_error'])): ?>
                <div class="mensaje error">
                    <p><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensaje_exito'])): ?>
                <div class="mensaje exito">
                    <p><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></p>
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
