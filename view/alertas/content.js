document.addEventListener("DOMContentLoaded", async function () {
 // Inicializar DataTables
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
    search: "Buscar:",
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
  dom: "Bfrtip", // Agregar los botones de descarga
  buttons: [
    "copyHtml5", // Botón de copiar
    "excelHtml5", // Botón de Excel
    "csvHtml5", // Botón de CSV
    "pdfHtml5", // Botón de PDF
  ],
  lengthChange: false,
  select: {
    style: "multi",
    selector: 'td:first-child input[type="checkbox"]',
  },
  columns: [
    {
      data: null,
      title: "",
      render: function (data, type, row) {
        return '<input type="checkbox">';
      },
    },
    { data: "nombre_producto", title: "Nombre" },
    { data: "talla", title: "Talla" },
    { data: "color", title: "Color" },
    { data: "total_stock", title: "Stock" },
    { data: "cant_pred", title: "Cantidad Pre-Compra" },
    {
      data: "imagen",
      title: "Imagen",
      render: function (data, type, row) {
        if (data) {
          return (
            '<img src="' +
            data +
            '" alt="Producto" style="max-width: 100px; max-height: 100px;">'
          );
        } else {
          return '<img src="../../public/images/products/defaultprod.png" alt="Producto por defecto" style="max-width: 100px; max-height: 100px;">';
        }
      },
    },
    {
      data: "total_stock",
      render: function (data, type, row) {
        return data > 0 ? "Disponible" : "Agotado";
      },
      title: "Estado",
    },
  ],
  createdRow: function (row, data, dataIndex) {
    $("td:eq(5)", row).on("click", function () {
      var cantidad = data.cant_pred;
      var input = $('<input type="number" value="' + cantidad + '">');
      $(this).html(input);
      input.on("keydown", function (e) {
        if (e.keyCode === 13) {
          var nuevaCantidad = $(this).val();
          data.cant_pred = nuevaCantidad;
          miTabla.row($(this).closest("tr")).data(data).draw();
        }
      });
      input.select();
    });
  },
});

// Función para marcar los checkboxes basados en las filas seleccionadas
function marcarCheckboxes() {
  var rows = miTabla.rows({ selected: true }).nodes(); // Obtener todas las filas seleccionadas
  $('input[type="checkbox"]', rows).prop("checked", true); // Marcar los checkboxes de las filas seleccionadas
}

// Crear un evento para el dibujo completo de la tabla
miTabla.on("draw.dt", function () {
  marcarCheckboxes(); // Llamar a la función para marcar los checkboxes
});

// Configurar la cabecera para el checkbox "Seleccionar todo"
$("#miTabla thead th:first-child").html(
  '<input type="checkbox" id="select-all-checkbox">'
);

// Crear un evento para el checkbox "Seleccionar todo"
$("#select-all-checkbox").on("click", function () {
  var rows = miTabla.rows({ search: "applied" }).nodes(); // Obtener todas las filas de la tabla
  $('input[type="checkbox"]', rows).prop("checked", this.checked); // Marcar/desmarcar los checkboxes de todas las filas
});

// Crear un evento para la selección/deselección de una fila
miTabla.on("select.dt deselect.dt", function () {
  marcarCheckboxes(); // Llamar a la función para marcar los checkboxes
});


// Agregar el checkbox "Seleccionar todo" en el encabezado de la tabla
$("#miTabla thead th:first-child").html(
  '<input type="checkbox" id="select-all-checkbox">'
);

// Evento para seleccionar/deseleccionar todas las filas
$("#select-all-checkbox").on("click", function () {
  var rows = miTabla.rows({ search: "applied" }).nodes();
  $('input[type="checkbox"]', rows).prop("checked", this.checked);
});
  document
    .getElementById("EnviarMensaje")
    .addEventListener("click", async function () {
      try {
        var selectedRows = miTabla.rows({ selected: true }).data().toArray();
        if (selectedRows.length === 0) {
          throw new Error("Por favor seleccione al menos un producto.");
        }

        var productosConCantPredMayorA0 = selectedRows.filter(function (
          producto
        ) {
          return producto.cant_pred > 0;
        });
        if (productosConCantPredMayorA0.length === 0) {
          throw new Error(
            "Ningún producto seleccionado tiene una cantidad predeterminada mayor a 0."
          );
        }
        var idProveedor = document.getElementById("id_proveedor").value;
        if (!idProveedor) {
          throw new Error("Por favor seleccione un proveedor.");
        }
        console.log(idProveedor);
        var dataToSend = {
          productos: productosConCantPredMayorA0,
          id_proveedor: idProveedor,
        };
        var response = await fetch(
          "../../controllers/router.php?op=send_alerta_whatsapp",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(dataToSend),
          }
        );

        if (response.ok) {
          swal(
            "Mensajes Enviados",
            "Exito al enviar los mensajes:!",
            "success"
          );
        } else {
          const errorMessage = await response.text();
          throw new Error("Error al enviar los mensajes: " + errorMessage);
        }
      } catch (error) {
        console.error("Error al enviar los mensajes:", error);
        swal("Error", error.message, "error");
      }
    });

  reloadSection();

  async function reloadSection() {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductsAlert"
      );
      if (!response.ok) {
        throw new Error(
          "Hubo un problema al obtener los detalles del producto."
        );
      }
      const data = await response.json();
      console.log(data);
      const newData = data.map((item) => ({ ...item, cant_pred: 0 }));
      miTabla.clear().draw();
      miTabla.rows.add(newData).draw();
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  // Función para actualizar la cantidad
  function updateCantidad(id_producto, cantidad) {
    // Aquí puedes realizar la lógica para actualizar la cantidad en el servidor
    console.log(
      `Actualizar cantidad para el producto ${id_producto} a ${cantidad}`
    );
  }
});
