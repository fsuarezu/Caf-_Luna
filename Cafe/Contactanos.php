<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contacto - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="imagenes/favicon.png">
  </head>
  <body>
    
    <?php include("phps/banner.php");?>

    <div class="menu">
      <main>
        <h1>Contáctanos</h1>
        <?php include ("phps/mensaje.php"); ?>
        <hr>
        
        <form action="contacto.php" method="POST" class="formulario">
          <label for="nombre">Nombre completo:</label><br>
          <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan Pérez" required><br>

          <label for="correo">Correo electrónico:</label><br>
          <input type="email" id="correo" name="correo" placeholder="ejemplo@mail.com" required><br>

          <label for="telefono">Teléfono:</label><br>
          <input type="tel" id="telefono" name="telefono" placeholder="Ej: 987654321" required><br>

          <label for="asunto">Asunto:</label>
          <select id="asunto" name="asunto" required>
            <option value="" disabled selected>Selecciona una opción...</option>
            <option value="Cotizacion">Cotización para eventos</option>
            <option value="Duda">Duda sobre productos</option>
            <option value="Reservacion">Reservación de mesa</option>
            <option value="Reclamo">Reclamos o Sugerencias</option>
            <option value="Trabajo">Trabaja con nosotros</option>
          </select>

          <label for="mensaje">Mensaje:</label><br>
          <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu consulta aquí..." required></textarea><br>

          <button type="submit">Enviar Mensaje</button>
        </form>

      </main>
      <hr class="bottom-line">
      <footer>
      </footer>
    </div>
  </body>
</html>