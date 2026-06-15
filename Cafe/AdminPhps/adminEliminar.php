<?php
session_start();

// Si no hay sesión activa, redirigimos al login
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}

include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

// Obtenemos el id del producto desde la URL
$id = $_GET["id"];

// Eliminamos el producto de la base de datos
$conexion->query("DELETE FROM producto WHERE id = '$id'");

// Redirigimos al panel de entrada principal
header("Location: ../principal.php");
exit();
?>