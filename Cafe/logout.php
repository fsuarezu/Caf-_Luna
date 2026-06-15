<?php
session_start();

// 1. Si hay una cookie de "recordar sesión", la eliminamos de la base de datos y del navegador
if (isset($_COOKIE["recordar_correo"])) {
    $token = $_COOKIE["recordar_correo"];
    
    include("bd/conexion.php");
    $conexion = conectarDB();
    
    if ($conexion) {
        // Escapamos el token para prevenir inyección SQL
        $token_seguro = $conexion->real_escape_string($token);
        
        // Eliminamos el registro de la base de datos
        $conexion->query("DELETE FROM token WHERE token = '$token_seguro'");
    }
    
    // Eliminamos la cookie del navegador (expiración en el pasado)
    setcookie("recordar_correo", "", time() - 3600, "/");
}

// 2. Destruimos todas las variables de sesión en el servidor
$_SESSION = array();
session_destroy();

// 3. Redirigimos al usuario al login
header("Location: login.php");
exit();
?>
