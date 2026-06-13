<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pago - Cafe Luna</title>
    <link href="estilos/estilos.css" rel="stylesheet"/>
</head>
<body>
    <?php include("phps/banner.php"); ?>
    <?php include("phps/carritoBanner.php"); ?>

    <div class="menu">
        <main>
            <h1>Método de Pago</h1>
            <hr>
            <?php include("phps/mensaje.php"); ?>

            <form action="phps/procesarPago.php" method="POST" class="formulario">
                <input type="hidden" name="productos" id="input-productos" value="">
                <input type="hidden" name="total" id="input-total" value="">
                <label>Nombre y Apellido:</label><br>
                <input type="text" name="nombre" placeholder="Tu nombre" minlength="3" required><br>

                <label>Correo:</label><br>
                <input type="email" name="correo" placeholder="tu@correo.com" required><br>

                <h2>Método de Pago</h2>
                <div class="metodos-pago">
                    <button type="button" class="metodo-btn" id="btn-credito" onclick="seleccionar('credito')">
                        <img src="imagenes/credito.svg" alt="Crédito">
                        <p>Crédito</p>
                    </button>
                    <button type="button" class="metodo-btn" id="btn-debito" onclick="seleccionar('debito')">
                        <img src="imagenes/debito.svg" alt="Débito">
                        <p>Débito</p>
                    </button>
                </div>

                <input type="hidden" name="metodo" id="metodo-seleccionado" value="">

                <button type="submit" id="btn-pagar" style="display:none;" class="btn-cerrar-sesion">Confirmar Pedido</button>
            </form>

        </main>
        <footer></footer>
    </div>

    <script>
        function seleccionar(metodo) {
            document.getElementById("metodo-seleccionado").value = metodo;
            document.getElementById("btn-credito").classList.remove("seleccionado");
            document.getElementById("btn-debito").classList.remove("seleccionado");
            document.getElementById("btn-" + metodo).classList.add("seleccionado");
            document.getElementById("btn-pagar").style.display = "block";
        }
        document.querySelector("form").addEventListener("submit", function() {
            document.getElementById("input-productos").value = localStorage.getItem("carritoCafeLuna");
            document.getElementById("input-total").value = localStorage.getItem("totalCafeLuna");
        });
    </script>
</body>
</html>