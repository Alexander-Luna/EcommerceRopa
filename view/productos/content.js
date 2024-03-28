document.addEventListener("DOMContentLoaded", async function () {
  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    columns: [
      { data: "nombre" },
      { data: "descripcion" },
      { data: "precio" },
      { data: "existencia" },
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
      { data: "id_categoria" },
      { data: "talla" },
      { data: "color" },
      { data: "tipo" },
      {
        data: null,
        render: function (data, type, row) {
          return (
            '<button type="button" class="btn btn-outline-warning" onclick="editar(' +
            row.id +
            ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button type="button" class="btn btn-outline-danger"onclick="Eliminar(' +
            row.id +
            ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
          );
        },
      },
    ],
  });

  // Cargar los datos al cargar la página
  reloadSection();
  function reloadSection() {
    try {
      fetch("../../controllers/router.php?op=getProducts").then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los detalles del producto."
          );
        }
        response.json().then((data) => {
          miTabla.clear().draw();
          miTabla.rows.add(data).draw(); // Aquí se modificó para agregar los datos directamente
        });
      });
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }


  // $(document).ready(function () {
  //   // Manejar el clic en los botones de activar/desactivar
  //   $(".btn-activar").click(function () {
  //     var productoId = $(this).data("producto-id");
  //     $.ajax({
  //       type: "POST",
  //       url: "activar_desactivar_producto.php",
  //       data: { productoId: productoId },
  //       success: function (response) {
  //         if (response === "Éxito") {
  //           // Actualizar el estado del botón
  //           var btn = $('.btn-activar[data-producto-id="' + productoId + '"]');
  //           if (btn.hasClass("btn-success")) {
  //             btn
  //               .removeClass("btn-success")
  //               .addClass("btn-warning")
  //               .text("Desactivar");
  //           } else {
  //             btn
  //               .removeClass("btn-warning")
  //               .addClass("btn-success")
  //               .text("Activar");
  //           }
  //         } else {
  //           // Manejar errores si es necesario
  //           console.log("Error al activar/desactivar producto: " + response);
  //         }
  //       },
  //     });
  //   });
  // });
});
