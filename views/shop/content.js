document.addEventListener("DOMContentLoaded", async function () {
  let page = 1,
    nitems = 20;

  setTimeout(() => {
    const modalButton = document.querySelector(".show-modal1"); // Selecciona el botón "Ver Producto"

    modalButton.addEventListener("click", function (event) {
      event.preventDefault(); // Evita el comportamiento predeterminado del enlace
      const modal = document.getElementById("modal1"); // Selecciona el modal por su ID
      modal.style.display = "block"; // Muestra el modal cambiando su estilo de visualización
    });

    metodosPlantilla();
  }, 2000);
  reloadSection();
  document.getElementById("bmas").addEventListener("click", function () {
    event.preventDefault();
    reloadSection();
  });

  async function reloadSection() {
    const productosContainer = document.getElementById("container");

    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProducts&page=" +
          page +
          "&nitems=" +
          nitems +
          ""
      );
      const data = await response.json();
      data.forEach((producto) => {
        const imagenProducto = producto.imagen
          ? producto.imagen
          : "../../public/images/products/defaultprod.png";
        const productoHTML = `
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="${imagenProducto}" alt="Product Image">
                            <button class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 show-modal1">
                            Ver Producto
                            </button>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="../product-detail/index.php?id=${producto.id}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">${producto.nombre}</a>
                                <span class="stext-105 cl3">$${producto.precio}</span>
                            </div>
                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                    <img class="icon-heart1 dis-block trans-04" src="../../public/images/icons/icon-heart-01.png" alt="Heart Icon">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="../../public/images/icons/icon-heart-02.png" alt="Heart Icon">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        productosContainer.innerHTML += productoHTML;
      });
      page = page + nitems;
    } catch (error) {
      console.error("Error al obtener productos:", error);
    }
  }

  function metodosPlantilla() {
    $(".parallax100").parallax100();

    $(".gallery-lb").each(function () {
      // the containers for all your galleries
      $(this).magnificPopup({
        delegate: "a", // the selector for gallery item
        type: "image",
        gallery: {
          enabled: true,
        },
        mainClass: "mfp-fade",
      });
    });
    $(".js-addwish-b2").on("click", function (e) {
      e.preventDefault();
    });

    $(".js-addwish-b2").each(function () {
      var nameProduct = $(this).parent().parent().find(".js-name-b2").html();
      $(this).on("click", function () {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass("js-addedwish-b2");
        $(this).off("click");
      });
    });

    $(".js-addwish-detail").each(function () {
      var nameProduct = $(this)
        .parent()
        .parent()
        .parent()
        .find(".js-name-detail")
        .html();

      $(this).on("click", function () {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass("js-addedwish-detail");
        $(this).off("click");
      });
    });

    $(".js-addcart-detail").each(function () {
      var nameProduct = $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find(".js-name-detail")
        .html();
      $(this).on("click", function () {
        swal(nameProduct, "is added to cart !", "success");
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
