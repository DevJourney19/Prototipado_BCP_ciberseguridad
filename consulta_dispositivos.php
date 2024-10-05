<?php
$inc = include_once("php/util/connection.php");
if ($inc) {
    conectar();
    $consulta = consultar("Select dispositivo_seguro, tipo_dispositivo, direccion_ip, 
    pais, ciudad, fecha_registro from dispositivos where dispositivo_seguro= 0");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/head.php' ?>
    <link href="dispositivos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <title>Historial de intentos de acceso de dispositivos</title>
</head>

<body>
    <header>
        <?php include 'fragmentos/nav.php' ?>
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
                <tr>
                    <th>Dispositivo seguro</th>
                    <th>Dispositivo</th>
                    <th>Direccion IP</th>
                    <th>Pais</th>
                    <th>Ciudad</th>
                    <th>Fecha de Registro</th>
                    <th colspan="2">Acciones</th>
                    

                </tr>
                <form action="#">
                    <?php if ($consulta) {
                        //Se va a guardar los datos en cada posicion de un array
                        //al hacer la consulta te retorna ya con el array.
                        foreach ($consulta as $row) {
                            $dispo_seguro = $row["dispositivo_seguro"];
                            $tipo_dispositivo = $row["tipo_dispositivo"];
                            $direccion_ip = $row["direccion_ip"];
                            $pais = $row["pais"];
                            $ciudad = $row["ciudad"];
                            $fecha_registro = $row["fecha_registro"];
                            ?>
                            <tr>
                                <td><?= $dispo_seguro ?></td>
                                <td><?= $tipo_dispositivo ?></td>
                                <td><?= $direccion_ip ?></td>
                                <td><?= $pais ?></td>
                                <td><?= $ciudad ?></td>
                                <td><?= $fecha_registro ?></td>
                                <td><button class="botoncito_accion_vincular">Vincular <i class="fa-solid fa-link"></i></button></td>
                                <td><button class="botoncito_accion_bloquear">Bloquear <i class="fa-solid fa-ban"></i></button></td>
                            </tr>
                        <?php }
                    } ?>
                </form>
            </table>
           
        </div>
        <a class="botoncito" href="dispositivos.php">Regresar</a>
    </main>
    <footer>
        <?php include 'fragmentos/menubar.php' ?>
    </footer>
    <script src="js/index.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/dispositivos.js"></script>
</body>

</html>