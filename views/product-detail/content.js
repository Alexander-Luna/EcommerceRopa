document.addEventListener("DOMContentLoaded", async function () {
  let tallaSeleccionada = "";
  let stockMax = 0;
  let imgProd = ""; 
  let id_prod = "";
  let stockDisponible = 0;
  const nombreElement = document.getElementById("tv-nombre");
  const precioElement = document.getElementById("tv-precio");
  const inputStock = document.getElementById("input_stock");

  const selectTalla = document.getElementById("id_talla");
  const selectColor = document.getElementById("id_color");
  obtenerIdDelURL();
  reloadSection();
  document
    .getElementById("js-addcart-detail")
    .addEventListener("click", function () {
      const tallaSeleccionada = selectTalla.value;
      const tallaTextoSeleccionado =
        selectTalla.options[selectTalla.selectedIndex].textContent;

      const colorSeleccionado = selectColor.value;
      const colorTextoSeleccionado =
        selectColor.options[selectColor.selectedIndex].textContent;

      try {
        if (tallaSeleccionada === "" || colorSeleccionado === "") {
          throw new Error(
            "Por favor seleccione una talla y un color antes de agregar al carrito."
          );
        }
        if (
          inputStock.value === "" ||
          isNaN(inputStock.value) ||
          inputStock.value < 1
        ) {
          throw new Error(
            "Por favor seleccione una cantidad válida de productos antes de agregar al carrito."
          );
        }

        const cantidadSeleccionada = parseInt(inputStock.value);

        if (cantidadSeleccionada > stockDisponible) {
          throw new Error(
            "La cantidad seleccionada es mayor que el stock disponible."
          );
        }

        const productToAdd = {
          id: Date.now(),
          color: colorTextoSeleccionado,
          color_id: colorSeleccionado,
          talla: tallaTextoSeleccionado,
          talla_id: tallaSeleccionada,
          cantidad: cantidadSeleccionada,
          precio_venta: parseFloat(precioElement.textContent.replace("$", "")),
          img: imgProd,
          producto_id: id_prod,
          nombre: nombreElement.textContent,
        };

        addToCart(productToAdd);
        swal({
          title: nombreElement.textContent,
          text: "Agregado al carrito!",
          icon: "success",
          timer: 1000,
          buttons: false,
        });
      } catch (error) {
        console.log(error.message);
        swal("Error", error.message, "warning");
      }
    });
  function selects() {
    const selectColor = document.getElementById("id_color");
    const selectTalla = document.getElementById("id_talla");
    let previousTallaId = selectTalla.value ? selectTalla.value : null;
    let previousColorId = selectColor.value ? selectColor.value : null;

    selectTalla.addEventListener("change", () => {
      console.log("Cambio en el selectTalla");
      const newTallaId = selectTalla.value;
      if (!previousColorId) {
        previousColorId = selectColor.value; // Obtener el valor del color seleccionado si no hay valor previo
      }
      getPrecio(newTallaId, previousColorId);
      getColores(newTallaId);
      previousTallaId = newTallaId;
    });

    selectColor.addEventListener("change", () => {
      console.log("Cambio en el selectColor");
      const newColorId = selectColor.value;
      if (!previousTallaId) {
        previousTallaId = selectTalla.value; // Obtener el valor de la talla seleccionada si no hay valor previo
      }
      getPrecio(previousTallaId, newColorId);
      getTallas(newColorId);
      previousColorId = newColorId;
    });
  }

  function getPrecio(talla_id, color_id) {
    // Obtener los elementos span por sus IDs
    const stockSpan = document.getElementById("stock");
    const precioSpan = document.getElementById("tv-precio");
    console.log("Entraaaa " + talla_id + " " + color_id);
    try {
      fetch(
        "../../controllers/router.php?op=getPrecioShop&prod_id=" +
          id_prod +
          "&talla_id=" +
          talla_id +
          "&color_id=" +
          color_id
      )
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          return response.json(); // No es necesario convertir nuevamente a JSON
        })
        .then((productos) => {
          if (productos.length > 0) {
            const producto = productos[0];
            console.log(producto);
            stockSpan.textContent = producto.stock;
            precioSpan.textContent = parseFloat(producto.precio).toFixed(2);
            stockDisponible = producto.stock;
          } else {
            stockSpan.textContent = "No disponible";
            precioSpan.textContent = "No disponible";
            stockDisponible = 0;
          }
        })
        .catch((error) => {
          console.error("Error al obtener los detalles del producto:", error);
          // Si hay un error, mostrar "No disponible"
          stockSpan.textContent = "No disponible";
          precioSpan.textContent = "No disponible";
          stockDisponible = 0;
        });
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
      // Si hay un error, mostrar "No disponible"
      stockSpan.textContent = "No disponible";
      precioSpan.textContent = "No disponible";
      stockDisponible = 0;
    }
  }

  selects();

  document
    .getElementById("id_talla")
    .addEventListener("change", function (event) {
      event.preventDefault(); // Utilizar event.preventDefault() para prevenir el comportamiento predeterminado del evento
      const selectTalla = document.getElementById("id_talla"); // Obtener el elemento select dentro del evento
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
    tv_stock.textContent = `${stock}`;
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
    const urlParams = new URLSearchParams(window.location.search);
    const idParam = urlParams.get("id");
    if (idParam !== null) {
      id_prod = idParam;
    } else {
      console.error("No se encontró el parámetro 'id' en la URL.");
    }
  }

  function reloadSection() {
    try {
      const nombreElement = document.getElementById("tv-nombre");
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
          console.log("realodad");
          console.log(producto);
          nombreElement.textContent = producto.nombre;
          descripcionElement.textContent = producto.descripcion;
          getTallas(producto.id_color);
          getColores(producto.id_talla);
          getPrecio(producto.id_talla, producto.id_color);
        });
      });
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  function getColores(talla) {
    fetch(
      "../../controllers/router.php?op=getColoresTalla&id_prod=" +
        id_prod +
        "&talla=" +
        talla
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los colores disponibles para la talla seleccionada."
          );
        }
        return response.json();
      })
      .then((data) => {
        const selectColor = document.getElementById("id_color");
        selectColor.innerHTML = "";
        if (data.length > 0) {
          data.forEach((color) => {
            const option = document.createElement("option");
            option.text = color.color;
            option.value = color.id_color;
            selectColor.appendChild(option);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }

  function getTallas(color) {
    fetch(
      "../../controllers/router.php?op=getTallasColor&id_prod=" +
        id_prod +
        "&color=" +
        color
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener las tallas disponibles para el color seleccionado."
          );
        }
        return response.json();
      })
      .then((data) => {
        const selectTalla = document.getElementById("id_talla");
        selectTalla.innerHTML = "";
        if (data.length > 0) {
          data.forEach((talla) => {
            const option = document.createElement("option");
            option.text = talla.talla;
            option.value = talla.id_talla;
            selectTalla.appendChild(option);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }

  function obtenerImagenes() {
    const galeria = document.getElementById("sliderIMG");

    let html = "";
    fetch("../../controllers/router.php?op=getAllImgProd&id=" + id_prod)
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
            html += `<div class="item-slick3" data-thumb="${imagen.url_imagen}">
                        <div class="wrap-pic-w pos-relative">
                            <img src="${imagen.url_imagen}" alt="IMG-PRODUCT">
                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="${imagen.url_imagen}">
                                <i class="fa fa-expand"></i>
                            </a>
                        </div>
                    </div>`;
            if (index == 0) {
              imgProd = imagen.url_imagen;
            }
          });
          galeria.innerHTML = html;
          setTimeout(() => {
            initSlickSlider(galeria);
          }, 100); // Cambia el valor del retraso según sea necesario
        } else {
          console.error("No hay imágenes disponibles para este producto");
        }
      })
      .catch((error) => {
        console.error("Error al obtener las imágenes:", error);
      });
  }

  function initSlickSlider(galeria) {
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
    } else {
      console.error(
        "No se pudo inicializar el slider: no se encontró el contenedor de la galería"
      );
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
