<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
include("phps/conexion.php");
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
            <a href="phps/adminAgregar.php">+ Agregar producto</a>
            <br><br>

            <table class="tabla-admin">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
                <?php
                $resultado = mysqli_query($conexion, "SELECT * FROM productos ORDER BY categoria");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                ?>
                <tr>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["precio"]; ?></td>
                    <td><?php echo $fila["categoria"]; ?></td>
                    <td>
                        <a href="phps/adminEditar.php?id=<?php echo $fila['id']; ?>">Editar</a> |
                        <a href="phps/adminEliminar.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </table>

            <br>
            <a href="phps/adminCerrarSesion.php">Cerrar sesión</a>
        </main>
    </div>
</body>
</html>