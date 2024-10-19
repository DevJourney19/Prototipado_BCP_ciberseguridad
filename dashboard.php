<?php
include_once 'php/util/validar_entradas.php';
include 'php/util/connection.php';
validar_entrada('login_admi.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Dashboard</title>
</head>

<body class="body_dashboard">
    <header>
        <?php include 'fragmentos/nav.php' ?>
    </header>

    <main class="main_dashboard">
        <h1 class="h1_dashboard">Dashboard</h1>
        <p class="description">Aquí puede visualizar las métricas del rendimiento dle sistema.</p>
        <div class="fila_gr">
            <div class="col">
                <h3>Nivel de Satisfacción</h3>
                <h5>Data del mes de Setiembre - 2024</h5>
                <div>
                    <canvas id="grafico_1"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Números de Ingresos y Registros</h3>
                <h5>Data de lo que va del año - 2024</h5>
                <div>
                    <canvas id="grafico_2"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Ganancias VS Metas</h3>
                <h5>Data del mes de Setiembre - 2024</h5>
                <div>
                    <canvas id="grafico_3"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Número de Reportes de Ataques Cibernéticos</h3>
                <h5>Data de lo que va del año - 2024</h5>
                <div>
                    <canvas id="grafico_4"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="js/charts.js"></script>
</body>

</html>