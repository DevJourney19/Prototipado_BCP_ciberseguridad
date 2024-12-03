<?php
include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerDispositivo.php';
$entradas = new ControllerEntradas();
$dispositivosEnProceso = new ControllerDispositivo();
$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);

$listaDisposEnProceso = $dispositivosEnProceso->obtenerDispositivosEnProceso($_SESSION['id_seguridad']);
if ($listaDisposEnProceso === null or !isset($listaDisposEnProceso)) {
    $listaDisposEnProceso = false;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../view/fragmentos/head.php' ?>
    <link href="css/dispositivos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <title>Historial de intentos de acceso de dispositivos</title>
</head>

<body>
    <header>
        <?php include '../view/fragmentos/nav.php' ?>
        <div id="resultado"></div>
    </header>

    <main>

        <div class="contenido-principal">
            <div class="titulo">
                <h4>Historial de intentos de acceso de dispositivos</h4>
            </div>
            <div class="subtitulo">
                <p>Este es el historial de los dispositivos que han decidido ingresar a su cuenta.</p>

            </div>
        </div>
        <div class="tabla_responsiva">
            <table border="1" class="tablita_equipos_no_deseados">
                <thead>
                    <tr> <!-- EN PROCESO SI ///// //EN PROCESO NO -->
                        <th>Dispositivo</th>
                        <th>Direccion IP</th>
                        <th>Pais</th>
                        <th>Ciudad</th>
                        <th>Valido el codigo?</th>
                        <th>Fecha de Registro</th>
                        <th colspan="3">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (!empty($listaDisposEnProceso)) {
                        foreach ($listaDisposEnProceso as $dispoProcess) { ?>
                            <tr data-id="<?=$dispoProcess['id_dispositivo']?>">
                                <td><?= $dispoProcess['tipo_dispositivo'] ?></td>
                                <td><?= $dispoProcess['direccion_ip'] ?></td>
                                <td><?= $dispoProcess['pais'] ?></td>
                                <td><?= $dispoProcess['ciudad'] ?></td>
                                <td class="estado-dispositivo"><?= $dispoProcess['estado_dispositivo'] ?></td>
                                <td><?= $dispoProcess['fecha_registro'] ?></td>
                                
                                <td><button class="botoncito_accion_permitir accion-boton" data-id="<?=$dispoProcess['id_dispositivo']?>"
                                        data-accion="permitir">Permitir</button></td>
                                <td><button class="botoncito_accion_eliminar accion-boton" data-id="<?=$dispoProcess['id_dispositivo']?>"
                                        data-accion="eliminar">Eliminar</button></td>
                                <td><button class="botoncito_accion_bloquear accion-boton" data-id="<?=$dispoProcess['id_dispositivo']?>"
                                        data-accion="bloquear">Bloquear</button></td>
                            </tr>;

                        <?php }
                    } ?>

                </tbody>

            </table>

        </div>
        <a class="botoncito" href="dispositivos.php">Regresar</a>
    </main>
    <footer>
        <?php include '../view/fragmentos/menubar.php' ?>
    </footer>
    <script src="../view/js/index.js"></script>
    <script src="../view/js/utils.js"></script>
    <script src="../view/js/dispositivos.js"></script>
</body>

</html>