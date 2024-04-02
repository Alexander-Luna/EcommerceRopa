document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertSlider cuando se hace clic en el botón
  });

  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    columns: [
      { data: "titulo" },
      { data: "descripcion" },
      {
        data: "img",
        title: "Imagen",
        render: function (data, type, row) {
          if (data) {
            return (
              '<img src="' +
              data +
              '" alt="Producto" style="max-width: 100px; max-height: 100px;"></img>'
            );
          } else {
            return '<img src="../../public/images/products/defaultprod.png" alt="Slider" style="max-width: 100px; max-height: 100px;"></img>';
          }
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          return `<button type="button" class="btn btn-outline-warning" onclick="${editarRow(
            row
          )}">
                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                  <button type="button" class="btn btn-outline-danger" onclick="${Eliminar(
                    row
                  )}">
                  <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });

  function editarRow(row) {
    console.log("Entra");
    // Asignar los valores del objeto row a los elementos del modal
    $("#exampleModal").modal("show");
    document.getElementById("id").value = row.id;
    document.getElementById("titulo").value = row.titulo;
    document.getElementById("descripcion").value = row.descripcion;
  }
  function insertar() {
    try {
    // Obtener los datos del formulario
      const id = document.getElementById("id").value;
      const titulo = document.getElementById("titulo").value;
      const descripcion = document.getElementById("descripcion").value;
      const imagen = document.getElementById("imagen").files[0];

      // Crear un objeto FormData para enviar los datos al servidor
      const formData = new FormData();
      formData.append("titulo", titulo);
      formData.append("descripcion", descripcion);
      formData.append("img", imagen);

      if (id === "") {
        // Realizar la solicitud POST al servidor para insertar el nuevo slider
        fetch("../../controllers/router.php?op=insertSlider", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Hubo un problema al insertar el nuevo slider.");
            }
            console.log(response);
            // Si la inserción fue exitosa, recargar la sección
            $("#exampleModal").modal("hide");
            reloadSection();
          })
          .catch((error) => {
            console.error("Error al insertar el nuevo slider:", error);
          });
      } else {
        formData.append("id", id);
        // Realizar la solicitud POST al servidor para insertar el nuevo slider
        fetch("../../controllers/router.php?op=updateSlider", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Hubo un problema al insertar el nuevo slider.");
            }
            console.log(response);
            // Si la inserción fue exitosa, recargar la sección
            $("#exampleModal").modal("hide");
            reloadSection();
          })
          .catch((error) => {
            console.error("Error al insertar el nuevo slider:", error);
          });
      }
    } catch (error) {
      console.error("Error al obtener los datos del formulario:", error);
    }
  }

  function actualizar(data) {
    $("#exampleModal").modal("hide");
  }

  function Eliminar(data) {
    $("#exampleModal").modal("show");
  }
  function reloadSection() {
    try {
      fetch("../../controllers/router.php?op=getAllSliders").then(
        (response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          response.json().then((data) => {
            miTabla.clear().draw();
            miTabla.rows.add(data).draw(); // Aquí se modificó para agregar los datos directamente
          });
        }
      );
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});
