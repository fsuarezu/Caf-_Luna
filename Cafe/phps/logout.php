<?php
session_start();

// Borramos la cookie de "recordar sesión" poniendo su fecha de expiración en el pasado
// El navegador elimina automáticamente las cookies que ya vencieron
setcookie("recordar_correo", "", time() - 3600, "/");

// Destruimos todas las variables de sesión
$_SESSION = array();
session_destroy();

// Redirigimos al login
header("Location: index.php");
exit();
?>