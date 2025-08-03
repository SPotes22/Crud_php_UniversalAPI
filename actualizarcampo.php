<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'administrador') {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

$id = $_POST['id'];
$campo = $_POST['campo'];
$valor = $_POST['valor'];

$permitidos = ['rol', 'estado'];

if (in_array($campo, $permitidos)) {
    $stmt = $conexion->prepare("UPDATE usuarios SET $campo = ? WHERE id = ?");
    $stmt->bind_param("si", $valor, $id);
    if ($stmt->execute()) {
        echo "ok";
    } else {
        echo "Error al actualizar.";
    }
} else {
    echo "Campo no permitido.";
}