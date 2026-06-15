<?php
/**
 * Carta Digital de Productos
 * Menú completo interactivo con controles de cantidad para el carrito de compras.
 */
?>
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

    
    <?php include("phps/banner.php"); ?>
    <?php include("phps/carritoBanner.php"); ?>

    <div class="menu">
      <main>
        <h1>Cafe Luna</h1>
        <p class="established">Est. 2026</p>
        <hr>
        <!-- Categoría: Cafés y Especialidades -->
        <section>
          <h2>Cafés y Especialidades</h2>
          <img src="https://cdn.freecodecamp.org/curriculum/css-cafe/coffee.jpg" alt="icono de café"/>
          
          <article class="item">
            <p class="flavor">Espresso</p>
            <p class="price">1.800</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>

          <article class="item">
            <p class="flavor">Americano</p>
            <p class="price">2.000</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>

          <article class="item">
            <p class="flavor">Cappuccino</p>
            <p class="price">2.500</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>

          <article class="item">
            <p class="flavor">Latte Clásico</p>
            <p class="price">2.800</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>

          <article class="item">
            <p class="flavor">French Vanilla</p>
            <p class="price">3.000</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>
          
          <article class="item">
            <p class="flavor">Caramel Macchiato</p>
            <p class="price">3.500</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>
          
          <article class="item">
            <p class="flavor">Pumpkin Spice Latte</p>
            <p class="price">3.800</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>
          
          <article class="item">
            <p class="flavor">Avellana</p>
            <p class="price">3.200</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>
          
          <article class="item">
            <p class="flavor">Mocha</p>
            <p class="price">3.500</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>
        </section>
        <!-- Categoría: Sándwiches y Salados -->
        <section>
          <h2>Sándwiches y Salados</h2>
          <img src="https://cdn.freecodecamp.org/curriculum/css-cafe/pie.jpg" alt="icono de comida salada"/>
          
          <article class="item">
            <p class="flavor">Tostadas con Palta</p>
            <p class="price">3.500</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>
          
          <article class="item">
            <p class="flavor">Sándwich Ave Palta</p>
            <p class="price">4.500</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>

          <article class="item">
            <p class="flavor">Sándwich Barros Jarpa</p>
            <p class="price">4.200</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>

          <article class="item">
            <p class="flavor">Quiche de Espinaca y Champiñón</p>
            <p class="price">3.800</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>

          <article class="item">
            <p class="flavor">Empanaditas de Queso (x3)</p>
            <p class="price">2.500</p>
            <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
          </article>
        </section>
        <!-- Categoría: Repostería y Dulces -->
        <section>
        <h2>Repostería y Dulces</h2>
        <img src="https://cdn.freecodecamp.org/curriculum/css-cafe/pie.jpg" alt="icono de repostería"/>
        
        <article class="item">
          <p class="dessert">Kuchen de Nuez</p>
          <p class="price">3.200</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>
        
        <article class="item">
          <p class="dessert">Kuchen de Frambuesa</p>
          <p class="price">3.000</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>

        <article class="item">
          <p class="dessert">Pie de Limón</p>
          <p class="price">2.800</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>

        <article class="item">
          <p class="dessert">Alfajor de Manjar Casero</p>
          <p class="price">1.500</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>

        <article class="item">
          <p class="dessert">Muffin de Arándanos</p>
          <p class="price">2.000</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>

        </article>

        <article class="item">
          <p class="dessert">Medialunas (x2)</p>
          <p class="price">2.200</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>

        </article>
        
        <article class="item">
          <p class="dessert">Croissant de Mantequilla</p>
          <p class="price">2.000</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>
      </section>
      <!-- Categoría: Bebidas Frías -->
      <section>
        <h2>Bebidas Frías</h2>
        <img src="https://cdn.freecodecamp.org/curriculum/css-cafe/coffee.jpg" alt="icono de bebida fría"/>
        
        <article class="item">
          <p class="flavor">Iced Americano</p>
          <p class="price">2.500</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>
        
        <article class="item">
          <p class="flavor">Frappuccino de Caramelo</p>
          <p class="price">4.500</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>

        <article class="item">
          <p class="flavor">Jugo Natural de Frambuesa</p>
          <p class="price">3.000</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>
        
        <article class="item">
          <p class="flavor">Limonada Menta Jengibre</p>
          <p class="price">2.800</p>
          <div class="cantidad-control">
                <button>-</button>
                <span>0</span>
                <button>+</button>
            </div>
        </article>
      </section>
      </main>
      <hr class="bottom-line">
      <footer>
      </footer>
    </div>
    <script src="js/carrito.js"></script>
  </body>
</html>