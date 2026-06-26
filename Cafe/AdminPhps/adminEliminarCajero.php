<?php
session_start();

// Si no hay sesión activa, redirigimos al login
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}

include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

// Obtenemos el id del cajero desde la URL
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = (int)$_GET["id"];

    // Primero eliminamos los tokens asociados a este usuario para evitar errores de llave foránea
    $conexion->query("DELETE FROM token WHERE usuario_id = '$id'");

    // Ahora eliminamos el usuario (asegurándonos que sea un cajero)
    $conexion->query("DELETE FROM usuario WHERE id = '$id' AND rol = 'caja'");
}

// Redirigimos al panel de entrada principal
header("Location: ../principal.php");
exit();
?>
