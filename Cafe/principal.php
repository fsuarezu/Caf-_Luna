<?php
session_start();
include("bd/conexion.php");
$conexion = conectarDB();

// Si no hay sesión activa, verificamos si hay una cookie de "recordar sesión"
if (!isset($_SESSION["admin"]) && isset($_COOKIE["recordar_correo"])) {
    $token = $_COOKIE["recordar_correo"];
    $hoy = date("Y-m-d H:i:s");

    // Buscamos el token en la BD y verificamos que no haya vencido
    $resultado = $conexion->query("SELECT usuario.correo FROM token 
        JOIN usuario ON token.usuario_id = usuario.id 
        WHERE token.token = '$token' AND token.expiracion > '$hoy'");

    // Si el token es válido, iniciamos sesión automáticamente
    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION["admin"] = $usuario["correo"];
    }
}

// Si no hay sesión, redirigimos al login
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

// --- CONSULTAS PARA EL DASHBOARD ---

// 1. KPIs Financieros: Ventas Totales, Ticket Promedio, Total Pedidos (solo entregados/completados)
$kpi_query = $conexion->query("SELECT SUM(total) as total_ventas, COUNT(id) as total_pedidos, AVG(total) as ticket_promedio FROM pedido WHERE id_estado = 3");
$kpis = $kpi_query ? $kpi_query->fetch_assoc() : null;
$total_ventas = $kpis && $kpis["total_ventas"] ? (int)$kpis["total_ventas"] : 0;
$total_pedidos_completados = $kpis && $kpis["total_pedidos"] ? (int)$kpis["total_pedidos"] : 0;
$ticket_promedio = $kpis && $kpis["ticket_promedio"] ? (float)$kpis["ticket_promedio"] : 0;

// Cantidad total de pedidos (independiente de su estado)
$total_pedidos_query = $conexion->query("SELECT COUNT(id) as cant FROM pedido");
$total_pedidos_general = $total_pedidos_query ? (int)$total_pedidos_query->fetch_assoc()["cant"] : 0;

// 2. Estados de Pedidos actual
$estados_query = $conexion->query("SELECT id_estado, COUNT(id) as cant FROM pedido GROUP BY id_estado");
$estados_cant = [1 => 0, 2 => 0, 3 => 0];
if ($estados_query) {
    while ($row = $estados_query->fetch_assoc()) {
        $estados_cant[(int)$row["id_estado"]] = (int)$row["cant"];
    }
}

// 3. Métodos de Pago (todos los pedidos)
$metodos_query = $conexion->query("SELECT metodo.nombre, COUNT(pedido.id) as cant FROM pedido JOIN metodo ON pedido.id_metodo = metodo.id GROUP BY metodo.id");
$metodos_pago = ["credito" => 0, "debito" => 0];
$total_metodos = 0;
if ($metodos_query) {
    while ($row = $metodos_query->fetch_assoc()) {
        $nombre_m = strtolower($row["nombre"]);
        $cant = (int)$row["cant"];
        $metodos_pago[$nombre_m] = $cant;
        $total_metodos += $cant;
    }
}

