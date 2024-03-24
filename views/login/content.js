function submitForm() {
  const form = document.getElementById("loginForm");
  const formData = new FormData(form);
  fetch("../../controllers/router.php?op=login", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        swal("Algo salio mal!", "error");
        throw new Error("Error en la solicitud");
      }
      //swal("Inicio de Sesión Exitoso !", "success");
      window.location.href = "../main/";
    })
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
