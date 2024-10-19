<?php
include_once 'php/util/validar_entradas.php';
include 'php/util/connection.php';
validar_entrada('index.php');
// verificar si ya ha sido contratado el servicio
validar_servicio('principal.php');

$sql = "SELECT * FROM seguridad WHERE id_usuario = " . $_SESSION['id'] . " AND estado_yape= true";
try {
    conectar();
    $resultado = consultar($sql);
    $datos = $resultado;
    unset($resultado);
    desconectar();
} catch (Exception $exc) {
    die($exc->getMessage());
}

?>

<html lang="es">

<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Yape Seguro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <?php include 'fragmentos/nav.php' ?>
        <?php include 'fragmentos/tabs.php' ?>
    </header>
    <main class="contenedor-yape-seguro">
        <div class="icono-fila">
            <i class="fa-solid fa-money-bill-transfer"></i>
            <h2>Yapeo Seguro</h2>
        </div>
        <div class="contenedor-texto">
            <?php if (count($datos) == 0) { ?>
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
        <?php include 'fragmentos/menubar.php' ?>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const boton = document.querySelector('#activar');
            const estado = <?php echo count($datos) == 0 ? 'false' : 'true' ?>;
            boton.addEventListener('click', async () => {
                await fetch("./php/estado_funcionalidades.php", {
                        method: "POST",
                        body: JSON.stringify({
                            estado: !estado,
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
</body>

</html>