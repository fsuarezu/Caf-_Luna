<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}
include(dirname(__FILE__) . "/../bd/conexion.php");

$id = intval($_GET["id"]);
$producto = $conexion->query("SELECT * FROM productos WHERE id = '$id'")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $precio = intval($_POST["precio"]);
    $categoria = htmlspecialchars(trim($_POST["categoria"]));

    $conexion->query("UPDATE productos SET nombre='$nombre', precio='$precio', categoria='$categoria' WHERE id='$id'");

    header("Location: ../admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Producto - Cafe Luna</title>
    <link href="../estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <div class="menu">
        <main>
            <h1>Editar Producto</h1>
            <hr>
            <form action="" method="POST" class="formulario">
                <label>Nombre:</label><br>
                <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br>

                <label>Precio:</label><br>
                <input type="number" name="precio" value="<?php echo $producto['precio']; ?>" required><br>

                <label>Categoría:</label><br>
                <select name="categoria" required>
                    <option value="Cafés y Especialidades" <?php if($producto['categoria'] == 'Cafés y Especialidades') echo 'selected'; ?>>Cafés y Especialidades</option>
                    <option value="Sándwiches y Salados" <?php if($producto['categoria'] == 'Sándwiches y Salados') echo 'selected'; ?>>Sándwiches y Salados</option>
                    <option value="Repostería y Dulces" <?php if($producto['categoria'] == 'Repostería y Dulces') echo 'selected'; ?>>Repostería y Dulces</option>
                    <option value="Bebidas Frías" <?php if($producto['categoria'] == 'Bebidas Frías') echo 'selected'; ?>>Bebidas Frías</option>
                </select><br>

                <button type="submit">Guardar cambios</button>
            </form>
            <br>
            <a href="../admin.php" class="btn-cerrar-sesion">Volver</a>
        </main>
    </div>
</body>
</html>