document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnentrar").addEventListener("click", submitForm);

  function submitForm() {
    const form = document.getElementById("miForm");
    const formData = new FormData(form);
    fetch("../../controllers/router.php?op=login", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          swal("Algo salio mal!" + response, "error");
          console.log(response);
          throw new Error("Error en la solicitud");
        }
        if (response.status === 200) {
          if (response.rol_id === 1) {
            window.location.href = "../admin/";
          } else {
            window.location.href = "../main/";
          }
        } else {
          swal("Error", "Usuario o contraseña incorrectos", "warning");
          return;
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
});
