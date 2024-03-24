document.addEventListener("DOMContentLoaded", async function () {
  const totalSpan = document.getElementById("totalspan");
  const subtotalSpan = document.getElementById("subtotal");
  let subtotal = 0;
  const selectRetiro = document.getElementById("selectRetiro");

  // Función para calcular el subtotal
  function calcularSubtotal() {
    subtotal = 0;
    const cart = JSON.parse(localStorage.getItem("cart"));
    if (cart && cart.length > 0) {
      cart.forEach((producto) => {
        subtotal +=
          parseFloat(producto.precio_venta.replace("$", "")) *
          producto.cantidad;
      });
    }
  }

  // Función para actualizar el subtotal y el total
  function actualizarSubtotal() {
    subtotalSpan.innerText = "$" + subtotal.toFixed(2);
    totalSpan.innerText = "$" + subtotal.toFixed(2); // El total es igual al subtotal en este caso
  }

  // Función para actualizar el subtotal según la opción de retiro seleccionada
  function actualizarSubtotalSegunRetiro(option) {
    if (option === "1" || option === "3") {
      subtotal += 5; // Sumar $5 al subtotal si la opción es 1 o 3
    }
    actualizarSubtotal();
  }

  // Escuchar cambios en la selección de opciones de retiro
  selectRetiro.addEventListener("change", function () {
    const optionSeleccionada = this.value;
    actualizarSubtotalSegunRetiro(optionSeleccionada);
  });

  calcularSubtotal();
  actualizarSubtotal();
  window.onload = function () {
    reloadSection();
    metodosPlantilla();
  };

  function reloadSection() {
    const cart = JSON.parse(localStorage.getItem("cart"));
    const tableBody = document.getElementById("contenttable");
    tableBody.innerHTML = ""; // Limpiar el contenido de la tabla antes de insertar nuevos elementos
    if (
      cart.length > 0) {
      cart.forEach((producto, index) => {
        const totalProducto =
          parseFloat(producto.precio_venta.replace("$", "")) *
          producto.cantidad;
        const row = tableBody.insertRow();
        const imagenProducto = producto.img
          ? producto.img
          : "../../public/images/products/defaultprod.png";
        row.innerHTML = `
                  <td class="column-1">
                      <div class="how-itemcart1" id="productImage_${index}" onclick="eliminarProducto(${index})">
                          <img style="height:100px; weight:100px;" src="${imagenProducto}" alt="IMG">
                      </div>
                  </td>
                  <td class="column-2">${producto.nombre}</td>
                  <td class="column-3">${producto.precio_venta}</td>
                  <td class="column-4">${producto.talla}</td>
                  <td class="column-5">${producto.color}</td>
                  <td class="column-6">
                      <div class="wrap-num-product flex-w m-l-auto m-r-0">
                          <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                              <i class="fs-16 zmdi zmdi-minus"></i>
                          </div>
                          <input id="input_stock_${index}" class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="${
          producto.cantidad
        }">
                          <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                              <i class="fs-16 zmdi zmdi-plus"></i>
                          </div>
                      </div>
                  </td>
                  <td class="column-7">$${totalProducto.toFixed(2)}</td>
              `;
      });
    } else {
      const productosContainer = document.getElementById("container");
      productosContainer.innerHTML = `	
              <a href="../login">
                  <p>Inicie sesión para ver sus productos favoritos</p>
              </a>
          `;
    }
  }

  // Función para eliminar un producto del carrito por su índice
  function eliminarProducto(index) {
    let cart = JSON.parse(localStorage.getItem("cart"));
    cart.splice(index, 1); // Eliminar el producto del carrito
    localStorage.setItem("cart", JSON.stringify(cart)); // Actualizar el carrito en localStorage
    location.reload(); // Recargar la página para reflejar los cambios en la tabla del carrito
  }

  function MetodoControlStock(stock, inputStock) {
    const disminuir = inputStock.parentElement.querySelector(
      ".btn-num-product-down"
    );
    const sumar = inputStock.parentElement.querySelector(".btn-num-product-up");

    disminuir.addEventListener("click", () => {
      if (stock > 0) {
        stock--;
        inputStock.value = stock;
      }
    });

    sumar.addEventListener("click", () => {
      stock++;
      inputStock.value = stock;
    });

    inputStock.addEventListener("change", () => {
      inputStock.value = stock;
    });
  }

  function metodosPlantilla() {
    $(".js-select2").each(function () {
      $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next(".dropDownSelect2"),
      });
    });

    $(".js-pscroll").each(function () {
      $(this).css("position", "relative");
      $(this).css("overflow", "hidden");
      var ps = new PerfectScrollbar(this, {
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
