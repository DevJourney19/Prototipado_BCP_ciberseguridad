<html lang="es">

<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Yape Seguro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="encabezado">
        <img src="img/loguito.png" alt="Logo BCP">
        <i class="fas fa-sign-out-alt"></i>
    </div>
    <div class="navegacion">
        <div>
            <i class="fas fa-arrow-left"></i>
            <span>Seguridad</span>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="interrupto">
            <span>ON</span>
            <div class="cambiar"></div>
        </div>
    </div>
    <div class="boton-encabezado">
        <a href="horario_ubicacion.php">Rango Horario y Ubicación</a>
        <a href="dispositivos.php">Dispositivos Vinculados</a>
        <a href="activacion.php" class="activo">Yapeo Seguro</a>
        <a href="#">Cancelar Servicio</a>
    </div>
    <div class="contenedor-yape-seguro">
        <div class="icono-fila">
            <i class="fas fa-shield-alt"></i>
            <h2>Yapeo Seguro</h2>
        </div>
        <div class="contenedor-texto">
            <p>Al darle aceptar cuando realices un yapeo, recibirás un código de un solo uso para comprobar la veracidad
                de la transacción.</p>
            <button>Sí, deseo utilizar Yapeo Seguro</button>
        </div>
    </div>
    <footer style="positon: absolute; bottom:0px;">
        <?php include 'fragmentos/menubar.php' ?>
    </footer>
    <script>
        let yapeSeguroActivado = true;

        const boton = document.querySelector('.contenedor-texto button');
        const parrafo = document.querySelector('.contenedor-texto p');

        boton.addEventListener('click', () => {
            if (yapeSeguroActivado) {
                boton.textContent = 'Ya no deseo Yape Seguro';
                parrafo.textContent = 'Ya cuentas con Yapeo Seguro, puedes deshabilitarlo pero ya no obtendrás el código de verificación.';
                yapeSeguroActivado = false;
            } else {
                boton.textContent = 'Sí, deseo utilizar Yapeo Seguro';
                parrafo.textContent = 'Al darle aceptar cuando realices un yapeo, recibirás un código de un solo uso para comprobar la veracidad de la transacción.';
                yapeSeguroActivado = true;
            }
        })
    </script>
</body>

</html>