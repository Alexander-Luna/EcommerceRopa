document.addEventListener("DOMContentLoaded", async function () {
  document
    .getElementById("btnGuardar")
    .addEventListener("click", function () {});

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
    dom: false, // Agregar los botones de descarga

    lengthChange: false,
    columns: [
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
      { data: "descripcion", title: "Descripción" },
      { data: "talla", title: "Talla" },
      { data: "ocasion", title: "Ocasión" },
      { data: "color", title: "Color" },
      { data: "genero", title: "Género" },
      { data: "stock_total", title: "Stock" },
      {
        data: "precio_promedio",
        title: "Precio",
        render: function (data, type, row) {
          return "$" + parseFloat(data).toFixed(2);
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
    document.getElementById("guia_serv").value = rowData.guia_servi;
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

  function reloadSection() {
    try {
      fetch("../../controllers/router.php?op=getProductsVenta&id=" + id).then(
        (response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles de las ventas."
            );
          }
          response.json().then((data) => {
            miTabla.clear().draw();
            miTabla.rows.add(data).draw();
            console.log(data);
          });
        }
      );
    } catch (error) {
      console.error("Error al obtener los detalles de las ventas:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});
