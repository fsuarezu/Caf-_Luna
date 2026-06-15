<?php
include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

// Verificamos que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpiamos los datos recibidos del formulario
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $correo = htmlspecialchars(trim($_POST["correo"]));
    $metodo = htmlspecialchars(trim($_POST["metodo"]));
    $productos = trim($_POST["productos"]);
    $total = $_POST["total"];

    // Buscamos el id del método de pago en la base de datos
    $resultado = $conexion->query("SELECT id FROM metodo WHERE nombre = '$metodo'");
    $fila = $resultado->fetch_assoc();
    $id_metodo = $fila["id"];

    // Guardamos el pedido en la base de datos
    $conexion->query("INSERT INTO pedido (nombre, correo, id_metodo, productos, total) 
        VALUES ('$nombre', '$correo', '$id_metodo', '$productos', '$total')");

    // Obtenemos el id del pedido recién creado
    $id_pedido = $conexion->insert_id;

    // Redirigimos al comprobante con el id del pedido
    header("Location: ../comprobante.php?id=$id_pedido");
    exit();

} else {
    // Si alguien intenta acceder directamente, redirigimos con mensaje de error
    header("Location: ../pago.php?error=acceso");
    exit();
}
?>