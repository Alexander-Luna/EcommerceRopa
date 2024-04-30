document.addEventListener("DOMContentLoaded", async function () {
  reloadSection();
  function reloadSection() {
    try {
      const vMes = document.getElementById("v_mes");
      const vTotal = document.getElementById("v_total");
      const newClientes = document.getElementById("new_clientes");
  
      fetch("../../controllers/router.php?op=getEstadisticas").then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener las estadísticas.");
        }
        response.json().then((data) => {
          // Actualizar la información de las ventas mensuales
          if (data.ventasMensuales.length > 0) {
            const ventasMes = data.ventasMensuales[0];
            vMes.textContent = `$${ventasMes.ganancias}`;
          }
  
          // Actualizar la información de las ventas totales
          if (data.gananciasAnioActual.length > 0) {
            const gananciasAnioActual = data.gananciasAnioActual[0];
            vTotal.textContent = gananciasAnioActual.numVentas;
          }
  
          // Actualizar la información de nuevos clientes
          newClientes.textContent = data.numNuevosUsuarios;
        });
      });
    } catch (error) {
      console.error("Error al obtener las estadísticas:", error);
    }
  }
  

});
