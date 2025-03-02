
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Datos</title>
    <link rel="stylesheet" href="../styles/usuario_modifica_datos.css">
</head>
<body>
    <header>
        <h1>Modificar Datos</h1>
    </header>
    <section>
        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
        <?php endif; ?>
        <h2>Datos del Usuario</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <td><?php echo htmlspecialchars($nombre); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><?php echo htmlspecialchars($password); ?></td>
            </tr>
        </table>
        <form action="../controllers/UsuarioController.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
            <button type="submit" name="action" value="actualizar_datos">Guardar Cambios</button>
        </form>
        <form action="menu_tienda_usu.php" method="get">
            <button type="submit">Volver al Menú</button>
        </form>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>