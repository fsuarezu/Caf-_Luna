<?php
session_start();

// Si no hay sesión activa, redirigimos al login
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}

include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

// Obtenemos el id del producto desde la URL
$id = ($_GET["id"]);

// Buscamos el producto en la base de datos por su id
$producto = $conexion->query("SELECT * FROM producto WHERE id = '$id'")->fetch_assoc();

// Si el formulario fue enviado por POST, procesamos los cambios
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpiamos los datos recibidos del formulario
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $precio = ($_POST["precio"]);
    $id_categoria = ($_POST["id_categoria"]);
    $stock = (int)$_POST["stock"];

    // Actualizamos el producto en la base de datos
    $conexion->query("UPDATE producto SET nombre='$nombre', precio='$precio', id_categoria='$id_categoria', stock='$stock' WHERE id='$id'");

    // Redirigimos al panel de entrada principal
    header("Location: ../principal.php");
    exit();
}

// Traemos todas las categorías para mostrarlas en el select
$categorias = $conexion->query("SELECT * FROM categoria");
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
                <!-- Mostramos el nombre actual del producto -->
                <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br>

                <label>Precio:</label><br>
                <!-- Mostramos el precio actual del producto -->
                <input type="number" name="precio" value="<?php echo $producto['precio']; ?>" required><br>

                <label>Categoría:</label><br>
                <!-- Mostramos las categorías desde la base de datos, marcando la actual -->
                <select name="id_categoria" required>
                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>" 
                            <?php if ($cat['id'] == $producto['id_categoria']) echo 'selected'; ?>>
                            <?php echo $cat['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select><br>

                <label>Stock:</label><br>
                <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" min="0" required><br>

                <button type="submit">Guardar cambios</button>
            </form>
            <br>
            <a href="../principal.php" class="btn-cerrar-sesion">Volver</a>
        </main>
    </div>
</body>
</html>