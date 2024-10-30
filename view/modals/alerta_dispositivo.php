<div id="modal" class="blur close">
  <!--BLUR-->
  <div class="modal alerta">
    <div>
      <i class="fa-solid fa-vault"></i>
      <h2>Estas intentando ingresar desde otro dispositivo?</h2>
    </div>
    <div>
      <div class="description">
        <span>Tipo: Laptop</span>
        <span>Ubicacion: Lima, Peru</span>
        <span>Hora: 14:00</span>
      </div>
      <div class="button_modal">
        <button type="button" id="envioCodigo" class="aceptar" onclick="enviarCodigo()">Si, enviar codigo</button>
        <button type="button" class="bloquear" id="bloquear">No, bloquear</button>
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
        <p>Para tu seguridad, te hemos enviado un codigo de verificacion a tu correo electronico y sms que has registrado. Por favor, ingresalo para continuar.</p>
      </div>
      <form action="#" class="form_verificacion">
        <div class="contenedor-token">
          <input type="number" maxlength="1" class="input-token" min="0">
          <input type="number" maxlength="1" class="input-token" min="0">
          <input type="number" maxlength="1" class="input-token" min="0">
          <input type="number" maxlength="1" class="input-token" min="0">
          <input type="number" maxlength="1" class="input-token" min="0">
          <input type="number" maxlength="1" class="input-token" min="0">
        </div>
        <div class="button_modal">
          <button type="button" id="cancelar" class="bloquear">Cancelar</button>
          <button type="submit" class="aceptar" onclick="verificarCodigo()">Verificar</button>
          <button type="button" class="reenviar">Reenviar</button>
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
      token = authenticator.generate(secret);
      return token;
    } else {
      console.error('otplib no esta cargando');
    }
  }

  async function enviarCodigo() {
    const token = generarToken();
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
      console.log("Resultado:", data);
    } catch (error) {
      console.error("Error al enviar los datos:", error);
    } finally {
      alert("Codigo enviado a tu correo");
      document.querySelector('.modal.alerta').classList.add('close');
      document.querySelector('.modal.codigo').classList.remove('close');
    }
    resetTimeout();
  }

  function verificarCodigo() {
    const tokenElements = document.getElementsByClassName('input-token');
    let tokenIngresado = '';
    Array.from(tokenElements).forEach((element) => {
      tokenIngresado += element.value;
    });
    if (token === tokenIngresado) {
      alert('Ingreso exitoso');
      document.getElementById('modal').classList.add('close');
    } else {
      alert('Código incorrecto');
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