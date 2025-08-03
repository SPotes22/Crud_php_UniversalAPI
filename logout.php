<?php
session_start();          // Inicia la sesión para poder acceder a $_SESSION

$_SESSION = [];           // Limpia todas las variables de sesión

session_destroy();        // Destruye la sesión en el servidor (elimina el archivo de sesión)

header("Location: login.php");  // Redirige al formulario de inicio de sesión
exit;                     // Finaliza el script por seguridad
?>

