<?php
include_once '/app/controller/ControllerEntradas.php';
include_once '/app/controller/ControllerSeguridad.php';
session_start();
$entradas = new ControllerEntradas();
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);

$seguridad = new ControllerSeguridad();
$datos2 = $seguridad->obtenerSeguridadUsuario($_SESSION['id_usuario'])[0];

?>

<html lang="es">

<head>
    <?php include_once '/app/view/fragmentos/head.php' ?>
    <title>Yape Seguro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <header>
        <?php include_once '/app/view/fragmentos/nav.php' ?>
        <?php include_once '/app/view/fragmentos/tabs.php' ?>
    </header>
    <main class="contenedor-yape-seguro">
        <div class="icono-fila">
            <i class="fa-solid fa-money-bill-transfer"></i>
            <h2>Yapeo Seguro</h2>
        </div>
        <div class="contenedor-texto">
            <?php if (!$datos2["estado_yape"]) { ?>
                <p>Al darle aceptar cuando realices un yapeo, recibirás un código de un solo uso para comprobar la veracidad
                    de la transacción.</p>
                <button id="activar">Sí, deseo utilizar Yapeo Seguro</button>
            <?php } else { ?>
                <p>Ya cuentas con Yapeo Seguro, puedes deshabilitarlo pero ya no obtendrás el código de verificación.</p>
                <button id="activar">Ya no deseo Yape Seguro</button>
            <?php } ?>

        </div>
    </main>

    <footer>
        <?php include_once '/app/view/fragmentos/menubar.php' ?>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const boton = document.querySelector('#activar');
            const estado = <?php echo $datos2["estado_yape"] ? 'false' : 'true' ?>;
            boton.addEventListener('click', async () => {
                await fetch("/app/controller/ControllerEstadoFunciones.php", {
                    method: "POST",
                    body: JSON.stringify({
                        estado: estado,
                        funcion: "estado_yape"
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log("Resultado:", data);
                        if (data.status == "activado") {
                            alert("Yapeo seguro activado");
                            location.reload();
                        } else {
                            alert("Yapeo seguro desactivado");
                            location.reload();
                        }
                    })
                    .catch((error) => {
                        console.error("Error al enviar los datos:", error);
                    });
            })
        })
    </script>
    <script src="js/utils.js"></script>
    <script src="js/index.js"></script>
</body>

</html>