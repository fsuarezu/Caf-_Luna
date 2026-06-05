document.addEventListener("DOMContentLoaded", () => {
  const productos = document.querySelectorAll(".item");

  // 1. Al cargar la página, verificamos si hay un carrito guardado en memoria
  cargarCarritoDesdeStorage();

  productos.forEach((producto) => {
    const control = producto.querySelector(".cantidad-control");
    const btnRestar = control.children[0];
    const spanCantidad = control.children[1];
    const btnSumar = control.children[2];

    btnSumar.addEventListener("click", () => {
      let cantidadActual = parseInt(spanCantidad.textContent);
      spanCantidad.textContent = cantidadActual + 1;
      
      // Guardamos en memoria cada vez que hay un cambio
      guardarCarrito();
    });

    btnRestar.addEventListener("click", () => {
      let cantidadActual = parseInt(spanCantidad.textContent);
      if (cantidadActual > 0) {
        spanCantidad.textContent = cantidadActual - 1;
        
        // Guardamos en memoria cada vez que hay un cambio
        guardarCarrito();
      }
    });
  });

  // --- NUEVAS FUNCIONES PARA LA MEMORIA DEL NAVEGADOR ---

  function guardarCarrito() {
    let carrito = []; // Arreglo para guardar los productos
    let totalGeneral = 0;

    productos.forEach((producto) => {
      // Necesitamos el nombre para identificar qué compró. 
      // Buscamos tanto la clase .flavor como .dessert según tu HTML
      const nombre = producto.querySelector(".flavor, .dessert").textContent; 
      const precio = parseInt(producto.querySelector(".price").textContent.replace('.', ''));
      const cantidad = parseInt(producto.querySelector(".cantidad-control span").textContent);
      
      // Solo guardamos los productos que tengan cantidad mayor a 0
      if (cantidad > 0) {
        carrito.push({ nombre: nombre, precio: precio, cantidad: cantidad });
        totalGeneral += (precio * cantidad);
      }
    });

    // Guardamos el arreglo convirtiéndolo a texto (JSON.stringify) porque localStorage solo acepta texto
    localStorage.setItem("carritoCafeLuna", JSON.stringify(carrito));
    localStorage.setItem("totalCafeLuna", totalGeneral);
    
    console.log("Datos guardados en memoria:", carrito);
    console.log("Total actualizado: $" + totalGeneral);
  }

  function cargarCarritoDesdeStorage() {
    // Intentamos leer la información guardada previamente
    const carritoGuardado = localStorage.getItem("carritoCafeLuna");
    
    // Si hay información, la procesamos
    if (carritoGuardado) {
      // Convertimos el texto de vuelta a un formato que JavaScript entienda (JSON.parse)
      const carrito = JSON.parse(carritoGuardado);
      
      productos.forEach((producto) => {
         const nombre = producto.querySelector(".flavor, .dessert").textContent;
         const spanCantidad = producto.querySelector(".cantidad-control span");
         
         // Buscamos si el producto actual de la página existe en nuestra memoria guardada
         const itemEnCarrito = carrito.find(item => item.nombre === nombre);
         
         // Si existe, le asignamos la cantidad que tenía guardada
         if (itemEnCarrito) {
             spanCantidad.textContent = itemEnCarrito.cantidad;
         }
      });
    }
  }
});