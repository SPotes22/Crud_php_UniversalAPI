<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'operaciones' || $_SESSION['estado'] !== 'activo') {
    echo "Acceso denegado.";
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID inválido.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['item_name'];
    $categoria = $_POST['item_category'];
    $stock = (int) $_POST['stock'];
    $valor = (float) $_POST['valor_item'];
    $vendido = ($stock <= 0) ? 'si' : 'no';
    $ganancias = $valor * 0.3;

    $stmt = $conexion->prepare("UPDATE inventario SET item_name = ?, item_category = ?, stock = ?, valor_item = ?, vendido = ?, ganancias = ? WHERE id = ?");
    $stmt->bind_param("ssidsdi", $nombre, $categoria, $stock, $valor, $vendido, $ganancias, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: inventario.php");
    exit;
}

$stmt = $conexion->prepare("SELECT * FROM inventario WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$item = $resultado->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Item</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2 class="mb-4">Editar Ítem</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Nombre del Item:</label>
            <input type="text" name="item_name" class="form-control" value="<?= htmlspecialchars($item['item_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Categoria:</label>
            <input type="text" name="item_category" class="form-control" value="<?= htmlspecialchars($item['item_category']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" value="<?= $item['stock'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Valor del Item:</label>
            <input type="number" step="0.01" name="valor_item" class="form-control" value="<?= $item['valor_item'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="inventario.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

