<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Activacion</title>
</head>

<body>
    <header>
        <?php include 'fragmentos/nav.php' ?>
    </header>
    <main>
        <h1>Activación de Nuevo Sistema Seguridad</h1>
        <div class="flex">
            <div class="primer_cuadro">
                <p>
                    Adquiere el servicio y comienza a sentirte ¡más seguro!
                </p>
                <ul>
                    <li>Código antes de tus transacciones con Yape.</li>
                    <li>Establecer ubicaciones seguras y horarios para realizar operaciones bancarias.</li>
                    <li>Verificar los dispositivos vinculados a tu cuenta desde cualquier tipo de equipo.</li>
                </ul>
            </div>
            <div class="segundo_cuadro">
                <div class="plan_seguro">
                    <img src="img/caja_fuerte.png" alt="plan_seguro.jpg">
                    <div>
                        <h4>Plan Seguro</h4>
                        <h3>S/300/mes</h3>
                    </div>
                </div>
                <p>Ingrese sus datos para realizar el cargo a la cuenta</p>
                <form action="#">
                    <div><input type="text" placeholder="Nombre Completo"></div>
                    <div><input type="text" placeholder="Teléfono"></div>
                    <div><input type="password" placeholder="Correo"></div>
                    <div><input class="checkbox" type="checkbox" data-required="1"> <span>Acepto los <a href="#">Términos y Condiciones</a></span></div>
                    <div class="button"><button type="submit">Ingresar</button></div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>