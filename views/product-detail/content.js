document.addEventListener("DOMContentLoaded", async function () {
  let tallaSeleccionada = "";
  let stockMax = 0;
  const imgProd = "";
  obtenerIdDelURL();
  reloadSection(stockMax);

  document
    .getElementById("select_talla")
    .addEventListener("change", function (event) {
      preventDefault(event);
      const selectedIndex = selectTalla.selectedIndex;
      const selectedOption = selectTalla.options[selectedIndex];
      const selectedValue = selectedOption.value;
      const selectedText = selectedOption.textContent;
      console.log("Valor seleccionado:", selectedValue);
      console.log("Texto seleccionado:", selectedText);
      tallaSeleccionada = selectedValue;
    });
  obtenerImagenes();
  metodosPlantilla();

  MetodoControlStock(stockMax);

  function updateStockLabel(stock) {
    const tv_stock = document.getElementById("stock");
    tv_stock.textContent = `${stock} Unidades Disponibles`;
    console.log(stock);
  }
  function MetodoControlStock(stockMax) {
    let stock = 0; // Initialize stock variable
    const disminuir = document.getElementById("disminuir");
    const sumar = document.getElementById("sumar");
    const inputStock = document.getElementById("input_stock");

    updateStockLabel(stockMax); // Update label initially

    disminuir.addEventListener("click", () => {
      if (stock > 0) {
        stock--;
        inputStock.value = stock;
        updateStockLabel(stockMax); // Always update label with stockMax on decrease
      }
    });

    sumar.addEventListener("click", () => {
      if (stock < stockMax) {
        stock++;
        inputStock.value = stock;
        updateStockLabel(stockMax - stock); // Update label with remaining available stock
      }
    });

    inputStock.addEventListener("change", () => {
      const nuevoValor = parseInt(inputStock.value);
      if (nuevoValor < 0) {
        stock = 0;
      } else if (nuevoValor > stockMax) {
        stock = stockMax;
      } else {
        stock = nuevoValor;
      }
      const availableStock = stockMax - stock;
      inputStock.value = stock; // Update input with actual stock
      updateStockLabel(availableStock); // Update label with remaining available stock
    });
  }

  function obtenerIdDelURL() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const id = urlParams.get("id");
    id_prod = id;
  }

  function reloadSection(stockMax) {
    try {
      const nombreElement = document.getElementById("tv-nombre");
      const precioElement = document.getElementById("tv-precio");
      const descripcionElement = document.getElementById("tv-descripcion");

      const response = fetch(
        "../../controllers/router.php?op=getProductDetail&id=" + id_prod
      );
      response
        .then((res) => res.json())
        .then((data) => {
          const producto = data;
          stockMax = producto.stock;
          nombreElement.textContent = producto.nombre;
          precioElement.textContent = `$${producto.precio_venta}`;
          descripcionElement.textContent = producto.descripcion;
          updateStockLabel(stockMax);
          obtenerTallas();
        })
        .catch((error) => {
          console.error("Error al obtener productos:", error);
        });
    } catch (error) {
      console.error("Error al obtener productos:", error);
    }
  }

  function obtenerTallas() {
    fetch("../../controllers/router.php?op=getTallasProd&id_prod=" + id_prod)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener las tallas.");
        }
        return response.json();
      })
      .then((data) => {
        const selectTalla = document.getElementById("select_talla");
        selectTalla.innerHTML = "";

        // Crea una opción por cada talla obtenida y la añade al select
        const option = document.createElement("option");
        option.text = "Seleccione una talla";
        option.value = "0";
        selectTalla.appendChild(option);
        data.forEach((talla) => {
          const option = document.createElement("option");
          option.text = talla.talla;
          option.value = talla.id_talla;
          selectTalla.appendChild(option);
        });
        obtenerColores(data[0].id_talla);
      })
      .catch((error) => {
        console.error("Error al obtener las tallas:", error);
      });
  }
  function obtenerColores(talla) {
    fetch(
      "../../controllers/router.php?op=getColoresTalla&id_prod=" +
        id_prod +
        "&talla=" +
        talla,
      {
        method: "GET",
      }
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los colores.");
        }
        return response.json();
      })
      .then((data) => {
        const selectTalla = document.getElementById("select-color");
        selectTalla.innerHTML = "<option>Seleccione un color</option>";
        data.forEach((color) => {
          const option = document.createElement("option");
          option.text = color.color;
          option.value = color.id_color;
          selectTalla.appendChild(option);
        });
      })
      .catch((error) => {
        console.error("Error al obtener las tallas:", error);
      });
  }
  function obtenerImagenes() {
    const galeria = document.getElementById("img-slide"); // Obtener el contenedor por ID
    let html = "";
    fetch("../../controllers/router.php?op=getImgProd&id_prod=" + id_prod)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener las imágenes");
        }
        return response.json();
      })
      .then((data) => {
        if (data.length > 0) {
          // Verifica si hay datos antes de procesarlos
          data.forEach((imagen, index) => {
            html += `<div class="item-slick3" data-thumb="${imagen.img}">
                            <div class="wrap-pic-w pos-relative">
                                <img src="${imagen.img}" alt="IMG-PRODUCT">
                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="${imagen.img}">
                                    <i class="fa fa-expand"></i>
                                </a>
                            </div>
                      </div>`;

            if (index == 0) {
              imgProd = imagen.img;
            }
            if (index === data.length - 1) {
              galeria.innerHTML = html; // Asignar el HTML al contenedor galeria
              initSlickSlider(); // Llamar a la función initSlickSlider() después de terminar el bucle
            }
          });
        } else {
          console.error("No hay imágenes disponibles para este producto");
        }
      })
      .catch((error) => {
        console.error("Error al obtener las imágenes:", error);
      });
  }

  function initSlickSlider() {
    var galeria = document.getElementById("img-slide");
    if (galeria) {
      $(galeria).slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 6000,
        arrows: true,
        dots: true,
        pauseOnFocus: false,
        pauseOnHover: false,
        appendArrows: $(galeria).siblings(".wrap-slick3-arrows"),
        appendDots: $(galeria).siblings(".wrap-slick3-dots"),
      });
    }
  }

  // Llama a la función para obtener las imágenes cuando la página se cargue
  function metodosPlantilla() {
    $(".js-select2").each(function () {
      $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next(".dropDownSelect2"),
      });
    });

    $(".parallax100").parallax100();

    $(".gallery-lb").each(function () {
      $(this).magnificPopup({
        delegate: "a", 
        type: "image",
        gallery: {
          enabled: true,
        },
        mainClass: "mfp-fade",
      });
    });

    $(".js-addwish-b2, .js-addwish-detail").on("click", function (e) {
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

    /*---------------------------------------------*/

    $(".js-addcart-detail").each(function () {
      $(this).on("click", function () {
        const nombreElement = document.getElementById("tv-nombre");
        const precioElement = document.getElementById("tv-precio");
        const inputStock = document.getElementById("input_stock");

        try {
          const productToAdd = {
            color: "Azul",
            talla: "tallaSeleccionada",
            cantidad: inputStock.value,
            precio_venta: `${precioElement.textContent}`,
            img: imgProd,
            nombre: nombreElement.textContent,
          };
          addToCart(productToAdd);
          swal(nombreElement.textContent, "Agregado al carrito !", "success");
          if (tallaSeleccionada !== "") {
          } else {
            console.log("Seleccione una talla antes de agregar al carrito.");
          }
        } catch (error) {
          console.log(error);
          swal(nombreElement.textContent, "error temporal!", "warning");
        }
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
