document.addEventListener("DOMContentLoaded", async function () {
  let total_entregado = 0,
    total_pendiente = 0;
  document
    .getElementById("miformulario")
    .addEventListener("submit", function (event) {
      event.preventDefault(); // Evitar que el formulario se envíe automáticamente

      try {
        const fechaIni = document.getElementById("fecha_ini").value;
        const fechaFin = document.getElementById("fecha_fin").value;

        fetch(
          "../../controllers/router.php?op=getReporteVentas&fecha_ini=" +
            fechaIni +
            "&fecha_fin=" +
            fechaFin,
          {
            method: "GET",
          }
        )
          .then((response) => {
            if (!response.ok) {
              throw new Error(
                "Hubo un problema al obtener los detalles del talla."
              );
            }
            response.json().then((data) => {
              total_entregado = 0;
              total_pendiente = 0;
              data.forEach((venta) => {
                if (venta.est_pago === 1) {
                  total_pendiente += venta.total;
                } else if (venta.est_pago === 2) {
                  total_entregado += venta.total;
                }
              });

              document.getElementById("total_pv").textContent =
                "$" + parseFloat(total_pendiente).toFixed(2);
              document.getElementById("total_ev").textContent =
                "$" + parseFloat(total_entregado).toFixed(2);

              miTabla.clear().draw();
              miTabla.rows.add(data).draw();
            });
          })
          .catch((error) => {
            // Manejo de errores
            console.error(error);
          });
      } catch (error) {
        // Manejo de errores
        console.error(error);
      }
    });

  // Inicializar DataTables
  let miTabla = $("#miTabla").DataTable({
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
    columns: [
      {
        title: "Fecha",
        render: function (data, type, row) {
          return row.fecha;
        },
      },
      {
        title: "Sub Total",
        render: function (data, type, row) {
          return parseInt(row.total).toFixed(2);
        },
      },
      {
        title: "Envió",
        render: function (data, type, row) {
          let subtotal = parseFloat(row.envio);
          return subtotal.toFixed(2);
        },
      },
      {
        title: "Total",
        render: function (data, type, row) {
          let subtotal = parseInt(row.total) + parseFloat(row.envio);
          return subtotal.toFixed(2);
        },
      },
      {
        data: "est_pago",
        title: "Estado",
        render: function (data, type, row) {
          return data === 0 ? "Pendiente" : "Enviada";
        },
      },
      {
        data: null,
        title: "Acciones",
        render: function (data, type, row) {
          return `<button type="button" title="Ver Venta" class="btn btn-outline-info btnVer" data-id="${row.id}">
          <i class="fa fa-shopping-bag" aria-hidden="true"></i></button>
                <button type="button" title="Descargar" class="btn btn-outline-danger btnDescargar" data-id="${row.id}">
                <i class="fa fa-download" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });
  $(document).on("click", ".btnVer", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var id = rowData.id;
    reloadModalInfo(id);
    $("#miModal").modal("show");
    document.getElementById("id_v").value = id;
  });
  var miTablaM = $("#miTablaM").DataTable({
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
    dom: false,
    lengthChange: false,
    searching: false,
    autoWidth: true,
    paging: false, // Desactiva la paginación
    columns: [
      { data: "producto", title: "Producto" },
      { data: "desc_producto", title: "Descripción" },
      { data: "talla", title: "Talla" },
      { data: "color", title: "Color" },
      { data: "cantidad", title: "Cantidad" },
      {
        data: "precio",
        title: "Precio Unidad",
        render: function (data, type, row) {
          return "$" + parseFloat(data).toFixed(2);
        },
      },
      {
        data: null,
        title: "Total",
        render: function (data, type, row) {
          return "$" + parseFloat(row.precio * row.cantidad).toFixed(2);
        },
      },
    ],
  });

  async function reloadModalInfo(id) {
    try {
      document.getElementById("btnPdf").addEventListener("click", function () {
        var link = document.createElement("a");
        link.href = comprobanteF;
        link.download = "comprobante.png";
        link.target = "_blank";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      });
      // Obtener detalles del cliente
      const clienteResponse = await fetch(
        "../../controllers/router.php?op=getClienteVenta&id=" + id
      );
      if (!clienteResponse.ok) {
        throw new Error(
          "Hubo un problema al obtener los detalles del cliente."
        );
      }
      const clienteData = await clienteResponse.json();
      const cliente = clienteData[0];
      let comprobanteF = cliente.comprobante;
      // Mostrar detalles del cliente
      document.getElementById("cliente").textContent = cliente.name_client;
      document.getElementById("direccion").textContent =
        cliente.provincia +
        " " +
        cliente.canton +
        " " +
        cliente.direccion +
        " " +
        cliente.referencia;
      document.getElementById("recibe").textContent = cliente.nombre;
      document.getElementById("fecha").textContent = cliente.fecha;
      document.getElementById("telefono").textContent = cliente.telefono;
      document.getElementById("guia_serv").textContent = cliente.guia_servi;
      document.getElementById("est").textContent =
        cliente.est === 2
          ? "Enviada"
          : cliente.est === 1
          ? "Pagada"
          : "Pendiente";
      document.getElementById("total_p").textContent = cliente.total;
      document.getElementById("total_e").textContent = cliente.envio;

      // Obtener detalles de los productos
      const productosResponse = await fetch(
        "../../controllers/router.php?op=getProductsVentaAdmin&id=" + id
      );
      if (!productosResponse.ok) {
        throw new Error(
          "Hubo un problema al obtener los detalles de los productos."
        );
      }
      const productosData = await productosResponse.json();

      miTablaM.clear().draw();
      miTablaM.rows.add(productosData).draw();

      console.log(clienteData, productosData);
    } catch (error) {
      console.error("Error al cargar la información del modal:", error);
    }
  }

  $(document).on("click", ".btnDescargar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    fetch("../../controllers/router.php?op=getVentaUser&id=" + rowData.id, {
      method: "GET",
    })
      .then((response) => {
        if (!response.ok) {
          swal(
            "Ups! Algo salió mal!",
            "La acción no se pudo realizar correctamente!",
            "error"
          );
          throw new Error("Hubo un problema al obtener el PDF.");
        }
        return response.blob(); // Convertir la respuesta en un blob
      })
      .then((blob) => {
        const url = window.URL.createObjectURL(blob);
        const currentDate = new Date();
        const formattedDate = currentDate
          .toISOString()
          .slice(0, 19)
          .replace(/[-T]/g, "")
          .replace(":", "")
          .replace(":", "");
        const fileName = `ventas_${formattedDate}.pdf`;
        const a = document.createElement("a");
        a.href = url;
        a.download = fileName;
        a.click();
        swal({
          title: "¡En Hora Buena!",
          text: "¡La acción se realizó de manera exitosa!",
          icon: "success",
          timer: 1000, // tiempo en milisegundos
          buttons: false, // ocultar botones
        });
      })
      .catch((error) => {
        swal(
          "Ups! Algo salió mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        console.error("Error al obtener el PDF:", error);
      });
  });
});
