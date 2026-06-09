<?php
session_start();

// Limpiar el arreglo de sesión y destruirla del servidor
$_SESSION = array();
session_destroy();

// Redirección inmediata al login
header("Location: index.php");
exit;

// Borramos la cookie de "recordar sesión" poniendo su fecha de expiración en el pasado
// El navegador elimina automáticamente las cookies que ya vencieron
setcookie("recordar_correo", "", time() - 3600, "/");
?>