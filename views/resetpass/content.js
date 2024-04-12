document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("verificationForm")
    .addEventListener("submit", function (e) {
      e.preventDefault(); // Evita que el formulario se envíe normalmente

      const form = document.getElementById("miForm");
      const formData = new FormData(form);
      console.log("FormData:", formData);
      fetch("../../controllers/router.php?op=resetpassci", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) {
            console.error("Error en la solicitud");
            throw new Error("Error en la solicitud");
          }
          console.log(response.text());
          return response.text();
        })
        .then((data) => {
          console.log("Respuesta del servidor:", data);
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
});
