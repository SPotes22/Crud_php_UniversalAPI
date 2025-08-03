<?php
session_start();          // Inicia la sesi�n para poder acceder a $_SESSION

$_SESSION = [];           // Limpia todas las variables de sesi�n

session_destroy();        // Destruye la sesi�n en el servidor (elimina el archivo de sesi�n)

header("Location: login.php");  // Redirige al formulario de inicio de sesi�n
exit;                     // Finaliza el script por seguridad
?>

