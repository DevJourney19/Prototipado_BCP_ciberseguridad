<?php
include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerUsuario.php';
$entradas = new ControllerEntradas();
$entradas->validarEntrada('login_admin.php');

$usuarioDao = new ControllerUsuario();
$usuarios = $usuarioDao->obtenerUsuarios();
$lista_llave = false;
if (!empty($usuarios)) {
    $lista_llave = true;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../view/fragmentos/head.php' ?>
    <link href="../view/css/admin.css" rel="stylesheet" />
    <title>Enviar correos - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            grid-template-rows: auto 1fr auto;
        }

        .container {
            margin: 20px auto;
            max-width: 800px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-direction: column;
            flex-wrap: nowrap;
            text-align: center;
            gap: 10px;
        }

        .header .select-all label {
            font-size: 14px;
            color: #333;
            cursor: pointer;
        }

        .header .info {
            font-size: 14px;
            color: #555;
        }

        .header .btn.enviar-emails {
            background-color: #FF7900;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
            display: none;
        }

        .ver_btn_enviar_email {
            display: block !important;
        }

        .header .btn.enviar-emails:hover {
            background-color: #de6900;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .custom-table th {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        .custom-table td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            font-size: 14px;
            text-align: left;
        }

        .custom-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .custom-table input[type="checkbox"] {
            cursor: pointer;
        }

        .custom-table td:last-child {
            text-align: center;
            font-size: 18px;
            color: #4caf50;
        }

        .tabla_correo {
            overflow-x: auto;
            width: 100%;
            margin-bottom: 10%;
        }

        main {
            padding: 30px 0px 10px 0px;
        }

        /* Estilo base del modal */
        .modal {
            /* Oculto por defecto */
            display: none;
            position: fixed;
            z-index: 1000;

            width: 100%;
            height: 100%;
            /* Fondo semitransparente */
            background-color: rgba(0, 0, 0, 0.5);
            /* Aplicar desenfoque */
            backdrop-filter: blur(8px);
            border-radius: 0px;

        }

        /* Contenido del modal */
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;

            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: black;
        }

        /* Botón de cierre */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            display: block !important;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .eleccion_contenido_correo {
            display: flex;
            flex-direction: column;
            width: 400px;
            margin: 18px auto;
            gap: 10px;
        }

        .image-container {
            position: relative;
            width: 200px;
            cursor: pointer;
        }

        .image-container img {
            width: 100%;
            height: auto;
        }

        /* Estilos para el modal */
        .fullscreen-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .fullscreen-modal img {
            max-width: 90%;
            max-height: 90%;
        }

        .fullscreen-modal:target {
            display: flex;
        }

        @media (min-width: 610px) {
            .eleccion_contenido_correo {
                flex-direction: row;
            }
        }
    </style>
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
        <p class="description">Aquí puede enviar correos a los clientes que adquirieron el servicio de
            ciberseguridad.
        </p>
        <hr style="width: 70%" />

        <div class="container">
            <div class="header">
                <div class="select-all">
                    <label><input type="checkbox" id="select-all" onclick="seleccionar_todo()"> Marcar todos</label>
                </div>
                <div class="info">
                    <p>Tienes Actualmente <span id="selected-count">0</span> Registros Seleccionado(s)</p>
                </div>
                <button class="btn enviar-emails" name="enviarform" id="openModal">Seleccionar correos</button>
            </div>

        </div>
        <div class=" tabla_correo">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Correo electrónico</th>
                        <th>Estado de Notificación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($lista_llave) {
                        /*en el name correo[], se implementó para poder almacenar en un array 
                        el valor del correo de los checkboxes seleccionados, y no solo del último 
                        checkbox que fue seleccionado*/
                        foreach ($usuarios as $user) { ?>
                            <tr>
                                <td><input class="checkbox_seleccionado" type="checkbox" name="correo[]"
                                        value="<?= $user->getCorreo() ?>"></td>
                                <td><?= $user->getNombre(); ?></td>
                                <td><?= $user->getCorreo(); ?></td>
                                <td>✔</td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </main>
    <!--Logica codigo enviar correo -->
    <form action="../view/admin_proceso_correo.php" method="post">
    </form>
    <!-- -->

    <div id="customModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Seleccione el contenido a enviar</h2>
            <p>Aquí seleccionará el contenido que se enviará a los usuarios seleccionados</p>
            <div class="eleccion_contenido_correo">

                <div class="image-container" onclick="showFullscreen(event)">
                    <img src="../view/img/img_1_info.jpg" alt="img_1" style="width:100%">

                    <button type="submit" style="background: #ff7900;color:black">Enviar</button>
                </div>
                <div class="image-container" onclick="showFullscreen(event)">
                    <img src="../view/img/img_2_info.jpg" alt="img_2" style="width:100%">
                    <button type="submit" style="background: #ff7900;color:black">Enviar</button>
                </div>
                <div class="image-container" onclick="showFullscreen(event)">
                    <img src="../view/img/img_3_info.jpg" alt="img_3" style="width:100%">
                    <button type="submit" style="background: #ff7900;color:black">Enviar</button>
                </div>

                <!-- Modal para mostrar la imagen en pantalla completa -->
                <div class="fullscreen-modal" id="fullscreen-modal">
                    <img id="fullscreen-image" src="" alt="Imagen en pantalla completa">
                </div>
            </div>
        </div>
    </div>
    <script src="../view/js/admin_correo.js"></script>
    <script>
        document.getElementById('openModal').onclick = function () {
            document.getElementById('customModal').style.display = 'flex';
        };

        document.querySelector('.close').onclick = function () {
            document.getElementById('customModal').style.display = 'none';
        };

        window.onclick = function (event) {
            if (event.target == document.getElementById('customModal')) {
                document.getElementById('customModal').style.display = 'none';
            }
        };
        function showFullscreen(event) {
            // Obtener el modal y la imagen seleccionada
            const modal = document.getElementById('fullscreen-modal');
            const fullscreenImage = document.getElementById('fullscreen-image');

            // Actualizar la fuente de la imagen en el modal
            fullscreenImage.src = event.target.src;

            // Mostrar el modal
            modal.style.display = 'flex';

            // Cerrar el modal cuando se haga clic
            modal.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }
    </script>
</body>

</html>