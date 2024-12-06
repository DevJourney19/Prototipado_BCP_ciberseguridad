<?php
// Incluir archivos necesarios para la conexión y el controlador
include("../config/Connection.php");
include_once '../controller/ControllerEstadisticas.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

// Función para exportar los datos a Excel
if (isset($_POST['exportar_excel'])) {
    $spreadsheet = new Spreadsheet();
    $activeSheet = $spreadsheet->getActiveSheet();

    // Título de la hoja
    $activeSheet->setCellValue('A1', 'Reporte de Actividades del Sistema');

    // Nivel de Satisfacción de Usuario
    $activeSheet->setCellValue('A3', '1. Nivel de Satisfacción de Usuario');
    $activeSheet->setCellValue('A4', 'Estado');
    $activeSheet->setCellValue('B4', 'Cantidad');
    $row = 5;
    foreach ($emocion as $emocions) {
        $activeSheet->setCellValue('A' . $row, $emocions['estado']);
        $activeSheet->setCellValue('B' . $row, (int) $emocions['cantidad']);
        $row++;
    }

    // Número de Registros de Usuario
    $activeSheet->setCellValue('A' . $row, '2. Número de Registros de Usuario');
    $activeSheet->setCellValue('A' . ($row + 1), 'Mes');
    $activeSheet->setCellValue('B' . ($row + 1), 'Cantidad de Registros');
    $row += 2;
    $totalRegistros = 0;
    foreach ($registros as $registro) {
        $totalRegistros += $registro['cantidad'];
        $activeSheet->setCellValue('A' . $row, obtenerNombreMes($registro['mes'] ?? 0));
        $activeSheet->setCellValue('B' . $row, $registro['cantidad'] ?? 0);
        $row++;
    }
    $activeSheet->setCellValue('A' . $row, 'Total');
    $activeSheet->setCellValue('B' . $row, $totalRegistros);
    $row++;

    // Ganancias
    $activeSheet->setCellValue('A' . $row, '3. Ganancias ' . date('Y'));
    $activeSheet->setCellValue('A' . ($row + 1), 'Mes');
    $activeSheet->setCellValue('B' . ($row + 1), 'Total Ganancias');
    $row += 2;
    $totalGanancias = 0;
    foreach ($ganancias as $ganancia) {
        $totalGanancias += $ganancia['total'];
        $activeSheet->setCellValue('A' . $row, obtenerNombreMes($ganancia['mes'] ?? 0));
        $activeSheet->setCellValue('B' . $row, 'S/ ' . number_format($ganancia['total'] ?? 0, 2));
        $row++;
    }
    $activeSheet->setCellValue('A' . $row, 'Total');
    $activeSheet->setCellValue('B' . $row, 'S/ ' . number_format($totalGanancias, 2));

    // Número de Reportes de Ataques
    $row++;
    $activeSheet->setCellValue('A' . $row, '4. Reportes de Ataques Cibernéticos ' . date('Y'));
    $activeSheet->setCellValue('A' . ($row + 1), 'Mes');
    $activeSheet->setCellValue('B' . ($row + 1), 'Cantidad de Reportes');
    $row += 2;
    $totalReportesAtaques = 0;
    foreach ($reportesAtaques as $reporte) {
        $totalReportesAtaques += $reporte['cantidad'];
        $activeSheet->setCellValue('A' . $row, obtenerNombreMes($reporte['mes'] ?? 0));
        $activeSheet->setCellValue('B' . $row, $reporte['cantidad'] ?? 0);
        $row++;
    }
    $activeSheet->setCellValue('A' . $row, 'Total');
    $activeSheet->setCellValue('B' . $row, $totalReportesAtaques);

    // Reportes de Usuarios
    $row++;
    $activeSheet->setCellValue('A' . $row, '5. Reportes de Usuarios');
    $activeSheet->setCellValue('A' . ($row + 1), 'ID');
    $activeSheet->setCellValue('B' . ($row + 1), 'Título');
    $activeSheet->setCellValue('C' . ($row + 1), 'Descripción');
    $activeSheet->setCellValue('D' . ($row + 1), 'Tipo');
    $activeSheet->setCellValue('E' . ($row + 1), 'Fecha de Creación');
    $row += 2;
    foreach ($reportes as $reporte) {
        $activeSheet->setCellValue('A' . $row, $reporte['id']);
        $activeSheet->setCellValue('B' . $row, $reporte['titulo']);
        $activeSheet->setCellValue('C' . $row, $reporte['descripcion']);
        $activeSheet->setCellValue('D' . $row, $reporte['tipo']);
        $activeSheet->setCellValue('E' . $row, date('Y-m-d', strtotime($reporte['created_at'])));
        $row++;
    }

    // Guardar el archivo Excel
    $writer = new Xlsx($spreadsheet);
    $fileName = 'reporte_actividades_' . date('Y-m-d_H-i-s') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}

?>

