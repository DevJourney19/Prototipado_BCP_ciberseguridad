function getCurrentPosition() {
  return new Promise((resolve, reject) => {
    navigator.geolocation.getCurrentPosition(resolve, reject);
  });
}

const controlarFormulario = async (event) => {
  event.preventDefault();
  const nombre = document.getElementById("nombre_activacion").value;
  const correo = document.getElementById("correo_activacion").value;
  const telefono = document.getElementById("telefono_activacion").value;
  const checkbox = document.getElementById("checkbox_activacion").checked;
  const error = document.getElementById("error_activacion");
  const alertaExito = document.getElementById("alerta_exito_activacion");

  error.innerHTML = "";

  if (nombre === "" || correo === "" || telefono === "" || !checkbox) {
    error.innerHTML = "Por favor, complete todos los campos.";
    return;
  }

  if (telefono.length < 9 && telefono.match(/^[0-9]+$/)) {
    error.innerHTML = "El teléfono debe tener al menos 9 dígitos.";
    return;
  }

  document.getElementById("telefono_activacion").disabled = true;
  document.getElementById("nombre_activacion").disabled = true;
  document.getElementById("correo_activacion").disabled = true;
  document.getElementById("button_activacion").disabled = true;

  const position = await getCurrentPosition();
  const latitud = position.coords.latitude;
  const longitud = position.coords.longitude;

  console.log(latitud, longitud);

  await fetch("/app/controller/ControllerVerifySession.php")
    .then((response) => response.json())
    .then(async (data) => {
      //Si la sesion esta activa
      if (data.status === true) {
        // obtener el id del usuario
        const userId = data.id;
        // enviar los datos al servidor
        await fetch("/app/controller/ControllerActivarSeguridad.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            userId,
            telefono: document.getElementById("telefono_activacion").value,
            correo: document.getElementById("correo_activacion").value,
            latitud,
            longitud,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            console.log("Datos enviados:", data);
          })
          .catch((error) => {
            console.error("Error al enviar los datos:", error);
          });
      } else {
        console.log("No hay sesion activa");
      }
    })
    .catch((error) => {
      console.error("Error al verificar la sesión:", error);
    });

  alertaExito.classList.remove("close");

  setTimeout(() => {
    alertaExito.classList.add("close");
  }, 3000);

  document.getElementById("nombre_activacion").value = "";
  document.getElementById("correo_activacion").value = "";
  document.getElementById("telefono_activacion").value = "";
  document.getElementById("checkbox_activacion").checked = false;
};

document.addEventListener("DOMContentLoaded", () => {
  const elems = document.querySelectorAll(".tab-link");
  const switchElement = document.querySelector(".switch");
  const path = window.location.pathname.split(
    "/Prototipado_BCP_ciberseguridad/view/"
  )[1];
  switch (path) {
    case "horario_ubicacion.php":
      elems[0].classList.add("active");
      break;
    case "dispositivos.php":
      switchElement.classList.add("disabled");
      elems[1].classList.add("active");
      break;
    case "yape_seguro.php":
      switchElement.classList.add("disabled");
      elems[2].classList.add("active");
      break;
    case "cancelar_servicio.php":
      switchElement.classList.add("disabled");
      elems[3].classList.add("active");
      break;
  }
});
