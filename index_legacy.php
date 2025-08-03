<?php
session_start();
// Verificar si el usuario ha iniciado sesión y tiene el rol y estado adecuados
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador' || $_SESSION['estado'] !== 'activo') {
    echo "Acceso denegado. Solo usuarios activos con rol de operaciones pueden acceder.";
    exit;
}


include 'conexion.php';
$resultado = $conexion->query("SELECT id, nombre, correo, rol, estado, contrasena, bodega FROM usuarios");
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
    <h1 class="mb-4">Gestion de Usuarios</h1>
    <a href="agregar.php" class="btn btn-primary mb-3">Agregar Usuario</a>
    <a href="logout.php" class="btn btn-secondary mb-3">Cerrar Sesion</a>

    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
		<th>bodega</th>
		<th>contrasena</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <?php
                    $rol = strtolower(trim($fila['rol']));
                    $estado = strtolower(trim($fila['estado']));
                ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['correo']) ?></td>
		    <td><?= htmlspecialchars($fila['bodega']) ?></td>
		    <td><?= htmlspecialchars($fila['contrasena']) ?></td>

                    <!-- Rol editable -->
                    <td>
                        <select class="form-select" onchange="cambiarCampo(<?= $fila['id'] ?>, 'rol', this.value)">
                            <option value="administrador" <?= $rol === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                            <option value="operaciones" <?= $rol === 'operaciones' ? 'selected' : '' ?>>Operaciones</option>
                            <option value="it" <?= $rol === 'it' ? 'selected' : '' ?>>IT</option>
                        </select>
                    </td>

                    <!-- Estado editable -->
                    <td>
                        <select class="form-select" onchange="cambiarCampo(<?= $fila['id'] ?>, 'estado', this.value)">
                            <option value="activo" <?= $estado === 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= $estado === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </td>

                    <td>
                        <a href="editar.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminar.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar este usuario?')">Eliminar</a>
                    </td>
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