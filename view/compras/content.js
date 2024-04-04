document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnAdd").addEventListener("click", function () {
    // Obtener el ID del producto
    const id = document.getElementById("id_hidden").value;

    // Obtener los valores del formulario
    const id_producto = document.getElementById("id_producto").value;
    const id_proveedor = document.getElementById("id_proveedor").value;
    const costo = document.getElementById("costo").value;
    const stock = document.getElementById("stock").value;
    const precio = document.getElementById("precio").value;
    const id_color = document.getElementById("id_color").value;
    const id_talla = document.getElementById("id_talla").value;

    // Obtener los nombres visibles seleccionados de los select
    const nombre_producto =
      document.getElementById("id_producto").options[
        document.getElementById("id_producto").selectedIndex
      ].text;
    const nombre_proveedor =
      document.getElementById("id_proveedor").options[
        document.getElementById("id_proveedor").selectedIndex
      ].text;
    const nombre_color =
      document.getElementById("id_color").options[
        document.getElementById("id_color").selectedIndex
      ].text;
    const nombre_talla =
      document.getElementById("id_talla").options[
        document.getElementById("id_talla").selectedIndex
      ].text;

    if (id === "") {
      // Si el ID es null, agregar un nuevo producto
      const uniqueId = Date.now(); // Generar un ID único para el producto

      const producto = {
        id: uniqueId,
        id_producto: id_producto,
        nombre_producto: nombre_producto,
        id_proveedor: id_proveedor,
        nombre_proveedor: nombre_proveedor,
        costo: costo,
        stock: stock,
        precio: precio,
        id_color: id_color,
        nombre_color: nombre_color,
        id_talla: id_talla,
        nombre_talla: nombre_talla,
      };

      // Obtener los datos guardados en LocalStorage (si existen)
      let productosGuardados =
        JSON.parse(localStorage.getItem("productos")) || [];

      // Agregar el nuevo producto al array de productos
      productosGuardados.push(producto);

      // Guardar el array de productos actualizado en LocalStorage
      localStorage.setItem("productos", JSON.stringify(productosGuardados));

      // Limpiar los campos del formulario después de agregar el producto
      //clearFormFields();
      swal(
        "En Hora Buena!",
        "La acción se realizó de manera exitosa!",
        "success"
      );
      reloadSection();
    } else {
      // Si el ID no es null, actualizar el producto existente en el localStorage
      const productosGuardados =
        JSON.parse(localStorage.getItem("productos")) || [];
      console.log(id);
      const index = productosGuardados.findIndex(
        (producto) => producto.id.toString() === id.toString()
      );

      if (index !== -1) {
        // Actualizar el producto existente con los nuevos valores
        productosGuardados[index].id_producto = id_producto;
        productosGuardados[index].nombre_producto = nombre_producto;
        productosGuardados[index].id_proveedor = id_proveedor;
        productosGuardados[index].nombre_proveedor = nombre_proveedor;
        productosGuardados[index].costo = costo;
        productosGuardados[index].stock = stock;
        productosGuardados[index].precio = precio;
        productosGuardados[index].id_color = id_color;
        productosGuardados[index].nombre_color = nombre_color;
        productosGuardados[index].id_talla = id_talla;
        productosGuardados[index].nombre_talla = nombre_talla;

        localStorage.setItem("productos", JSON.stringify(productosGuardados));
        document.getElementById("id_hidden").value = "";
        swal(
          "En Hora Buena!",
          "La acción se realizó de manera exitosa!",
          "success"
        );
        clearFormFields();
        reloadSection();
      } else {
        swal(
          "Ups! Algo salió mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
      }
    }
  });

  function clearFormFields() {
    // Limpiar los campos del formulario después de agregar el producto
    document.getElementById("id_hidden").value = "";
    document.getElementById("id_producto").value = "Seleccione...";
    document.getElementById("id_proveedor").value = "Seleccione...";
    document.getElementById("costo").value = "";
    document.getElementById("stock").value = "";
    document.getElementById("precio").value = "";
    document.getElementById("id_color").value = "Seleccione...";
    document.getElementById("id_talla").value = "Seleccione...";
  }

  metodosModal();
  const imgProd = document.getElementById("imgProd");
  const selectProducto = document.getElementById("id_producto");
  selectProducto.addEventListener("change", () => {
    const productId = selectProducto.value;
    const selectedProduct = productos.find(
      (product) => product.id == productId
    );
    if (selectedProduct) {
      imgProd.src = selectedProduct.imagen;
      if (selectedProduct.imagen == null) {
        imgProd.src = "../../public/images/products/defaultprod.png";
      }
    }
  });

  let productos;
  function metodosModal() {
    fetch("../../controllers/router.php?op=getProducts")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los datos de tallas.");
        }
        return response.json();
      })
      .then((data) => {
        const selectOcasion = document.getElementById("id_producto");
        imgProd.src = data[0].imagen;
        selectOcasion.innerHTML = "";
        productos = data;
        data.forEach((product) => {
          const option = document.createElement("option");
          option.value = product.id;
          option.textContent = product.nombre + " - " + product.descripcion;
          selectOcasion.appendChild(option);
        });
      });
    fetch("../../controllers/router.php?op=getTallas")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los datos de tallas.");
        }
        return response.json();
      })
      .then((data) => {
        const selectOcasion = document.getElementById("id_talla");
        selectOcasion.innerHTML = "";
        data.forEach((talla) => {
          const option = document.createElement("option");
          option.value = talla.id;
          option.textContent = talla.talla;
          selectOcasion.appendChild(option);
        });
      });

    fetch("../../controllers/router.php?op=getColores")
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los datos de tipo de prenda."
          );
        }
        return response.json();
      })
      .then((data) => {
        const selectTipoPrenda = document.getElementById("id_color");
        selectTipoPrenda.innerHTML = "";
        data.forEach((color) => {
          const option = document.createElement("option");
          option.value = color.id;
          option.textContent = color.color;
          selectTipoPrenda.appendChild(option);
        });
      });

    fetch("../../controllers/router.php?op=getProveedores")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los datos de género.");
        }
        return response.json();
      })
      .then((data) => {
        const selectGenero = document.getElementById("id_proveedor");
        selectGenero.innerHTML = "";
        data.forEach((proveedor) => {
          const option = document.createElement("option");
          option.value = proveedor.id;
          option.textContent = proveedor.nombre;
          selectGenero.appendChild(option);
        });
      });
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
      { data: "nombre_producto", title: "Producto" }, // Nombre del producto

      { data: "stock", title: "Cantidad" },
      { data: "costo", title: "Costo" },
      {
        title: "Sub Total",
        render: function (data, type, row) {
          // Calcular el subtotal multiplicando cantidad por costo
          var subtotal = parseInt(row.stock) * parseFloat(row.costo);
          return subtotal.toFixed(2); // Formatear el subtotal con dos decimales
        },
      },
      { data: "nombre_talla", title: "Talla" }, // Talla
      { data: "nombre_color", title: "Color" }, // Color
      { data: "nombre_proveedor", title: "Proveedor" },
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

    // Asignar valores de la fila seleccionada al formulario de inserción

    document.getElementById("id_hidden").value = rowData.id;
    document.getElementById("id_producto").value = rowData.id_producto;
    document.getElementById("id_proveedor").value = rowData.id_proveedor;
    document.getElementById("costo").value = rowData.costo;
    document.getElementById("stock").value = rowData.stock;
    document.getElementById("precio").value = rowData.precio;
    document.getElementById("id_color").value = rowData.id_color;
    document.getElementById("id_talla").value = rowData.id_talla;

    // Mostrar la imagen del producto
    var imgProd = document.getElementById("imgProd");
    if (rowData.imagen) {
      imgProd.src = rowData.imagen;
    } else {
      imgProd.src = "../../public/images/products/defaultprod.png";
    }

    // Mostrar el formulario modal
    $("#miModal").modal("show");
  });

  // Manejador de eventos para el botón de eliminar
  $(document).on("click", ".btnEliminar", function () {
    var dataId = $(this).data("id");
    var rowData = miTabla.row($(this).closest("tr")).data();

    // Obtener los productos guardados en localStorage
    let productosGuardados =
      JSON.parse(localStorage.getItem("productos")) || [];

    // Filtrar los productos para eliminar el que tenga el id coincidente
    productosGuardados = productosGuardados.filter(
      (producto) => producto.id !== dataId
    );

    // Guardar los productos actualizados en localStorage
    localStorage.setItem("productos", JSON.stringify(productosGuardados));

    // Realizar cualquier otra acción necesaria, como recargar la tabla
    reloadSection();
  });

  function insertar() {
    try {
      // Obtener los datos del formulario
      const id_producto = document.getE;
      productos.forEach((producto) => {});
      lementById("id_producto").value;
      const stock = document.getElementById("stock").value;
      const stock_alert = document.getElementById("stock_alert").value;
      const id_color = document.getElementById("id_color").value;
      const id_talla = document.getElementById("id_talla").value;
      const id_proveedor = document.getElementById("id_proveedor").value;

      // Crear un objeto FormData para enviar los datos al servidor
      const formData = new FormData();
      formData.append("id_producto", id_producto);
      formData.append("stock", stock);
      formData.append("stock_alert", stock_alert);
      formData.append("id_color", id_color);
      formData.append("id_talla", id_talla);
      formData.append("id_proveedor", id_proveedor);

      const url = "../../controllers/router.php?op=insertCompra"; // Siempre es una nueva inserción en este caso
      // Realizar la solicitud POST al servidor para insertar el nuevo producto
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
            throw new Error("Hubo un problema al insertar el nuevo producto.");
          }
          console.log(response);
          // Si la inserción fue exitosa, ocultar el modal y mostrar un mensaje de éxito
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
      const productos = JSON.parse(localStorage.getItem("productos")) || [];
      miTabla.clear().draw();
      let total = 0;
      productos.forEach((producto) => {
        total += parseFloat(producto.precio) * parseInt(producto.stock);
      });
      document.getElementById("total").textContent = total.toFixed(2);
      miTabla.rows.add(productos).draw();
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});
