<?php
session_start();

// Si no hay sesión activa, redirigimos al login
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}

include(dirname(__FILE__) . "/../bd/conexion.php");
$conexion = conectarDB();

$error = "";

// Si el formulario fue enviado por POST, procesamos el nuevo cajero
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpiamos los datos recibidos del formulario
    $correo = htmlspecialchars(trim($_POST["correo"]));
    $contrasenia = trim($_POST["contrasenia"]);

    if (!empty($correo) && !empty($contrasenia)) {
        // Verificar si el correo ya existe en la base de datos
        $resultado = $conexion->query("SELECT id FROM usuario WHERE correo = '$correo'");
        if ($resultado && $resultado->num_rows > 0) {
            $error = "El correo electrónico ya está registrado.";
        } else {
            // Cifrar la contraseña
            $hash = password_hash($contrasenia, PASSWORD_DEFAULT);
            
            // Insertar el nuevo cajero (rol predefinido como 'caja')
            $stmt = $conexion->prepare("INSERT INTO usuario (correo, contrasenia, rol) VALUES (?, ?, 'caja')");
            $stmt->bind_param("ss", $correo, $hash);
            if ($stmt->execute()) {
                header("Location: ../principal.php");
                exit();
            } else {
                $error = "Ocurrió un error al registrar el cajero en la base de datos.";
            }
            $stmt->close();
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar Cajero - Cafe Luna</title>
    <link href="../estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <div class="menu">
        <main>
            <h1>Agregar Cajero</h1>
            <hr>
            
            <?php if (!empty($error)): ?>
                <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; text-align: center; font-weight: bold;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="formulario">
                <label>Correo Electrónico:</label><br>
                <input type="email" name="correo" required style="padding: 8px; font-size: 14px;"><br>

                <label>Contraseña:</label><br>
                <input type="password" name="contrasenia" required style="padding: 8px; font-size: 14px;"><br>

                <button type="submit" style="cursor: pointer; font-weight: bold;">Agregar Cajero</button>
            </form>
            <br>
            <a href="../principal.php" class="btn-cerrar-sesion">Volver</a>
        </main>
    </div>
</body>
</html>
