<?php
session_start();

// Si no hay sesión activa de cajero, redirigimos al login
if (!isset($_SESSION["cajero"])) {
    header("Location: login.php");
    exit();
}

include("bd/conexion.php");
$conexion = conectarDB();

$mensaje_alerta = "";
$tipo_alerta = "";

// 1. Procesar escaneo de código de barras (ID del pedido)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["barcode"])) {
    $barcode = trim($_POST["barcode"]);
    if (!empty($barcode) && is_numeric($barcode)) {
        $pedido_id = (int)$barcode;
        
        // Buscar el pedido en la base de datos
        $check_pedido = $conexion->query("SELECT * FROM pedido WHERE id = '$pedido_id'");
        
        if ($check_pedido->num_rows == 1) {
            $pedido_scan = $check_pedido->fetch_assoc();
            $estado_actual = (int)$pedido_scan["id_estado"];
            
            if ($estado_actual == 1) { // de pendiente -> listo
                $conexion->query("UPDATE pedido SET id_estado = 2 WHERE id = '$pedido_id'");
                $mensaje_alerta = "Pedido #$pedido_id marcado automáticamente como LISTO.";
                $tipo_alerta = "exito";
            } else if ($estado_actual == 2) { // de listo -> entregado
                $conexion->query("UPDATE pedido SET id_estado = 3 WHERE id = '$pedido_id'");
                $mensaje_alerta = "Pedido #$pedido_id marcado automáticamente como ENTREGADO.";
                $tipo_alerta = "exito";
            } else {
                $mensaje_alerta = "El pedido #$pedido_id ya se encuentra entregado y archivado.";
                $tipo_alerta = "info";
            }
        } else {
            $mensaje_alerta = "El código o N° de pedido #$barcode no existe.";
            $tipo_alerta = "error";
        }
    } else {
        $mensaje_alerta = "Por favor ingrese un código numérico válido.";
        $tipo_alerta = "error";
    }
}

// 2. Procesar cambio de estado manual
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cambiar_estado"]) && isset($_POST["pedido_id"])) {
    $pedido_id = (int)$_POST["pedido_id"];
    $nuevo_estado = (int)$_POST["nuevo_estado"];
    
    $conexion->query("UPDATE pedido SET id_estado = '$nuevo_estado' WHERE id = '$pedido_id'");
    $mensaje_alerta = "Estado del pedido #$pedido_id actualizado con éxito.";
    $tipo_alerta = "exito";
}

