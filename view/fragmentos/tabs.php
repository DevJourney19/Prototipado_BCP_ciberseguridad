<?php

include_once '../controller/ControllerSeguridad.php';

$controllerSeguridad = new ControllerSeguridad();

$resultado = $controllerSeguridad->obtenerSeguridadUsuario($_SESSION['id_usuario']);
if (isset($resultado[0]['estado_hora_direccion']) && $resultado[0]['estado_hora_direccion'] !== null) {
  $datos = $resultado[0]['estado_hora_direccion'];
} else {
  $datos = false;
}
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
          funcion: "estado_hora_direccion",
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

  const links = document.querySelectorAll('.tab-link');

  // Obtener la URL actual
  const currentUrl = window.location.href;

  // Marcar la pestaña activa según la URL actual
  links.forEach(link => {
    if (link.href === currentUrl) {
      link.classList.add('active');
    }
  });

  // Ocultar el switchCheckbox si la URL no es horario_ubicacion.php
  if (!currentUrl.includes('horario_ubicacion.php')) {
    switchCheckbox.style.display = 'none';
  }

  // Añadir event listeners a cada enlace de pestaña
  links.forEach(link => {
    link.addEventListener('click', function(event) {
      // Eliminar la clase 'active' de todos los enlaces
      links.forEach(link => link.classList.remove('active'));
      // Añadir la clase 'active' al enlace clicado
      event.currentTarget.classList.add('active');

      // Guardar la URL en localStorage
      localStorage.setItem('activeTab', event.currentTarget.href);
    });
  });

  // Escuchar cambios en la URL
  window.addEventListener('popstate', function() {
    const newActiveTab = window.location.href;
    links.forEach(link => link.classList.remove('active'));
    document.querySelector(`a[href="${newActiveTab}"]`)?.classList.add('active');

    // Ocultar el switchCheckbox si la URL no es horario_ubicacion.php
    if (!newActiveTab.includes('horario_ubicacion.php')) {
      switchCheckbox.style.display = 'none';
    } else {
      switchCheckbox.style.display = 'block';
    }
  });
</script>