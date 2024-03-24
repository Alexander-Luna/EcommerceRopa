function submitForm() {
  const form = document.getElementById("loginForm");
  const formData = new FormData(form);
  fetch("../../controllers/router.php?op=login", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      // Manipular la respuesta del servidor si es necesario
      console.log(data);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
