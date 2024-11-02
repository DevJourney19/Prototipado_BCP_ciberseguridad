<?php
include_once '../php/util/validar_entradas.php';
include_once '../php/util/connection.php';
validar_entrada('index.php');
// verificar si ya ha sido contratado el servicio
validar_servicio('principal.php');
$id_usuario = $_SESSION['id_usuario'];
conectar();
$sql = "select * from usuario where id_usuario= '$id_usuario'";
$resultado1 = consultar($sql);
$sql2 = "Select * from seguridad where id_usuario='$id_usuario'";
$resultado2 = consultar($sql2);
$id_segu = $resultado2[0]['id_seguridad'];
$sql3 = "Select * from dispositivo where id_seguridad='$id_segu' AND estado_dispositivo='activado'";
$resultado3 = consultar($sql3);
desconectar();

//Si ese dispositivo tiene el estado activado entonces se mostrará

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

            <?php if (isset($resultado3)) { ?>

                <div class="caja">

                    <div class="primero">
                        <div class="imagen">
                            <?php switch ($resultado3[0]['tipo_dispositivo']) {
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
                                <h4>
                                    <?= $resultado3[0]['tipo_dispositivo'] ?>
                                </h4>
                            </div>
                            <div class="descripcion-caja">
                                <p>
                                    Lugar: <?= $resultado3[0]['ciudad'] ?>- <?= $resultado3[0]['pais'] ?>
                                    <br />
                                    IP: <?= $resultado3[0]['direccion_ip'] ?>
                                    <br />
                                    Ingreso: <?= $resultado3[0]['fecha_registro'] ?>
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="segundo">
                        <input type="radio" name="vinculo" id="dispositivo1" checked>
                        <label for="dispositivo1"><span class="radio-button"></span></label>
                    </div>
                </div>
            <?php } ?>


        </div>

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
        <?php include_once '../view/fragmentos/menubar.php' ?>
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
    <script src="../view/js/index.js"></script>
    <script src="../view/js/utils.js"></script>
    <script src="js/dispositivos.js"></script>
    <script>
        const info = localStorage.getItem('nuevo_dispositivo'); //Retorna String
        console.log(info);
        if (info) {
            try {
                //Convertir la cadena JSON de nuevo a un objeto
                const obj_info = JSON.parse(info);
                console.log(obj_info);

                //Cambiar el contenido del div [ubicación referencial]
                const mensajito = document.getElementById('mensajin');
                obj_info.forEach((item, index) => {
                    //Crear un nuevo div
                    const nueva_caja = document.createElement('div');
                    nueva_caja.classList.add('caja');

                    nueva_caja.innerHTML = `
            
                <div class="primero">
                    <div class="imagen">
                        <img src="img/laptop.png" alt="Imagen de celular" />
                    </div>
                    <div class="seccion">
                        <div class="titulo-caja">
                            <h4>
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

                <div class="segundo">
                    <input type="radio" name="vinculo" id="dispositivo${index + 2}" />
                    <label for="dispositivo${index + 2}"><span class="radio-button"></span></label>
                </div>
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
-->