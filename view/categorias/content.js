document.addEventListener("DOMContentLoaded", async function () {
  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    columns: [
      { data: "ruc" },
      { data: "nombre" },
      { data: "email" },
      { data: "telefono" },
      {
        data: "est",
        render: function (data, type, row) {
          return data == 1 ? "Activo" : "Desactivado";
        },
      },
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
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");
    document.getElementById("title").innerText = "Editar Proveedor";
    $("#id").val(rowData.id);
    $("#ruc").val(rowData.ruc);
    $("#nombre").val(rowData.nombre);
    $("#email").val(rowData.email);
    $("#telefono").val(rowData.telefono);
    $("#direccion").val(rowData.direccion);
  });

  // Manejador de eventos para el botón de eliminar
  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var formData = new FormData();
    formData.append("id", rowData.id);
    fetch("../../controllers/router.php?op=deleteProveedor", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          swal(
            "Ups! Algo salio mal!",
            "La acción no se pudo realizar correctamente!",
            "error"
          );
          throw new Error("Hubo un problema al eliminar Proveedor.");
        }
        console.log(response);
        $("#miModal").modal("hide");
        swal(
          "En Hora Buena!",
          "La accion se realizo de manera exitosa!",
          "success"
        );
        reloadSection();
      })
      .catch((error) => {
        swal(
          "Ups! Algo salio mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        console.error("Error al eliminar el Proveedor:", error);
      });
  });

  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertar cuando se hace clic en el botón
  });

  function insertar() {
    try {
      // Obtener los datos del formulario del modal
      const id = document.getElementById("id").value;
      const ruc = document.getElementById("ruc").value;
      const nombre = document.getElementById("nombre").value;
      const email = document.getElementById("email").value;
      const telefono = document.getElementById("telefono").value;
      const direccion = document.getElementById("direccion").value;

      // Crear un objeto FormData para enviar los datos al servidor
      const formData = new FormData();

      formData.append("ruc", ruc);
      formData.append("nombre", nombre);
      formData.append("email", email);
      formData.append("telefono", telefono);
      formData.append("direccion", direccion);

      if (id === "") {
        fetch("../../controllers/router.php?op=insertProveedor", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              swal(
                "Ups! Algo salio mal!",
                "La acción no se pudo realizar correctamente!",
                "error"
              );
              throw new Error(
                "Hubo un problema al insertar el nuevo Proveedor."
              );
            }
            console.log(response);
            // Si la inserción fue exitosa, recargar la sección
            $("#miModal").modal("hide");
            swal(
              "En Hora Buena!",
              "La accion se realizo de manera exitosa!",
              "success"
            );
            reloadSection();
          })
          .catch((error) => {
            swal(
              "Ups! Algo salio mal!",
              "La acción no se pudo realizar correctamente!",
              "error"
            );
            console.error("Error al insertar el nuevo Proveedor:", error);
          });
      } else {
        formData.append("id", id);
        fetch("../../controllers/router.php?op=updateProveedor", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              swal(
                "Ups! Algo salio mal!",
                "La acción no se pudo realizar correctamente!",
                "error"
              );
              throw new Error(
                "Hubo un problema al insertar el nuevo Proveedor."
              );
            }
            console.log(response);
            $("#miModal").modal("hide");
            swal(
              "En Hora Buena!",
              "La accion se realizo de manera exitosa!",
              "success"
            );
            reloadSection();
          })
          .catch((error) => {
            console.error("Error al insertar el nuevo Proveedor:", error);
            swal(
              "Ups! Algo salio mal!",
              "La accion no se pudo realizar correctamente!",
              "error"
            );
          });
      }
    } catch (error) {
      console.error("Error al obtener los datos del formulario:", error);
      swal(
        "Ups! Algo salio mal!",
        "La accion no se pudo realizar correctamente!",
        "error"
      );
    }
  }

  function reloadSection() {
    try {
      fetch("../../controllers/router.php?op=getAllProveedores").then(
        (response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del proveedor."
            );
          }
          response.json().then((data) => {
            // Limpiar los datos existentes en la tabla
            miTabla.clear().draw();
            // Agregar los nuevos datos a la tabla
            miTabla.rows.add(data).draw();
          });
        }
      );
    } catch (error) {
      console.error("Error al obtener los detalles del proveedor:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});