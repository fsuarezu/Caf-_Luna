<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cafe Menu</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="imagenes/favicon.png">
  </head>
  <body>
    
    <?php include("phps/banner.php");?>

    <div class="menu">
      <main>
        
      <main>
        <h1>Cafe Luna</h1>
        <p class="established">Resumen de tu pedido</p>
        <hr>
        
        <!-- Aquí es donde JavaScript pondrá los productos -->
        <section id="contenedor-resumen-carrito">
            <!-- El contenido se generará dinámicamente -->
        </section>

        <!-- Sección del total -->
        <section class="total-final-container" style="text-align: right; margin-top: 20px;">
            <h2>Total a Pagar: $<span id="total-final-pagina">0</span></h2>
            <button id="btn-pagar" style="padding: 10px 20px; background-color: #4a3623; color: white; border: none; cursor: pointer; font-size: 16px;">Proceder al Pago</button>
        </section>
      </main>
      </main>
      <hr class="bottom-line">
      <footer>
      </footer>
    </div>
    
    
    <!-- Conectamos el script que lee la memoria -->
    <script src="js/pagina-carrito.js"></script>
  </body>
</html>
  </body>
</html>