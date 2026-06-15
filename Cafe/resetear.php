<?php
include("bd/conexion.php");
$conexion = conectarDB();

// Obtenemos el token desde la URL
$token = $_GET["token"];
$hoy = date("Y-m-d H:i:s");

// Verificamos que el token existe y no ha vencido
$resultado = $conexion->query("SELECT usuario.* FROM token 
    JOIN usuario ON token.usuario_id = usuario.id 
    WHERE token.token = '$token' AND token.expiracion > '$hoy'");

// Si el token no es válido o ya venció, redirigimos con error
if ($resultado->num_rows == 0) {
    header("Location: recuperar.php?error=token");
    exit();
}

$usuario = $resultado->fetch_assoc();

// Si el formulario fue enviado, actualizamos la contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nueva = trim($_POST["contrasenia"]);

    // Encriptamos la nueva contraseña
    $hash = password_hash($nueva, PASSWORD_DEFAULT);

    // Actualizamos la contraseña en la base de datos
    $conexion->query("UPDATE usuario SET contrasenia = '$hash' WHERE id = '{$usuario['id']}'");

    // Eliminamos el token usado
    $conexion->query("DELETE FROM token WHERE token = '$token'");

    // Redirigimos al login con mensaje de éxito
    header("Location: login.php?resetead=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nueva Contraseña - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <?php include("phps/banner.php"); ?>
    <div class="menu">
        <main>
            <h1>Nueva Contraseña</h1>
            <hr>
            <form action="" method="POST" class="formulario">
                <label>Nueva contraseña:</label><br>
                <input type="password" name="contrasenia" minlength="6" required><br>
                <button type="submit">Guardar</button>
            </form>
        </main>
    </div>
</body>
</html>