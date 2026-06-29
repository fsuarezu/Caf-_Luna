<?php
session_start();

// Si no hay sesión activa, redirigimos al login
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}

include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

// Si el formulario fue enviado por POST, procesamos el nuevo producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpiamos los datos recibidos del formulario
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $precio = ($_POST["precio"]);
    $id_categoria = ($_POST["id_categoria"]);
    $stock = (int)$_POST["stock"];

    // Insertamos el nuevo producto en la base de datos
    $conexion->query("INSERT INTO producto (nombre, precio, id_categoria, stock) VALUES ('$nombre', '$precio', '$id_categoria', '$stock')");

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
    <title>Agregar Producto - Cafe Luna</title>
    <link href="../estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <div class="menu">
        <main>
            <h1>Agregar Producto</h1>
            <hr>
            <form action="" method="POST" class="formulario">
                <label>Nombre:</label><br>
                <input type="text" name="nombre" required><br>

                <label>Precio:</label><br>
                <input type="number" name="precio" required><br>

                <label>Categoría:</label><br>
                <!-- Mostramos las categorías desde la base de datos -->
                <select name="id_categoria" required>
                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre']; ?></option>
                    <?php endwhile; ?>
                </select><br>

                <label>Stock Inicial:</label><br>
                <input type="number" name="stock" min="0" value="0" required><br>

                <button type="submit">Agregar</button>
            </form>
            <br>
            <a href="../principal.php" class="btn-cerrar-sesion">Volver</a>
        </main>
    </div>
</body>
</html>