<?php
session_start();
include 'conexion.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $credenciales = [
        'correo'     => $_POST['correo'] ?? '',
        'contrasena' => $_POST['contrasena'] ?? ''
    ];

    $respuesta = llamarAPI("/login", "POST", $credenciales);

    if (isset($respuesta['token'])) {
        $_SESSION['token'] = $respuesta['token'];
        $_SESSION['rol']   = $respuesta['rol'];
        $_SESSION['estado'] = $respuesta['estado'];
        $_SESSION['nombre'] = $respuesta['nombre'];

        // Redirección según rol
        switch ($_SESSION['rol']) {
            case 'administrador':
                header("Location: index.php");
                break;
            case 'operaciones':
                header("Location: inventario.php");
                break;
            case 'it':
                header("Location: it.php");
                break;
        }
        exit;
    } else {
        $mensaje = $respuesta['mensaje'] ?? 'Credenciales inválidas.';
    }
}
?>
<!-- HTML igual al anterior -->
