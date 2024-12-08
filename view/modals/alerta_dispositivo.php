<div id="modal" class="blur ">
  <!--BLUR-->
  <div class="modal alerta">
    <div>
      <i class="fa-solid fa-user-lock"></i>
      <h2>Estás intentando ingresar desde otro dispositivo?</h2>
    </div>
    <div>
      <div class="description">
        <span>Tipo: <?= $_SESSION['dispositivo'] ?></span>
        <span>Ubicación: <?= $_SESSION['ciudad'] ?>, <?= $_SESSION['pais'] ?></span>
        <span>Hora: <?= $_SESSION['hora'] ?></span>
      </div>
      <div class="button_modal">
        <button type="button" id="envioCodigo" class="aceptar" onclick="enviarCodigo()">Sí, enviar código</button>
        <button type="button" class="bloquear" id="bloquear">No</button>
      </div>
    </div>
  </div>

  <div class="modal codigo close">
    <div>
      <i class="fa-solid fa-vault"></i>
      <h2>Ingresa el código que se te envió al correo o SMS</h2>
    </div>
    <div>
      <div class="description">
        <p>Por tu seguridad, te hemos enviado un código de verificación a tu correo electrónico y SMS que has
          registrado. Por favor, ingrésalo para continuar.</p>
      </div>
      <form action="#" class="form_verificacion">
        <div class="contenedor-token">
          <input type="number" max="1" class="input-token" min="0">
          <input type="number" max="1" class="input-token" min="0">
          <input type="number" max="1" class="input-token" min="0">
          <input type="number" max="1" class="input-token" min="0">
          <input type="number" max="1" class="input-token" min="0">
          <input type="number" max="1" class="input-token" min="0">
        </div>
        <div class="button_modal">
          <button type="button" id="cancelar" class="bloquear">Cancelar</button>
          <button type="submit" class="aceptar" onclick="verificarCodigo(event)">Verificar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal de Envío de Correo -->
<div id="modalCorreo" class="modal advertencia close">
  <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#856404">
    <path
      d="M638-80 468-250l56-56 114 114 226-226 56 56L638-80ZM480-520l320-200H160l320 200Zm0 80L160-640v400h206l80
   80H160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v174l-80 80v-174L480-440Zm0 0Zm0-80Zm0 80Z" />
  </svg>
  <p>Código enviado, revise su bandeja de entrada</p>
</div>

<div id="modalExito" class="modal advertencia exito close">
  <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#314D1C">
    <path
      d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
  </svg>
  <p>Código correcto. ¡Acceso autorizado!</p>
</div>

<div id="modalError" class="modal advertencia error close">
  <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#8C1A10">
    <path
      d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 
    28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
  </svg>
  <p>Código incorrecto. Intenta nuevamente.</p>
</div>

<script src="https://unpkg.com/@otplib/preset-browser@^12.0.0/buffer.js"></script>
<script src="https://unpkg.com/@otplib/preset-browser@^12.0.0/index.js"></script>
<script type="text/javascript">
  let secret;
  let token;
  let timeoutHandle = 0;

  const inputs = document.querySelectorAll('input[type=number]');

  inputs.forEach((input, index) => {
    input.addEventListener('input', function() {
      // Si la longitud del valor del input es igual a su máximo
      if (this.value.length >= this.max) {
        // Mueve el foco al siguiente input
        if (index + 1 < inputs.length) {
          inputs[index + 1].focus();
        }
      }
    });
  });

  function resetTimeout() {
    clearTimeout(timeoutHandle);
    timeoutHandle = setTimeout(() => {
      generarToken();
    }, 60000);
  }

  function generarToken() {
    if (window.otplib) {
      const {
        authenticator
      } = window.otplib;
      secret = authenticator.generateSecret();
      const tokenGenerado = authenticator.generate(secret); //se va a generar por defecto un codigo de 6 digitos
      return tokenGenerado;
    } else {
      console.error('otplib no esta cargando');
    }
  }


  async function enviarCodigo() {
    document.getElementById("envioCodigo").disabled = true; //Evitar hacer multiples clics en el botón
    token = generarToken(); //Se va a enviar el token al ControllerEnvioCodigo.php
    try {
      const response = await fetch("../controller/ControllerEnvioCodigo.php", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          codigo: token
        }),
      });

      const data = await response.json();

    } catch (error) { //Problemita a resolver 
      console.error("Error al enviar los datos:", error);
    } finally {
      mostrarModalTemporal('modalCorreo');
      //Aparece el modal para ingresar el código a verificar
      document.querySelector('.modal.alerta').classList.add('close');
      document.querySelector('.modal.codigo').classList.remove('close');
    }
    resetTimeout();
  }

  function mostrarModalTemporal(modalId, duracion = 5000) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('close');
    modal.classList.add('open');

    setTimeout(() => {
      modal.classList.remove('open');
      modal.classList.add('close');
    }, duracion);
  }

  function mostrarModalExito(modalExito, duracion = 3000) {
    const modal = document.getElementById(modalExito);
    modal.classList.remove('close');
    modal.classList.add('open');

    setTimeout(() => {
      modal.classList.remove('open');
      modal.classList.add('close');
    }, duracion);
  }

  function mostrarModalError(modalError, duracion = 3000) {
    const modal = document.getElementById(modalError);
    modal.classList.remove('close');
    modal.classList.add('open');

    setTimeout(() => {
      modal.classList.remove('open');
      modal.classList.add('close');
    }, duracion);
  }

  function getCurrentPosition() {
    return new Promise((resolve, reject) => {
      navigator.geolocation.getCurrentPosition(resolve, reject);
    });
  }

  async function verificarCodigo(event) {
    event.preventDefault();
    const tokenElements = document.getElementsByClassName('input-token');
    let tokenIngresado = '';
    Array.from(tokenElements).forEach((element) => {
      tokenIngresado += element.value;
    });
    if (token === tokenIngresado) {
      // latitud y longitud
      const position = await getCurrentPosition();
      const latitud = position.coords.latitude;
      const longitud = position.coords.longitude;

      mostrarModalExito('modalExito');
      try {
        const response = await fetch('../controller/ControllerDispositivo.php?action=getUsuario&cambio=true', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            token_validado: true,
            latitud,
            longitud
          })
        });
        const textResponse = await response.text();
        console.log(textResponse);

        const data = JSON.parse(textResponse);

          setTimeout(() => {
            window.location.href = "./principal.php";
          }, 2000)


      } catch (error) {
        console.error('Error al establecer la sesión: ', error);
      };

    } else {
      mostrarModalError('modalError');
      try {
        const response = await fetch('../controller/ControllerDispositivo.php?action=getUsuario&cambio=true', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            token_validado: false
          })
        });
        const textResponse = await response.text();
        console.log(textResponse);

        const data = JSON.parse(textResponse);
        //const data = await response.json();

        //window.location.href = "./index.php";

      } catch (error) {
        console.error('Error al establecer la sesión: ', error);
      };
    }
    resetTimeout();
  }

  document.getElementById('bloquear').addEventListener('click', function() {
    document.getElementById('modal').classList.add('close');
  });

  document.getElementById('cancelar').addEventListener('click', function() {
    document.getElementById('modal').classList.add('close');
  });
</script>