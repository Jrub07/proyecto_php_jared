<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver/Modificar Usuarios</title>
    <link rel="stylesheet" href="../styles/ver_usuarios.css">
</head>
<body>
    <header>
        <h1>Lista de Usuarios</h1>
    </header>
    <section>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($usuarios) && is_array($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['password']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No se encontraron usuarios.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
    <section>
        <form action="../controllers/UsuarioController.php" method="post">
            <fieldset>
                <legend>Seleccionar Usuario por ID</legend>
                <label for="user_id">ID del Usuario:</label>
                <input type="number" id="user_id" name="user_id" required>
                <button type="submit" name="action" value="modificar_usuario">Modificar Usuario</button>
            </fieldset>
        </form>
        <button onclick="window.location.href='../vistas/menu_tienda_admin.php'">Volver al Menú</button>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>