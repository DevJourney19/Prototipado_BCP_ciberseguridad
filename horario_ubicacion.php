<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Rango de Horario y Ubicacion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="horario_ubicacion.css">
</head>

<body>
    <header>
        <?php include 'fragmentos/nav.php' ?>
    </header>
    <main class="contenedor">
        <div class="secciones">
            <h2>Rellena el formulario para indicar el rango de hora que tu cuenta se encontrará bloqueada</h2>
            <div class="formulario">
                <div class="grupo-formulario-horario">
                    <label for="hora-inicio">
                        <i class="fas fa-clock"></i>Hora Inicio
                    </label>
                    <input id="hora-inicio" placeholder="00:00" type="text" />
                </div>
                <div class="grupo-formulario-horario">
                    <label for="hora-fin">
                        <i class="fas fa-clock"></i></i>Hora Fin
                    </label>
                    <input id="hora-fin" placeholder="23:00" type="text" />
                </div>
            </div>
            <small>* Recuerda que cada día debes registrar un rango de horario</small>
            <div class="botones">
                <button id="boton-editar-rango" class="boton-azul">Editar</button>
                <button id="boton-registrar-rango" class="boton-naranja">Registrar</button>
            </div>
        </div>
        <div class="secciones">
            <h2>Ingresa la Ubicación Segura</h2>
            <div class="grupo-formulario">
                <label for="direccion">
                    <i class="fa-solid fa-map-location-dot"></i>Dirección Exacta (Calle y Distrito)
                </label>
                <input id="direccion" placeholder="Ejemplo: Calle Berlin 601, Miraflores" type="text" />
            </div>
            <div class="mapa">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7805.665578140945!2d-77.01171266362851!3d-11.986069441082716!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c562b237b1ad%3A0x81b7bf88d50f89ff!2sUniversidad%20Tecnol%C3%B3gica%20Del%20Per%C3%BA!5e0!3m2!1ses-419!2spe!4v1727847322106!5m2!1ses-419!2spe" width="600" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <small>* Puedes ingresar varias ubicaciones, pero solo 2 al día</small>
            <div class="botones">
                <button id="boton-registrar-direccion" class="boton-naranja">Guardar</button>
                <a href="ver_direcciones.php"><button class="boton-azul">Ver Direcciones</button></a>
            </div>
        </div>
    </main>

    <!-- Modal 1: Para el registro del horario -->
    <div id="modal-horario" class="modal-overlay">
        <div class="modal-guardar-rango">
            <div class="icono">
                <i class="fas fa-check"></i>
            </div>
            <div class="modal-mensaje">
                Se ha registrado exitosamente el horario para el día de hoy.
            </div>
            <button class="boton-naranja">Cerrar</button>
        </div>
    </div>

    <!-- Modal 2: Para el registro de la ubicación -->
    <div id="modal-ubicacion" class="modal-overlay">
        <div class="modal-guardar-rango">
            <div class="icono">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="modal-mensaje">
                Se ha registrado exitosamente la ubicación.
            </div>
            <button class="boton-naranja">Cerrar</button>
        </div>
    </div>
    <footer>
        <?php include 'fragmentos/menubar.php' ?>
    </footer>
    <script src="js/horario_ubicacion.js"></script>
</body>

</html>