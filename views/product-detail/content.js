document.addEventListener("DOMContentLoaded", async function () {
  let tallaSeleccionada = "";
  let stockMax = 0;
  let imgProd = ""; // Declarar la variable imgProd
  let id_prod = ""; // Declarar la variable id_prod
  obtenerIdDelURL();
  reloadSection(stockMax);

  document
    .getElementById("select_talla")
    .addEventListener("change", function (event) {
      event.preventDefault(); // Utilizar event.preventDefault() para prevenir el comportamiento predeterminado del evento
      const selectTalla = document.getElementById("select_talla"); // Obtener el elemento select dentro del evento
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
    let stock = 0; // Inicializar la variable stock
    const disminuir = document.getElementById("disminuir");
    const sumar = document.getElementById("sumar");
    const inputStock = document.getElementById("input_stock");

    updateStockLabel(stockMax); // Actualizar la etiqueta inicialmente

    disminuir.addEventListener("click", () => {
      if (stock > 0) {
        stock--;
        inputStock.value = stock;
        updateStockLabel(stockMax); // Siempre actualizar la etiqueta con stockMax al disminuir
      }
    });

    sumar.addEventListener("click", () => {
      if (stock < stockMax) {
        stock++;
        inputStock.value = stock;
        updateStockLabel(stockMax - stock); // Actualizar la etiqueta con el stock disponible restante
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
      inputStock.value = stock; // Actualizar el input con el stock actual
      updateStockLabel(availableStock); // Actualizar la etiqueta con el stock disponible restante
    });
  }

  function obtenerIdDelURL() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    id_prod = urlParams.get("id");
  }

  function reloadSection(stockMax) {
    try {
      const nombreElement = document.getElementById("tv-nombre");
      const precioElement = document.getElementById("tv-precio");
      const descripcionElement = document.getElementById("tv-descripcion");

      fetch(
        "../../controllers/router.php?op=getProductDetail&id=" + id_prod
      ).then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los detalles del producto."
          );
        }
        response.json().then((producto) => {
          stockMax = producto.stock;
          nombreElement.textContent = producto.nombre;
          precioElement.textContent = `$${producto.precio_venta}`;
          descripcionElement.textContent = producto.descripcion;
          updateStockLabel(stockMax);
          obtenerTallas();
        });
      });
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  function obtenerTallas() {
    fetch(
      "../../controllers/router.php?op=getTallasProd&id_prod=" + id_prod
    ).then((response) => {
      if (!response.ok) {
        throw new Error("Hubo un problema al obtener las tallas del producto.");
      }
      response.json().then((data) => {
        const selectTalla = document.getElementById("select_talla");
        selectTalla.innerHTML = "<option>Seleccione una talla</option>";
        data.forEach((talla) => {
          const option = document.createElement("option");
          option.text = talla.talla;
          option.value = talla.id_talla;
          selectTalla.appendChild(option);
        });
        if (data.length > 0) {
          obtenerColores(data[0].id_talla);
        }
      });
    });
  }

  function obtenerColores(talla) {
    fetch(
      "../../controllers/router.php?op=getColoresTalla&id_prod=" +
        id_prod +
        "&talla=" +
        talla
    ).then((response) => {
      if (!response.ok) {
        throw new Error(
          "Hubo un problema al obtener los colores disponibles para la talla seleccionada."
        );
      }
      response.json().then((data) => {
        const selectColor = document.getElementById("select_color");
        selectColor.innerHTML = "<option>Seleccione un color</option>";
        data.forEach((color) => {
          const option = document.createElement("option");
          option.text = color.color;
          option.value = color.id_color;
          selectColor.appendChild(option);
        });
      });
    });
  }

  function obtenerImagenes() {
    const galeria = document.getElementById("img-slide");
    let html = "";
    fetch("../../controllers/router.php?op=getImgProd&id_prod=" + id_prod)
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener las imágenes del producto."
          );
        }
        return response.json();
      })
      .then((data) => {
        if (data.length > 0) {
          data.forEach((imagen, index) => {
            html += `<div class="item-slick3" data-thumb="${imagen.img}"> <div class="wrap-pic-w pos-relative"> <img src="${imagen.img}" alt="IMG-PRODUCT"> <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="${imagen.img}"> <i class="fa fa-expand"></i> </a> </div> </div>`;
            if (index == 0) {
              imgProd = imagen.img;
            }
            if (index === data.length - 1) {
              galeria.innerHTML = html;
              initSlickSlider();
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

    $(".js-addcart-detail").each(function () {
      $(this).on("click", function () {
        const nombreElement = document.getElementById("tv-nombre");
        const precioElement = document.getElementById("tv-precio");
        const inputStock = document.getElementById("input_stock");

        const selectTalla = document.getElementById("select_talla");
        const selectColor = document.getElementById("select_color");

        const tallaSeleccionada = selectTalla.value;
        const tallaTextoSeleccionado =
          selectTalla.options[selectTalla.selectedIndex].textContent;

        const colorSeleccionado = selectColor.value;
        const colorTextoSeleccionado =
          selectColor.options[selectColor.selectedIndex].textContent;
        try {
          if (
            tallaSeleccionada === "Seleccione una talla" ||
            colorSeleccionado === "Seleccione un color"
          ) {
            throw new Error(
              "Por favor seleccione una talla y un color antes de agregar al carrito."
            );
          }
          if (inputStock.value < 1 || inputStock.value === "") {
            throw new Error(
              "Por favor seleccione la cantidad de productos antes de agregar al carrito."
            );
          }
          const productToAdd = {
            id: ,
            color: colorTextoSeleccionado,
            color_id: colorSeleccionado,
            talla: tallaTextoSeleccionado,
            talla_id: tallaSeleccionada,
            cantidad: inputStock.value,
            precio_venta: parseFloat(
              precioElement.textContent.replace("$", "")
            ),
            img: imgProd,
            nombre: nombreElement.textContent,
          };

          addToCart(productToAdd);
          swal(nombreElement.textContent, "Agregado al carrito !", "success");
        } catch (error) {
          console.log(error.message);
          swal("Error", error.message, "warning");
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
