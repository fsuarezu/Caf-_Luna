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
            <a href="AdminPhps/adminAgregar.php" class="btn-agregar">+ Agregar producto</a>

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

            <br>
            <a href="logout.php" class="btn-cerrar-sesion">Cerrar sesión</a>
        </main>
    </div>
</body>
</html>