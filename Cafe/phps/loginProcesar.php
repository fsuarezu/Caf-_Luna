<?php
session_start();
include(dirname(__FILE__) . "/../bd/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = htmlspecialchars(trim($_POST["correo"]));
    $contrasenia = trim($_POST["contrasenia"]);

    $resultado = $conexion->query("SELECT * FROM usuarios WHERE correo = '$correo'");

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contrasenia, $usuario["contrasenia"])) {
            $_SESSION["admin"] = $usuario["correo"];

            if (isset($_POST["recordar"])) {
                setcookie("recordar_correo", $usuario["correo"], strtotime("+30 days"), "/");
            }

            header("Location: ../admin.php");
            exit();
        }
    }

    header("Location: ../login.php?error=1");
    exit();

} else {
    die("Acceso no permitido.");
}
?>