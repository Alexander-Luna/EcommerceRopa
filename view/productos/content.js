document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertar cuando se hace clic en el botón
  });
  metodosModal();
  function metodosModal() {
    try {
      fetch("../../controllers/router.php?op=getOcasion")
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los datos de ocasión."
            );
          }
          return response.json();
        })
        .then((data) => {
          const selectOcasion = document.getElementById("id_ocasion");
          selectOcasion.innerHTML = "";
          data.forEach((ocasion) => {
            const option = document.createElement("option");
            option.value = ocasion.id;
            option.textContent = ocasion.nombre;
            selectOcasion.appendChild(option);
          });
        });

      fetch("../../controllers/router.php?op=getTipoPrenda")
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los datos de tipo de prenda."
            );
          }
          return response.json();
        })
        .then((data) => {
          const selectTipoPrenda = document.getElementById("id_tipo_prenda");
          selectTipoPrenda.innerHTML = "";
          data.forEach((tipoPrenda) => {
            const option = document.createElement("option");
            option.value = tipoPrenda.id;
            option.textContent = tipoPrenda.nombre;
            selectTipoPrenda.appendChild(option);
          });
        });

      fetch("../../controllers/router.php?op=getGenero")
        .then((response) => {
          if (!response.ok) {
            throw new Error("Hubo un problema al obtener los datos de género.");
          }
          return response.json();
        })
        .then((data) => {
          const selectGenero = document.getElementById("id_genero");
          selectGenero.innerHTML = "";
          data.forEach((genero) => {
            const option = document.createElement("option");
            option.value = genero.id;
            option.textContent = genero.nombre;
            selectGenero.appendChild(option);
          });
        });
    } catch (error) {
      console.error("Error al obtener los datos:", error);
    }
  }

  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    language: {
      decimal: "",
      emptyTable: "No hay datos disponibles en la tabla",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(filtrados de un total de _MAX_ registros)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "No se encontraron registros coincidentes",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
      aria: {
        sortAscending: ": activar para ordenar la columna ascendente",
        sortDescending: ": activar para ordenar la columna descendente",
      },
    },
    columns: [
      { data: "nombre", title: "Nombre" }, // Nombre
      { data: "descripcion", title: "Descripción" }, // Descripción
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
      { data: "talla", title: "Talla" }, // Talla
      { data: "ocasion", title: "Ocasión" },
      { data: "color", title: "Color" }, // Color
      { data: "stock", title: "Stock" }, // Stock
      { data: "genero", title: "Genero" }, // Género
      {
        data: null,
        title: "Acciones",
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
    console.log(rowData);
    document.getElementById("descripcion").value = rowData.descripcion;
    document.getElementById("nombre").value = rowData.nombre;
    document.getElementById("title").innerHTML = "Editar Productos";
    document.getElementById("id").value = rowData.id;
    document.getElementById("id_tipo_prenda").value = rowData.id_tipo_prenda;
    document.getElementById("id_genero").value = rowData.id_genero;
    document.getElementById("id_ocasion").value = rowData.id_ocasion;
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
        swal({
          title: "En Hora Buena!",
          text: "La acción se realizó de manera exitosa!",
          icon: "success",
          timer: 1000,
          buttons: false,
        });
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
      const nombre = document.getElementById("nombre").value;
      const descripcion = document.getElementById("descripcion").value;
      const imagenes = document.getElementById("imagenes").files;

      // Crear un objeto FormData para enviar los datos al servidor
      const formData = new FormData();
      formData.append("nombre", nombre);
      formData.append("descripcion", descripcion);
      for (let i = 0; i < imagenes.length; i++) {
        formData.append("imagenes[]", imagenes[i]);
      }

      // Obtener los valores seleccionados de los selects
      const genero = document.getElementById("id_genero").value;
      const tipoPrenda = document.getElementById("id_tipo_prenda").value;
      const ocasion = document.getElementById("id_ocasion").value;
      formData.append("id_genero", genero);
      formData.append("id_tipo_prenda", tipoPrenda);
      formData.append("id_ocasion", ocasion);

      const url =
        id === ""
          ? "../../controllers/router.php?op=insertProduct"
          : "../../controllers/router.php?op=updateProduct";
      // Realizar la solicitud POST al servidor para insertar o actualizar el producto
      fetch(url, {
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
              "Hubo un problema al insertar o actualizar el producto."
            );
          }
          console.log(response);
          // Si la inserción o actualización fue exitosa, ocultar el modal y mostrar un mensaje de éxito
          $("#miModal").modal("hide");
          swal({
            title: "En Hora Buena!",
            text: "La acción se realizó de manera exitosa!",
            icon: "success",
            timer: 1000,
            buttons: false,
          });

          reloadSection();
        })
        .catch((error) => {
          swal(
            "Ups! Algo salió mal!",
            "La acción no se pudo realizar correctamente!",
            "error"
          );
          console.error("Error al insertar o actualizar el producto:", error);
        });
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
      fetch("../../controllers/router.php?op=getAllProducts").then(
        (response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          response.json().then((data) => {
            miTabla.clear().draw();
            miTabla.rows.add(data).draw(); // Agregar los datos directamente
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
