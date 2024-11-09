<?php
include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerSeguridad.php';
$entradas = new ControllerEntradas();
$entradas->validarEntrada('index.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include '../view/fragmentos/head.php' ?>
  <title>Configuración</title>
</head>

<body>
  <header>
    <?php include '../view/fragmentos/nav.php' ?>
    <div class="head-config">
      <h2>Configuración</h2>
    </div>
  </header>
  <section>

    <div id="modal" class="config blur close">
      <!--BLUR-->
      <div class="modal alerta">
        <div class="modal_info">
          <i class="fa-regular fa-face-grin-squint"></i>
          <h2>¿Qué tan satisfecho te encuentras con nuestro servicio?</h2>
        </div>
        <div class="config">
          <div class="config options">
            <div>
              <input type="radio" name="emotion" value="Muy insatisfecho" id="muyInsatisfecho">
              <label for="muyInsatisfecho"><span><i class="fa-regular fa-face-tired" style="color: red;"></i></span>Muy insatisfecho</label>
            </div>
            <div>
              <input type="radio" name="emotion" value="Insatisfecho" id="insatisfecho">
              <label for="insatisfecho"><span><i class="fa-regular fa-face-frown-open" style="color: orange;"></i></span>Insatisfecho</label>
            </div>
            <div>
              <input type="radio" name="emotion" value="Neutral" id="neutral">
              <label for="neutral"><span><i class="fa-regular fa-face-meh" style="color: #dbca00;"></i></span>Neutral</label>
            </div>
            <div>
              <input type="radio" name="emotion" value="Satisfecho" id="satisfecho">
              <label for="satisfecho"><span><i class="fa-regular fa-face-smile" style="color: #3aca00;"></i></span>Satisfecho</label>
            </div>
            <div>
              <input type="radio" name="emotion" value="Muy satisfecho" id="muySatisfecho" checked>
              <label for="muySatisfecho"><span><i class="fa-regular fa-face-grin-hearts" style="color: #175200;"></i></span>Muy satisfecho</label>
            </div>
          </div>
          <div class="config button_modal">
            <button type="button" id="envioEmocion" class="aceptar">Enviar</button>
            <button type="button" class="bloquear" id="bloquear">Cancelar</button>
          </div>
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
              <h3>Configuración de tarjetas</h3>
              <span>Gestiona tus tarjetas y agrega más</span>
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
              <span>Selecciona el método de tu preferencia</span>
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
    <?php if(isset($_SESSION["id_seguridad"])) {?>
    <button id="abrirModal">
      <i class="fa-solid fa-clipboard-list"></i>
      <span>Ayúdanos resolviendo una encuesta para mejorar tu experiencia</span>
    </button>
    <?php } ?>
  </section>
  <footer>
    <?php include '../view/fragmentos/menubar.php' ?>
  </footer>
  <script src="../view/js/index.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.querySelector('#modal');
      const abrirModal = document.querySelector('#abrirModal');
      const bloquear = document.querySelector('#bloquear');
      abrirModal.addEventListener('click', () => {
        modal.classList.remove('close');
      })
      bloquear.addEventListener('click', () => {
        modal.classList.add('close');
      })

      const boton = document.querySelector('#envioEmocion');
      boton.addEventListener('click', async () => {
        const estado = document.querySelector('input[name="emotion"]:checked').value;
        await fetch("../controller/ControllerEmocion.php", {
            method: "POST",
            body: JSON.stringify({
              estado: estado
            }),
          })
          .then((response) => response.json())
          .then((data) => {
            console.log("Resultado:", data);
            if (data.status == "registrado") {
              alert("Gracias por tu opinion");
            } else {
              alert("Error al enviar los datos");
            }
            document.querySelector('#modal').classList.add('close');
          })
          .catch((error) => {
            console.error("Error al enviar los datos:", error);
          });
      })
    })
  </script>
</body>

</html>