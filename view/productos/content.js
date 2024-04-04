document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertar cuando se hace clic en el botón
  });

  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    columns: [
      { data: "nombre" }, // Nombre
      { data: "descripcion" }, // Descripción
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
      { data: "talla" }, // Talla
      { data: "ocasion" },
      { data: "color" }, // Color
      { data: "stock" }, // Stock
      { data: "genero" }, // Género
      {
        data: null,
        render: function (data, type, row) {
          return `<button type="button" class="btn btn-outline-warning btnEditar" data-id="${row.id}">
                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                  <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                  <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });
  // Manejador de eventos para el botón de editar
  $(document).on("click", ".btnEditar", function () {
    var dataId = $(this).data("id");
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");

    document.getElementById("title").innerHTML = "Editar Productos";
    document.getElementById("id").value = rowData.id;
    document.getElementById("titulo").value = rowData.nombre; // Modificado: Nombre
    document.getElementById("descripcion").value = rowData.descripcion; // Modificado: Descripción
  });

  // Manejador de eventos para el botón de eliminar
  $(document).on("click", ".btnEliminar", function () {
    var dataId = $(this).data("id");
    var rowData = miTabla.row($(this).closest("tr")).data();
    // Realizar la solicitud POST al servidor para eliminar el producto

    var formData = new FormData();
    formData.append("id", rowData.id);
    fetch("../../controllers/router.php?op=deleteProduct", {
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
          throw new Error("Hubo un problema al eliminar el producto.");
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
        console.error("Error al eliminar el producto:", error);
      });
  });

  function insertar() {
    try {
      // Obtener los datos del formulario
      const id = document.getElementById("id").value;
      const nombre = document.getElementById("titulo").value; // Modificado: Nombre
      const descripcion = document.getElementById("descripcion").value;
      const imagen = document.getElementById("imagen").files[0];

      // Crear un objeto FormData para enviar los datos al servidor
      const formData = new FormData();
      formData.append("nombre", nombre); // Modificado: Nombre
      formData.append("descripcion", descripcion);
      formData.append("img", imagen);

      if (id === "") {
        // Realizar la solicitud POST al servidor para insertar el nuevo producto
        fetch("../../controllers/router.php?op=insertProduct", {
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
              throw new Error(
                "Hubo un problema al insertar el nuevo producto."
              );
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
            console.error("Error al insertar el nuevo producto:", error);
          });
      } else {
        formData.append("id", id);
        fetch("../../controllers/router.php?op=updateProduct", {
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
              throw new Error("Hubo un problema al actualizar el producto.");
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
            console.error("Error al actualizar el producto:", error);
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
      fetch("../../controllers/router.php?op=getProducts").then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los detalles del producto."
          );
        }
        response.json().then((data) => {
          miTabla.clear().draw();
          miTabla.rows.add(data).draw(); // Agregar los datos directamente
        });
      });
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});
