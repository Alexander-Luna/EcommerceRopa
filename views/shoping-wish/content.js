document.addEventListener("DOMContentLoaded", async function () {
  let id_user = 0;
  metodosPlantilla();
  reloadSection();
  async function reloadSection() {
    if (id_user != 0) {
      const productosContainer = document.getElementById("container");

      try {
        const response = await fetch(
          "../../controllers/router.php?op=getWishList&id_user=" + id_user
        );
        const data = await response.json();

        productosContainer.innerHTML = `	<tr class="table_head">
      <th class="column-1">Producto</th>
      <th class="column-2"></th>
      <th class="column-3">Precio</th>
      <th class="column-5"></th>
    </tr>`;

        data.forEach((producto) => {
          const imagenProducto = producto.img
            ? producto.img
            : "../../public/images/products/defaultprod.png";
          const productoHTML = `
                <tr class="table_row">
                    <td class="column-1">
                        <div class="how-itemcart1">
                            <img src="${imagenProducto}" alt="IMG">
                        </div>
                    </td>
                    <td class="column-2"><a href="../product-detail/index.php?id=${producto.id}">${producto.nombre}</a></td>
                    <td class="column-3">
                    $${producto.precio} 

                    </td>
                  
                    <td class="column-4">
                    <a href="../product-detail/index.php?id=${producto.id}" class=" text-decoration-none" >
                    <div class="zmdi zmdi-shopping-cart icon-header-item cl2 hov-cl1 trans-04 p-l-20 p-r-11 icon-header-noti js-show-cart" data-notify="+">
                </div>
                </a>
                    </td>
                  
                   
                </tr>
            `;
          productosContainer.innerHTML += productoHTML;
        });
      } catch (error) {
        console.error("Error al obtener productos:", error);
      }
    } else {
      const productosContainer = document.getElementById("container");
      productosContainer.innerHTML = `	
      <a href="../login" >
      <p>Inicie sesión para ver su productos favoritos</p>
      </a>
   `;
    }
  }
  function metodosPlantilla() {
    $(".js-select2").each(function () {
      $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next(".dropDownSelect2"),
      });
    });
    $(".js-pscroll").each(function () {
      $(this).css("position", "relative");
      $(this).css("overflow", "hidden");
      var ps = new PerfectScrollbar(this, {
        wheelSpeed: 1,
        scrollingThreshold: 1000,
        wheelPropagation: false,
      });

      $(window).on("resize", function () {
        ps.update();
      });
    });
  }
});
