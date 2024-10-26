<?php
include_once 'php/util/validar_entradas.php';
include 'php/util/connection.php';
validar_entrada('index.php');

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include 'fragmentos/head.php' ?>
  <title>Configuracion</title>
</head>

<body>
  <header>
    <?php include 'fragmentos/nav.php' ?>
    <div class="head-config">
      <h2>Configuracion</h2>
    </div>
  </header>
  <section>

    <div id="modal" class="blur close">
      <!--BLUR-->
      <div class="modal alerta">
        <div>
        <i class="fa-regular fa-face-grin-squint"></i>
          <h2>Que tan satisfecho te encuentras con nuestro servicio?</h2>
        </div>
        <div class="button_modal">
          <button type="button" id="envioCodigo" class="aceptar">Enviar</button>
          <button type="button" class="bloquear" id="bloquear">Cancelar</button>
        </div>
      </div>
    </div>


    <div class="section-config">
      <div>
        <div>
          <div>
            <i class="fa-solid fa-user"></i>
            <div>
              <h3>Perfil</h3>
              <span>Configura tu perfil</span>
            </div>
          </div>
          <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div>
          <div>
            <i class="fa-solid fa-credit-card"></i>
            <div>
              <h3>Configuracion de tarjetas</h3>
              <span>Gestiona tus tarjetas y agrega mas</span>
            </div>
          </div>
          <i class="fa-solid fa-chevron-right"></i>
        </div>
      </div>
      <div>
        <div>
          <div>
            <i class="fa-solid fa-shield-halved"></i>
            <div>
              <h3>Seguridad</h3>
              <span>Selecciona el metodo de tu preferencia</span>
            </div>
          </div>
          <a href="horario_ubicacion.php"><i class="fa-solid fa-chevron-right"></i></a>
        </div>
        <div>
          <div>
            <i class="fa-solid fa-file-invoice"></i>
            <div>
              <h3>Historial de Transacciones</h3>
              <span>Visualiza tus transacciones realizadas</span>
            </div>
          </div>
          <i class="fa-solid fa-chevron-right"></i>
        </div>
      </div>
    </div>
    <button>
      <i class="fa-solid fa-clipboard-list"></i>
      <span>Ayudanos resolviendo una encuesta para mejorar tu experiencia</span>
    </button>
  </section>
  <footer>
    <?php include 'fragmentos/menubar.php' ?>
  </footer>
  <script src="js/index.js"></script>
</body>

</html>