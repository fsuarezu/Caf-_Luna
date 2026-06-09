<?php
session_start();

if (!isset($_SESSION["admin"]) && isset($_COOKIE["recordar_correo"])) {
    $_SESSION["admin"] = $_COOKIE["recordar_correo"];
}

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
include("bd/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel Admin - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <div class="menu">
        <main>
            <h1>Panel Admin</h1>
            <p>Bienvenido, <?php echo $_SESSION["admin"]; ?></p>
            <hr>

            <h2>Productos</h2>
            <a href="phps/adminAgregar.php" class="btn-agregar">+ Agregar producto</a>

            <div class="contenedor-productos-admin">
                <?php
                $resultado = $conexion->query("SELECT * FROM productos ORDER BY categoria");
                while ($fila = $resultado->fetch_assoc()) {
                ?>
                <div class="tarjeta-producto-admin">
                    <div class="tarjeta-info">
                        <p class="tarjeta-nombre"><?php echo $fila["nombre"]; ?></p>
                        <p class="tarjeta-categoria"><?php echo $fila["categoria"]; ?></p>
                    </div>
                    <p class="tarjeta-precio">$<?php echo number_format($fila["precio"], 0, ',', '.'); ?></p>
                    <div class="tarjeta-acciones">
                        <a href="phps/adminEditar.php?id=<?php echo $fila['id']; ?>" class="btn-editar">Editar</a>
                        <a href="phps/adminEliminar.php?id=<?php echo $fila['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                    </div>
                </div>
                <?php } ?>
            </div>

            <br>
            <a href="phps/adminCerrarSesion.php" class="btn-cerrar-sesion">Cerrar sesión</a>
        </main>
    </div>
</body>
</html>