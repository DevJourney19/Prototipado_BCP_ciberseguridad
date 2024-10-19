<?php
include_once 'php/util/validar_entradas.php';
include 'php/util/connection.php';
validar_entrada('index.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Principal</title>
</head>

<body>
    <header>
        <?php include 'fragmentos/nav.php' ?>
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
            <div><span class="hola">Hola, </span><span>Yoshua</span></div>
            <div class="circulo">
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
                    <div class="circulo_naranja"></div>
                </a>
                <span>Transferir Dinero</span>
            </div>
            <div>
                <a href="yape_seguro.php">
                    <div class="circulo_naranja"></div>
                </a>
                <span>Yapear Seguro</span>
            </div>
            <div>
                <a href="dispositivos.php">
                    <div class="circulo_naranja"></div>
                </a>
                <span>Gestionar dispositivos</span>
            </div>
            <div>
                <a href="#">
                    <div class="circulo_naranja"></div>
                </a>
                <span>Pagar a Servicios</span>
            </div>

        </div>

        <div class="tarjeta">
            <div class="donaciones">
                <div>
                    <span>Donaciones</span>
                    <p>Transforma vidas y sé parte del cambio</p>
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
                <div><i class="fa-solid fa-user-lock"></i>
                    <a href="activacion.php" class="fa-solid fa-chevron-right fa-xl"></a>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <?php include 'fragmentos/menubar.php' ?>
    </footer>
    <script src="js/index.js"></script>
</body>

</html>