<?php
/**
 * Vista de Nuestra Localidad
 * Muestra la ubicación física del local, horarios de atención y el mapa interactivo.
 */
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nuestra Localidad - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="imagenes/favicon.png">
  </head>
  <body>
    
    <?php include("phps/banner.php");?>

    <div class="menu">
      <main>
        <h1>Nuestra Localidad</h1>
        <hr>
        
        <section>
          <h2>Encuéntranos</h2>
          <p>Ven a disfrutar del mejor café en un ambiente cálido y acogedor.</p>
          
          <div style="text-align: center; margin: 25px 0;">
          <!-- Dirección física de la cafetería -->
          <address style="font-size: 18px; line-height: 1.6;">
              <strong>Café Luna - Sucursal Principal</strong><br>
              Gral. Jofré 466<br>
              Santiago, Región Metropolitana<br>
              Teléfono: +56 9 7858 4981
          </address>
          </div>

          <!-- Horarios de atención al público -->
          <h2>Horarios de Atención</h2>
          <ul style="list-style: none; padding: 0; text-align: center; font-size: 17px; line-height: 1.8;">
            <li><strong>Lunes a Viernes:</strong> 08:10 AM - 06:00 PM</li>
            <li><strong>Sábados:</strong> 09:00 AM - 09:00 PM</li>
            <li><strong>Domingos:</strong> Cerrado</li>
          </ul>
          
          <!-- Contenedor del mapa de Google Maps integrado mediante un iframe -->
          <div style="margin-top: 30px; text-align: center;">
             <div style="background-color: #eaddc7; width: 100%; height: 250px; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: 1px dashed brown;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d989.7485359444808!2d-70.64121267813842!3d-33.44659733039272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scl!4v1777340138191!5m2!1ses!2scl" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
             </div>
          </div>

        </section>

      </main>
      <hr class="bottom-line">
      <footer>
        <p style="text-align: center;"><a href="Contactanos.php">¿Necesitas hacer una reserva? Contáctanos</a></p>
      </footer>
    </div>
  </body>
</html>