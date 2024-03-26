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
});
