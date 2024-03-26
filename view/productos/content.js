document.addEventListener("DOMContentLoaded", async function () {
  reloadSection();
  function reloadSection() {
    try {
      const nVentas = document.getElementById("numVentas");
      const nClientes = document.getElementById("numClientes");

      fetch("../../controllers/router.php?op=getEstadisticas").then(
        (response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          response.json().then((data) => {
            nVentas.textContent = data.numVentasSemana;
            nClientes.textContent = data.numClientes;
          });
        }
      );
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  $(document).ready(function () {
    // Manejar el clic en los botones de activar/desactivar
    $(".btn-activar").click(function () {
      var productoId = $(this).data("producto-id");
      $.ajax({
        type: "POST",
        url: "activar_desactivar_producto.php",
        data: { productoId: productoId },
        success: function (response) {
          if (response === "Éxito") {
            // Actualizar el estado del botón
            var btn = $('.btn-activar[data-producto-id="' + productoId + '"]');
            if (btn.hasClass("btn-success")) {
              btn
                .removeClass("btn-success")
                .addClass("btn-warning")
                .text("Desactivar");
            } else {
              btn
                .removeClass("btn-warning")
                .addClass("btn-success")
                .text("Activar");
            }
          } else {
            // Manejar errores si es necesario
            console.log("Error al activar/desactivar producto: " + response);
          }
        },
      });
    });
  });
});
