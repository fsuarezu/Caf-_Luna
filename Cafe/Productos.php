<?php
/**
 * Carta Digital de Productos - Café Luna
 * Menú completo interactivo y cargado dinámicamente desde la base de datos.
 */
include("bd/conexion.php");
$conexion = conectarDB();
if (!$conexion) {
    die("Error de conexión a la base de datos.");
}

// Consultar todas las categorías
$resultado_categorias = $conexion->query("SELECT * FROM categoria ORDER BY id");
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menú - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="imagenes/favicon.png">
    <style>
      .item {
          flex-wrap: wrap;
      }
      .stock-info {
          width: 100%;
          text-align: left;
          font-size: 12px;
          color: #5c3a21;
          margin-top: 4px !important;
      }
      .stock-info.agotado {
          color: red;
          font-weight: bold;
      }
    </style>
  </head>
  <body>

    <?php include("phps/banner.php"); ?>
    <?php include("phps/carritoBanner.php"); ?>

    <div class="menu">
      <main>
        <h1>Cafe Luna</h1>
        <p class="established">Est. 2026</p>
        <hr>

        <?php
        $iconos_categoria = [
            1 => "https://cdn.freecodecamp.org/curriculum/css-cafe/coffee.jpg", // Cafés y Especialidades
            2 => "https://cdn.freecodecamp.org/curriculum/css-cafe/pie.jpg",    // Sándwiches y Salados
            3 => "https://cdn.freecodecamp.org/curriculum/css-cafe/pie.jpg",    // Repostería y Dulces
            4 => "https://cdn.freecodecamp.org/curriculum/css-cafe/coffee.jpg" // Bebidas Frías
        ];

        if ($resultado_categorias && $resultado_categorias->num_rows > 0) {
            while ($cat = $resultado_categorias->fetch_assoc()) {
                $id_cat = $cat["id"];
                $nombre_cat = $cat["nombre"];
                $icono = isset($iconos_categoria[$id_cat]) ? $iconos_categoria[$id_cat] : "https://cdn.freecodecamp.org/curriculum/css-cafe/coffee.jpg";

                // Consultar productos de la categoría actual
                $resultado_productos = $conexion->query("SELECT * FROM producto WHERE id_categoria = '$id_cat' ORDER BY nombre");

                if ($resultado_productos && $resultado_productos->num_rows > 0) {
                    ?>
                    <section>
                      <h2><?php echo htmlspecialchars($nombre_cat); ?></h2>
                      <img src="<?php echo $icono; ?>" alt="icono de <?php echo htmlspecialchars($nombre_cat); ?>"/>
                      
                      <?php 
                      while ($prod = $resultado_productos->fetch_assoc()) {
                          $nombre_prod = $prod["nombre"];
                          $precio_prod = number_format($prod["precio"], 0, ',', '.');
                          $stock = (int)$prod["stock"];
                          
                          // Categoría Repostería y Dulces (id = 3) usa clase 'dessert', los demás usan 'flavor' para el CSS/JS
                          $clase_tipo = ($id_cat == 3) ? "dessert" : "flavor";
                          ?>
                          <article class="item" data-stock="<?php echo $stock; ?>">
                              <p class="<?php echo $clase_tipo; ?>"><?php echo htmlspecialchars($nombre_prod); ?></p>
                              <p class="price"><?php echo $precio_prod; ?></p>
                              <div class="cantidad-control">
                                  <button>-</button>
                                  <span>0</span>
                                  <button>+</button>
                              </div>
                              <?php if ($stock <= 0): ?>
                                  <p class="stock-info agotado">Agotado</p>
                              <?php else: ?>
                                  <p class="stock-info">Stock disponible: <?php echo $stock; ?></p>
                              <?php endif; ?>
                          </article>
                          <?php
                      }
                      ?>
                    </section>
                    <?php
                }
            }
        } else {
            echo "<p style='text-align:center;'>No se encontraron categorías disponibles.</p>";
        }
        ?>

      </main>
      <hr class="bottom-line">
      <footer>
        <p style="text-align: center;">© 2026 Cafe Luna</p>
      </footer>
    </div>
    <script src="js/carrito.js"></script>
  </body>
</html>