<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <?php include("phps/banner.php"); ?>

    <div class="menu">
      <main>
        <h1>Café Luna</h1>
        <p class="established">Est. 2026</p>
        <hr>
        
        <section>
          <h2>Productos Destacados</h2>
          <img src="https://cdn.freecodecamp.org/curriculum/css-cafe/coffee.jpg" alt="Icono de café"/>
          
          <article class="item">
            <p class="flavor">Caramel Macchiato</p><p class="price">3.500</p>
          </article>
          <article class="item">
            <p class="flavor">Pie de Limón</p><p class="price">2.800</p>
          </article>
          <article class="item">
            <p class="flavor">Frappuccino de Caramelo</p><p class="price">4.500</p>
          </article>
          
          <p style="text-align: center; margin-top: 20px;">
            <a href="Productos.php">Ver carta completa</a>
          </p>
        </section>
      </main>
      <hr class="bottom-line">
      <footer>
        <p style="text-align: center;">© 2026 Cafe Luna</p>
      </footer>
    </div>
</body>
</html>