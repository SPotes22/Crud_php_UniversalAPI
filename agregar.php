<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = [
        'nombre'     => $_POST['nombre'] ?? '',
        'correo'     => $_POST['correo'] ?? '',
        'contrasena' => $_POST['contrasena'] ?? '',
        'bodega'     => $_POST['bodega'] ?? '',
        'rol'        => $_POST['rol'] ?? '',
        'estado'     => $_POST['estado'] ?? ''
    ];

    $respuesta = llamarAPI("/usuarios", "POST", $datos);

    if (isset($respuesta['success'])) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . json_encode($respuesta);
    }
}
?>
<!-- HTML igual al anterior (formulario) -->
