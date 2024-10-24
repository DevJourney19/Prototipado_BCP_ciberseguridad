<?php
include_once 'php/util/validar_entradas.php';
include 'php/util/connection.php';
validar_entrada('index.php');
// verificar si ya ha sido contratado el servicio

$sql = "SELECT * FROM seguridad WHERE id_usuario = " . $_SESSION['id'];
try {
    conectar();
    $resultado = consultar($sql);
    $datos = $resultado;

    desconectar();
} catch (Exception $exc) {
    die($exc->getMessage());
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Activacion</title>
</head>

<body>
    <header>
        <?php include 'fragmentos/nav.php' ?>
    </header>
    <div id="alerta_exito_activacion" class="notificacion close">
        <i class="fa-solid fa-circle-check" style="color: #63E6BE;"></i>
        <span>El cargo se ha realizado exitosamente</span>
    </div>
    <main>
        <h1>Activación de Nuevo Sistema Seguridad</h1>
        <div class="flex">
            <div class="primer_cuadro">
                <p>
                    Adquiere el servicio y comienza a sentirte ¡más seguro!
                </p>
                <ul>
                    <li>Código antes de tus transacciones con Yape.</li>
                    <li>Establecer ubicaciones seguras y horarios para realizar operaciones bancarias.</li>
                    <li>Verificar los dispositivos vinculados a tu cuenta desde cualquier tipo de equipo.</li>
                </ul>
            </div>
            <div class="segundo_cuadro">
                <div class="plan_seguro">
                    <img src="img/caja_fuerte.png" alt="plan_seguro.jpg">
                    <div>
                        <h4>Plan Seguro</h4>
                        <h3>S/10/mes</h3>
                    </div>
                </div>
                <p>Ingrese sus datos para realizar el cargo a la cuenta</p>
                <form action="#">
                    <div><input id="nombre_activacion" type="text" placeholder="Nombre Completo de la tarjeta" <?php if ($datos != null)
                                echo 'disabled'; ?>></div>
                    <div><input id="telefono_activacion" type="text" placeholder="Teléfono" <?php if ($datos != null)
                                echo 'disabled'; ?>></div>
                    <div><input id="correo_activacion" type="text" placeholder="Correo" <?php if ($datos != null)
                                echo 'disabled'; ?>></div>
                    <div><input id="checkbox_activacion" class="checkbox" type="checkbox" data-required="1" <?php if ($datos != null)
                                echo 'disabled'; ?>>
                        <span>Acepto los <a href="#">Términos y Condiciones</a></span>
                    </div>
                    <span id="error_activacion"></span>
                    <div class="button"><button id="button_activacion" type="submit"
                            onclick="controlarFormulario(event)" <?php if ($datos != null)
                                echo 'disabled'; ?>>
                            Registrar</button></div>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <?php include 'fragmentos/menubar.php' ?>
    </footer>
    <script src="js/index.js"></script>
    <script src="js/utils.js"></script>

</body>

</html>