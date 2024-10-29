<?php
include_once '../php/util/validar_entradas.php';
include_once '../php/util/connection.php';
validar_entrada('index.php');
// verificar si ya ha sido contratado el servicio
validar_servicio('principal.php');
// verificar si la funcion de yape ha sido activada

$id_seguridad = $_SESSION['id_seguridad'] ?? null; // Usando coalescencia nula

if ($id_seguridad === null) {
    return null; // Maneja el caso donde id_seguridad no está definido
}



$sql = "SELECT * FROM seguridad WHERE id_seguridad = '" . $id_seguridad . "' AND estado_yape = 1";
try {
    conectar();
    $resultadoYape = consultar($sql);
    if (count($resultadoYape) == 0) {
        $estado = 0;
    } else {
        $estado = 1;
    }
    desconectar();
} catch (Exception $exc) {
    die($exc->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../view/fragmentos/head.php' ?>
    <title>Simulación de Yapeo</title>
</head>

<body class="fondo-yape">
    <div class="contenedor-yape">
        <div id="alerta_codigo_otp" class="notificacion close">
            <i class="fa-regular fa-envelope" style="color:red"></i>
            <div>
                <span>Código OTP para confirmar tu yapeo</span>
                <span id="codigoOTP"></span>
            </div>
        </div>
        <div class="logo-yape">
            <img src="img/logo_yape.png" alt="Logo Yape" width=100 height=100>
        </div>
        <div class="contenedor-datos">
            <h2>Yapear a</h2>
            <div class="nombre-yape">Amanda Raquel Rodriguez</div>
            <div class="monto-yape">
                <span>S/</span><input type="number" class="digitar-monto" value="0" min="1" max="500"></input>
            </div>
            <div class="mensaje-fijo">Puedes yapear hasta S/ 500 diarios</div>
            <input type="text" class="mensaje-yape" placeholder="Agregar mensaje">
            <div class="contenedor-botones">
                <button class="btn-otros">Otros Bancos</button>
                <button class="btn-yapear" <?php
                if ($estado == 1) {
                    ?> onclick="abrirModal()" <?php } ?>>Yapear</button>
            </div>
        </div>
    </div>
    <div class="modal-yape" id="modal-token">
        <div class="contenedor-modal">
            <h3>Ingrese el Token Secreto<br>para continuar el yapeo</h3>
            <div class="contenedor-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
            </div>
            <div class="botones-modal">
                <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-aceptar" onclick="verificarCodigo()">Aceptar</button>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/@otplib/preset-browser@^12.0.0/buffer.js"></script>
    <script src="https://unpkg.com/@otplib/preset-browser@^12.0.0/index.js"></script>
    <script type="text/javascript">
        function generarToken() {
            document.getElementById('alerta_codigo_otp').classList.remove('close');
            if (window.otplib) {
                const {
                    authenticator
                } = window.otplib;
                const secret = authenticator.generateSecret();
                const token = authenticator.generate(secret);
                document.getElementById('codigoOTP').innerText = token;
            } else {
                console.error('otplib no esta cargando');
            }
        }

        function abrirModal() {
            generarToken();
            const token = document.getElementById('codigoOTP').innerText;
            const inputs = document.getElementsByClassName('input-token');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = token[i];
            }
            document.getElementById('modal-token').classList.add('active');
            // si no se presiona en 30 segundos, cerrar el modal y borrar el código
            setTimeout(() => {
                cerrarModal();
            }, 30000);
        }

        function cerrarModal() {
            document.getElementById('alerta_codigo_otp').classList.add('close');
            document.getElementById('modal-token').classList.remove('active');
            document.getElementById('codigoOTP').innerText = '';
            const inputs = document.getElementsByClassName('input-token');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }
        }

        function verificarCodigo() {
            const token = document.getElementById('codigoOTP').innerText;
            const tokenElements = document.getElementsByClassName('input-token');
            let tokenIngresado = '';
            Array.from(tokenElements).forEach((element) => {
                tokenIngresado += element.value;
            });
            if (token === tokenIngresado) {
                alert('Yapeo exitoso');
                cerrarModal();
                document.getElementsByClassName('digitar-monto')[0].value = 0;
                document.getElementsByClassName('mensaje-yape')[0].value = '';
            } else {
                alert('Código incorrecto');
            }
        }
    </script>
</body>

</html>