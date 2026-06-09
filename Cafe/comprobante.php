<?php
include("bd/conexion.php");

$id = intval($_GET["id"]);
$pedido = $conexion->query("SELECT * FROM pedidos WHERE id = '$id'")->fetch_assoc();

if (!$pedido) {
    die("Pedido no encontrado.");
}

$productos = json_decode($pedido["productos"], true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Comprobante - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <?php include("phps/banner.php"); ?>

    <div class="menu">
        <main>
            <h1>¡Pedido Confirmado!</h1>
            <hr>

            <p><strong>N° de pedido:</strong> #<?php echo $pedido["id"]; ?></p>
            <p><strong>Nombre:</strong> <?php echo $pedido["nombre"]; ?></p>
            <p><strong>Correo:</strong> <?php echo $pedido["correo"]; ?></p>
            <p><strong>Método de pago:</strong> <?php echo ucfirst($pedido["metodo"]); ?></p>
            <p><strong>Fecha:</strong> <?php echo $pedido["fecha"]; ?></p>

            <hr>
            <h2>Detalle del Pedido</h2>

            <?php foreach ($productos as $item): ?>
            <div class="item">
                <p class="flavor"><?php echo $item["nombre"]; ?></p>
                <p class="price">x<?php echo $item["cantidad"]; ?></p>
                <p class="price">$<?php echo number_format($item["precio"] * $item["cantidad"], 0, ',', '.'); ?></p>
            </div>
            <?php endforeach; ?>

            <hr>
            <p><strong>Total: $<?php echo number_format($pedido["total"], 0, ',', '.'); ?></strong></p>

            <br>
            <a href="index.php" class="btn-agregar">Volver al inicio</a>
        </main>
        <footer></footer>
    </div>

    <script>
        // Limpiar el carrito después de confirmar el pedido
        localStorage.removeItem("carritoCafeLuna");
        localStorage.removeItem("totalCafeLuna");
    </script>
</body>
</html>