<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../controller/ControllerEntradas.php';
include_once '../controller/ControllerHorario.php'; // Incluye el nuevo controlador
include_once '../dao/DaoHorario.php'; 

// include_once '../config/Connection.php';

// Crear instancia del controlador
$controllerEntradas = new ControllerEntradas();
$controllerEntradas->validarEntrada('index.php');
$controllerEntradas->validarServicio('principal.php', $_SESSION['id_seguridad']);

$controllerHorario = new ControllerHorario();

// Obtener horarios restringidos
$horarios = $controllerHorario->obtenerHorarios();

date_default_timezone_set('America/Lima');
$fechaHoy = date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/head.php'; ?>
    <title>Rango de Horario y Ubicación</title>
    <link rel="stylesheet" href="css/horario_ubicacion.css">
</head>

<body>
    <header>
        <?php include 'fragmentos/nav.php'; ?>
        <?php include 'fragmentos/tabs.php'; ?>
    </header>

    <main class="contenedor">
        <div class="secciones">
            <div id="avisoError" style="color: red;"></div>
            <h2>Fecha de hoy: &nbsp;<?php echo $fechaHoy; ?></h2>

            <?php if (empty($horarios)): ?>
                <h4>No se han encontrado horarios restringidos. Puedes registrar uno nuevo.</h4>
                <form action="../controller/ControllerHorario.php?action=registrar" method="post">
                    <div class="formulario">
                        <input type="hidden" name="id_seguridad" value="<?php echo $_SESSION['id_seguridad']; ?>">
                        <div class="grupo-formulario-horario">
                            <label for="hora-inicio-nuevo">
                                <i class="fas fa-clock"></i> Hora Inicio
                            </label>
                            <input id="hora-inicio-nuevo" type="time" name="txtHoraInicio" required />
                        </div>
                        <div class="grupo-formulario-horario">
                            <label for="hora-fin-nuevo">
                                <i class="fas fa-clock"></i> Hora Fin
                            </label>
                            <input id="hora-fin-nuevo" type="time" name="txtHoraFin" required />
                        </div>
                    </div>
                    <small>* Recuerda que cada día debes registrar un rango de horario</small>
                    <div class="botones">
                        <button type="submit" class="boton-naranja" name="btnRegistrar">Registrar</button>
                    </div>
                </form>
            <?php else: ?>
                <?php foreach ($horarios as $datos): ?>
                    <form action="../controllers/ControllerHorario.php?action=modificar" method="post">
                        <div class="formulario">
                            <input type="hidden" name="txtId" value="<?php echo htmlspecialchars($datos['id_hora']); ?>">
                            <div class="grupo-formulario-horario">
                                <label for="hora-inicio-nuevo">
                                    <i class="fas fa-clock"></i> Hora Inicio
                                </label>
                                <input id="hora-inicio-nuevo" type="time" name="txtHoraInicio"
                                    value="<?php echo htmlspecialchars($datos['hora_inicio']); ?>" required />
                            </div>
                            <div class="grupo-formulario-horario">
                                <label for="hora-fin-nuevo">
                                    <i class="fas fa-clock"></i> Hora Fin
                                </label>
                                <input id="hora-fin-nuevo" type="time" name="txtHoraFin"
                                    value="<?php echo htmlspecialchars($datos['hora_final']); ?>" required />
                            </div>
                        </div>
                        <small>* Recuerda que cada día debes registrar un rango de horario</small>
                        <div class="botones">
                            <button type="submit" class="boton-azul" name="btnModificar">Editar Cambios</button>
                        </div>
                    </form>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="secciones">
            <form action="" method="post">
                <div>
                    <?php
                    if (isset($_SESSION['mensaje'])) {
                        echo "<div style='color: red;'>" . $_SESSION['mensaje'] . "</div>";
                        unset($_SESSION['mensaje']); // Limpiar el mensaje de la sesión
                    }
                    ?>
                </div>
                <h2>Ingresa la Ubicación Segura</h2>
                <div class="grupo-formulario">
                    <label for="direccion">
                        <i class="fa-solid fa-map-location-dot"></i> Dirección Exacta (Calle y Distrito)
                    </label>
                    <div style="display: flex; align-items: center; position: relative;">
                        <input type="text" id="locationInput" placeholder="Busca una dirección"
                            oninput="autocompleteAddress(this.value)" name="txtdireccion"
                            style="flex: 1; margin-right: 5px; width: 200px;" />
                        <button type="button" onclick="getLocation()" class="boton-azulle">Ubicación Actual</button>
                    </div>
                    <ul id="suggestions"></ul>
                </div>
                <div style="display:flex; justify-content: center;">
                    <iframe id="mapIframe"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=-77.009679,-11.983784,-77.006679,-11.981784&layer=mapnik"
                        width="600" height="250" style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>
                <small>* Puedes ingresar varias ubicaciones, pero solo 2 al día</small>
                <div class="botones">
                    <button id="boton-registrar-direccion" class="boton-naranja" name="btnRegistrarDireccion"
                        type="submit">Guardar</button>
                    <button id="boton-editar-rango" type="button" class="boton-azul"
                        onclick="window.location.href='ver_direcciones.php'">Ver direcciones</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <?php include 'fragmentos/menubar.php'; ?>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"
        integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMrMC4gY5p5Y5B6mFfsZR/tD8d3B3h5uLTPGxW"
        crossorigin="anonymous"></script>
    <script src="js/validacionhora.js"></script>
    <script src="js/Ubicacion_direccion.js"></script>
</body>

</html>