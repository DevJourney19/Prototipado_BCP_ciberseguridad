<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/head.php' ?>
    <link href="css/dispositivos.css" rel="stylesheet">
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
            <!--Necesito crear esto por js -->
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
                                <p>
                                    Lugar: Av Lomas - SMP
                                    IP: 192.168.769
                                    Ingreso: 05/09/2024
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="segundo">
                        <input type="radio" name="vinculo" id="dispositivo1" checked>
                        <label for="dispositivo1"><span class="radio-button"></span></label>
                    </div>
                </div>
            </div>
            <!--
                <div class="caja">
                    <div class="primero">
                        <div class="imagen">
                            <img src="img/laptop.png" alt="Imagen de celular">
                        </div>
                        <div class="seccion">
                            <div class="titulo-caja">
                                <h4>
                                    Laptop
                                </h4>
                            </div>
                            <div class="descripcion-caja">
                                <p>
                                Lugar: Av Lomas - SMP IP: 192.168.769 Ingreso: 05/09/2024
                                </p>

                            </div>
                        </div>
                    </div>

                    <div class="segundo">
                        <input type="radio" name="vinculo" id="dispositivo2">
                        <label for="dispositivo2"><span class="radio-button"></span></label>
                    </div>

                </div>
                <div class="caja">
                    <div class="primero">
                        <div class="imagen">
                            <img src="img/computadora.png" alt="Imagen de celular">
                        </div>
                        <div class="seccion">
                            <div class="titulo-caja">
                                <h4>
                                    Computadora
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
                        <input type="radio" name="vinculo" id="dispositivo3">
                        <label for="dispositivo3"><span class="radio-button"></span></label>
                    </div>
                </div>
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
                        <input type="radio" name="vinculo" id="dispositivo4">
                        <label for="dispositivo4"><span class="radio-button"></span></label>
                    </div>
                </div>
                <div class="caja">
                    <div class="primero">
                        <div class="imagen">
                            <img src="img/laptop.png" alt="Imagen de celular">
                        </div>
                        <div class="seccion">
                            <div class="titulo-caja">
                                <h4>
                                    Laptop
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
                        <input type="radio" name="vinculo" id="dispositivo5">
                        <label for="dispositivo5"><span class="radio-button"></span></label>
                    </div>
                </div>
                <div class="caja">
                    <div class="primero">
                        <div class="imagen">
                            <img src="img/computadora.png" alt="Imagen de celular">
                        </div>
                        <div class="seccion">
                            <div class="titulo-caja">
                                <h4>
                                    Computadora
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
                        <input type="radio" name="vinculo" id="dispositivo6">
                        <label for="dispositivo6"><span class="radio-button"></span></label>
                    </div>
                </div>

            </div>
        </div>
        -->
            <div class="opciones">
                <div class="boton-primario">
                    <button type="button" onclick="openModal()">Dispositivo Principal</button>
                </div>
                <div class="boton-secundario">
                    <button type="button" onclick="openModalDos()">Desvincular</button>
                </div>
                <div class="boton-primario">
                    <button type="button" id="historial">Historial de intentos de acceso de dispositivos</button>
                </div>
            </div>
    </main>
    <footer>
        <?php include 'fragmentos/menubar.php' ?>
    </footer>
    <dialog class="dispositivo-vinculados" id="vinculo">
        <div class="imagen">
            <img src="img/touch.png" alt="touch">
        </div>
        <div class="texto">
            <p>¿Estas seguro que deseas establecer el dispositivo como principal?</p>
        </div>
        <div class="opciones-modal">
            <div class="boton-primario-modal">
                <button type="button" onclick="closeModal()">Aceptar</button>
            </div>
            <div class="boton-secundario-modal">
                <button type="button" onclick="closeModal()">Cancelar</button>
            </div>
        </div>
    </dialog>
    <dialog class="dispositivo-vinculados" id="desvinculo">
        <div class="imagen">
            <img src="img/desvincular.png" alt="desvinular">
        </div>
        <div class="texto">
            <p>¿Estas seguro que deseas desvincular este dispositivo?</p>
        </div>
        <div class="opciones-modal">
            <div class="boton-primario-modal">
                <button type="button" onclick="closeModalDos()">Aceptar</button>
            </div>
            <div class="boton-secundario-modal">
                <button type="button" onclick="closeModalDos()">Cancelar</button>
            </div>
        </div>
    </dialog>
    <script src="js/index.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/dispositivos.js"></script>
</body>

</html>