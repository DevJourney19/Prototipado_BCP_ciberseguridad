<?php
include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerUsuario.php';
$entradas = new ControllerEntradas();
$entradas->validarEntrada('index.php');

$sql = "SELECT * FROM usuario WHERE id_usuario = " . $_SESSION['id_usuario'];
if ($_SESSION['estado_dispositivo'] === 'seguro') {
    echo 'Es un dispositivo seguro';
} else if ($_SESSION['estado_dispositivo'] === 'activado') {
    echo 'Es un dispositivo activado';
}
try {
    conectar();
    $resultado = consultar($sql);
    $nombre = $resultado[0]["nombre"];
    unset($resultado);
    desconectar();
} catch (Exception $exc) {
    die($exc->getMessage());
}

$daoUsuario = new ControllerUsuario();
$usuario = $daoUsuario->obtenerUsuario($_SESSION['id_seguridad']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../view/fragmentos/head.php' ?>
    <title>Principal</title>
</head>

<body>
    <header>
        <?php include '../view/fragmentos/nav.php' ?>
    </header>
    <div id="alerta_intruso" class="notificacion close">
        <div class="bcp_alerta">
            <img src="img/bcp_logo.png" alt="img_bcp.png">
            <div><span class="fa-solid fa-triangle-exclamation fa-xl"></span> Hace 1 min</div>
        </div>
        <div><span>Alguien ha intentado ingresar a tu cuenta con las restricciones activadas.</span>
            <h3>¡¡ALERTA!! SE BLOQUEARÁ LAS TRANSACCIONES</h3>
        </div>
    </div>
    <div class="cuadro_superior">
        <div class="izquierda">
            <<<<<<< HEAD <div><span class="hola">Hola, </span><span><?= $nombre ?></span>
        </div>
        =======
        <div><span class="hola">Hola, </span><span><?= $usuario->getNombre() ?></span></div>
        >>>>>>> 1530d48364483322a7de83750dc61148f72dacc4
        <div class="circulo">
            <img src="img/usuario.png" alt="Perfil Usuario">
        </div>
    </div>
    <div class="derecha">
        <span>Mis productos</span>
        <div class="cuentas">
            <div class="cuenta_1">
                <span>Cuentas de Ahorro</span>
                <span class="amount">S/. 120.40</span>
                <span>**** 2030</span>
            </div>
            <div class="cuenta_2">
                <span>Cuentas de Ahorro</span>
                <span class="amount">S/. 120.40</span>
                <span>**** 2030</span>
            </div>
        </div>
    </div>
    </div>
    <section>
        <div class="fila">

            <div>
                <a href="#">
                    <div class="circulo_naranja"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
                </a>
                <span>Transferir Dinero</span>
            </div>
            <div>
                <a href="yape.php">
                    <div class="circulo_naranja"><i class="fas fa-location-arrow"></i></div>
                </a>
                <span>Yapear Seguro</span>
            </div>
            <div>
                <a href="dispositivos.php">
                    <div class="circulo_naranja"><i class="fa-solid fa-mobile"></i></div>
                </a>
                <span>Gestionar dispositivos</span>
            </div>
            <div>
                <a href="#">
                    <div class="circulo_naranja"><i class="fa-solid fa-droplet"></i></div>
                </a>
                <span>Pagar a Servicios</span>
            </div>

        </div>

        <div class="tarjeta">
            <div class="donaciones">
                <div>
                    <span>Donaciones</span>
                    <p>Transforma vidas y se parte del cambio</p>
                </div>
                <div> <i class="fa-solid fa-heart fa-2xl"></i>
                    <span class="fa-solid fa-chevron-right fa-xl"></span>
                </div>
            </div>
            <div class="seguridad_mejorada">
                <div>
                    <span>Seguridad Mejorada</span>
                    <p>Introduce nuevas funcionalidades y controla tus datos</p>
                </div>
                <div><i class="fa-solid fa-user-lock fa-2xl"></i>
                    <a href="activacion.php" class="fa-solid fa-chevron-right fa-xl"></a>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <?php include '../view/fragmentos/menubar.php' ?>
    </footer>
    <script src="../view/js/index.js"></script>
</body>

</html>