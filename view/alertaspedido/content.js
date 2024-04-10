document.addEventListener("DOMContentLoaded", async function () {
  // Inicializar DataTables
  var miTabla = $("#miTabla").DataTable({
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
      buttons: {
        copy: "Copiar",
        colvis: "Visibilidad",
        print: "Imprimir",
        excel: "Exportar a Excel",
        pdf: "Exportar a PDF",
      },
    },
    columns: [
      { data: "nombre", title: "Nombre" },
      {
        data: "url_imagen",
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
      { data: "talla", title: "Talla" },
      { data: "color", title: "Color" },

      { data: "cantidad", title: "Cantidad" },

      {
        data: "descripcion_ap",
        render: function (data, type, row) {
          return data === null ? "" : data;
        },
        title: "Descripción pedido",
      },
      {
        data: "est_ap",
        render: function (data, type, row) {
          return data === 0 ? "Finalizado" : "Pendiente";
        },
        title: "Estado",
      },
      { data: "fecha", title: "Fecha del Pedido" },

      { data: "prov_nombre", title: "Proveedor" },
      { data: "telefono", title: "Teléfono" },
      {
        data: null,
        render: function (data, type, row) {
          return `
          <button type="button" class="btn btn-outline-success btnShop" data-id="${row.id}">
          <i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
          <button type="button" class="btn btn-outline-warning btnEditar" data-id="${row.id}">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
    createdRow: function (row, data, dataIndex) {
      $("td:eq(2)", row).on("click", function () {
        var cantidad = data.cant_pred;
        var input = $('<input type="number" value="' + cantidad + '">');
        $(this).html(input);
        input.on("keydown", function (e) {
          if (e.keyCode === 13) {
            var nuevaCantidad = $(this).val();
            data.cant_pred = nuevaCantidad;
            miTabla.row($(this).closest("tr")).data(data).draw();
          }
        });
        input.select();
      });
    },
  });

  reloadSection();

  async function reloadSection() {
    miTabla.clear().draw();
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductPedido"
      );
      if (!response.ok) {
        throw new Error(
          "Hubo un problema al obtener los detalles del producto."
        );
      }

      const data = await response.json();
      console.log(data);
      const newData = data.map((item) => ({ ...item, cant_pred: 0 }));
      miTabla.rows.add(newData).draw();
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  $(document).on("click", ".btnEditar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");
    console.log(rowData.cantidad);
    document.getElementById("title").innerText = "Editar Pedido";
    $("#id").val(rowData.id_pedido);
    $("#nombre").text(rowData.nombre);
    $("#color").text(rowData.color);
    $("#talla").text(rowData.talla);
    $("#est").val(rowData.est_ap);
    $("#cantidad").text(rowData.cantidad);
    $("#prov_nombre").text(rowData.prov_nombre);
    $("#telefono").text(rowData.telefono);
    $("#descripcion").val(rowData.descripcion_ap);
  });
  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var formData = new FormData();
    formData.append("id", rowData.id_pedido);
    swal({
      title: "¿Estás seguro?",
      text: "Una vez eliminado, no podrás recuperar este pedido!",
      icon: "warning",
      buttons: ["Cancelar", "Eliminar"],
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        fetch("../../controllers/router.php?op=deleteProductPedido", {
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
            swal(
              "¡En Hora Buena!",
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
      } else {
        // Si el usuario cancela, mostrar un mensaje de cancelación
        swal("Operación cancelada!", "Tu producto está a salvo :)", "info");
      }
    });
  });

 
  $(document).on("click", ".btnShop", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    const uniqueId = Date.now();
    const producto = {
      id: uniqueId,
      id_producto: rowData.id_producto,
      nombre_producto: rowData.nombre,
      id_proveedor: rowData.id_proveedor,
      nombre_proveedor: rowData.prov_nombre,
      costo: 0,
      stock: rowData.cantidad,
      precio: 0,
      id_color: rowData.id_color,
      nombre_color: rowData.color,
      id_talla: rowData.id_talla,
      nombre_talla: rowData.talla,
    };
    let productosGuardados =
      JSON.parse(localStorage.getItem("productos")) || [];
    productosGuardados.push(producto);
    localStorage.setItem("productos", JSON.stringify(productosGuardados));
    swal({
      title: "En Hora Buena!",
      text: "La acción se realizó de manera exitosa!",
      icon: "success",
      timer: 1000,
      buttons: false,
    });
    const formData = new FormData();
    formData.append("id", rowData.id);
    fetch("../../controllers/router.php?op=deleteProductPedido", {
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
          throw new Error("Hubo un problema al realizar la transacción.");
        }
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
          "Ups! Algo salio mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        console.error("Error al realizar la transacción:", error);
      });
  });
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertar cuando se hace clic en el botón
  });

  function insertar() {
    try {
      // Obtener los datos del formulario del modal
      const id = document.getElementById("id").value;
      const descripcion = document.getElementById("descripcion").value;
      const est = document.getElementById("est").value;
      const formData = new FormData();
      formData.append("est", est);
      formData.append("descripcion", descripcion);
      formData.append("id", id);
      fetch("../../controllers/router.php?op=updateProductPedido", {
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
            throw new Error("Hubo un problema al insertar el nuevo Proveedor.");
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
          console.error("Error al insertar el nuevo Proveedor:", error);
          swal(
            "Ups! Algo salio mal!",
            "La accion no se pudo realizar correctamente!",
            "error"
          );
        });
    } catch (error) {
      console.error("Error al obtener los datos del formulario:", error);
      swal(
        "Ups! Algo salio mal!",
        "La accion no se pudo realizar correctamente!",
        "error"
      );
    }
  }
});
