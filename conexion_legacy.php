<?php
$host = "192.168.1.101"; // Cambia esto por la IP real de la VM con MySQL$usuario = "root";       // O el usuario que creaste (ej. appuser)
$usuario = "root";
$password = "";          // Contrase�a si tiene
$bd = "pruebita";            // Base de datos que creaste

$conexion = new mysqli($host, $usuario, $password, $bd);
if ($conexion->connect_error) {
    die("Conexi�n fallida: " . $conexion->connect_error);
}
?>
