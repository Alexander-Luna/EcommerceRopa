document.addEventListener("DOMContentLoaded", async function () {
  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
      buttons: {
        copy: "Copiar",
        colvis: "Visibilidad",
        print: "Imprimir",
        excel: "Exportar a Excel",
        pdf: "Exportar a PDF",
      },
    },
    columns: [
      { data: "nombre", title: "Nombre" },
      { data: "stock", title: "Stock" },

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
        data: "stock",
        render: function (data, type, row) {
          return data > 0 ? "Disponible" : "Agotado";
        },
        title: "Estado",
      },
      { data: "nombre_proveedor", title: "Proveedor" },
    ],
    createdRow: function (row, data, dataIndex) {
      $("td:eq(2)", row).on("click", function () {
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

  document
    .getElementById("EnviarMensaje")
    .addEventListener("click", async function () {
      try {
        var tableData = miTabla.rows().data().toArray();
        var productosConCantPredMayorA0 = tableData.filter(function (producto) {
          return producto.cant_pred > 0;
        });
        //console.log(JSON.stringify({ productos: productosConCantPredMayorA0 }));
        var response = await fetch(
          "../../controllers/router.php?op=send_alerta_whatsapp",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ productos: productosConCantPredMayorA0 }),
          }
        );
        if (response.ok) {
          swal(
            "Mensajes Enviados",
            "Exito al enviar los mensajes:!",
            "success"
          );
          console.log("Entraaa ");
          console.log(response);
        } else {
          const errorMessage = await response.text();
          throw new Error("Error al enviar los mensajes: " + errorMessage);
        }
      } catch (error) {
        console.error("Error al enviar los mensajes:", error);
        swal("Error", error.message, "error");
      }

      // var tableData = miTabla.rows().data().toArray();
      // var productosConCantPredMayorA0 = tableData.filter(function (producto) {
      //   return producto.cant_pred > 0;
      // });
      // productosConCantPredMayorA0.forEach(function (producto) {
      //   var mensaje =
      //     "¡Hola! Me interesa comprar " +
      //     producto.cant_pred +
      //     " " +
      //     producto.nombre +
      //     " " +
      //     producto.talla +
      //     " " +
      //     producto.color +
      //     " " +
      //     " de " +
      //     producto.genero +
      //     ". ¿Podrías enviarme más información?";
      //   var telefono = producto.telefono;
      //   var enlaceWhatsApp =
      //     "https://api.whatsapp.com/send?phone=" +
      //     telefono +
      //     "&text=" +
      //     encodeURIComponent(mensaje);
      //   window.open(enlaceWhatsApp);
      // });
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

      // Limpiar los datos existentes en la tabla
      miTabla.clear().draw();

      // Agregar los nuevos datos a la tabla
      miTabla.rows.add(data).draw();
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
