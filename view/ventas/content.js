document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertar cuando se hace clic en el botón
  });

  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    columns: [
      { data: "nombre_usuario" },
      { data: "nombre_recibe" },
      { data: "comprobante" },
      {
        data: "metodo_pago",
        render: function (data, type, row) {
          return data == 1 ? "Retiro en Oficina" : "Subir Comprobante de Pago";
        },
      },
      {
        data: "est_pago",
        render: function (data, type, row) {
          if (data == 0) {
            return "Pendiente";
          } else if (data == 1) {
            return "Pagado";
          } 
        },
      },
      { data: "fecha" },
      {
        data: null,
        render: function (data, type, row) {
          return `
          <button type="button" class="btn btn-outline-success btnView" data-id="${row.id}">
                    <i class="fa fa-eye" aria-hidden="true"></i></button>
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
