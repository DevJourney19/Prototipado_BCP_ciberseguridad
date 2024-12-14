<?php
include_once '/app/controller/ControllerEntradas.php';
$entradas = new ControllerEntradas();
$entradas->validarEntrada('login_admin.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '/app/view/fragmentos/head.php' ?>
    <link href="/app/view/css/admin.css" rel="stylesheet" />
    <title>Dashboard</title>
</head>

<body class="body_dashboard">
    <header>
        <?php include_once '/app/view/fragmentos/nav_close_admin.php' ?>
        <?php include_once '/app/view/fragmentos/nav_admin.php' ?>
    </header>

    <main class="main_dashboard" style="
    background: white;
    color: black;">
        <div class="title_dashboard">
            <h1 class="h1_dashboard">Dashboard</h1>
            <div>
                <button class="excel" onclick="window.location.href='reporte_excel.php'">
                    <i class="fa-solid fa-file-excel"></i>
                </button>
                <button class="pdf" onclick="window.location.href='reportepdf.php'">
                    <i class="fa-solid fa-file-pdf"></i>
                </button>
            </div>
        </div>
        <p class="description">Aquí puede visualizar las métricas del rendimiento dle sistema.</p>

        <div class="fila_gr">
            <div class="col">
                <div class="encabezado-admi">
                    <div>
                        <h3>Nivel de Satisfacción</h3>
                        <h5>Data del mes de <span class="mes"></span> - <span class="anio"></span></h5>
                    </div>
                    <select class="form-select" id="satisfaccion-mes">
                        <option selected>Elige un mes</option>
                        <?php
                        $months = [
                            1 => 'Enero',
                            2 => 'Febrero',
                            3 => 'Marzo',
                            4 => 'Abril',
                            5 => 'Mayo',
                            6 => 'Junio',
                            7 => 'Julio',
                            8 => 'Agosto',
                            9 => 'Septiembre',
                            10 => 'Octubre',
                            11 => 'Noviembre',
                            12 => 'Diciembre'
                        ];
                        for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $months[$i]; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="grafico">
                    <span id="mensaje-satisfaccion"></span>
                    <canvas id="grafico_1"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Números de Registros</h3>
                <h5>Data de lo que va del año - <span class="anio"></span></h5>
                <div class="grafico">
                    <canvas id="grafico_2"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Número de Reportes de Ataques Cibernéticos</h3>
                <h5>Data de lo que va del año - <span class="anio"></span></h5>
                <div class="grafico">
                    <canvas id="grafico_4"></canvas>
                </div>
            </div>
            <div class="col">
                <h3>Ganancias VS Metas</h3>
                <h5>Data del mes de <span class="mes"></span> - <span class="anio"></span></h5>
                <div class="grafico">
                    <canvas id="grafico_3"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="/app/view/js/charts.js"></script>
</body>

</html>