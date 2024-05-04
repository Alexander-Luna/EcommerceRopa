document.addEventListener("DOMContentLoaded", async function () {
  reloadSection();
  var url = window.location.href;
  var urlParams = new URLSearchParams(new URL(url).search);
  var filterValue = urlParams.has("filter") ? urlParams.get("filter") : null;

  let currentPage = 1;
  const itemsPerPage = 16;
  let data;
  async function reloadSection() {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductsShop"
      );
      data = await response.json();

      if (filterValue !== null) {
        filtrarPorGenero(filterValue);
      } else {
        mostrarElementosEnBloques(data);
      }
    } catch (error) {
      console.error("Error al obtener productos:", error);
    }
  }

  function mostrarElementosEnBloques(dataFilter) {
    const container = document.getElementById("container");
    container.innerHTML = "";
    renderPagination(dataFilter.length);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentData = dataFilter.slice(startIndex, endIndex);

    if (currentData && currentData.length > 0) {
      currentData.forEach((producto) => {
        const imagenProducto = producto.imagen
          ? producto.imagen
          : "../../public/images/products/defaultprod.png";
        const productoHTML = `
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ${producto.genero}">
          <div class="block2">
            <div class="block2-pic hov-img0">
              <img src="${imagenProducto}" alt="Product Image">
              <a href="../product-detail/index.php?id=${producto.id_producto}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 show-modal1 text-decoration-none">Ver Producto</a>
            </div>
            <div class="block2-txt flex-w flex-t p-t-14">
              <div class="block2-txt-child1 flex-col-l">
                <a href="../product-detail/index.php?id=${producto.id_producto}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text-decoration-none">${producto.nombre}</a>
                <span class="stext-105 cl3">$${producto.precio}</span>
                <input type="hidden" class="genero" data-genero="${producto.genero}">
                <input type="hidden" class="ocasion" data-ocasion="${producto.ocasion}">
              </div>
              <div class="block2-txt-child2 flex-r p-t-3">
                <button class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 btnAddWish"  data-id="${producto.id_producto}">
                  <img class="icon-heart1 dis-block trans-04" src="../../public/images/icons/icon-heart-01.png" alt="Heart Icon">
                  <img class="icon-heart2 dis-block trans-04 ab-t-l" src="../../public/images/icons/icon-heart-02.png" alt="Heart Icon">
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
        container.innerHTML += productoHTML;
      });

      renderPagination(dataFilter.length); // Mantenemos la paginación basada en la longitud total de los datos, no solo en los datos mostrados
    } else {
      container.innerHTML = "";
      const liVacio = document.createElement("div");
      liVacio.textContent = "No existen elementos";
      container.appendChild(liVacio);
    }
  }

  function renderPagination(totalItems) {
    const pages = Math.ceil(totalItems / itemsPerPage);
    const pagination = document.querySelector(".pagination");
    pagination.innerHTML = "";

    for (let i = 1; i <= pages; i++) {
      const li = document.createElement("li");
      li.classList.add("page-item");
      const a = document.createElement("a");
      a.classList.add("page-link");
      a.href = "#";
      a.textContent = i;
      a.addEventListener("click", () => {
        if (pages > 1) {
          currentPage = i;
          mostrarElementosEnBloques(data);
        }
      });
      li.appendChild(a);
      pagination.appendChild(li);
    }
  }

  function filtrarPorGenero(genero) {
    if (genero === "") {
      mostrarElementosEnBloques(data);
    } else {
      const filteredData = data.filter((producto) => {
        const generoProducto = producto.genero.toLowerCase();
        const ocasionProducto = producto.ocasion.toLowerCase();
        if (genero === "Uniforme Escolar" || genero === "Deportivo") {
          return generoProducto === genero.toLowerCase();
        } else if (genero === "Niños") {
          return (
            generoProducto.includes("niño") || generoProducto.includes("niña")
          );
        } else {
          return (
            generoProducto === genero.toLowerCase() ||
            ocasionProducto === genero.toLowerCase()
          );
        }
      });
      mostrarElementosEnBloques(filteredData);
    }
  }

  $(document).on("click", ".btnAddWish", function () {
    var id = $(this).data("id");
    const formData = new FormData();
    formData.append("id_producto", id);
    fetch("../../controllers/router.php?op=insertWishClient", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (response.ok) {
          swal("Excelente!", "Transaccion realizada con exito", "success");
        }
      })
      .catch((error) => {
        console.error("Error al enviar los datos:", error);
      });
  });
  const campoBusqueda = document.getElementById("searchInput");

  campoBusqueda.addEventListener("input", function () {
    const keywords = campoBusqueda.value.toLowerCase().trim();
    const productosFiltrados = data.filter((producto) => {
      const nombreProducto = producto.nombre.toLowerCase();
      return nombreProducto.includes(keywords);
    });
    mostrarElementosEnBloques(productosFiltrados);
  });

  document.getElementById("btnall").addEventListener("click", function () {
    var url = new URL(window.location.href);
    url.searchParams.delete("filter");
    window.location.href = url.toString();
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
});
