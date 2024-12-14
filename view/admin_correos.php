<?php include_once '/app/controller/ControllerEntradas.php';
include_once '/app/controller/ControllerUsuario.php';
$entradas = new ControllerEntradas();
$entradas->validarEntrada('login_admin.php');

$usuarioDao = new ControllerUsuario();
$usuarios = $usuarioDao->obtenerUsuarios();
$admin = $usuarioDao->obtenerUsuario($_SESSION['id_usuario'], "usuario");

$lista_llave = false;
if (!empty($usuarios)) {
    $lista_llave = true;
}
$count = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '/app/view/fragmentos/head.php' ?>
    <link href="/app/view/css/admin.css" rel="stylesheet" />
    <title>Enviar correos - Admin</title>
</head>

<body class="body_dashboard" style="background: white;">
    <header>
        <?php include_once '/app/view/fragmentos/nav_close_admin.php' ?>
        <?php include_once '/app/view/fragmentos/nav_admin.php' ?>
    </header>

    <main class="main_dashboard" style="
    background: white;
    color: black;width:80%; margin: auto;">

        <h1 class="h1_dashboard" style="color: #02173f;"><i class="fa-solid fa-paper-plane" style="color: #02173f;"></i>
            Enviar correos - Admin</h1>
        <span id="admin_nombre" data-value="<?= htmlspecialchars($admin->getNombre()) ?>"></span>
        <p class="description">Aquí puede enviar correos a los clientes que adquirieron el servicio de
            ciberseguridad.
        </p>
        <hr style="width: 70%" />

        <div class="container">
            <div class="header" style="margin-bottom: 0px;">
                <button class="btn enviar-emails" name="enviarform" id="openModal">Elegir tipo de correo</button>
            </div>

        </div>
        <div class=" tabla_correo">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Correo electrónico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($lista_llave) {
                        /*en el name correo[], se implementó para poder almacenar en un array 
                        el valor del correo de los checkboxes seleccionados, y no solo del último 
                        checkbox que fue seleccionado*/
                        foreach ($usuarios as $user) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>
                                <input type="hidden" name="ids[]" value="<?= $user->getIdUsuario() ?>" />
                                <input type="hidden" name="correo[]" value="<?= $user->getCorreo() ?>" />
                                <td><?= $user->getNombre(); ?></td>
                                <td><?= $user->getCorreo(); ?></td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </main>


    <div id="customModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Seleccione el contenido a enviar de manera masiva</h2>
            <hr style="border: 1px solid lightgray;" />
            <br />
            <h3 style="color:#ff7900" class="msg_especifico_correo">Mensajes específicos</h3>
            <div class="mensaje_especifico_correo">
                <div class="col_mensaje_especifico">
                    <h2>Direcciones configuradas</h2>
                    <button data-especifico="1">Enviar</button>
                </div>
                <div class="col_mensaje_especifico">
                    <h2>Horas configuradas</h2>
                    <button data-especifico="2">Enviar</button>
                </div>
                <div class="col_mensaje_especifico">
                    <h2>Acceso de dispositivos</h2>
                    <button data-especifico="3">Enviar</button>
                </div>
                <div class="col_mensaje_especifico">
                    <h2>Configuración de dispositivos</h2>
                    <button data-especifico="4">Enviar</button>
                </div>
                <div class="col_mensaje_especifico">
                    <h2>Si el yape está activado</h2>
                    <button data-especifico="5">Enviar</button>
                </div>
            </div>

            <!--LOGICA COMPLETADA-->
            <h3 style="color:#ff7900; margin-top: 10px;">Mensajes predeterminados</h3>
            <div class="eleccion_contenido_correo">
                <div class="mensaje_predeterminado">
                    <h2>Consejos</h2>
                    <div class="image-container" onclick="showFullscreen(event)">
                        <img src="/app/view/img/img_cb_1.jpg" alt="img_1" style="width:100%">
                    </div>
                    <button type="submit" style="background: #ff7900;color:white" onclick="enviarCorreo(event)"
                        data-opcion="1">Enviar</button>
                </div>
                <div class="mensaje_predeterminado">
                    <h2>Novedades</h2>
                    <div class="image-container" onclick="showFullscreen(event)">
                        <img src="/app/view/img/img_cb_2.jpg" alt="img_2" style="width:100%">
                    </div>
                    <button type="submit" style="background: #ff7900;color:white" onclick="enviarCorreo(event)"
                        data-opcion="2">Enviar</button>
                </div>
                <div class="mensaje_predeterminado">
                    <h2>Recordatorio</h2>
                    <div class="image-container" onclick="showFullscreen(event)">
                        <img src="/app/view/img/img_cb_3.jpg" alt="img_3" style="width:100%">
                    </div>
                    <button type="submit" style="background: #ff7900;color:white" onclick="enviarCorreo(event) "
                        data-opcion="3">Enviar</button>
                </div>

                <!-- Modal para mostrar la imagen en pantalla completa -->
                <div class="fullscreen-modal" id="fullscreen-modal">
                    <img id="fullscreen-image" src="" alt="Imagen en pantalla completa">
                </div>
            </div>
        </div>
    </div>
    <script src="/app/view/js/admin_correo.js"></script>
</body>

</html>