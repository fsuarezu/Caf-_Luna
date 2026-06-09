<?php
include(dirname(__FILE__) . "/../bd/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $correo = htmlspecialchars(trim($_POST["correo"]));
    $metodo = htmlspecialchars(trim($_POST["metodo"]));
    $productos = trim($_POST["productos"]);
    $total = intval($_POST["total"]);

    $conexion->query("INSERT INTO pedidos (nombre, correo, metodo, productos, total) VALUES ('$nombre', '$correo', '$metodo', '$productos', '$total')");

    $id_pedido = $conexion->insert_id;

    header("Location: ../comprobante.php?id=$id_pedido");
    exit();
} else {
    die("Acceso no permitido.");
}
if (strlen($nombre) < 3) {
    header("Location: ../pago.php?error=nombre");
    exit();
}
?>