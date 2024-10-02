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

    <title>Dispositivos</title>
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
        <div class="contenido-principal">
            <div class="titulo">
                <h4>Dispositivos Vinculados</h4>
            </div>
            <div class="subtitulo">
                <p>Estos son los dispositivos que se encuentran vinculados en tu banca móvil.</p>
            </div>
        </div>
        <div class="tabla">
            <div class="contenido-izq">
                <div class="caja">
                    <div class="primero">
                        <div class="imagen">
                            <img src="img/icono_cel.png" alt="Imagen de celular">
                        </div>
                        <div class="seccion">
                            <div class="titulo-caja">
                                <h4>
                                    iPhone
                                </h4>
                            </div>
                            <div class="descripcion-caja">
                                <p>Lugar: Av Lomas - SMP
                                    IP: 192.168.769
                                    Ingreso: 05/09/2024</p>  

                            </div>
                        </div>
                    </div>
                    <div class="segundo">
                        
                    </div>
                </div>
                <div class="caja">
                    aaaaaaaaaaaa
                </div>
                <div class="caja">
                    aaaaaaaaaaaaaa
                </div>
            </div>
            <div class="contenido-der">
                <div class="caja">
                    aaaaaaaaaaa
                </div>
                <div class="caja">
                    aaaaaaaaaaaaaaaaaaa
                </div>
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