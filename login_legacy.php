<?php
session_start();
include 'conexion.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $stmt = $conexion->prepare("SELECT id, nombre, contrasena, rol, estado FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
        if (!password_verify($contrasena, $usuario['contrasena'])) {
            $mensaje = "Contraseña incorrecta.";
        } elseif ($usuario['estado'] != 'activo') {
            $mensaje = "Tu cuenta está inactiva.";
        } else {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['estado'] = $usuario['estado'];

            // Redirección según el rol
            switch ($usuario['rol']) {
                case 'administrador':
                    header("Location: index.php");
                    break;
                case 'operaciones':
                    header("Location: inventario.php");
                    break;
                case 'it':
                    header("Location: it.php"); // Crear después
                    break;
                default:
                    $mensaje = "Rol no autorizado.";
                    session_destroy();
            }
            exit;
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2 class="mb-4">Inicio de Sesión</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-danger"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" class="form-control" name="correo" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña:</label>
            <input type="password" class="form-control" name="contrasena" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>