<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'operaciones' || $_SESSION['estado'] !== 'activo') {
    echo "Acceso denegado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['item_name'];
    $categoria = $_POST['item_category'];
    $stock = (int) $_POST['stock'];
    $valor = (float) $_POST['valor_item'];
    $vendido = ($stock <= 0) ? 'si' : 'no';
    $ganancias = $valor * 0.3;

    $stmt = $conexion->prepare("INSERT INTO inventario (item_name, item_category, stock, valor_item, vendido, ganancias) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidsd", $nombre, $categoria, $stock, $valor, $vendido, $ganancias);
    $stmt->execute();
    $stmt->close();

    header("Location: inventario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Item</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2 class="mb-4">Agregar Nuevo Item</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Nombre del Item:</label>
            <input type="text" name="item_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoria:</label>
            <input type="text" name="item_category" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Valor del Item:</label>
            <input type="number" step="0.01" name="valor_item" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
        <a href="inventario.php" class="btn btn-secondary">Volver</a>
    </form>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>