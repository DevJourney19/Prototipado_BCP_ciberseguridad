<?php
// session_start();
// if (!isset($_SESSION['usuario'])) {
// header("Location:../index.php");
// }else{
//     if ($_SESSION['usuario']=="ok") {
//     $nombreUsuario=$_SESSION["nombreUsuario"];
//     }
// }

ob_start();

// Incluir archivos necesarios para la conexión y el controlador
include("../config/Connection.php");
include_once '../controller/ControllerEstadisticas.php';

// Conexión a la base de datos
$conexion = new Connection();
$daoEstadisticas = new DaoDashboard();

// Inicializar variables para evitar errores si los métodos devuelven valores no válidos
$emocion = [];
$reportes = [];
$registros = [];
$ganancias = [];
$reportesAtaques = [];

try {
    // Obtener estadísticas de registros desde el DAO
    $emocion = $daoEstadisticas->SatisfaccionPorAnio(date('Y'));
    $reportes = $daoEstadisticas->obtenerReportes();
    $registros = $daoEstadisticas->obtenerNumeroRegistros();
    $ganancias = $daoEstadisticas->obtenerGananciasPorAnio(date('Y'));
    $reportesAtaques = $daoEstadisticas->obtenerReportesAtaques(date('Y'));
} catch (Exception $e) {
    // Manejo de errores
    error_log("Error al obtener estadísticas: " . $e->getMessage());
}

// Función para obtener el nombre del mes
function obtenerNombreMes($numeroMes)
{
    $meses = [
        1 => "Enero",
        2 => "Febrero",
        3 => "Marzo",
        4 => "Abril",
        5 => "Mayo",
        6 => "Junio",
        7 => "Julio",
        8 => "Agosto",
        9 => "Septiembre",
        10 => "Octubre",
        11 => "Noviembre",
        12 => "Diciembre"
    ];

    // Verifica si el mes es válido
    return ($numeroMes >= 1 && $numeroMes <= 12) ? $meses[$numeroMes] : "Mes desconocido";
}

// Verifica si los registros están vacíos
$mensaje = "No se encontraron resultados.";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Prototipado_BCP_ciberseguridad/view/css/tablapdf.css">
    <?php include '../view/fragmentos/head.php'; ?>
    <title>Reporte</title>
    <?php date_default_timezone_set('America/Lima'); ?>
</head>
<body>
    <div class="imagenLogo">
        <div>
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Prototipado_BCP_ciberseguridad/view/img/logotipopdf.jpg"
                alt="logotipo">
        </div>
        <div class="derecha">
            <h4>Fecha: </h4>
            <p><?php echo date("d-m-Y"); ?></p>
            <h4>Hora: </h4>
            <p><?php echo date("H:i:s"); ?></p>
        </div>
    </div>

    <div class="seccion">
        <div style="text-align: center; margin-top: 1rem; margin-bottom: 1rem;">
            <h2>Reporte de Actividades del Sistema</h2>
        </div>
        <h4>1. Nivel de Satisfacción de Usuario <?php echo date('Y') ?></h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($emocion)): ?>
                    <?php foreach ($emocion as $emocions): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($emocions['estado']); ?></td>
                            <td><?php echo (int) $emocions['cantidad']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center"><?php echo htmlspecialchars($mensaje); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <h4>2. Número de Registros de Usuario</h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Cantidad de Registros</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalRegistros = 0;
                if (!empty($registros)):
                    foreach ($registros as $registro):
                        $totalRegistros += $registro['cantidad'];
                        ?>
                        <tr>
                            <td><?php echo obtenerNombreMes($registro['mes'] ?? 0); ?></td>
                            <td><?php echo $registro['cantidad'] ?? 0; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td><strong>Total</strong></td>
                        <td><strong><?php echo $totalRegistros; ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center"><?php echo $mensaje; ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <h4>3. Ganancias <?php echo date('Y') ?></h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Total Ganancias</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalGanancias = 0;
                if (!empty($ganancias)):
                    foreach ($ganancias as $ganancia):
                        $totalGanancias += $ganancia['total'];
                        ?>
                        <tr>
                            <td><?php echo obtenerNombreMes($ganancia['mes'] ?? 0); ?></td>
                            <td>S/ <?php echo number_format($ganancia['total'] ?? 0, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td><strong>Total</strong></td>
                        <td><strong>S/ <?php echo number_format($totalGanancias, 2); ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center"><?php echo $mensaje; ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <h4>4. Número de Reportes de Ataques Cibernéticos <?php echo date('Y'); ?></h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Cantidad de Reportes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalReportesAtaques = 0;
                if (!empty($reportesAtaques)):
                    foreach ($reportesAtaques as $reporte):
                        $totalReportesAtaques += $reporte['cantidad'];
                        ?>
                        <tr>
                            <td><?php echo obtenerNombreMes($reporte['mes'] ?? 0); ?></td>
                            <td><?php echo $reporte['cantidad'] ?? 0; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td><strong>Total</strong></td>
                        <td><strong><?php echo $totalReportesAtaques; ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center"><?php echo $mensaje; ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <h4>5. Reportes de Usuarios</h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reportes)): ?>
                    <?php foreach ($reportes as $reporte): ?>
                        <tr>
                            <td><?php echo $reporte['id']; ?></td>
                            <td><?php echo htmlspecialchars($reporte['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($reporte['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($reporte['tipo']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($reporte['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron reportes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script
        src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Prototipado_BCP_ciberseguridad/view/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
<?php
$html = ob_get_clean();
// echo $html;
require_once __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array(
    'isHtml5ParserEnabled' => true,
    'isPhpEnabled' => true,
    'isRemoteEnabled' => true
));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter');
// $dompdf->setPaper('A4','landscape')
$dompdf->render();
$dompdf->stream("archivo_.pdf", array("Attachment" => true))
    ?>