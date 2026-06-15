<?php
include("bd/conexion.php");
$conexion = conectarDB();

// Obtenemos el id del pedido desde la URL
$id = $_GET["id"];

// Buscamos el pedido en la base de datos con el nombre del método de pago
$pedido = $conexion->query("SELECT pedido.*, metodo.nombre AS nombre_metodo 
    FROM pedido 
    JOIN metodo ON pedido.id_metodo = metodo.id 
    WHERE pedido.id = '$id'")->fetch_assoc();

// Si no existe el pedido, mostramos un error
if (!$pedido) {
    die("Pedido no encontrado.");
}

// Convertimos el texto JSON de productos a un arreglo
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

            <!-- Mostramos los datos del pedido -->
            <p><strong>N° de pedido:</strong> #<?php echo $pedido["id"]; ?></p>
            <p><strong>Nombre:</strong> <?php echo $pedido["nombre"]; ?></p>
            <p><strong>Correo:</strong> <?php echo $pedido["correo"]; ?></p>
            <p><strong>Método de pago:</strong> <?php echo ucfirst($pedido["nombre_metodo"]); ?></p>
            <p><strong>Fecha:</strong> <?php echo $pedido["fecha"]; ?></p>

            <hr>
            <h2>Detalle del Pedido</h2>

            <!-- Mostramos cada producto del pedido -->
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
        // Limpiamos el carrito del navegador después de confirmar el pedido
        localStorage.removeItem("carritoCafeLuna");
        localStorage.removeItem("totalCafeLuna");
    </script>
</body>
</html>