<?php
include_once '../php/util/validar_entradas.php';
include_once '../php/util/connection.php';
validar_entrada('index.php');
// verificar si ya ha sido contratado el servicio
validar_servicio('principal.php');

$sql = "SELECT * FROM seguridad WHERE id_usuario = " . $_SESSION['id_usuario'];
try {
  conectar();
  $resultado2 = consultar($sql);
  if ($resultado2) {
    $datos2 = $resultado2[0];
  } else {
    $datos2 = null;
  }

  unset($resultado2);
  desconectar();
} catch (Exception $exc) {
  die($exc->getMessage());
}

?>

<html lang="es">

<head>
  <?php include_once '../view/fragmentos/head.php' ?>
  <title>Cancelar Servicio</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <header>
    <?php include_once '../view/fragmentos/nav.php' ?>
    <?php include_once '../view/fragmentos/tabs.php' ?>
  </header>
  <main class="contenedor-cancelar">
    <div>
      <div class="icono-fila">
        <i class="fa-solid fa-user-pen"></i>
        <h2>Estas apunto de cancelar el servicio</h2>
      </div>
      <div class="contenedor-texto">
        <p>Una vez que termine el mes, ya no se te cobrará el cargo del servicio y perderas el acceso a las funcionalidades inmediatamente.</p>
      </div>
      <div class="contenedor-info">
        <i class="fa-solid fa-info"></i>
        <span>No te preocupes! La data que has registrado estará guardada cuando desees volver a activar el servicio</span>
      </div>
      <div class="options">
        <a href="configuracion.php">Seguir subscrito</a>
        <button id="cancelarSubscripcion"><span>Cancelar mi subscripción</span> <i class="fa-solid fa-angle-right"></i></button>
      </div>
    </div>
  </main>

  <footer>
    <?php include_once '../view/fragmentos/menubar.php' ?>
  </footer>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const boton = document.querySelector('#cancelarSubscripcion');
      const estado = <?php echo $datos2["activacion_seguridad"] ? 'false' : 'true' ?>;
      boton.addEventListener('click', async () => {
        await fetch("../php/estado_funcionalidades.php", {
            method: "POST",
            body: JSON.stringify({
              estado: estado,
              funcion: "activacion_seguridad"
            }),
          })
          .then((response) => response.json())
          .then((data) => {
            console.log("Resultado:", data);
            if (data.status == "desactivado") {
              window.location.href = "principal.php";
            }
          })
          .catch((error) => {
            console.error("Error al enviar los datos:", error);
          });
      })
    })
  </script>
  <script src="../view/js/utils.js"></script>
  <script src="../view/js/index.js"></script>
</body>

</html>