<?php
session_start();

// Verificamos si hay una cookie de "recordar sesión"
if (isset($_COOKIE["recordar_correo"])) {
    $token = $_COOKIE["recordar_correo"];
    
    include(dirname(__FILE__) . "/../bd/conexion.php");
    $conexion = conectarDB();
    
    // Eliminamos el token de la base de datos
    $conexion->query("DELETE FROM token WHERE token = '$token'");
    
    // Borramos la cookie poniendo su fecha de expiración en el pasado
    // El navegador elimina automáticamente las cookies que ya vencieron
    setcookie("recordar_correo", "", time() - 3600, "/");
}

// Destruimos todas las variables de sesión
session_destroy();

// Redirigimos al login
header("Location: ../login.php");
exit();
?>