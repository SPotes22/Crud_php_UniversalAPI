<?php



include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = password_hash($_POST['contrasena'],PASSWORD_DEFAULT) ?? '';
    $bodega = $_POST['bodega'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // Validar campos requeridos
    if (empty($nombre) || empty($correo) || empty($contrasena) || empty($rol) || empty($estado)) {
        echo "Faltan campos del formulario";
    } else {
        // Preparar e insertar
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, bodega, contrasena, rol, estado) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssss", $nombre, $correo, $bodega, $contrasena, $rol, $estado);
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error al ejecutar: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error en la consulta: " . $conexion->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="container py-5">

    <h2 class="mb-4">Agregar Nuevo Usuario</h2>

    <form method="POST" action="agregar.php">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" class="form-control" name="correo" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contrasena:</label>
            <input type="password" class="form-control" name="contrasena" required>
        </div>
	<div class="mb-3">
            <label class="form-label">bodega (solo para usuarios de it):</label>
            <input type="text" class="form-control" name="bodega" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rol:</label>
            <select class="form-select" name="rol" required>
                <option value="administrador">Administrador</option>
                <option value="operaciones">Operaciones</option>
                <option value="it">IT</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <select class="form-select" name="estado" required>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>