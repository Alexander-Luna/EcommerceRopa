function submitForm() {
  const form = document.getElementById("registroForm");
  const formData = new FormData(form);
  fetch("../../controllers/router.php?op=registro", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        swal("Algo salio mal!", "error");
        throw new Error("Error en la solicitud");
      }
      swal("Registro Exitoso !", "success");
      window.location.href = "../login/";
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
