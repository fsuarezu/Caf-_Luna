<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="imagenes/favicon.png">
</head>
<body>
  
    <?php include("phps/banner.php"); ?>
  <div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Diapositiva 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Diapositiva 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Diapositiva 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="..." class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>

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