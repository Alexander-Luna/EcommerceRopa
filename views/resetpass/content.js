document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnentrar").addEventListener("click", submitForm);
  function submitForm(event) { // Agrega el parámetro event aquí
    event.preventDefault();
    const form = document.getElementById("miForm");
    const formData = new FormData(form);
    fetch("../../controllers/router.php?op=resetpassci", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          swal("Algo salio mal!" + response, "error");
          console.log(response);
          throw new Error("Error en la solicitud");
        }
        console.log(response);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
});
