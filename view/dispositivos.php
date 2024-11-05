<?php

include_once '../controller/ControllerEntradas.php';

$entradas = new ControllerEntradas();
$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);
$seguro = null;

if ($_SESSION['estado_dispositivo'] === 'seguro') {
    $seguro = true;
}
$dispositivo = $_SESSION['dispositivo'];

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

            <?php if (isset($dispositivo)) { ?>

                <div class="caja">
                    <div class="primero">
                        <div class="imagen">
                            <?php switch ($dispositivo) {
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
                                <h4 style="color: darkorange; font-weight: 800;">
                                    <?= $dispositivo ?>
                                </h4>
                            </div>
                            <div class="descripcion-caja">
                                <p>
                                    Lugar: <?= $_SESSION['ciudad'] ?>- <?= $_SESSION['pais'] ?>
                                    <br />
                                    IP: <?= $_SESSION['direccion_ip'] ?>
                                    <br />
                                    Ingreso: <?= $_SESSION['hora'] ?>
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

        <?php if (!isset($seguro)) { ?>
            <div class="opciones">
                <div class="boton-primario">
                    <button type="button" onclick="openModal()">Dispositivo Principal</button>
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
    <script>
        const info = localStorage.getItem('nuevo_dispositivo'); //Retorna String
        //console.log(info);
        if (info) {
            try {

                //Convertir la cadena JSON de nuevo a un objeto
                const obj_info = JSON.parse(info);
                //console.log(obj_info);
                console.log(obj_info);
                //Cambiar el contenido del div [ubicación referencial]
                const mensajito = document.getElementById('mensajin');
                obj_info.forEach((item, index) => {
                    let color = item.estado === 'activado' ? 'darkorange' : '#001843';
                    let font = item.estado === 'activado' ? '800' : '400';
                    //Crear un nuevo div
                    const nueva_caja = document.createElement('div');
                    nueva_caja.classList.add('caja');
                    // Asignar un id único numérico al div
                    const idNumerico = item.id;
                    nueva_caja.id = idNumerico;
                    // Switch en JavaScript para determinar la imagen
                    let imagenHTML;
                    switch (item.tipo) {
                        case 'Ordenador de escritorio':
                            imagenHTML = '<img src="img/computadora.png" alt="Imagen de computadora">';
                            break;
                        case 'Portátil':
                            imagenHTML = '<img src="img/icono_portatil.png" alt="Imagen de portátil">';
                            break;
                        case 'Tableta':
                            imagenHTML = '<img src="img/icono_tableta.png" alt="Imagen de tableta">';
                            break;
                        case 'Teléfono móvil':
                            imagenHTML = '<img src="img/icono_cel.png" alt="Imagen de teléfono móvil">';
                            break;
                        case 'Smartwatch':
                            imagenHTML = '<img src="img/icono_smartwatch.png" alt="Imagen de smartwatch">';
                            break;
                        case 'Televisor inteligente':
                            imagenHTML = '<img src="img/icono_televisor.png" alt="Imagen de televisor inteligente">';
                            break;
                        case 'Consola de videojuegos':
                            imagenHTML = '<img src="img/icono_consola.png" alt="Imagen de consola de videojuegos">';
                            break;
                        case 'Dispositivo IoT':
                            imagenHTML = '<img src="img/icono_iot.png" alt="Imagen de dispositivo IoT">';
                            break;
                        default:
                            imagenHTML = '<p>Tipo de dispositivo no reconocido.</p>';
                    }
                    nueva_caja.innerHTML = `
            
                <div class="primero">
                    <div class="imagen">
                ${imagenHTML}
                    </div>
                    <div class="seccion">
                        <div class="titulo-caja">
                        
                            <h4 style="color:${color}; font-weight:${font}">
                                ${item.tipo}
                            </h4>
                        </div>
                        <div class="descripcion-caja">
                            <p>
                                Lugar: ${item.ciudad} - ${item.pais} <br/> 
                                IP: ${item.dip} <br/>
                                Ingreso: ${item.fecha}
                            </p>

                        </div>
                    </div>
                </div>
                <?php if (!isset($seguro)) { ?>
                                                                                                                                                                                            <div class="segundo">
                                                                                                                                                                                                <input type="radio" name="vinculo" onchange="handleCheckboxClick(this)" id="dispositivo${index + 2}" />
                                                                                                                                                                                                <label for="dispositivo${index + 2}"><span class="radio-button"></span></label>
                                                                                                                                                                                            </div>
                <?php } ?>
            `;
                    //localStorage.removeItem('nuevo_dispositivo');
                    mensajito.appendChild(nueva_caja);
                });
            } catch (error) {
                console.error('Error al analizar JSON:', error);
            }
        }
    </script>

</body>
</html>