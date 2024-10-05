<?php
$inc = include_once("fragmentos/conexion.php");
if ($inc) {
    $consulta = "Select tipo_dispositivo, direccion_ip, pais, ciudad, fecha_registro from dispositivos";
    $resultado = mysqli_query($enlace, $consulta);
}
?>

<!DOCTYPE html>
<html lang="en">

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

        <table>
            <tr>
                <th>Dispositivo</th>
                <th>Direccion IP</th>
                <th>Pais</th>
                <th>Ciudad</th>
                <th>Fecha de Registro</th>
            </tr>
            <?php if ($resultado) {
                //Se va a guardar los datos en cada posicion de un array
                while ($row = $resultado->fetch_array()) {
                    $tipo_dispositivo = $row["tipo_dispositivo"];
                    $direccion_ip = $row["direccion_ip"];
                    $pais = $row["pais"];
                    $ciudad = $row["ciudad"];
                    $fecha_registro = $row["fecha_registro"];
                    ?>
                    <tr>
                        <td><?= $tipo_dispositivo ?></td>
                        <td><?= $direccion_ip ?></td>
                        <td><?= $pais ?></td>
                        <td><?= $ciudad ?></td>
                        <td><?= $fecha_registro ?></td>
                    </tr>
                <?php }
            } ?>
        </table>

        <script src="js/index.js"></script>
        <script src="js/utils.js"></script>
        <script src="js/dispositivos.js"></script>
</body>

</html>