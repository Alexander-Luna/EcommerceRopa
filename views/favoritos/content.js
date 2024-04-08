document.addEventListener("DOMContentLoaded", async function () {
  // document
  //   .getElementById("btnpagar")
  //   .addEventListener("click", async function () {
  //     swal({
  //       title: "¿Esta seguro de realizar la compra?",
  //       text: "La acción se realizó de manera exitosa!",
  //       icon: "warning",
  //       buttons: ["Cancelar", "Confirmar"],
  //     }).then((confirmado) => {
  //       if (confirmado) {
  //         realizarPago();
  //       }
  //     });
  //   });
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
        data: "url_imagen",
        title: "Imagen",
        render: function (data, type, row) {
          return `<img src="${data}" alt="imagen del producto" width="50" />`;
        },
      },
      { data: "nombre", title: "Producto" }, // Nombre del producto

      { data: "descripcion", title: "Descipcion" },
      {
        data: null,
        title: "Acciones",
        render: function (data, type, row) {
          return ` <a href="../product-detail/index.php?id=${row.id}" class="btn btn-outline-info btnView" data-id="${row.id}">
          <i class="fa fa-eye" aria-hidden="true"></i></a>
                    <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });

  reloadSection();

  function realizarPago() {
    event.preventDefault();
    // Obtener el carrito de compras del localStorage
    let carrito = [];
    const carritoJSON = localStorage.getItem("cart");
    if (carritoJSON) {
      carrito = JSON.parse(carritoJSON);
    } else {
      swal("Error", "No existen productos en el carrito", "warning");
      //return;
    }
    const nombre = document.getElementById("nombre").value;
    const provincia = document.getElementById("provincias").value;
    const canton = document.getElementById("canton").value;
    const direccion = document.getElementById("direccion").value;
    const email = document.getElementById("email").value;
    const ci = document.getElementById("ci").value;
    const telefono = document.getElementById("telefono").value;
    const idEnvio = document.getElementById("id_envio").value;
    const metodoDePago = document.getElementById("metododepago").value;
    const comprobante = document.getElementById("comprobante").value;
    const comprobantef = document.getElementById("comprobantef").value;

    // Crear un nuevo objeto FormData
    const formData = new FormData();
    formData.append("carrito", JSON.stringify(carrito));

    formData.append("nombre", nombre);
    formData.append("telefono", telefono);
    formData.append("email", email);
    formData.append("direccion", provincia + " " + canton + " " + direccion);

    formData.append("total", SUBTOTAL);
    formData.append("cenvio", CENVIO);
    formData.append("ci", ci);
    let isEnvio = 1;
    if (idEnvio === 1) {
      isEnvio = 0;
    }
    formData.append("isenvio", isEnvio);

    formData.append("metodo_pago", metodoDePago);

    formData.append("ncomprobante", comprobante);
    formData.append("comprobante", comprobantef);
    // Realizar alguna acción, como enviar los datos al servidor
    enviarDatosAlServidor(formData);
  }

  function enviarDatosAlServidor(formData) {
    // Aquí puedes enviar los datos al servidor utilizando AJAX, Fetch, etc.
    // Por ejemplo, usando Fetch:
    fetch("../../controllers/router.php?op=insertVentaClient", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        console.log(response);
        if (response.ok) {
          swal("Excelente!", "Transaccion realizada con exito", "success");
        }
      })
      .catch((error) => {
        console.error("Error al enviar los datos:", error);
      });
  }
  async function reloadSection() {
    try {
      miTabla.clear().draw(); // Limpiar la tabla antes de insertar nuevos datos

      const response = await fetch(
        "../../controllers/router.php?op=getWishClient"
      );
      data = await response.json();
      console.log(data);
      miTabla.rows.add(data).draw();
    } catch (error) {
      console.error("Error al obtener productos:", error);
    }
  }

  $(document).on("click", ".btnEliminar", function () {
    var id = $(this).data("id");
    const formData = new FormData();
    formData.append("id", id);
    fetch("../../controllers/router.php?op=deleteWishClient", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        console.log(response);
        if (response.ok) {
          swal("Excelente!", "Transaccion realizada con exito", "success");
        }
      })
      .catch((error) => {
        console.error("Error al enviar los datos:", error);
      });
  });

  $(document).on("click", ".btnSumar", async function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    let cart = JSON.parse(localStorage.getItem("cart"));
    let producto = cart.find((producto) => producto.id === id);
    if (producto) {
      producto.cantidad++;

      const stockActual = await getPrecioShop(
        producto.producto_id,
        producto.color_id,
        producto.talla_id
      );
      // console.log(producto);
      console.log(stockActual);

      if (stockActual > producto.cantidad) {
        localStorage.setItem("cart", JSON.stringify(cart));
        reloadCart();
        reloadSection();
      } else {
        producto.cantidad = stockActual;
        localStorage.setItem("cart", JSON.stringify(cart));
        reloadCart();
        reloadSection();
      }
    }
  });
  $(document).on("click", ".btnRestar", function () {
    var id = $(this).data("id");
    let cart = JSON.parse(localStorage.getItem("cart"));
    let producto = cart.find((producto) => producto.id === id);
    if (producto) {
      const cantidad = producto.cantidad--;
      if (cantidad < 2) {
        producto.cantidad = 1;
      }
      localStorage.setItem("cart", JSON.stringify(cart));
      reloadCart();
      reloadSection();
    }
  });

  async function getPrecioShop(prod_id, talla_id, color_id) {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getPrecioShop&prod_id=" +
          prod_id +
          "&talla_id=" +
          talla_id +
          "&color_id=" +
          color_id
      );
      if (!response.ok) {
        throw new Error(
          "Hubo un problema al obtener los detalles del producto."
        );
      }
      const productos = await response.json();
      console.log(productos[0]);
      if (productos.length > 0) {
        const producto = productos[0];
        return producto.stock;
      } else {
        return 0;
      }
    } catch (error) {
      console.log(error);
      return 0;
    }
  }
});
