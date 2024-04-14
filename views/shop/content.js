document.addEventListener("DOMContentLoaded", async function () {
  // Obtener la URL actual
  // Obtener la URL actual

  var numElementosMostrados = 0;
  var tamanoBloque = 16; // Número de elementos a mostrar en cada bloque
  reloadSection();
  // Agregar evento al botón "Ver Más"
  document.getElementById("bmas").addEventListener("click", function () {
    mostrarElementosEnBloques(data);
  });
  var url = window.location.href;
  var urlParams = new URLSearchParams(new URL(url).search);
  var filterValue = urlParams.has("filter") ? urlParams.get("filter") : null;

  $(document).on("click", ".btnAddWish", function () {
    var id = $(this).data("id");
    const formData = new FormData();
    formData.append("id_producto", id);
    fetch("../../controllers/router.php?op=insertWishClient", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        console.log(response);
        if (response.ok) {
          //swal("Excelente!", "Transaccion realizada con exito", "success");
        }
      })
      .catch((error) => {
        console.error("Error al enviar los datos:", error);
      });
  });
  let dataColor;
  reloadSectionColores();
  async function reloadSectionColores() {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getColores"
      );
      dataColor = await response.json();
      cargarColores(dataColor);
    } catch (error) {
      console.error("Error al obtener productos:", error);
    }
  }
  // Función para cargar los colores en el diseño
  function cargarColores(data) {
    const listaColores = document.getElementById("listaColores");

    // Limpiar la lista de colores
    listaColores.innerHTML = "";

    // Iterar sobre los colores y crear elementos HTML para cada uno
    data.forEach((color) => {
      const listItem = document.createElement("li");
      listItem.classList.add("p-b-6");

      const spanIcono = document.createElement("span");
      spanIcono.classList.add("fs-15", "lh-12", "m-r-6");
      spanIcono.style.color = color.color_hexa;

      const icono = document.createElement("i");
      icono.classList.add("zmdi", "zmdi-circle");

      spanIcono.appendChild(icono);

      const enlaceColor = document.createElement("a");
      enlaceColor.href = "#";
      enlaceColor.classList.add("filter-link", "stext-106", "trans-04");
      enlaceColor.textContent = color.color;

      listItem.appendChild(spanIcono);
      listItem.appendChild(enlaceColor);

      listaColores.appendChild(listItem);
    });
  }

  const campoBusqueda = document.getElementById("searchInput");
  const productos = document.getElementsByClassName("isotope-item");

  campoBusqueda.addEventListener("input", function () {
    const keywords = campoBusqueda.value.toLowerCase().trim();
    for (let i = 0; i < productos.length; i++) {
      const nombreProducto = productos[i]
        .querySelector(".js-name-b2")
        .innerText.toLowerCase();
      if (nombreProducto.includes(keywords)) {
        productos[i].style.display = "block";
      } else {
        productos[i].style.display = "none";
      }
    }
  });
  document.getElementById("btnall").addEventListener("click", function () {
    filtrarPorGenero("");
  });

  document.getElementById("btnmujer").addEventListener("click", function () {
    filtrarPorGenero("Mujer");
  });

  document.getElementById("btnhombre").addEventListener("click", function () {
    filtrarPorGenero("Hombre");
  });

  document.getElementById("btnninio").addEventListener("click", function () {
    filtrarPorGenero("Niño");
  });

  document.getElementById("btnninia").addEventListener("click", function () {
    filtrarPorGenero("Niña");
  });

  function filtrarPorGenero(genero) {
    console.log(genero);
    if (genero === "Uniforme Escolar" || genero === "Deportivo") {
      for (let i = 0; i < productos.length; i++) {
        const generoProducto = productos[i]
          .querySelector(".ocasion")
          .getAttribute("data-ocasion")
          .toLowerCase();
        if (genero === "") {
          productos[i].style.display = "block";
        } else {
          if (generoProducto === genero.toLowerCase()) {
            productos[i].style.display = "block";
          } else {
            productos[i].style.display = "none";
          }
        }
      }
    } else {
      for (let i = 0; i < productos.length; i++) {
        const generoProducto = productos[i]
          .querySelector(".genero")
          .getAttribute("data-genero")
          .toLowerCase();
        if (genero === "") {
          productos[i].style.display = "block";
        } else {
          if (generoProducto === genero.toLowerCase()) {
            productos[i].style.display = "block";
          } else {
            productos[i].style.display = "none";
          }
        }
      }
    }
    if (genero === "Niños") {
      for (let i = 0; i < productos.length; i++) {
        const generoProducto = productos[i]
          .querySelector(".genero")
          .getAttribute("data-genero")
          .toLowerCase();
        productos[i].style.display = "block";
        genero = genero.slice(0, -2);
        if (generoProducto.includes(genero.toLowerCase())) {
          productos[i].style.display = "block";
        } else {
          productos[i].style.display = "none";
        }
      }
    }
  }
  let data;
  async function reloadSection() {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductsShop"
      );
      data = await response.json();
      mostrarElementosEnBloques(data);
    } catch (error) {
      console.error("Error al obtener productos:", error);
    }
  }
  function mostrarElementosEnBloques(data) {
    // Crear un nuevo contenedor para los elementos adicionales
    var nuevoContenedor = document.createElement("div");
    nuevoContenedor.className = "row isotope-grid"; // Agregar la clase necesaria

    // Limpiar el contenido del contenedor existente
    document.getElementById("container").innerHTML = "";

    // Calcular el índice de inicio y fin para los elementos a mostrar
    var startIndex = numElementosMostrados;
    var endIndex = Math.min(numElementosMostrados + tamanoBloque, data.length);

    // Iterar sobre los datos y construir los elementos HTML
    for (var i = startIndex; i < endIndex; i++) {
      const producto = data[i];
      console.log(producto);
      const imagenProducto = producto.imagen
        ? producto.imagen
        : "../../public/images/products/defaultprod.png";
      const productoHTML = `
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ${producto.genero}">
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="${imagenProducto}" alt="Product Image">
                        <a href="../product-detail/index.php?id=${producto.id}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 show-modal1 text-decoration-none">
                            Ver Producto
                        </a>
                    </div>
                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="../product-detail/index.php?id=${producto.id}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text-decoration-none">${producto.nombre}</a>
                            <span class="stext-105 cl3">$${producto.precio}</span>
                            <input type="hidden" class="genero" data-genero="${producto.genero}">
                            <input type="hidden" class="ocasion" data-ocasion="${producto.ocasion}">
                           
                            </div>
                        <div class="block2-txt-child2 flex-r p-t-3">
                            <button class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 btnAddWish"  data-id="${producto.id}">
                                <img class="icon-heart1 dis-block trans-04" src="../../public/images/icons/icon-heart-01.png" alt="Heart Icon">
                                <img class="icon-heart2 dis-block trans-04 ab-t-l" src="../../public/images/icons/icon-heart-02.png" alt="Heart Icon">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
      nuevoContenedor.innerHTML += productoHTML;
    }
    var contenedorExistente = document.getElementById("container");
    contenedorExistente.insertAdjacentElement("beforebegin", nuevoContenedor);
    numElementosMostrados += tamanoBloque;
    if (filterValue !== null) {
      filtrarPorGenero(filterValue);
    }
  }
});
