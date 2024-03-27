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
      { data: "stock", title: "Stock" },
     
      { data: "cant_pred", title: "Cantidad Pre-Compra" },
      {
        data: "imagen",
        title: "Imagen",
        render: function (data, type, row) {
          if (data) {
            // Si hay una imagen, la mostramos
            return '<img src="' + data + '" alt="Producto" style="max-width: 100px; max-height: 100px;">';
          } else {
            // Si no hay imagen, mostramos la imagen por defecto
            return '<img src="../../public/images/products/defaultprod.png" alt="Producto por defecto" style="max-width: 100px; max-height: 100px;">';
          }
        }
      },
      {
        data: "stock",
        render: function (data, type, row) {
          return data > 0 ? "Disponible" : "Agotado";
        },
        title: "Estado",
      },
      { data: "nombre_proveedor", title: "Proveedor" },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button type="button" class="btn btn-outline-warning editar" onclick="editar(${row.id})">
              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-outline-danger eliminar" onclick="Eliminar(${row.id})">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>
          `;
        },
        title: "Acciones",
      },
    ],
    createdRow: function (row, data, dataIndex) {
      // Agregar evento de clic para editar la cantidad
      $("td:eq(2)", row).on("click", function () {
        // Obtener el valor actual de cant_pred
        var cantidad = data.cant_pred;

        // Crear un campo de entrada para editar la cantidad
        var input = $('<input type="number" value="' + cantidad + '">');

        // Reemplazar el contenido de la celda con el campo de entrada
        $(this).html(input);

        // Escuchar el evento keydown del campo de entrada para guardar los cambios
        input.on("keydown", function (e) {
          // Si la tecla presionada es Enter
          if (e.keyCode === 13) {
            // Obtener el nuevo valor ingresado en el campo de entrada
            var nuevaCantidad = $(this).val();

            // Actualizar el valor de cant_pred en los datos
            data.cant_pred = nuevaCantidad;

            // Actualizar la fila de la tabla con los datos modificados
            miTabla.row($(this).closest("tr")).data(data).draw();
          }
        });

        // Seleccionar automáticamente el texto en el campo de entrada
        input.select();
      });
    },
  });

  // Cargar los datos al cargar la página
  reloadSection();

  async function reloadSection() {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductsAlert"
      );
      if (!response.ok) {
        throw new Error(
          "Hubo un problema al obtener los detalles del producto."
        );
      }
      const data = await response.json();

      // Limpiar los datos existentes en la tabla
      miTabla.clear().draw();

      // Agregar los nuevos datos a la tabla
      miTabla.rows.add(data).draw();
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  // Función para actualizar la cantidad
  function updateCantidad(id_producto, cantidad) {
    // Aquí puedes realizar la lógica para actualizar la cantidad en el servidor
    console.log(
      `Actualizar cantidad para el producto ${id_producto} a ${cantidad}`
    );
  }
});
