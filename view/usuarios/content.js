document.addEventListener("DOMContentLoaded", async function () {
  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    columns: [
      { data: "email" },
      { data: "nombre" },
      {
        data: "rol_id",
        render: function (data, type, row) {
          // Si el rol_id es 1, mostrar "Administrador", de lo contrario, mostrar "Cliente"
          return data == 1 ? "Administrador" : "Cliente";
        },
      },
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

  // Cargar los datos al cargar la página
  reloadSection();
});
