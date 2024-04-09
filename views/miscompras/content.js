document.addEventListener("DOMContentLoaded", async function () {
  // Variables para rastrear el número de elementos mostrados y el tamaño del bloque
  let numElementosMostrados = 0;
  let tamanoBloque = 16; // Número de elementos a mostrar en cada bloque
  reloadSection(null);
  // Agregar evento al botón "Ver Más"
  funcionBotones();
  function funcionBotones() {
    const compras = document.getElementById("btncompras");
    const pendiente = document.getElementById("btnpendiente");
    const pagado = document.getElementById("btnpagado");
    const entregados = document.getElementById("btnentregado");

    compras.addEventListener("click", function () {
      numElementosMostrados = 0;
      tamanoBloque = 10;
      reloadSection(null);
    });
    compras.addEventListener("click", function () {
      numElementosMostrados = 0;
      tamanoBloque = 10;
      reloadSection(1);
    });
    pendiente.addEventListener("click", function () {
      numElementosMostrados = 0;
      tamanoBloque = 10;
      reloadSection(0);
    });
    entregados.addEventListener("click", function () {
      numElementosMostrados = 0;
      tamanoBloque = 10;
      reloadSection(2);
    });
  }
  document.getElementById("bmas").addEventListener("click", function () {
    mostrarElementosEnBloques(data);
  });
  let data;
  async function reloadSection(id) {
    event.preventDefault();
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductsCliente&id=" + id
      );
      data = await response.json();
      console.log(data);
      mostrarElementosEnBloques(data);
    } catch (error) {
      console.error("Error al obtener productos:", error);
    }
  }
  function mostrarElementosEnBloques(data) {
    // Obtener una referencia al contenedor existente
    let contenedorExistente = document.getElementById("container");
    contenedorExistente.innerHTML = "";
  
    if (data && data.length > 0) { // Verifica si hay datos en data
      for (
        let i = numElementosMostrados;
        i < Math.min(numElementosMostrados + tamanoBloque, data.length);
        i++
      ) {
        const producto = data[i];
  
        const estPago =
          producto.est_pago === 0
            ? "Pendiente"
            : producto.est_pago === 2
            ? "Pagado"
            : producto.est_pago === 3
            ? "Entregado"
            : "Estado inválido";
  
        const imagenProducto = producto.imagen
          ? producto.imagen
          : "../../public/images/products/defaultprod.png";
  
        // Crear un nuevo elemento <li> para el producto
        let nuevoElemento = document.createElement("li");
  
        nuevoElemento.className = "list-group-item";
  
        // Construir el HTML del producto
        nuevoElemento.innerHTML = `
        <div class="media align-items-lg-center flex-column flex-lg-row p-3">
        <h5 class="mt-0 font-weight-bold mb-2">${producto.fecha_venta}</h5> 
        <div class="media-body order-2 order-lg-1">
            <h5 class="mt-0 font-weight-bold mb-2">${
              producto.nombre_producto
            }</h5>
            <p class="font-italic text-muted mb-0 small">${
              producto.descripcion_producto
            }</p>
            <div class="d-flex align-items-center justify-content-between mt-1">
              <h6 class="font-weight-bold my-2">${producto.cantidad} X $${
          producto.precio_unitario
        } = $${producto.cantidad * producto.precio_unitario}</h6>
              <ul class="list-inline small">
                <div>
                  <a href="../product-detail/index.php?id=${
                    producto.id_producto
                  }" class="btn btn-success m-2">Ver Producto</a>
                  <h5 class="m-2 font-weight-bold">${estPago}</h5>
                </div>
              </ul>
            </div>
          </div>
          <img src="${imagenProducto}" alt="Product Image" width="100" height="100" class="ml-lg-5 order-1 order-lg-2" />
        </div>
      `;
  
        // Agregar el nuevo elemento al contenedor existente
        contenedorExistente.appendChild(nuevoElemento);
      }
  
      // Actualizar el contador de elementos mostrados
      numElementosMostrados += tamanoBloque;
    } else {
      // Si no hay datos en data, puedes mostrar un mensaje o dejar el contenedor vacío
      contenedorExistente.innerHTML = "<p>No hay elementos para mostrar</p>";
    }
  }
  

  function metodosPlantilla() {
    $(".parallax100").parallax100();

    $(".gallery-lb").each(function () {
      // the containers for all your galleries
      $(this).magnificPopup({
        delegate: "a", // the selector for gallery item
        type: "image",
        gallery: {
          enabled: true,
        },
        mainClass: "mfp-fade",
      });
    });
    $(".js-addwish-b2").on("click", function (e) {
      e.preventDefault();
    });

    $(".js-addwish-b2").each(function () {
      let nameProduct = $(this).parent().parent().find(".js-name-b2").html();
      $(this).on("click", function () {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass("js-addedwish-b2");
        $(this).off("click");
      });
    });

    $(".js-addwish-detail").each(function () {
      let nameProduct = $(this)
        .parent()
        .parent()
        .parent()
        .find(".js-name-detail")
        .html();

      $(this).on("click", function () {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass("js-addedwish-detail");
        $(this).off("click");
      });
    });

    $(".js-addcart-detail").each(function () {
      let nameProduct = $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find(".js-name-detail")
        .html();
      $(this).on("click", function () {
        swal(nameProduct, "is added to cart !", "success");
      });
    });
    $(".js-pscroll").each(function () {
      $(this).css("position", "relative");
      $(this).css("overflow", "hidden");
      let ps = new PerfectScrollbar(this, {
        wheelSpeed: 1,
        scrollingThreshold: 1000,
        wheelPropagation: false,
      });

      $(window).on("resize", function () {
        ps.update();
      });
    });
  }
});