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
                if (venta.est === 1) {
                  total_pendiente += venta.total;
                } else {
                  total_entregado += venta.total;
                }
              });

              document.getElementById("total_p").textContent =
                "$" + parseFloat(total_pendiente).toFixed(2);
              document.getElementById("total_e").textContent =
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
        data: "est",
        title: "Estado",
        render: function (data, type, row) {
          return data === 0 ? "Pendiente" : "Entregada";
        },
      },
      {
        data: null,
        title: "Acciones",
        render: function (data, type, row) {
          return `<button type="button" class="btn btn-outline-warning btnEditar" data-id="${row.id}">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });
});