// 5. Top 5 Productos más vendidos (analizando JSON de pedidos entregados)
$pedidos_productos_query = $conexion->query("SELECT productos FROM pedido WHERE id_estado = 3");
$ventas_productos = [];
if ($pedidos_productos_query) {
    while ($p = $pedidos_productos_query->fetch_assoc()) {
        $items = json_decode($p["productos"], true);
        if (is_array($items)) {
            foreach ($items as $item) {
                $nombre_p = $item["nombre"];
                $cant = (int)$item["cantidad"];
                if (isset($ventas_productos[$nombre_p])) {
                    $ventas_productos[$nombre_p] += $cant;
                } else {
                    $ventas_productos[$nombre_p] = $cant;
                }
            }
        }
    }
}
arsort($ventas_productos);
$top_productos = array_slice($ventas_productos, 0, 5, true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel Admin - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
    <style>
        .admin-contenedor {
            width: 98%;
            max-width: 1600px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .admin-bienvenida {
            color: #fdf5e6;
            font-size: 16px;
            margin: 0;
            text-align: center;
            font-weight: bold;
        }
        .columnas-admin {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            align-items: flex-start;
        }
        .columna-admin {
            flex: 1;
            min-width: 320px;
            background-color: burlywood;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            box-sizing: border-box;
        }
        .columna-admin h2 {
            font-size: 24px;
            color: #3d2a1d;
            border-bottom: 2px solid brown;
            padding-bottom: 10px;
            margin-top: 0;
            margin-bottom: 15px;
            text-align: center;
        }
        /* Estilos del Dashboard */
        .dashboard-kpis {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .kpi-tarjeta {
            flex: 1;
            min-width: 90px;
            background-color: #fdf5e6;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            box-sizing: border-box;
        }
        .kpi-titulo {
            font-size: 11px;
            color: brown;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .kpi-valor {
            font-size: 16px;
            color: #3d2a1d;
            font-weight: bold;
        }
        .dashboard-seccion {
            background-color: #fdf5e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        .dashboard-seccion h3 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 16px;
            color: brown;
            border-bottom: 1px dashed #deb887;
            padding-bottom: 5px;
            text-align: left;
            font-family: Impact, serif;
        }
        .barra-progreso-doble {
            height: 14px;
            border-radius: 7px;
            background-color: #e2e3e5;
            display: flex;
            overflow: hidden;
            margin-bottom: 8px;
        }
        .progreso-debito {
            background-color: #5c3a21;
        }
        .progreso-credito {
            background-color: brown;
        }
        .barra-leyenda {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #3d2a1d;
        }
        .leyenda-color {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 4px;
        }
        .leyenda-color.debito { background-color: #5c3a21; }
        .leyenda-color.credito { background-color: brown; }
        
        .top-productos-lista {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .top-producto-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: #3d2a1d;
        }
        .top-pos {
            font-weight: bold;
            color: brown;
            width: 25px;
            text-align: left;
        }
        .top-nombre {
            flex: 1;
            text-align: left;
            font-weight: bold;
        }
        .top-cant {
            font-weight: bold;
            color: #5c3a21;
        }
        .estados-graficos {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .estado-barra-info {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #3d2a1d;
            border-bottom: 1px solid #f2e2cf;
            padding-bottom: 4px;
        }
    </style>
</head>
<body>
    <header class="banner-flotante">
        <div class="banner-imagen">
            <img src="imagenes/logo.png" alt="Logo Café Luna">
        </div>
        <h2 style="color: #3d2a1d; margin: 0; font-family: Impact, serif; font-size: 32px;">Panel Admin</h2>
    </header>

    <div class="admin-contenedor">
        <p class="admin-bienvenida">Bienvenido, <?php echo htmlspecialchars($_SESSION["admin"]); ?></p>

        <div class="columnas-admin">
            
            <!-- Columna Productos -->
            <div class="columna-admin">
                <h2>Productos</h2>
                <div style="text-align: center; margin-bottom: 15px;">
                    <a href="AdminPhps/adminAgregar.php" class="btn-agregar" style="margin-bottom: 0;">+ Agregar producto</a>
                </div>
                
                <div class="contenedor-productos-admin">
                    <?php
                    // Traemos todos los productos con el nombre de su categoría usando JOIN
                    $resultado = $conexion->query("SELECT producto.*, categoria.nombre AS nombre_categoria 
                        FROM producto 
                        JOIN categoria ON producto.id_categoria = categoria.id 
                        ORDER BY categoria.nombre");

                    // Mostramos cada producto como una tarjeta
                    while ($fila = $resultado->fetch_assoc()) {
                    ?>
                    <div class="tarjeta-producto-admin">
                        <div class="tarjeta-info">
                            <p class="tarjeta-nombre"><?php echo $fila["nombre"]; ?></p>
                            <p class="tarjeta-categoria"><?php echo $fila["nombre_categoria"]; ?></p>
                        </div>
                        <p class="tarjeta-precio">$<?php echo number_format($fila["precio"], 0, ',', '.'); ?></p>
                        <div class="tarjeta-acciones">
                            <a href="AdminPhps/adminEditar.php?id=<?php echo $fila['id']; ?>" class="btn-editar">Editar</a>
                            <a href="AdminPhps/adminEliminar.php?id=<?php echo $fila['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Columna Cajeros -->
            <div class="columna-admin">
                <h2>Cajeros</h2>
                <div style="text-align: center; margin-bottom: 15px;">
                    <a href="AdminPhps/adminAgregarCajero.php" class="btn-agregar" style="margin-bottom: 0;">+ Agregar cajero</a>
                </div>

                <div class="contenedor-productos-admin">
                    <?php
                    // Traemos todos los cajeros
                    $resultado_cajeros = $conexion->query("SELECT * FROM usuario WHERE rol = 'caja' ORDER BY correo");

                    if ($resultado_cajeros && $resultado_cajeros->num_rows > 0) {
                        while ($fila_caja = $resultado_cajeros->fetch_assoc()) {
                        ?>
                        <div class="tarjeta-producto-admin">
                            <div class="tarjeta-info">
                                <p class="tarjeta-nombre"><?php echo htmlspecialchars($fila_caja["correo"]); ?></p>
                                <p class="tarjeta-categoria">Cajero</p>
                            </div>
                            <div class="tarjeta-acciones">
                                <a href="AdminPhps/adminEliminarCajero.php?id=<?php echo $fila_caja['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este cajero?')">Eliminar</a>
                            </div>
                        </div>
                        <?php 
                        }
                    } else {
                    ?>
                        <p style="color: #5c3a21; font-style: italic; font-size: 14px; text-align: center;">No hay cajeros registrados.</p>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <!-- Columna Dashboard -->
            <div class="columna-admin">
                <h2>Dashboard</h2>
                
                <!-- Tarjetas KPI -->
                <div class="dashboard-kpis">
                    <div class="kpi-tarjeta">
                        <div class="kpi-titulo">Ventas (Entr.)</div>
                        <div class="kpi-valor">$<?php echo number_format($total_ventas, 0, ',', '.'); ?></div>
                    </div>
                    <div class="kpi-tarjeta">
                        <div class="kpi-titulo">Compr. Prom.</div>
                        <div class="kpi-valor">$<?php echo number_format($ticket_promedio, 0, ',', '.'); ?></div>
                    </div>
                    <div class="kpi-tarjeta">
                        <div class="kpi-titulo">Pedidos Totales</div>
                        <div class="kpi-valor"><?php echo $total_pedidos_general; ?></div>
                    </div>
                </div>

                <!-- Sección: Métodos de Pago -->
                <div class="dashboard-seccion">
                    <h3>Distribución de Pagos</h3>
                    <?php
                    $pct_debito = $total_metodos > 0 ? round(($metodos_pago["debito"] / $total_metodos) * 100) : 50;
                    $pct_credito = $total_metodos > 0 ? round(($metodos_pago["credito"] / $total_metodos) * 100) : 50;
                    ?>
                    <div class="barra-progreso-doble">
                        <div class="progreso-debito" style="width: <?php echo $pct_debito; ?>%;" title="Débito: <?php echo $metodos_pago["debito"]; ?> pedidos"></div>
                        <div class="progreso-credito" style="width: <?php echo $pct_credito; ?>%;" title="Crédito: <?php echo $metodos_pago["credito"]; ?> pedidos"></div>
                    </div>
                    <div class="barra-leyenda">
                        <span><span class="leyenda-color debito"></span> Débito: <?php echo $pct_debito; ?>% (<?php echo $metodos_pago["debito"]; ?>)</span>
                        <span><span class="leyenda-color credito"></span> Crédito: <?php echo $pct_credito; ?>% (<?php echo $metodos_pago["credito"]; ?>)</span>
                    </div>
                </div>

                <!-- Sección: Top Productos -->
                <div class="dashboard-seccion">
                    <h3>Top 5 Productos Vendidos</h3>
                    <div class="top-productos-lista">
                        <?php 
                        if (!empty($top_productos)) {
                            $pos = 1;
                            foreach ($top_productos as $nombre => $cant) {
                            ?>
                            <div class="top-producto-item">
                                <div class="top-pos">#<?php echo $pos++; ?></div>
                                <div class="top-nombre"><?php echo htmlspecialchars($nombre); ?></div>
                                <div class="top-cant"><?php echo $cant; ?> u.</div>
                            </div>
                            <?php 
                            }
                        } else {
                        ?>
                            <p style="color: #5c3a21; font-style: italic; font-size: 13px; text-align: center; margin: 10px 0;">Sin datos de productos.</p>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <!-- Sección: Estado Actual de Pedidos -->
                <div class="dashboard-seccion">
                    <h3>Estado de Pedidos Actual</h3>
                    <div class="estados-graficos">
                        <div class="estado-barra-info">
                            <span>Pendientes</span>
                            <span><strong><?php echo $estados_cant[1]; ?></strong></span>
                        </div>
                        <div class="estado-barra-info">
                            <span>Listos</span>
                            <span><strong><?php echo $estados_cant[2]; ?></strong></span>
                        </div>
                        <div class="estado-barra-info">
                            <span>Entregados (Historial)</span>
                            <span><strong><?php echo $estados_cant[3]; ?></strong></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div style="text-align: center; margin-top: 20px; margin-bottom: 40px;">
            <a href="logout.php" class="btn-cerrar-sesion">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>