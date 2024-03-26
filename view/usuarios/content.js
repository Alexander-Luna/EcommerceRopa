document.addEventListener("DOMContentLoaded", async function () {
    const miTabla = $("#miTabla").DataTable({
      columns: [
        { data: "email" },
        { data: "nombre" },
        {
          data: null,
          render: function (data, type, row) {
            // Aquí puedes personalizar las acciones según tus necesidades
            return (
              '<button onclick="editarUsuario(' +
              row.id +
              ')">Editar</button>'
            );
          },
        },
      ],
    });
  
    reloadSection();
  
    function reloadSection() {
      try {
        fetch("../../controllers/router.php?op=getAllUsers").then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          response.json().then((data) => {
            // Limpiar los datos existentes en la tabla
            miTabla.clear().draw();
  
            // Agregar los nuevos datos a la tabla
            miTabla.rows.add(data).draw();
          });
        });
      } catch (error) {
        console.error("Error al obtener los detalles del producto:", error);
      }
    }
  });
  