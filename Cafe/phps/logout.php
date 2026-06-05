<?php
session_start();

// Limpiar el arreglo de sesión y destruirla del servidor
$_SESSION = array();
session_destroy();

// Redirección inmediata al login
header("Location: index.php");
exit;
?>