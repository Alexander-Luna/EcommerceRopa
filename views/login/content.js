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
      //swal("Inicio de Sesión Exitoso !", "success");
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
