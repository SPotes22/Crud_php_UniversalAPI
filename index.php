<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador' || $_SESSION['estado'] !== 'activo') {
    echo "Acceso denegado. Solo usuarios activos con rol administrador pueden acceder.";
    exit;
}

$usuarios = llamarAPI("/usuarios", "GET");
?>
<!-- HTML donde recorres $usuarios['data'] con foreach -->
