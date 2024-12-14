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
    <title>Login | Administrador</title>
    <link href="../view/css/style_login.css" rel="stylesheet">
    <link rel="shortcut icon" href="../view/img/bcp_logo.png" type="image/x-icon">
</head>

<body>
    <main>
        <div class="logo"><img src="../view/img/loguito.png" alt="logo_bcp.jpg"></div>
        <div class="flex">
            <div class="img_trabajador"><img src="../view/img/trabajador_bcp.jpg" alt="imagen_login.jpg"></img></div>
            <div class="iniciar_sesion">
                <h1>Ingresa tus datos de Administrador</h1>
                <form action="/controller/ControllerAdminLogin.php" method="POST" autocomplete="off">
                    <div><input type="text" placeholder="Email" name="email"></div>
                    <div><input type="text" placeholder="Nombre Completo" name="nombre"></div>
                    <div><input type="password" placeholder="Contraseña" name="password"></div>
                    <?php if ($error != null): ?>
                        <p class="error"><?= $error ?></p>
                    <?php endif; ?>
                    <button type="submit">Ingresar</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>