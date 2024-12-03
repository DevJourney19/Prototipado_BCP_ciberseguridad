<?php

include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerDispositivo.php';
$entradas = new ControllerEntradas();
$dispositivoCtler = new ControllerDispositivo();
$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);
$seguro = null;

if (isset($_SESSION['estado_dispositivo']) && $_SESSION['estado_dispositivo'] === 'seguro') {
    $seguro = true;
}
$dispositivo = $_SESSION['dispositivo'];
$listaDispositivos = $dispositivoCtler->obtenerDispositivosFiltrados($_SESSION['id_seguridad']);


if ($listaDispositivos === null or !isset($listaDispositivos)) {
    $listaDispositivos = false;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once '../view/fragmentos/head.php' ?>
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
        <?php include_once '../view/fragmentos/nav.php' ?>
        <?php include_once '../view/fragmentos/tabs.php' ?>
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

        <div class="tabla grid" id="mensajin">

            <!--Necesito crear esto por js -->

            <?php
            if ($listaDispositivos) {

                $count = 0;
                $llave_dispositivo_principal = false;

                foreach ($listaDispositivos as $dispo) {
                    if ($dispo['estado_dispositivo'] === "activado") {
                        $count++;
                        if ($count >= 3) {
                            echo "<script>alert('Limite máximo de 3 equipos principales');</script>";
                            $llave_dispositivo_principal = true;
                        }
                    }
                    if (isset($dispo['tipo_dispositivo'])) { ?>
                        <div class="caja" data-id="<?= htmlspecialchars($dispo['id_dispositivo']) ?>">
                            <div class="primero">
                                <div class="imagen">

                                    <?php switch ($dispo['tipo_dispositivo']) {
                                        case 'Ordenador de escritorio': ?>
                                            <img src="img/computadora.png" alt="Imagen de celular">

                                            <?php break;
                                        case 'Portátil': ?>
                                            <img src="img/icono_portatil.png" alt="Imagen de portátil">
                                            <?php break;

                                        case 'Tableta': ?>
                                            <img src="img/icono_tableta.png" alt="Imagen de tableta">
                                            <?php break;

                                        case 'Teléfono móvil': ?>
                                            <img src="img/icono_cel.png" alt="Imagen de teléfono móvil">
                                            <?php break;

                                        case 'Smartwatch': ?>
                                            <img src="img/icono_smartwatch.png" alt="Imagen de smartwatch">
                                            <?php break;

                                        case 'Televisor inteligente': ?>
                                            <img src="img/icono_televisor.png" alt="Imagen de televisor inteligente">
                                            <?php break;

                                        case 'Consola de videojuegos': ?>
                                            <img src="img/icono_consola.png" alt="Imagen de consola de videojuegos">
                                            <?php break;

                                        case 'Dispositivo IoT': ?>
                                            <img src="img/icono_iot.png" alt="Imagen de dispositivo IoT">
                                            <?php break;

                                        default: ?>
                                            <p>Tipo de dispositivo no reconocido.</p>
                                    <?php } ?>

                                </div>
                                <div class="seccion">
                                    <div class="titulo-caja">
                                        <h4 <?php if ($dispo['estado_dispositivo'] === "activado") { ?>
                                                style="color: darkorange; font-weight: 800;<?php } else { ?> style=" color: #001843;
                                                font-weight: 600;<?php } ?> ">
                                                                                                                                                                                <?= $dispo['tipo_dispositivo'] ?>
                                                                                                                                                                            </h4>

                                                                                                                                                                        </div>
                                                                                                                                                                        <div class="
                                descripcion-caja">
                                            <p>
                                                Lugar: <?= $dispo['ciudad'] ?>- <?= $dispo['pais'] ?>
                                                <br />
                                                IP: <?= $dispo['direccion_ip'] ?>
                                                <br />
                                                Ingreso: <?= $dispo['ultima_conexion'] ?>
                                            </p>
                                    </div>
                                </div>
                            </div>
                            <div class="segundo">
                                <input type="radio" name="vinculo" onchange="handleCheckboxClick(this)"
                                    id="<?= $dispo['id_dispositivo'] ?>">
                                <label for="<?= $dispo['id_dispositivo'] ?>"><span class="radio-button"></span></label>
                            </div>
                        </div>
                    <?php }
                }
            } ?>
        </div>

        <?php if (!isset($seguro)) { ?>
            <div class="opciones">
                <div class="boton-primario">

                    <button type="button" onclick="openModal()" <?php if ($llave_dispositivo_principal) { ?> disabled <?php } ?>>Dispositivo Principal</button>
                </div>
                <div class="boton-secundario">
                    <button type="button" onclick="openModalDos()">Desvincular y eliminar</button>
                </div>
                <div class="boton-primario">
                    <button type="button" id="historial">Historial de intentos de acceso de dispositivos</button>
                </div>
            </div>
        <?php } ?>

    </main>
    <footer>
        <?php include_once '../view/fragmentos/menubar.php' ?>
    </footer>
    <dialog class="dispositivo-vinculados" id="vinculo">
        <div class="imagen">
            <img src="img/touch.png" alt="touch">
        </div>
        <div class="texto">
            <p>¿Estás seguro que deseas establecer el dispositivo como principal?</p>
        </div>
        <div class="opciones-modal">
            <div class="boton-primario-modal">
                <button type="button" onclick="closeModal('aceptar')">Aceptar</button>
            </div>
            <div class="boton-secundario-modal">
                <button type="button" onclick="closeModal('cancelar')">Cancelar</button>
            </div>
        </div>
    </dialog>
    <dialog class="dispositivo-vinculados" id="desvinculo">
        <div class="imagen">
            <img src="img/desvincular.png" alt="desvinular">
        </div>
        <div class="texto">
            <p>¿Estás seguro que deseas desvincular este dispositivo?</p>
        </div>
        <div class="opciones-modal">
            <div class="boton-primario-modal">
                <!-- LOGICA AQUI - QUE SE ELIMINE ESA CAJA-->
                <button type="button" onclick="closeModalDos('aceptar')">Aceptar</button>

            </div>
            <div class="boton-secundario-modal">
                <button type="button" onclick="closeModalDos('cancelar')">Cancelar</button>
            </div>
        </div>
    </dialog>
    <script src="../view/js/index.js"></script>
    <script src="../view/js/utils.js"></script>
    <script src="js/dispositivos.js"></script>
</body>

</html>