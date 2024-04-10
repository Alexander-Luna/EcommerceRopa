document.addEventListener("DOMContentLoaded", async function () {
  document
    .getElementById("miformulario")
    .addEventListener("submit", function (event) {
      event.preventDefault(); // Evitar que el formulario se envíe automáticamente
      try {
        const formData = new FormData(this); // Pasar el formulario actual como argumento

        fetch("../../controllers/router.php?op=getReporteVentas", {
          method: "POST", // Cambiar a POST si quieres enviar datos de formulario
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error(
                "Hubo un problema al obtener los detalles del talla."
              );
            }
            response.json().then((data) => {
              // Aquí manejas la respuesta como lo necesites
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
    lengthChange: false,
    columns: [
      { data: "fecha", title: "Fecha" }, 
      {
        title: "Sub Total",
        render: function (data, type, row) {
          var subtotal = parseInt(row.stock) * parseFloat(row.costo);
          return subtotal.toFixed(2); 
        },
      },
      {
        title: "Envió",
        render: function (data, type, row) {
          var subtotal = parseFloat(row.envio);
          return subtotal.toFixed(2);
        },
      },
      {
        title: "Total",
        render: function (data, type, row) {
          var subtotal = parseInt(row.total) + parseFloat(row.envio);
          return subtotal.toFixed(2); 
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
