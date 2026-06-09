<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}
include(dirname(__FILE__) . "/../bd/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $precio = intval($_POST["precio"]);
    $categoria = htmlspecialchars(trim($_POST["categoria"]));

    $conexion->query("INSERT INTO productos (nombre, precio, categoria) VALUES ('$nombre', '$precio', '$categoria')");

    header("Location: ../admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar Producto - Cafe Luna</title>
    <link href="../estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <div class="menu">
        <main>
            <h1>Agregar Producto</h1>
            <hr>
            <form action="" method="POST" class="formulario">
                <label>Nombre del producto:</label><br>
                <input type="text" name="nombre" required><br>

                <label>Precio:</label><br>
                <input type="number" name="precio" required><br>

                <label>Categoría:</label><br>
                <select name="categoria" required>
                    <option value="Cafés y Especialidades">Cafés y Especialidades</option>
                    <option value="Sándwiches y Salados">Sándwiches y Salados</option>
                    <option value="Repostería y Dulces">Repostería y Dulces</option>
                    <option value="Bebidas Frías">Bebidas Frías</option>
                </select><br>

                <button type="submit">Agregar</button>
            </form>
            <br>
            <a href="../admin.php" class="btn-cerrar-sesion">Volver</a>
        </main>
    </div>
</body>
</html>