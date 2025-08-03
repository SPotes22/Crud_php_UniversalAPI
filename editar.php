	
<?php

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $bodega = $_POST["bodega"];

    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, correo = ?, bodega = ? WHERE id = ?");
    if (!$stmt) {
        die("Error en prepare: " . $conexion->error);
    }

    $stmt->bind_param("sssi", $nombre, $correo, $bodega, $id);
    if (!$stmt->execute()) {
        die("Error al ejecutar: " . $stmt->error);
    }

    header("Location: index.php");
    exit();
} else {
    if (!isset($_GET["id"])) {
        die("ID no especificado");
    }

    $id = $_GET["id"];
    $stmt = $conexion->prepare("SELECT nombre, correo, bodega FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if (!$usuario) {
        die("Usuario no encontrado");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Editar Usuario</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="editar.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" name="correo" id="correo" class="form-control" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
                </div>

		<div class="mb-3">
                    <label for="bodega" class="form-label">bodega</label>
                    <input type="text" name="bodega" id="bodega" class="form-control" value="<?php echo htmlspecialchars($usuario['bodega']); ?>" required>
                </div>

                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>