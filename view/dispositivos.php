<?php

/*include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerEntradas.php';*/
include '../config/Connection.php';
session_start();
$conexion = new Connection();
$conexion->conectar();
$id_usuario = $_SESSION['id_usuario'];
$sql = "select * from usuario where id_usuario= '$id_usuario'";
$resultado1 = $conexion->consultar($sql);
$sql2 = "Select * from seguridad where id_usuario='$id_usuario'";
$resultado2 = $conexion->consultar($sql2);
$id_segu = $resultado2[0]['id_seguridad'];
$sql3 = "Select * from dispositivo where id_seguridad='$id_segu' AND estado_dispositivo='activado'";
$resultado3 = $conexion->consultar($sql3);

$seguro = null;
/*
if ($_SESSION['estado_dispositivo'] === 'seguro') {
    echo 'Es un dispositivo seguro';
    $seguro = true;
}*/
//$entradas = new ControllerEntradas();
/*$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);*/

//$dispositivo = new ControllerDispositivo();
//$dispositivo->readById($id_usuario);
/*$usuario = new ControllerUsuario();
$info_usuario->obtener_info_usuario($id_usuario);
$info_usuario->obtenerUsuario($entradas);
$usuario->estado_activado($info_usuario);*/
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
        <div class="tabla">
            <div class="contenido-izq">
                <div class="caja">
                    <div class="primero">
                        <div class="imagen">
                            <img src="img/icono_cel.png" alt="Imagen de celular">
                        </div>
                        <div class="seccion">
                            <div class="titulo-caja">

                                <h4  style="color: darkorange; font-weight: 800;">
                                    <?= $resultado3[0]['tipo_dispositivo'] ?>
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

        <?php if (!isset($seguro)) { ?>
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
            <p>¿Estás seguro que deseas desvincular este dispositivo?</p>
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
        //console.log(info);
        if (info) {
            try {
                //Convertir la cadena JSON de nuevo a un objeto
                const obj_info = JSON.parse(info);
                //console.log(obj_info);

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
                <?php if (!isset($seguro)) { ?>
                                                                                <div class="segundo">
                                                                                    <input type="radio" name="vinculo" id="dispositivo${index + 2}" />
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
>>>>>>> main
</body>
</html>