<?php


$id = $_GET['id'] ?? 0; // Asegurar que se recibe un ID válido

$conexion = new mysqli('localhost', 'root', '', 'tienda_php');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$stmt = $conexion->prepare("SELECT nombre, email, password, rol FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($nombre, $email, $password, $rol);
    $stmt->fetch();
} else {
    // Si no encuentra el usuario, asigna valores vacíos para evitar errores en el HTML
    $nombre = $email = $password = $rol = "No encontrado";
}

$stmt->close();
$conexion->close();
?>

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
    <section>
        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
        <?php endif; ?>
        <h2>Datos del Usuario</h2>
        <table>
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
        <form action="../controllers/UsuarioController.php" method="post">
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
        <form action="../vistas/menu_tienda_admin.php" method="get">
            <button type="submit">Volver al Menú</button>
        </form>
    </section>
    <footer>
        <p>Badulake - 2020</p>
    </footer>
</body>
</html>