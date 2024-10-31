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
    /*Se va a filtrar todos los dispositivos almacenados de la base de datos con parametros si estan establecidos 
    como inseguros y por el id de seguridad activado, el cual está relacionado de 1 a 1 con la información del cliente.*/
    $consulta = consultar("Select id_dispositivo, tipo_dispositivo, direccion_ip, 
    pais, ciudad, estado_dispositivo, fecha_registro, ultima_conexion from dispositivo where id_seguridad='$id_seguridad' AND (estado_dispositivo='en_proceso_si' || estado_dispositivo='en_proceso_no')");
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
                <tr> <!-- EN PROCESO SI ///// //EN PROCESO NO -->
                    <th>Dispositivo</th>
                    <th>Direccion IP</th>
                    <th>Pais</th>
                    <th>Ciudad</th>
                    <th>Valido el codigo?</th>
                    <th>Fecha de Registro</th>
                    <th colspan="3">Acciones</th>
                </tr>

                <?php if ($consulta) {
                    foreach ($consulta as $row) {
                        $tipo_dispositivo = $row["tipo_dispositivo"];
                        $direccion_ip = $row["direccion_ip"];
                        $pais = $row["pais"];
                        $ciudad = $row["ciudad"];
                        $estado_dispositivo = $row["estado_dispositivo"];
                        $fecha_registro = $row["fecha_registro"];
                        $id_dispositivo = $row["id_dispositivo"];
                        ?>
                        <tr>

                            <td><?= htmlspecialchars($tipo_dispositivo) ?></td>
                            <td><?= htmlspecialchars($direccion_ip) ?></td>
                            <td><?= htmlspecialchars($pais) ?></td>
                            <td><?= htmlspecialchars($ciudad) ?></td>
                            <?php if ($estado_dispositivo === 'en_proceso_si') { ?>
                                <td>Si</td>
                            <?php } else { ?>
                                <td>No</td>
                            <?php } ?>
                            <td><?= htmlspecialchars($fecha_registro) ?></td>
                            <form action="../php/acciones_dispositivo.php" method="POST">
                                <!-- Se obtiene el id por cada fila del dispositivo-->
                                <input type="hidden" name="id_dispositivo" value="<?= htmlspecialchars($id_dispositivo) ?>">
                                <td><button type="submit" class="botoncito_accion_permitir" name="accion"
                                        value="permitir">Permitir <i class="fa-solid fa-check"></i></button>
                                </td>

                                <td><button type="submit" class="botoncito_accion_eliminar" name="accion"
                                        value="eliminar">Eliminar <i class="fa-solid fa-x"></i></button>
                                </td>


                                <td><button type="submit" class="botoncito_accion_bloquear" name="accion"
                                        value="bloquear">Bloquear <i class="fa-solid fa-ban"></i></button>
                                </td>
                            </form>
                        </tr>
                    <?php }
                } ?>

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