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
      if (response.rol_id === 1) {
        window.location.href = "../admin/";
      } else {
        window.location.href = "../main/";
      }
      //swal("Inicio de Sesión Exitoso !", "success");
    })
    .then((data) => {
      console.log(data);
      if (data.rol_id === 1) {
        window.location.href = "../admin/";
      } else {
        window.location.href = "../main/";
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
