document.addEventListener("DOMContentLoaded", async function () {
  const totalSpan = document.getElementById("totalspan");
  const subtotalSpan = document.getElementById("subtotal");
  const cenvioSpan = document.getElementById("cenvio");
  document
    .getElementById("btnpagar")
    .addEventListener("click", async function () {
      swal({
        title: "¿Esta seguro de realizar la compra?",
        text: "La acción se realizó de manera exitosa!",
        icon: "warning",
        buttons: ["Cancelar", "Confirmar"],
      }).then((confirmado) => {
        if (confirmado) {
          realizarPago();
        }
      });
    });
  var miTabla = $("#miTabla").DataTable({
    language: {
      decimal: "",
      emptyTable: "No hay datos disponibles en la tabla",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(filtrados de un total de _MAX_ registros)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "", // Quitamos el texto "Buscar:"
      zeroRecords: "No se encontraron registros coincidentes",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
      aria: {
        sortAscending: ": activar para ordenar la columna ascendente",
        sortDescending: ": activar para ordenar la columna descendente",
      },
    },
    lengthChange: false, // Desactivamos la opción de cambiar la cantidad de registros por página
    searching: false, // Desactivamos la búsqueda
    columns: [
      {
        data: "img",
        title: "Imagen",
        render: function (data, type, row) {
          return `<img src="${data}" alt="imagen del producto" width="50" />`;
        },
      },
      { data: "nombre", title: "Producto" }, // Nombre del producto

      { data: "talla", title: "Talla" },
      { data: "color", title: "Color" },

      { data: "talla_id", title: "Talla", visible: false }, // Talla
      { data: "color_id", title: "Color", visible: false }, // Color
      {
        data: null,
        title: "pedido",
        render: function (data, type, row) {
          return `${row.cantidad} X $${row.precio_venta} = $${
            row["precio_venta"].toFixed(2) * row["cantidad"]
          }`;
        },
      },

      {
        data: null,
        title: "Cantidad",
        render: function (data, type, row) {
          return ` <td class="column-6">
          <div class="wrap-num-product flex-w m-l-auto m-r-0">
              
          <button class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m  btnRestar" data-id="${row.id}">
                  <i class="fs-16 zmdi zmdi-minus"></i>
              </button>
          
              <input id="input_stock_${row.id}" class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="${row.cantidad}">
              <button class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m  btnSumar" data-id="${row.id}">
                  <i class="fs-16 zmdi zmdi-plus"></i>
              </button>
          
              </div>
        </td>`;
        },
      },
      {
        data: null,
        title: "Acciones",
        render: function (data, type, row) {
          return `
                    <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });
  let SUBTOTAL = 0;
  let CENVIO = 0;
  let TOTAL = 0;
  reloadSection();

  $("#id_envio").change(function () {
    var opcion_seleccionada = $(this).val();
    switch (opcion_seleccionada) {
      case "1":
        CENVIO = 5; // Precio para Retiro en domicilio
        break;
      case "2":
        CENVIO = 0; // Precio para Retiro en oficina
        break;
      case "3":
        CENVIO = 8; // Precio para Enviar regalo
        break;
      default:
        CENVIO = 0;
    }
    reloadSection();
    $("#precio").text(CENVIO.toFixed(2));
  });
  function realizarPago() {
    alert("Entra");
  }
  function reloadSection() {
    try {
      const productos = JSON.parse(localStorage.getItem("cart")) || [];
      miTabla.clear().draw(); // Limpiar la tabla antes de insertar nuevos datos
      SUBTOTAL = 0;

      productos.forEach((producto) => {
        SUBTOTAL +=
          parseFloat(producto.precio_venta) * parseInt(producto.cantidad);
      });
      miTabla.rows.add(productos).draw();
      TOTAL = SUBTOTAL + CENVIO;
      // Agregar los productos a la tabla y dibujarla
      cenvioSpan.textContent = "$" + CENVIO.toFixed(2);
      totalSpan.textContent = "$" + TOTAL.toFixed(2);
      subtotalSpan.textContent = "$" + SUBTOTAL.toFixed(2);
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  $(document).on("click", ".btnEliminar", function () {
    var id = $(this).data("id");
    let cart = JSON.parse(localStorage.getItem("cart"));
    cart = cart.filter((producto) => producto.id !== id);
    localStorage.setItem("cart", JSON.stringify(cart));
    reloadCart();
    reloadSection();
  });
  $(document).on("click", ".btnSumar", function () {
    var id = $(this).data("id");
    let cart = JSON.parse(localStorage.getItem("cart"));
    let producto = cart.find((producto) => producto.id === id);
    if (producto) {
      producto.cantidad++; // Incrementar la cantidad del producto
      localStorage.setItem("cart", JSON.stringify(cart));
      reloadCart();
      reloadSection();
    }
  });
  $(document).on("click", ".btnRestar", function () {
    var id = $(this).data("id");
    let cart = JSON.parse(localStorage.getItem("cart"));
    let producto = cart.find((producto) => producto.id === id);
    if (producto) {
      producto.cantidad--; // Incrementar la cantidad del producto
      localStorage.setItem("cart", JSON.stringify(cart));
      reloadCart();
      reloadSection();
    }
  });
});
