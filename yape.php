<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Simulación de Yapeo</title>
</head>
<body class="fondo-yape">
    <div class="contenedor-yape">
        <div class="logo-yape">
            <img src="img/logo-yape.png" alt="Logo Yape" width=100 height=100>
        </div>
        <div class="contenedor-datos">
            <h2>Yapear a</h2>
            <div class="nombre-yape">Amanda Raquel Rodriguez</div>
            <div class="monto-yape">
                <span>S/</span><input type="number" class="digitar-monto" value="0" min="1" max="500"></input>
            </div>
            <div class="mensaje-fijo">Puedes yapear hasta S/ 500 diarios</div>
            <input type="text" class="mensaje-yape" placeholder="Agregar mensaje">
            <div class="contenedor-botones">
                <button class="btn-otros">Otros Bancos</button>
                <button class="btn-yapear" onclick="abrirModal()">Yapear</button>
            </div>
        </div>
    </div>
    <div class="modal-yape" id="modal-token">
        <div class="contenedor-modal">
            <h3>Ingrese el Token Secreto<br>para continuar el yapeo</h3>
            <div class="contenedor-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
                <input type="text" maxlength="1" class="input-token">
            </div>
            <div class="botones-modal">
                <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-aceptar">Aceptar</button>
            </div>
        </div>
    </div>
    <script>
        function abrirModal() {
            document.getElementById('modal-token').classList.add('active');            
        }
        function cerrarModal() {
            document.getElementById('modal-token').classList.remove('active');            
        }
    </script>
</body>
</html>