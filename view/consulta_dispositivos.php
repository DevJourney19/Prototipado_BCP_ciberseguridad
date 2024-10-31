<?php
$inc = include_once("../php/util/connection.php");

if ($inc) {
    session_start();
    //Obtenemos el id del usuario que ingreso a la cuenta
    $id_usuario = $_SESSION['id_usuario'];
    conectar();
    /*Quiero mostrar la información almacenada de la tabla dispositivos, para ello necesito el id del usuario, y 
    de ahi el id de seguridad, para recien llegar al dispositivo, el cual su llave foranea es el id_seguro*/
    $array_seguridad = consultar(query: "Select id_seguridad from seguridad where id_usuario='$id_usuario'");
    /*Necesito el id_seguridad porque de esta manera me relacionaría con la otra tabla dispositivos, teniendo 
    en cuenta que por cada usuario solo podrá tener 1 cuenta activada.*/

    $id_seguridad = $array_seguridad[0]['id_seguridad'] ?? "";
    $_SESSION['id_seguridad'] = $id_seguridad;
    /*Se va a filtrar todos los dispositivos almacenados de la base de datos con parametros si estan establecidos 
    como inseguros y por el id de seguridad activado, el cual está relacionado de 1 a 1 con la información del cliente.*/
    /*$consulta = consultar("Select id_dispositivo, tipo_dispositivo, direccion_ip, 
    pais, ciudad, estado_dispositivo, fecha_registro, ultima_conexion from dispositivo where id_seguridad='$id_seguridad' AND (estado_dispositivo='en_proceso_si' || estado_dispositivo='en_proceso_no')");*/
    desconectar();
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

                <tbody id="tabla_dispositivos"></tbody>


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