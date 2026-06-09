<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}
include(dirname(__FILE__) . "/../bd/conexion.php");

$id = intval($_GET["id"]);

$conexion->query("DELETE FROM productos WHERE id = '$id'");

header("Location: ../admin.php");
exit();
?>