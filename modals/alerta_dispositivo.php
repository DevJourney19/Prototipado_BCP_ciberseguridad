<div id="modal" class="blur">
  <!--BLUR-->
  <div class="modal alerta close">
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
        <button type="button" id="envioCodigo" class="aceptar">Si, enviar codigo</button>
        <button type="button" class="bloquear" id="bloquear">No, bloquear</button>
      </div>
    </div>
  </div>

  <div class="modal codigo">
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
          <button type="submit" class="aceptar">Verificar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('envioCodigo').addEventListener('click', function() {
    document.querySelector('.modal.alerta').classList.add('close');
    document.querySelector('.modal.codigo').classList.remove('close');
  });

  document.getElementById('bloquear').addEventListener('click', function() {
    document.getElementById('modal').classList.add('close');
  });

  document.getElementById('cancelar').addEventListener('click', function() {
    document.getElementById('modal').classList.add('close');
  });
</script>