// 3. Obtener todos los pedidos
$resultado = $conexion->query("SELECT pedido.*, metodo.nombre AS nombre_metodo, estado_pedido.nombre AS nombre_estado 
    FROM pedido 
    JOIN metodo ON pedido.id_metodo = metodo.id 
    JOIN estado_pedido ON pedido.id_estado = estado_pedido.id
    ORDER BY pedido.id DESC");

$pendientes = [];
$listos = [];
$entregados = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila["id_estado"] == 1) {
            $pendientes[] = $fila;
        } else if ($fila["id_estado"] == 2) {
            $listos[] = $fila;
        } else if ($fila["id_estado"] == 3) {
            $entregados[] = $fila;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de Caja - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
    <style>
        /* Estilos específicos para la vista de cajero */
        .cajero-layout {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 95%;
            max-width: 1200px;
            margin: 20px auto;
        }
        .barra-alerta {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
        .alerta-exito {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alerta-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alerta-info {
            background-color: #e2e3e5;
            color: #383d41;
            border: 1px solid #d6d8db;
        }
        .columnas-pedidos {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .columna-pedidos {
            flex: 1;
            min-width: 300px;
            background-color: burlywood;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            box-sizing: border-box;
        }
        .columna-pedidos h2 {
            font-size: 24px;
            color: #3d2a1d;
            border-bottom: 2px solid brown;
            padding-bottom: 10px;
            margin-top: 0;
        }
        .tarjeta-pedido {
            background-color: #fdf5e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        .tarjeta-pedido h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: brown;
            border-bottom: 1px dashed #deb887;
            padding-bottom: 5px;
            text-align: left;
        }
        .tarjeta-pedido p {
            margin: 5px 0;
            text-align: left;
            font-size: 14px;
        }
        .pedido-productos {
            margin: 10px 0;
            padding: 0 0 0 20px;
            font-size: 14px;
            text-align: left;
        }
        .pedido-productos li {
            margin-bottom: 5px;
        }
        .form-accion {
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
        }
        .btn-estado {
            background-color: brown;
            color: #fdf5e6;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            width: 100%;
        }
        .btn-estado:hover {
            background-color: #5a1a1a;
        }
        .estado-nombre {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .est-pendiente { background-color: #ffeeba; color: #856404; }
        .est-listo { background-color: #b8daff; color: #004085; }
        .est-entregado { background-color: #c3e6cb; color: #155724; }
    </style>
</head>
<body>
    <header class="banner-flotante">
        <div class="banner-imagen">
            <img src="imagenes/logo.png" alt="Logo Café Luna">
        </div>
        <h2 style="color: #3d2a1d; margin: 0; font-family: Impact, serif; font-size: 32px;">Panel de Caja</h2>
    </header>

    <div class="cajero-layout">
        
        <!-- Notificaciones de Alerta -->
        <?php if (!empty($mensaje_alerta)): ?>
            <div class="barra-alerta <?php 
                echo $tipo_alerta === 'exito' ? 'alerta-exito' : ($tipo_alerta === 'error' ? 'alerta-error' : 'alerta-info'); 
            ?>">
                <?php echo $mensaje_alerta; ?>
            </div>
        <?php endif; ?>

        <!-- Sección del Lector de Código de Barras -->
        <div style="background-color: burlywood; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
            <h2 style="margin-top: 0; color: #3d2a1d; font-size: 26px;">Escanear Código de Barras (Pedido)</h2>
            <p style="text-align: left; margin-bottom: 15px; font-size: 15px;">Coloque el cursor en el campo de texto de abajo para simular o usar el lector de códigos de barras (ID del pedido):</p>
            <form method="POST" action="" style="display: flex; gap: 10px; justify-content: center; max-width: 600px; margin: 0 auto;">
                <input type="text" name="barcode" placeholder="Escanee o digite el N° de pedido..." autofocus required style="padding: 12px; flex: 1; font-size: 16px; border-radius: 6px; border: 1px solid black;">
                <button type="submit" class="btn-agregar" style="margin: 0; padding: 12px 24px; border-radius: 6px; cursor: pointer;">Procesar</button>
            </form>
        </div>

        <!-- Columnas de Pedidos -->
        <div class="columnas-pedidos">
            
            <!-- Columna Pendientes -->
            <div class="columna-pedidos">
                <h2>Pendientes (<?php echo count($pendientes); ?>)</h2>
                <?php if (count($pendientes) == 0): ?>
                    <p style="color: #5c3a21; font-style: italic; font-size: 14px;">No hay pedidos pendientes.</p>
                <?php else: ?>
                    <?php foreach ($pendientes as $p): 
                        $items = json_decode($p["productos"], true); 
                    ?>
                        <div class="tarjeta-pedido">
                            <h3>Pedido #<?php echo $p["id"]; ?></h3>
                            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($p["nombre"]); ?></p>
                            <p><strong>Pago:</strong> <?php echo ucfirst($p["nombre_metodo"]); ?></p>
                            <p><strong>Fecha:</strong> <?php echo date("d/m H:i", strtotime($p["fecha"])); ?></p>
                            
                            <ul class="pedido-productos">
                                <?php foreach ($items as $item): ?>
                                    <li><?php echo $item["cantidad"]; ?>x <?php echo htmlspecialchars($item["nombre"]); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <p><strong>Total:</strong> $<?php echo number_format($p["total"], 0, ',', '.'); ?></p>
                            
                            <form method="POST" action="" class="form-accion">
                                <input type="hidden" name="pedido_id" value="<?php echo $p["id"]; ?>">
                                <input type="hidden" name="nuevo_estado" value="2">
                                <button type="submit" name="cambiar_estado" class="btn-estado">Marcar como Listo</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Columna Listos -->
            <div class="columna-pedidos">
                <h2>Listos para Retiro (<?php echo count($listos); ?>)</h2>
                <?php if (count($listos) == 0): ?>
                    <p style="color: #5c3a21; font-style: italic; font-size: 14px;">No hay pedidos listos.</p>
                <?php else: ?>
                    <?php foreach ($listos as $p): 
                        $items = json_decode($p["productos"], true); 
                    ?>
                        <div class="tarjeta-pedido">
                            <h3>Pedido #<?php echo $p["id"]; ?></h3>
                            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($p["nombre"]); ?></p>
                            <p><strong>Pago:</strong> <?php echo ucfirst($p["nombre_metodo"]); ?></p>
                            <p><strong>Fecha:</strong> <?php echo date("d/m H:i", strtotime($p["fecha"])); ?></p>
                            
                            <ul class="pedido-productos">
                                <?php foreach ($items as $item): ?>
                                    <li><?php echo $item["cantidad"]; ?>x <?php echo htmlspecialchars($item["nombre"]); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <p><strong>Total:</strong> $<?php echo number_format($p["total"], 0, ',', '.'); ?></p>
                            
                            <form method="POST" action="" class="form-accion">
                                <input type="hidden" name="pedido_id" value="<?php echo $p["id"]; ?>">
                                <input type="hidden" name="nuevo_estado" value="3">
                                <button type="submit" name="cambiar_estado" class="btn-estado">Marcar como Entregado</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Columna Entregados -->
            <div class="columna-pedidos">
                <h2>Entregados (<?php echo count($entregados); ?>)</h2>
                <?php if (count($entregados) == 0): ?>
                    <p style="color: #5c3a21; font-style: italic; font-size: 14px;">No hay pedidos entregados.</p>
                <?php else: ?>
                    <?php foreach ($entregados as $p): 
                        $items = json_decode($p["productos"], true); 
                    ?>
                        <div class="tarjeta-pedido" style="opacity: 0.75;">
                            <h3>Pedido #<?php echo $p["id"]; ?></h3>
                            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($p["nombre"]); ?></p>
                            <p><strong>Pago:</strong> <?php echo ucfirst($p["nombre_metodo"]); ?></p>
                            <p><strong>Fecha:</strong> <?php echo date("d/m H:i", strtotime($p["fecha"])); ?></p>
                            
                            <ul class="pedido-productos">
                                <?php foreach ($items as $item): ?>
                                    <li><?php echo $item["cantidad"]; ?>x <?php echo htmlspecialchars($item["nombre"]); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <p><strong>Total:</strong> $<?php echo number_format($p["total"], 0, ',', '.'); ?></p>
                            <span class="estado-nombre est-entregado">Entregado</span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="logout.php" class="btn-cerrar-sesion">Cerrar sesión de caja</a>
        </div>
    </div>
</body>
</html>
