<?php
include_once '../controller/ControllerEntradas.php';
$entradas = new ControllerEntradas();
$entradas->validarEntrada('login_admin.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../view/fragmentos/head.php' ?>
    <link href="../view/css/admin.css" rel="stylesheet" />
    <title>Dashboard</title>
</head>

<body class="body_dashboard">
    <header>
        <?php include_once '../view/fragmentos/nav_close_admin.php' ?>
        <?php include_once '../view/fragmentos/nav_admin.php' ?>
    </header>

    <main class="main_dashboard" style="
    background: white;
    color: black;">
        <h1 class=" h1_dashboard">Dashboard</h1>
        <p class="description">Aquí puede visualizar las métricas del rendimiento dle sistema.</p>

        <div class="fila_gr">
            <div class="col">
                <h3>Nivel de Satisfacción</h3>
                <h5>Data del mes de <span class="mes"></span> - <span class="anio"></span></h5>
                <div>
                    <canvas id="grafico_1"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Números de Registros</h3>
                <h5>Data de lo que va del año - <span class="anio"></span></h5>
                <div>
                    <canvas id="grafico_2"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Ganancias VS Metas</h3>
                <h5>Data del mes de <span class="mes"></span> - <span class="anio"></span></h5>
                <div>
                    <canvas id="grafico_3"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Número de Reportes de Ataques Cibernéticos</h3>
                <h5>Data de lo que va del año - <span class="anio"></span></h5>
                <div>
                    <canvas id="grafico_4"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="../view/js/charts.js"></script>
</body>

</html>