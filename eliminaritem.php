<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'operaciones' || $_SESSION['estado'] !== 'activo') {
    echo "Acceso denegado.";
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conexion->prepare("DELETE FROM inventario WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: inventario.php");
exit;
?>