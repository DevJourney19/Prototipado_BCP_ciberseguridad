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
        }

        .header .btn.enviar-emails:hover {
            background-color: #7b1fa2;
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
            padding: 10px 0px 10px 0px;
            ;
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
        <p class="description">Aquí puede enviar correos a los clientes que adquirieron el servicio de ciberseguridad.
        </p>
        <hr style="width: 70%" />
        <div class="container">
            <div class="header">
                <div class="select-all">
                    <label><input type="checkbox" id="select-all"> Marcar todos</label>
                </div>
                <div class="info">
                    <p>Tienes Actualmente <span id="selected-count">4</span> Registros Seleccionado(s)</p>
                </div>
                <button class="btn enviar-emails">ENVIAR EMAILS</button>
            </div>

        </div>
        <div class="tabla_correo">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Estado de Notificación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($lista_llave) {
                        foreach ($usuarios as $user) { ?>
                            <tr>
                                <td><input type="checkbox" checked></td>
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



</body>

</html>