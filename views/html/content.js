document.addEventListener("DOMContentLoaded", function () {
  reloadSection();
});
function reloadSection() {
    try {
      fetch("../../controllers/router.php?op=getCategorias")
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          //        console.log(response.json())
          return response.json();
        })
        .then((data) => {
          // Obtener los elementos <ul> donde se agregarán los elementos
          const ul = document.getElementById("subMenuCat");
          const ul1 = document.getElementById("subMenuCat1");
          // Limpiar el contenido actual de los <ul>
          ul.innerHTML = "";
          ul1.innerHTML = "";
          // Recorrer los datos y agregar elementos <li> a los <ul> correspondientes
  
          data.forEach((categoria) => {
            const li = document.createElement("li");
            const a = document.createElement("a");
            a.href = "../shop/index.php?op=" + categoria.tabla; // Puedes establecer el enlace aquí si tienes la URL correspondiente
            a.textContent = categoria.nombre;
            // Crear un nuevo <li> y <a> para cada <ul>
            const li1 = li.cloneNode(true);
            const a1 = a.cloneNode(true);
            li.appendChild(a);
            ul.appendChild(li);
            li1.appendChild(a1);
            ul1.appendChild(li1);
          });
  
          // Si hay más de 5 elementos, añadir la clase 'scrollable'
          if (data.length > 5) {
            ul.classList.add("scrollable");
            ul1.classList.add("scrollable");
          } else {
            ul.classList.remove("scrollable");
            ul1.classList.remove("scrollable");
          }
        });
    } catch (error) {
      alert("Error al obtener los detalles del producto:", error);
    }
  }
  
