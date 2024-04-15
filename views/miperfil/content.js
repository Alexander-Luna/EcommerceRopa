document.addEventListener("DOMContentLoaded", async function () {
  function limitarCaracteres(input, maxLength) {
    if (input.value.length > maxLength) {
      input.value = input.value.slice(0, maxLength);
    }
  }
  let iduser = 0;
  fetch("../../controllers/router.php?op=getUserData")
    .then((response) => {
      if (response.ok) {
        return response.json(); // Convertir la respuesta a JSON
      }
      throw new Error("Error al obtener los datos del perfil");
    })
    .then((data) => {
      // Asignar los datos del perfil a los campos del formulario
      iduser = data.id;
      document.getElementById("id_hidden").value = data.id; // Si existe un campo de ID oculto en el formulario
      document.getElementById("cedula").value = data.cedula;
      document.getElementById("email").value = data.email;
      document.getElementById("nombres").value = data.nombre;
      document.getElementById("direccion").value = data.direccion;
      document.getElementById("telefono").value = data.telefono;
    })
    .catch((error) => {
      console.error("Error:", error);
      // Aquí puedes manejar el error de alguna manera, por ejemplo, mostrando un mensaje al usuario
    });

  document
    .getElementById("btnActualizar")
    .addEventListener("click", function () {
      const id = document.getElementById("id_hidden").value;
      const nombres = document.getElementById("nombres").value;
      const direccion = document.getElementById("direccion").value;
      const email = document.getElementById("email").value;
      const cedula = document.getElementById("cedula").value;
      const telefono = document.getElementById("telefono").value;
      const formData = new FormData();
      formData.append("nombre", nombres);
      formData.append("id", id);
      formData.append("direccion", direccion);
      formData.append("email", email);
      formData.append("cedula", cedula);
      formData.append("telefono", telefono);

      fetch("../../controllers/router.php?op=updateUser", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          console.log(response);
          if (response.ok) {
            swal("Excelente!", "Transacción realizada con éxito", "success");
          }
        })
        .catch((error) => {
          // Capturar y manejar cualquier error que ocurra durante la solicitud
          console.error("Error al enviar los datos:", error);
        });
    });

    document.getElementById("btnCambiarPass").addEventListener("click", function () {
      const id = document.getElementById("id").value;
      const pass = document.getElementById("pass").value;
      const confpass = document.getElementById("confPass").value;
  
      // Validar que las contraseñas coincidan
      if (pass !== confpass) {
          swal("Error", "Las contraseñas no coinciden", "error");
          return; // Detener el envío del formulario si las contraseñas no coinciden
      }
  
      // Validar que la longitud de la contraseña sea al menos 8 caracteres
      if (pass.length < 8) {
          swal("Error", "La contraseña debe tener al menos 8 caracteres", "error");
          return; // Detener el envío del formulario si la contraseña es demasiado corta
      }
  
      // Si pasa la validación, continuar con el envío de datos
      const formData = new FormData();
      formData.append("pass", pass);
      formData.append("id_user", id);
  
      fetch("../../controllers/router.php?op=cambiarPass", {
          method: "POST",
          body: formData,
      })
      .then((response) => {
          console.log(response);
          if (response.ok) {
              swal("Excelente!", "Transacción realizada con éxito", "success");
          }
      })
      .catch((error) => {
          // Capturar y manejar cualquier error que ocurra durante la solicitud
          console.error("Error al enviar los datos:", error);
      });
  });
  
});
