<?php
/**
 * Vista de Inicio de Sesión
 * Permite ingresar credenciales para acceder al panel de administración.
 */
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de sesion</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
  </head>
  <body>
    
    <?php include("phps/banner.php");?>

    <div class="menu">
      <main>
        <h1>Inicio de sesion</h1>
        <?php include ("phps/mensaje.php"); ?>
        <hr>
        
        <!-- Formulario de inicio de sesión que redirige a loginProcesar.php -->
        <form action="phps/loginProcesar.php" method="POST" class="formulario">
          
          <label for="correo">Correo electrónico:</label><br>
          <input type="email" id="correo" name="correo" placeholder="ejemplo@mail.com" required><br>

          <label for="contrasenia">Contraseña:</label><br>
          <input type="password" id="contrasenia" name="contrasenia" required><br>

          <label for="rol">Ingresar como:</label><br>
          <select id="rol" name="rol" required style="width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid black;">
              <option value="admin">Administrador</option>
              <option value="caja">Caja / Cajero</option>
          </select><br>

          <div class="checkbox-group">
              <input type="checkbox" id="recordar" name="recordar">
              <label for="recordar">Recordar sesión</label>
          </div>

          <button type="submit">Entrar</button>
          <a href="recuperar.php">¿Olvidaste tu contraseña?</a>
        </form>

      </main>
      <hr class="bottom-line">
      <footer>
      </footer>
    </div>
  </body>
</html>