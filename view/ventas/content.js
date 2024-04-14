document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertar cuando se hace clic en el botón
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
      { data: "nombre_usuario", title: "Cliente" },
      { data: "nombre_recibe", title: "Receptor" },
      {
        data: "metodo_pago",
        title: "Metodo de Pago",
        render: function (data, type, row) {
          return data === 0
            ? "Pago en Oficina"
            : data === 1
            ? "Deposito"
            : data === 2
            ? "Transferencia"
            : "Método de pago inválido";
        },
      },
      {
        data: "est_pago",
        title: "Estado de la venta",
        render: function (data, type, row) {
          return data === 0
            ? "Pendiente"
            : data === 1
            ? "Pagado"
            : data === 2
            ? "Entregada"
            : "inválido";
        },
      },
      { data: "fecha", title: "Fecha" },
      {
        data: "total",
        title: "Total",
        render: function (data, type, row) {
          return "$" + data;
        },
      },
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
        reloadSection();
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

  $(document).on("click", ".btnDownload", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var link = document.createElement("a");
    link.href = rowData.comprobante;
    link.download = "comprobante.webp";
    link.target = "_blank";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  });

  $(document).on("click", ".btnEditar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");
    console.log(rowData);
    document.getElementById("title").textContent = "Editar Venta";
    document.getElementById("id").value = rowData.id;
    document.getElementById("id_cliente").value = rowData.idcli;
    document.getElementById("recibe").textContent = rowData.nombre_recibe;
    document.getElementById("cliente").textContent = rowData.nombre_usuario;
    document.getElementById("direccion").textContent = rowData.direccion_recibe;
    document.getElementById("telefono").textContent = rowData.telefono_recibe;
    document.getElementById("fecha").textContent = rowData.fecha;
    document.getElementById("est").value = rowData.est_pago;
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
      const est = document.getElementById("est").value;
      const formData = new FormData();
      formData.append("id", id);
      formData.append("est", est);

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
