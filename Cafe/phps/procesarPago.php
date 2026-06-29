<?php
include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

// Verificamos que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpiamos los datos recibidos del formulario
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $correo = htmlspecialchars(trim($_POST["correo"]));
    $metodo = htmlspecialchars(trim($_POST["metodo"]));
    $productos_json = trim($_POST["productos"]);
    $total = $_POST["total"];

    // 1. Validar el stock antes de realizar cualquier cambio
    $carrito_productos = json_decode($productos_json, true);
    if (!is_array($carrito_productos) || empty($carrito_productos)) {
        header("Location: ../pago.php?error=acceso");
        exit();
    }

    // Verificar disponibilidad de stock para cada artículo
    foreach ($carrito_productos as $item) {
        $nombre_p = $conexion->real_escape_string($item["nombre"]);
        $cant_pedida = (int)$item["cantidad"];

        // Buscar producto en BD para obtener stock actual
        $res = $conexion->query("SELECT stock FROM producto WHERE nombre = '$nombre_p'");
        if ($res && $res->num_rows > 0) {
            $fila_prod = $res->fetch_assoc();
            $stock_actual = (int)$fila_prod["stock"];
            if ($stock_actual < $cant_pedida) {
                // Redirigir con error de stock insuficiente
                $msg_err = "Lo sentimos, no hay suficiente stock disponible de '{$item['nombre']}' (Disponible: {$stock_actual}).";
                header("Location: ../pago.php?error=stock&msg=" . urlencode($msg_err));
                exit();
            }
        } else {
            // Producto no encontrado en la base de datos
            $msg_err = "Lo sentimos, el producto '{$item['nombre']}' no existe en el catálogo.";
            header("Location: ../pago.php?error=stock&msg=" . urlencode($msg_err));
            exit();
        }
    }

    // 2. Restar stock de la base de datos para cada producto comprado
    foreach ($carrito_productos as $item) {
        $nombre_p = $conexion->real_escape_string($item["nombre"]);
        $cant_pedida = (int)$item["cantidad"];
        $conexion->query("UPDATE producto SET stock = stock - $cant_pedida WHERE nombre = '$nombre_p'");
    }

    // 3. Buscamos el id del método de pago en la base de datos
    $metodo_esc = $conexion->real_escape_string($metodo);
    $resultado = $conexion->query("SELECT id FROM metodo WHERE nombre = '$metodo_esc'");
    $fila = $resultado->fetch_assoc();
    $id_metodo = $fila["id"];

    // 4. Guardamos el pedido en la base de datos
    $nombre_esc = $conexion->real_escape_string($nombre);
    $correo_esc = $conexion->real_escape_string($correo);
    $productos_esc = $conexion->real_escape_string($productos_json);
    $total_esc = $conexion->real_escape_string($total);

    $conexion->query("INSERT INTO pedido (nombre, correo, id_metodo, productos, total) 
        VALUES ('$nombre_esc', '$correo_esc', '$id_metodo', '$productos_esc', '$total_esc')");

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