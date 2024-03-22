document.addEventListener("DOMContentLoaded", function () {
  getSliders();
});
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


async function getSliders() {
  try {
    const response = await fetch("../../controllers/router.php?op=getSliders");
    const data = await response.json();

    // Obtener el contenedor del slider y los indicadores
    const sliderContainer = document.getElementById("sliderContainer");
    const sliderIndicators = document.getElementById("sliderIndicators");
    const carouselInner = document.querySelector(".carousel-inner");

    // Limpiar el contenido del contenedor del slider y los indicadores
    sliderIndicators.innerHTML = "";
    carouselInner.innerHTML = "";

    data.forEach((slider, index) => {
      const imagen = slider.img
        ? slider.img
        : "../../public/images/sliders/defaultslider.jpg";
      const url = slider.url_web ? slider.url_web : "#";

      // Crear el elemento del slide
      const slideItem = document.createElement("div");
      slideItem.classList.add("carousel-item");
      if (index === 0) {
        slideItem.classList.add("active");
      }

      const slideContent = `
          <div class="carousel-caption d-none d-md-block text-dark text-left align-items-center">
              <h5 class="align-items-top">${slider.titulo}</h5>
              <p>${slider.descripcion}</p>
          </div>
          <img src="${imagen}" class="d-block w-100" alt="${slider.titulo}">
        
      `;

      slideItem.innerHTML = slideContent;

      // Agregar el slide al contenedor del slider
      carouselInner.appendChild(slideItem);

      // Crear el indicador
      const indicator = document.createElement("li");
      indicator.setAttribute("data-target", "#sliderContainer");
      indicator.setAttribute("data-slide-to", index);
      if (index === 0) {
        indicator.classList.add("active");
      }
      sliderIndicators.appendChild(indicator);
    });

    // Agregar los botones de control al contenedor del slider
    const controlsHTML = `
    <a class="carousel-control-prev" href="#sliderContainer" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#sliderContainer" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>

      `;
    sliderContainer.innerHTML += controlsHTML;

    // Inicializar el componente del slider de Bootstrap
    $(".carousel").carousel();

    // Llamar a metodosPlantilla para vincular eventos
    metodosPlantilla();

  } catch (error) {
    console.error("Error al obtener sliders:", error);
  }
}
