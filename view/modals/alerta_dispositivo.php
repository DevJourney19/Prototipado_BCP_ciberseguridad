<div id="modal" class="blur ">
  <!--BLUR-->
  <div class="modal alerta">
    <div>
      <i class="fa-solid fa-vault"></i>
      <h2>Estas intentando ingresar desde otro dispositivo?</h2>
    </div>
    <div>
      <div class="description">
        <span>Tipo: <?= $_SESSION['dispositivo'] ?></span>
        <span>Ubicacion: <?= $_SESSION['ciudad'] ?>, <?= $_SESSION['pais'] ?></span>
        <span>Hora: <?= $_SESSION['hora'] ?></span>
      </div>
      <div class="button_modal">
        <button type="button" id="envioCodigo" class="aceptar" onclick="enviarCodigo()">Si, enviar codigo</button>
        <button type="button" class="bloquear" id="bloquear">No</button>
      </div>
    </div>
  </div>

  <div class="modal codigo close">
    <div>
      <i class="fa-solid fa-vault"></i>
      <h2>Ingresa el codigo que se te envio al correo o sms</h2>
    </div>
    <div>
      <div class="description">
        <p>Por tu seguridad, te hemos enviado un codigo de verificacion a tu correo electronico y sms que has
          registrado. Por favor, ingresalo para continuar.</p>
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
          <!-- <button type="button" class="reenviar">Reenviar</button> -->
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://unpkg.com/@otplib/preset-browser@^12.0.0/buffer.js"></script>
<script src="https://unpkg.com/@otplib/preset-browser@^12.0.0/index.js"></script>
<script type="text/javascript">
  let secret;
  let token;
  let timeoutHandle = 0;

  const inputs = document.querySelectorAll('input[type=number]');

  inputs.forEach((input, index) => {
    input.addEventListener('input', function () {
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
      alert("Codigo enviado a tu correo");
      //Aparece el modal para ingresar el código a verificar
      document.querySelector('.modal.alerta').classList.add('close');
      document.querySelector('.modal.codigo').classList.remove('close');
    }
    resetTimeout();
  }

  async function verificarCodigo(event) {
    event.preventDefault;
    const tokenElements = document.getElementsByClassName('input-token');
    let tokenIngresado = '';
    Array.from(tokenElements).forEach((element) => {
      tokenIngresado += element.value;
    });
    if (token === tokenIngresado) {
      alert('Código exitoso, necesita validación');
      // latitud y longitud
      let latitud = 0;
        let longitud = 0;
        navigator.geolocation.getCurrentPosition((position) => {
          latitud = position.coords.latitude;
          longitud = position.coords.longitude;
        });
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

        window.location.href = "./index.php";

      } catch (error) {
        console.error('Error al establecer la sesión: ', error);
      };

    } else { 
      alert('Código incorrecto');
      try {
        const response = await fetch('../controller/ControllerDispositivo.php?action=getUsuario&cambio=true', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ token_validado: false })
        });
        const textResponse = await response.text(); 
        console.log(textResponse); 

        const data = JSON.parse(textResponse);
        //const data = await response.json();

        window.location.href = "./index.php";

      } catch (error) {
        console.error('Error al establecer la sesión: ', error);
      };
    }
    resetTimeout();
  }

  document.getElementById('bloquear').addEventListener('click', function () {
    document.getElementById('modal').classList.add('close');
  });

  document.getElementById('cancelar').addEventListener('click', function () {
    document.getElementById('modal').classList.add('close');
  });
</script>