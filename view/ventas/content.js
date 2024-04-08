document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertar cuando se hace clic en el botón
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
    columns: [
      { data: "nombre_usuario", title: "Cliente" },
      { data: "nombre_recibe", title: "Receptor" },
      {
        data: "metodo_pago",
        title: "Metodo de Pago",
        render: function (data, type, row) {
          return data === 0 ? "Pago en Oficina" : data === 1 ? "Deposito" : data === 2 ? "Transferencia" : "Método de pago inválido";

        },
      },
      {
        data: "est_pago",
        title: "Estado de la venta",
        render: function (data, type, row) {
          return data === 0 ? "Pendiente" : data === 1 ? "Pagado" : data === 2 ? "Entregada" : "inválido";

        },
      },
      { data: "fecha", title: "Fecha" },
      {
        data: null,
        title: "Acciones",
        render: function (data, type, row) {
          return `
          <button type="button" class="btn btn-outline-success btnView" data-id="${row.id}">
                    <i class="fa fa-eye" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-outline-info btnDownload" data-id="${row.id}">
                    <i class="fa fa-download" aria-hidden="true"></i></button>
          <button type="button" class="btn btn-outline-warning btnEditar" data-id="${row.id}">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });

  $(document).on("click", ".btnView", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var ventaId = rowData.id; // Suponiendo que el ID de la venta está en la propiedad "id" de los datos de la fila

    // Redireccionar a la página ventas-details con el ID de la venta como parámetro
    window.location.href = "../ventas-details/index.php?id=" + ventaId;
  });
  $(document).on("click", ".btnDownload", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();

    // Crear un enlace de descarga
    var link = document.createElement("a");
    link.href = rowData.comprobante; // Establecer la URL de descarga como la URL de la imagen
    link.download = "comprobante.webp"; // Establecer el nombre de archivo de descarga
    link.target = "_blank"; // Abrir en una nueva ventana

    // Simular un clic en el enlace para iniciar la descarga
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link); // Eliminar el enlace después de la descarga para evitar desorden en el DOM
  });

  // Manejador de eventos para el botón de editar
  $(document).on("click", ".btnEditar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");
    document.getElementById("title").textContent = "Editar Venta";
    document.getElementById("id").value = rowData.id;
    document.getElementById("idcli").value = rowData.idcli;
    document.getElementById("idPago").value = rowData.idPago;
    document.getElementById("metodo_pago").value = rowData.metodo_pago;
    document.getElementById("fecha").value = rowData.fecha;
  });

  // Manejador de eventos para el botón de eliminar
  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var formData = new FormData();
    formData.append("id", rowData.id);
    fetch("../../controllers/router.php?op=deleteVenta", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          swal(
            "Ups! Algo salió mal!",
            "La acción no se pudo realizar correctamente!",
            "error"
          );
          throw new Error("Hubo un problema al eliminar la venta.");
        }
        console.log(response);
        $("#miModal").modal("hide");
        swal(
          "En Hora Buena!",
          "La acción se realizó de manera exitosa!",
          "success"
        );
        reloadSection();
      })
      .catch((error) => {
        swal(
          "Ups! Algo salió mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        console.error("Error al eliminar la venta:", error);
      });
  });

  function insertar() {
    try {
      // Obtener los datos del formulario
      const id = document.getElementById("id").value;
      const idcli = document.getElementById("idcli").value;
      const idPago = document.getElementById("idPago").value;
      const metodo_pago = document.getElementById("metodo_pago").value;
      const fecha = document.getElementById("fecha").value;

      // Crear un objeto FormData para enviar los datos al servidor
      const formData = new FormData();
      formData.append("idcli", idcli);
      formData.append("idPago", idPago);
      formData.append("metodo_pago", metodo_pago);
      formData.append("fecha", fecha);

      if (id === "") {
        // Realizar la solicitud POST al servidor para insertar la nueva venta
        fetch("../../controllers/router.php?op=insertVenta", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              swal(
                "Ups! Algo salió mal!",
                "La acción no se pudo realizar correctamente!",
                "error"
              );
              throw new Error("Hubo un problema al insertar la nueva venta.");
            }
            console.log(response);
            // Si la inserción fue exitosa, recargar la sección
            $("#miModal").modal("hide");
            swal(
              "En Hora Buena!",
              "La acción se realizó de manera exitosa!",
              "success"
            );
            reloadSection();
          })
          .catch((error) => {
            swal(
              "Ups! Algo salió mal!",
              "La acción no se pudo realizar correctamente!",
              "error"
            );
            console.error("Error al insertar la nueva venta:", error);
          });
      } else {
        formData.append("id", id);
        fetch("../../controllers/router.php?op=updateVenta", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              swal(
                "Ups! Algo salió mal!",
                "La acción no se pudo realizar correctamente!",
                "error"
              );
              throw new Error("Hubo un problema al actualizar la venta.");
            }
            console.log(response);
            $("#miModal").modal("hide");
            swal(
              "En Hora Buena!",
              "La acción se realizó de manera exitosa!",
              "success"
            );
            reloadSection();
          })
          .catch((error) => {
            console.error("Error al actualizar la venta:", error);
            swal(
              "Ups! Algo salió mal!",
              "La acción no se pudo realizar correctamente!",
              "error"
            );
          });
      }
    } catch (error) {
      console.error("Error al obtener los datos del formulario:", error);
      swal(
        "Ups! Algo salió mal!",
        "La acción no se pudo realizar correctamente!",
        "error"
      );
    }
  }

  function reloadSection() {
    try {
      fetch("../../controllers/router.php?op=getVentas").then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los detalles de las ventas."
          );
        }
        response.json().then((data) => {
          miTabla.clear().draw();
          miTabla.rows.add(data).draw();
        });
      });
    } catch (error) {
      console.error("Error al obtener los detalles de las ventas:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});
