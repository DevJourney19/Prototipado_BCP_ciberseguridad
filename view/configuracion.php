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

    <div id="modal2" class="config blur close">
      <!--BLUR-->
      <div class="modal alerta">
        <div class="modal_info">
          <i class="fa-solid fa-circle-exclamation"></i>
          <h2>Tienes algun reporte de ataque o sospecha?</h2>
        </div>
        <div class="config">
          <div class="config options">
            <div>
              <h3>Elige lo que desea reportar</h3>
              <div>
                <div>
                  <input type="radio" name="reporte" value="Ataque" id="ataque">
                  <label for="ataque"><span><i class="fa-solid fa-bomb" style="color: red;"></i></span>Ataque</label>
                </div>
                <div>
                  <input type="radio" name="reporte" value="Sospecha" id="sospecha">
                  <label for="sospecha"><span><i class="fa-solid fa-exclamation" style="color: orange;"></i></span>Sospecha</label>
                </div>
                <div>
                  <input type="radio" name="reporte" value="Otro" id="otro">
                  <label for="otro"><span><i class="fa-solid fa-question" style="color: #dbca00;"></i></span>Otro</label>
                </div>
              </div>
            </div>
            <div class="form_report">
              <input type="text" name="titulo" placeholder="Ingresa el asunto">
              <textarea rows="5" name="descripcion" id="descripcion" placeholder="Ingresa la descripcion de lo sucedido"></textarea>
            </div>
          </div>
          <div class="config button_modal">
            <button type="button" id="envioReporte" class="aceptar">Enviar</button>
            <button type="button" class="bloquear" id="bloquearReporte">Cancelar</button>
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
    <?php if (isset($_SESSION["id_seguridad"])) { ?>
      <div class="btns-reports">
        <button id="abrirModal">
          <i class="fa-solid fa-clipboard-list"></i>
          <span>Ayúdanos para mejorar tu experiencia</span>
        </button>
        <button id="abrirModal2">
          <i class="fa-solid fa-comment"></i>
          <span>Si tienes algun reporte no te olvides avisarnos!</span>
        </button>
      </div>
    <?php } ?>
  </section>
  <footer>
    <?php include '../view/fragmentos/menubar.php' ?>
  </footer>
  <script src="../view/js/index.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.querySelector('#modal');
      const modal2 = document.querySelector('#modal2');
      const abrirModal = document.querySelector('#abrirModal');
      const abrirModal2 = document.querySelector('#abrirModal2');
      const bloquear = document.querySelector('#bloquear');
      const bloquearReporte = document.querySelector('#bloquearReporte');
      abrirModal.addEventListener('click', () => {
        modal.classList.remove('close');
      })
      bloquear.addEventListener('click', () => {
        modal.classList.add('close');
      })
      abrirModal2.addEventListener('click', () => {
        modal2.classList.remove('close');
      })
      bloquearReporte.addEventListener('click', () => {
        modal2.classList.add('close');
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
      
      const boton2 = document.querySelector('#envioReporte');
      boton2.addEventListener('click', async () => {
        const tipo = document.querySelector('input[name="reporte"]:checked').value;
        const titulo = document.querySelector('input[name="titulo"]').value;
        const descripcion = document.querySelector('textarea[name="descripcion"]').value;
        await fetch("../controller/ControllerReportes.php?action=registrar", {
            method: "POST",
            body: JSON.stringify({
              tipo: tipo,
              titulo: titulo,
              descripcion: descripcion
            }),
          })
          .then((response) => response.json())
          .then((data) => {
            console.log("Resultado:", data);
            if (data.status == "registrado") {
              alert("Gracias!\nRevisaremos tu reporte lo más pronto posible");
            } else {
              alert("Error al enviar los datos");
            }
            document.querySelector('#modal2').classList.add('close');
          })
          .catch((error) => {
            console.error("Error al enviar los datos:", error);
          });
      })

    })
  </script>
</body>

</html>