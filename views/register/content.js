function submitForm() {
  const form = document.getElementById("registroForm");
  const formData = new FormData(form);
  fetch("../../controllers/router.php?op=registro", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        swal(
          "Ups! Algo salió mal!",
          "Revise que su email o numero de cédula no se encuentre ya registrado!",
          "error"
        );
        throw new Error("Error en la solicitud");
      }
      swal("Registro Exitoso !", "success");
      window.location.href = "../login/";
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
