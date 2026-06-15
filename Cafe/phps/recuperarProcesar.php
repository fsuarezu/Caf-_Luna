<?php
include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = htmlspecialchars(trim($_POST["correo"]));

    // Buscamos si el correo existe en la base de datos
    $resultado = $conexion->query("SELECT * FROM usuario WHERE correo = '$correo'");

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        // Generamos un token seguro temporal
        $token = bin2hex(random_bytes(32));
        $expiracion = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardamos el token en la base de datos
        $conexion->query("INSERT INTO token (usuario_id, token, expiracion) VALUES ('{$usuario['id']}', '$token', '$expiracion')");

        // Mostramos el enlace para resetear la contraseña
        header("Location: ../recuperar.php?token=$token&enviado=1");
        exit();
    }

    // Si el correo no existe, redirigimos con error
    header("Location: ../recuperar.php?error=correo");
    exit();

} else {
    die("Acceso no permitido.");
}
?>