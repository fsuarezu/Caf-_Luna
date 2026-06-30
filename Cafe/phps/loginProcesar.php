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

    // Si encontramos al menos un usuario con ese correo
    if ($resultado->num_rows >= 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificamos que la contraseña ingresada coincida con el hash guardado en la BD
        if (password_verify($contrasenia, $usuario["contrasenia"])) {

            // Validamos que el rol del usuario coincida con el seleccionado
            $rol_seleccionado = htmlspecialchars(trim($_POST["rol"]));
            if ($usuario["rol"] === $rol_seleccionado) {
                
                // Si marcó "Recordar sesión", creamos un token y una cookie
                if (isset($_POST["recordar"])) {
                    // Generamos un token seguro aleatorio
                    $token = bin2hex(random_bytes(32));
                    $expiracion = date("Y-m-d H:i:s", strtotime("+1 day"));
                    $id = $usuario["id"];

                    // Guardamos el token en la base de datos
                    $conexion->query("INSERT INTO token (usuario_id, token, expiracion) VALUES ('$id', '$token', '$expiracion')");

                    // Guardamos el token en una cookie por 1 día
                    setcookie("recordar_correo", $token, strtotime("+1 day"), "/");
                }

                if ($rol_seleccionado === "admin") {
                    $_SESSION["admin"] = $usuario["correo"];
                    header("Location: ../principal.php");
                } else {
                    $_SESSION["cajero"] = $usuario["correo"];
                    header("Location: ../cajero.php");
                }
                exit();
            } else {
                // Si el rol no coincide con la cuenta, redirigimos con error de rol
                header("Location: ../login.php?error=rol");
                exit();
            }
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