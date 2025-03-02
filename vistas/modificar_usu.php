
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="../styles/modificar_usu.css">
</head>
<body>
    <header>
        <h1>Modificar Usuario</h1>
    </header>
    <section id="modify-user-section">
        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
        <?php endif; ?>
        <h2>Datos del Usuario</h2>
        <table id="user-table">
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($id); ?></td>
            </tr>
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
            <tr>
                <th>Rol</th>
                <td><?php echo htmlspecialchars($rol); ?></td>
            </tr>
        </table>
    </section>
    <section>
        <h2>Editar Usuario</h2>
        <form id="user-form" action="../controllers/UsuarioController.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
            <label for="rol">Rol:</label>
            <input type="text" id="rol" name="rol" value="<?php echo htmlspecialchars($rol); ?>" required>
            <button type="submit" name="action" value="actualizar_usuario">Guardar Cambios</button>
        </form>
        <button onclick="window.location.href='../vistas/menu_tienda_admin.php'">Volver al Menú</button>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>