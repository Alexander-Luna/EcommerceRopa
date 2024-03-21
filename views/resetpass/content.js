document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("verificationForm")
    .addEventListener("submit", function (e) {
      e.preventDefault(); // Evita que el formulario se envíe normalmente

      // Obtener los datos del formulario
      var formData = new FormData(this);
      console.log("FormData:", formData);

      // Enviar los datos mediante Fetch
      fetch("../../controllers/router.php?op=resetpassci", {
        method: "POST", // Método HTTP
        body: formData, // Datos a enviar
      })
        .then((response) => {
          if (!response.ok) {
            console.error("Error en la solicitud");
            throw new Error("Error en la solicitud");
          }
          console.log(response.text());
          return response.text(); // Convertir la respuesta a texto
        })
        .then((data) => {
          // Manejar la respuesta del servidor
          console.log("Respuesta del servidor:", data);
          // Aquí puedes realizar otras acciones según la respuesta del servidor
        })
        .catch((error) => {
          console.error("Error:", error);
          // Manejar errores de la solicitud Fetch
        });
    });
});
