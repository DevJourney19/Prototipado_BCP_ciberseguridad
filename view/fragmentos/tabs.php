<?php
include_once '../controller/ControllerSeguridad.php';

$controllerSeguridad = new ControllerSeguridad();
$resultado = $controllerSeguridad->obtenerUsuario($_SESSION['id']);

$datos = isset($resultado[0]['estado_horas_direcciones']) ? $resultado[0]['estado_horas_direcciones'] : false;
?>

<div class="tabs">
  <div class="tabs_encabezado">
    <div>
      <a href="configuracion.php"><i class="fa-solid fa-arrow-left"></i></a>
      <div class="tab_title">
        <span>Seguridad</span>
        <i class="fa-solid fa-shield"></i>
      </div>
    </div>
    <label class="switch">
      <input id="switchCheckbox" type="checkbox" <?php echo $datos ? 'checked' : ''; ?>>
      <span class="slider"></span>
    </label>
  </div>
  <div class="tabs_body">
    <a class="tab-link" href="horario_ubicacion.php">Rango Horario y Ubicacion</a>
    <a class="tab-link" href="dispositivos.php">Dispositivos Vinculados</a>
    <a class="tab-link" href="yape_seguro.php">Yape Seguro</a>
    <a class="tab-link" href="cancelar_servicio.php">Cancelar Servicio</a>
  </div>
</div>

<script>
  const switchCheckbox = document.getElementById('switchCheckbox');
  const estado = <?php echo $datos ? 'true' : 'false' ?>;

  switchCheckbox.addEventListener('change', async () => {
    const response = await fetch("../controller/ControllerEstadoFunciones.php", {
      method: "POST",
      body: JSON.stringify({
        estado: !estado, // Cambia el estado cuando se haga clic
        funcion: "estado_horas_direcciones",
      }),
    })
    .then((response) => response.json())
    .then((data) => {
      console.log("Resultado:", data);
      if (data.status == "activado") {
        alert("Restricciones activadas");
      } else {
        alert("Restricciones desactivadas");
      }
      location.reload(); 
    })
    .catch((error) => {
      console.error("Error al enviar los datos:", error);
    });
  });
</script>
<<<<<<< HEAD
=======

<script>
  const links = document.querySelectorAll('.tab-link');

  const activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    document.querySelector(`a[href="${activeTab}"]`)?.classList.add('active');
  }

  links.forEach(link => {
    link.addEventListener('click', function(event) {
      links.forEach(link => link.classList.remove('active'));
      event.currentTarget.classList.add('active');

      localStorage.setItem('activeTab', event.currentTarget.getAttribute('href'));
    });
  });
</script>
>>>>>>> 1530d48364483322a7de83750dc61148f72dacc4
