<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuario</title>
    <link rel="stylesheet" href="../styles/ver_categorias.css">
    
</head>
<body>
    <header>
        <h1>Ver Usuario</h1>
    </header>
    <section id="user-section">
        <form id="user-form">
            <!-- Formulario de usuario -->
        </form>
        <table id="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($usuarios) && is_array($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                            <td>
                                <form action="../controllers/UsuarioController.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                    <button type="submit" name="action" value="modificar_usuario">Modificar</button>
                                </form>
                                <form action="../controllers/UsuarioController.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                    <button type="submit" name="action" value="eliminar_usuario">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No se encontraron usuarios.</td>
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