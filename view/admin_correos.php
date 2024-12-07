<?php include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerUsuario.php';
$entradas = new ControllerEntradas();
$entradas->validarEntrada('login_admin.php');

$usuarioDao = new ControllerUsuario();
$usuarios = $usuarioDao->obtenerUsuarios();
if (isset($_SESSION['security'])) {
    $admin = $usuarioDao->obtenerUsuario($_SESSION['security'], "seguridad");
} else {
    $admin = $usuarioDao->obtenerUsuario($_SESSION['security'], "usuario");
}

$lista_llave = false;
if (!empty($usuarios)) {
    $lista_llave = true;
}
$count = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../view/fragmentos/head.php' ?>
    <link href="../view/css/admin.css" rel="stylesheet" />
    <title>Enviar correos - Admin</title>
</head>

<body class="body_dashboard" style="background: white;">
    <header>
        <?php include_once '../view/fragmentos/nav_close_admin.php' ?>
        <?php include_once '../view/fragmentos/nav_admin.php' ?>
    </header>

    <main class="main_dashboard" style="
    background: white;
    color: black;width:80%; margin: auto;">

        <h1 class=" h1_dashboard">Enviar correos - Admin</h1>
        <span id="admin_nombre" data-value="<?= htmlspecialchars($admin->getNombre()) ?>"></span>
        <p class="description">Aquí puede enviar correos a los clientes que adquirieron el servicio de
            ciberseguridad.
        </p>
        <hr style="width: 70%" />

        <div class="container">
            <div class="header">
                <div class="select-all">
                    <label><input type="checkbox" id="select-all" onclick="seleccionar_todo()"> Marcar todo</label>
                </div>
                <div class="info">
                    <p>Tienes Actualmente <span id="selected-count">0</span> Registro(s) Seleccionado(s)</p>
                </div>
                <button class="btn enviar-emails" name="enviarform" id="openModal">Seleccionar correos</button>
            </div>

        </div>
        <div class=" tabla_correo">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Seleccionar</th>
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
                                <td><input class="checkbox_seleccionado" type="checkbox" name="correo[]"
                                        value="<?= $user->getCorreo() ?>"></td>
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
            <h2>Seleccione el contenido a enviar</h2>
            <p>Aquí seleccionará el contenido que se enviará a los usuarios seleccionados</p>
            <div class="eleccion_contenido_correo">
                <div>
                    <div class="image-container" onclick="showFullscreen(event)">
                        <h2>Consejos</h2>
                        <img src="../view/img/img_cb_1.jpg" alt="img_1" style="width:100%">
                    </div>
                    <button type="submit" style="background: #ff7900;color:white" onclick="enviarCorreo(event)"
                        data-opcion="1">Enviar</button>
                </div>
                <div>
                    <div class="image-container" onclick="showFullscreen(event)">
                        <h2>Novedades</h2>
                        <img src="../view/img/img_cb_2.jpg" alt="img_2" style="width:100%">
                    </div>
                    <button type="submit" style="background: #ff7900;color:white" onclick="enviarCorreo(event)"
                        data-opcion="2">Enviar</button>
                </div>
                <div>
                    <div class="image-container" onclick="showFullscreen(event)">
                        <h2>Recordatorio</h2>
                        <img src="../view/img/img_cb_3.jpg" alt="img_3" style="width:100%">
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
    <script src="../view/js/admin_correo.js"></script>
</body>

</html>