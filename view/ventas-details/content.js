document.addEventListener("DOMContentLoaded", async function () {
  $("#miTabla").DataTable({
    lengthChange: false,
columns: [
      { data: "nombre_producto" },
      {
        data: "imagen",
        render: function (data, type, row) {
          return (
            '<img src="' + data + '" alt="Producto" style="width: 100px;">'
          );
        },
      },
      { data: "cantidad" },
      { data: "precio_unitario" },
      { data: "total_producto" },
      { data: "color" },
      { data: "talla" },
    ],
  });

  // Función para recargar la sección con los detalles de las ventas
  function reloadSection() {
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get("id");
    if (id !== null) {
      fetch("../../controllers/router.php?op=getDetalleVentas&id="+id)
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles de las ventas. Código: " +
                response.status
            );
          }
          return response.json();
        })
        .then((data) => {
          $("#miTabla").DataTable().clear().rows.add(data).draw();
        })
        .catch((error) => {
          console.error("Error al obtener los detalles de las ventas:", error);
          swal(
            "Ups! Algo salió mal!",
            "La acción no se pudo realizar correctamente!",
            "error"
          );
        });
    } else {
      console.log("No se ha pasado ningún valor para 'id'");
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
  calcularSubtotal();
  function calcularSubtotal() {
    var subtotal = 0;

    // Iterar sobre los datos de la tabla para sumar los valores de total_producto
    var tableData = $("#miTabla").DataTable().data();
    tableData.each(function (dataRow) {
      subtotal += parseFloat(dataRow.total_producto);
    });

    // Actualizar el elemento HTML del subtotal
    $("#subTotal").text("$" + subtotal.toFixed(2));

    // Actualizar el elemento HTML del total sumando el subtotal y el envío
    var envio = 10; // Valor fijo de envío
    var total = subtotal + envio;
    $("#total").text("$" + total.toFixed(2));
  }
});
