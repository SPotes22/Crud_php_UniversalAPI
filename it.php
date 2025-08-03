<?php
session_start();
// Verificar si el usuario ha iniciado sesión y tiene el rol y estado adecuados
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'it' || $_SESSION['estado'] !== 'activo') {
    echo "Acceso denegado. Solo usuarios activos con rol de operaciones pueden acceder.";
    exit;
}


include 'conexion.php';
$resultado = $conexion->query("SELECT id, nombre, correo, estado, bodega FROM usuarios WHERE rol = 'it' ");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestion de Usuarios</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        select.form-select {
            min-width: 120px;
        }
    </style>
</head>
<body class="container py-5">
    <h1 class="mb-4">Usuario it</h1>
    <a href="logout.php" class="btn btn-secondary mb-3">Cerrar Sesion</a>

    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
		<th>bodega</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['correo']) ?></td>
		    <td><?= htmlspecialchars($fila['bodega']) ?></td>
		    <td><?= htmlspecialchars($fila['estado']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
    function cambiarCampo(id, campo, valor) {
        fetch('actualizarcampo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&campo=${campo}&valor=${valor}`
        })
        .then(response => response.text())
        .then(data => {
            if (data !== 'ok') {
                alert('Error: ' + data);
            }
        });
    }
    </script>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>