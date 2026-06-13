<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Contraseña - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <?php include("phps/banner.php"); ?>
    <div class="menu">
        <main>
            <h1>Recuperar Contraseña</h1>
            <?php include("phps/mensaje.php"); ?>
            <hr>
            <form action="phps/recuperarProcesar.php" method="POST" class="formulario">
                <label>Correo electrónico:</label><br>
                <input type="email" name="correo" placeholder="ejemplo@mail.com" required><br>
                <button type="submit">Enviar</button>
            </form>
        </main>
    </div>
</body>
</html>