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
        data: "est",
        render: function (data, type, row) {
          // Si el rol_id es 1, mostrar "Administrador", de lo contrario, mostrar "Cliente"
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
    document.getElementById("title").value = "Editar Usuario";
    $("#id").val(rowData.id);
    $("#email").val(rowData.email);
    $("#nombre").val(rowData.nombre);
    $("#direccion").val(rowData.direccion);
    $("#cedula").val(rowData.cedula);
    $("#rol_id").val(rowData.rol_id);
  });

  // Manejador de eventos para el botón de eliminar
  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var formData = new FormData();
    formData.append("id", rowData.id);
    fetch("../../controllers/router.php?op=deleteUser", {
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
          throw new Error("Hubo un problema al eliminar User.");
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
        console.error("Error al insertar el nuevo User:", error);
      });
  });
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertSlider cuando se hace clic en el botón
  });
  function insertar() {
    try {
      // Obtener los datos del formulario del modal
      const id = document.getElementById("id").value;
      const email = document.getElementById("email").value;
      const nombre = document.getElementById("nombre").value;
      const direccion = document.getElementById("direccion").value;
      const cedula = document.getElementById("cedula").value;
      const rol_id = document.getElementById("rol_id").value;

      // Crear un objeto FormData para enviar los datos al servidor
      const formData = new FormData();

      formData.append("email", email);
      formData.append("nombre", nombre);
      formData.append("direccion", direccion);
      formData.append("cedula", cedula);
      formData.append("rol_id", rol_id);

      if (id === "") {
        formData.append("pass", cedula);
        fetch("../../controllers/router.php?op=registro", {
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
              throw new Error("Hubo un problema al insertar el nuevo User.");
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
            console.error("Error al insertar el nuevo User:", error);
          });
      } else {
        formData.append("id", id);
        fetch("../../controllers/router.php?op=updateUser", {
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
              throw new Error("Hubo un problema al insertar el nuevo User.");
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
            console.error("Error al insertar el nuevo User:", error);
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
