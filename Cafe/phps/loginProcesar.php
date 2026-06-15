<?php
session_start();
include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

// Verificamos que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpiamos los datos recibidos del formulario
    $correo = htmlspecialchars(trim($_POST["correo"]));
    $contrasenia = trim($_POST["contrasenia"]);

    // Buscamos el usuario en la base de datos por su correo
    $resultado = $conexion->query("SELECT * FROM usuario WHERE correo = '$correo'");

    // Si encontramos exactamente un usuario con ese correo
    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificamos que la contraseña ingresada coincida con el hash guardado en la BD
        if (password_verify($contrasenia, $usuario["contrasenia"])) {

            // Guardamos el correo en la sesión para identificar al admin
            $_SESSION["admin"] = $usuario["correo"];

            // Si marcó "Recordar sesión", creamos un token y una cookie
            if (isset($_POST["recordar"])) {
                // Generamos un token seguro aleatorio
                $token = bin2hex(random_bytes(32));
                $expiracion = date("Y-m-d H:i:s", strtotime("+30 days"));
                $id = $usuario["id"];

                // Guardamos el token en la base de datos
                $conexion->query("INSERT INTO token (usuario_id, token, expiracion) VALUES ('$id', '$token', '$expiracion')");

                // Guardamos el token en una cookie por 30 días
                setcookie("recordar_correo", $token, strtotime("+30 days"), "/");
            }

            // Redirigimos al panel de entrada principal
            header("Location: ../principal.php");
            exit();
        }
    }

    // Si el correo o contraseña son incorrectos, volvemos al login con error
    header("Location: ../login.php?error=1");
    exit();

} else {
    // Si alguien intenta acceder directamente al archivo sin enviar el formulario
    die("Acceso no permitido.");
}
?>