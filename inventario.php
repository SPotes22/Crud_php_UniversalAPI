<?php
session_start();
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión y tiene el rol y estado adecuados
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'operaciones' || $_SESSION['estado'] !== 'activo') {
    echo "Acceso denegado. Solo usuarios activos con rol de operaciones pueden acceder.";
    exit;
}

// Obtener datos del inventario
$resultado = $conexion->query("SELECT * FROM inventario");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2 class="mb-4">Gestión de Inventario</h2>

    <a href="agregaritem.php" class="btn btn-success mb-3">Agregar Ítem</a>
    <a href="logout.php" class="btn btn-secondary mb-3">Cerrar Sesión</a>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Valor</th>
                <th>Vendido</th>
                <th>Ganancias</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= htmlspecialchars($fila['item_name']) ?></td>
                <td><?= htmlspecialchars($fila['item_category']) ?></td>
                <td><?= $fila['stock'] ?></td>
                <td>$<?= number_format($fila['valor_item'], 2) ?></td>
                <td><?= $fila['vendido'] ?></td>
                <td>$<?= number_format($fila['ganancias'], 2) ?></td>
                <td>
                    <a href="editaritem.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="eliminaritem.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar este ítem?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>