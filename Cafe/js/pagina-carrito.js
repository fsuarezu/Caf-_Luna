document.addEventListener("DOMContentLoaded", () => {
    const contenedorResumen = document.getElementById("contenedor-resumen-carrito");
    const totalVisor = document.getElementById("total-final-pagina");

    // 1. Leer la memoria del navegador
    const carritoGuardado = localStorage.getItem("carritoCafeLuna");
    let sumaTotal = 0;

    if (carritoGuardado) {
        const carrito = JSON.parse(carritoGuardado);

        if (carrito.length === 0) {
            contenedorResumen.innerHTML = "<p style='text-align:center;'>Tu carrito está vacío. ¡Vuelve al menú para elegir algo rico!</p>";
        } else {
            // 2. Si hay productos, limpiamos el contenedor y empezamos a dibujar
            contenedorResumen.innerHTML = ""; 

            carrito.forEach((item) => {
                const subtotal = item.precio * item.cantidad;
                sumaTotal += subtotal;

                // Creamos un artículo por cada producto (reutilizando tus clases para que se vea similar)
                const article = document.createElement("article");
                article.classList.add("item");
                article.style.display = "flex";
                article.style.justifyContent = "space-between";
                article.style.marginBottom = "15px";

                article.innerHTML = `
                    <p class="flavor" style="margin:0;"><strong>${item.cantidad}x</strong> ${item.nombre}</p>
                    <p class="price" style="margin:0;">$${subtotal}</p>
                `;

                contenedorResumen.appendChild(article);
            });
        }
    } else {
        contenedorResumen.innerHTML = "<p style='text-align:center;'>Tu carrito está vacío.</p>";
    }

    // 3. Mostrar el total final
    totalVisor.textContent = sumaTotal;
});