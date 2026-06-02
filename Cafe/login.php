<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contacto - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
  </head>
  <body>
    
    <?php include("phps/banner.php");?>

    <div class="menu">
      <main>
        <h1>Inicio de sesion</h1>
        <?php include ("phps/MENSAJE.php"); ?>
        <hr>
        
        <form action="phps/loginProcesar.php" method="POST" class="formulario">
          
          <label for="correo">Correo electrónico:</label><br>
          <input type="email" id="correo" name="correo" placeholder="ejemplo@mail.com" required><br>

          <label for="telefono">Contraseña:</label><br>
          <input type="password" id="contrasenia" name="contrasenia" required><br>
          <button type="submit">Entrar</button>
        </form>

      </main>
      <hr class="bottom-line">
      <footer>
      </footer>
    </div>
  </body>
</html>
