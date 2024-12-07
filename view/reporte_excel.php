<?php
require '../vendor/autoload.php';
include("../config/Connection.php");
include_once '../controller/ControllerEstadisticas.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

ob_clean();

$controller = new ControllerEstadisticas();
$daoEstadisticas = new DaoDashboard();

//Obtener los datos estadisticos desde el controlador
$emocion = $daoEstadisticas->SatisfaccionPorAnio(date('Y'));
$reportesUsuarios = $daoEstadisticas->obtenerReportes();
$registros = $daoEstadisticas->obtenerNumeroRegistros();
$ganancias = $daoEstadisticas->obtenerGananciasPorAnio(date('Y'));
$reportesAtaques = $daoEstadisticas->obtenerReportesAtaques(date('Y'));

//Crear un nuevo documento de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$estiloEncabezado = [
    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 14],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => '003366']],
];

$estiloTabla = [
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']],
    ],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'padding' => ['top' => 2, 'bottom' => 2, 'left' => 3, 'right' => 3],
    'font' => ['size' => 13],
];

$estiloFilaAlternada = [
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'F2F2F2']],
];

//Ajuste de columnas
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$sheet->getColumnDimension('C')->setWidth(50);

//Insertar logo de BCP
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setDescription('Logo de la empresa');
$drawing->setPath('img/bcp_logo.png');
$drawing->setHeight(50);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($sheet);

//Fecha y hora para el encabezado
$fechaHoraActual = date('d/m/Y H:i:s');
$sheet->setCellValue('B1', "Fecha: $fechaHoraActual");
$sheet->getStyle('B1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 12],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
]);

//Configurar encabezado principal
$sheet->setCellValue('A3', 'Reporte de Actividades del Sistema');
$sheet->mergeCells('A3:B3');
$sheet->getStyle('A3')->applyFromArray([
    'font' => ['bold' => true, 'size' => 18],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

//Sección 1: Nivel de Satisfacción
$sheet->setCellValue('A5', '1. Nivel de Satisfacción de Usuario');
$sheet->getStyle('A5')->applyFromArray(['font' => ['bold' => true, 'size' => 14,],]);
$sheet->setCellValue('A6', 'Estado')->setCellValue('B6', 'Cantidad');
$sheet->getStyle('A6:B6')->applyFromArray($estiloEncabezado);

$row = 7;
foreach ($emocion as $data) {
    $sheet->setCellValue("A$row", $data['estado']);
    $sheet->setCellValue("B$row", $data['cantidad']);
    $sheet->getStyle("A$row:B$row")->applyFromArray($estiloTabla);

    if ($row % 2 == 0) {
        $sheet->getStyle("A$row:B$row")->applyFromArray($estiloFilaAlternada);
    }
    $row++;
}

//Sección 2: Número de Registros
$row += 2;
$sheet->setCellValue("A$row", '2. Número de Registros de Usuarios');
$sheet->getStyle("A$row")->applyFromArray(['font' => ['bold' => true, 'size' => 14,],]);
$sheet->setCellValue("A" . ($row + 1), 'Mes')->setCellValue("B" . ($row + 1), 'Cantidad de Registros');
$sheet->getStyle("A" . ($row + 1) . ":B" . ($row + 1))->applyFromArray($estiloEncabezado);

$row += 2;
$totalRegistros = 0;
foreach ($registros as $data) {
    $sheet->setCellValue("A$row", obtenerNombreMes($data['mes']));
    $sheet->setCellValue("B$row", $data['cantidad']);
    $totalRegistros += $data['cantidad'];
    $sheet->getStyle("A$row:B$row")->applyFromArray($estiloTabla);
    
    if ($row % 2 == 0) {
        $sheet->getStyle("A$row:B$row")->applyFromArray($estiloFilaAlternada);
    }
    $row++;
}
$sheet->setCellValue("A$row", 'Total');
$sheet->setCellValue("B$row", $totalRegistros);
$sheet->getStyle("A$row:B$row")->applyFromArray($estiloTabla);

//Sección 3: Ganancias
$row += 2;
$sheet->setCellValue("A$row", '3. Ganancias '.date('Y'));
$sheet->getStyle("A$row")->applyFromArray(['font' => ['bold' => true, 'size' => 14,],]);
$sheet->setCellValue("A" . ($row + 1), 'Mes')->setCellValue("B" . ($row + 1), 'Total Ganancias');
$sheet->getStyle("A" . ($row + 1) . ":B" . ($row + 1))->applyFromArray($estiloEncabezado);

$row += 2;
$totalGanancias = 0;
foreach ($ganancias as $data) {
    $sheet->setCellValue("A$row", obtenerNombreMes($data['mes']));
    $sheet->setCellValue("B$row", 'S/ '.number_format($data['total'], 2));
    $totalGanancias += $data['total'];
    $sheet->getStyle("A$row:B$row")->applyFromArray($estiloTabla);

    if ($row % 2 == 0) {
        $sheet->getStyle("A$row:B$row")->applyFromArray($estiloFilaAlternada);
    }
    $row++;
}
$sheet->setCellValue("A$row", 'Total');
$sheet->setCellValue("B$row", 'S/ '.number_format($totalGanancias, 2));
$sheet->getStyle("A$row:B$row")->applyFromArray($estiloTabla);

//Sección 4: Reportes de Ataques
$row += 2;
$sheet->setCellValue("A$row", '4. Número de Reportes de Ataques Cibernéticos '.date('Y'));
$sheet->getStyle("A$row")->applyFromArray(['font' => ['bold' => true, 'size' => 14,],]);
$sheet->setCellValue("A" . ($row + 1), 'Mes')->setCellValue("B" . ($row + 1), 'Cantidad de Reportes');
$sheet->getStyle("A" . ($row + 1) . ":B" . ($row + 1))->applyFromArray($estiloEncabezado);

$row += 2;
$totalReportes = 0;
foreach ($reportesAtaques as $data) {
    $sheet->setCellValue("A$row", obtenerNombreMes($data['mes']));
    $sheet->setCellValue("B$row", $data['cantidad']);
    $totalReportes += $data['cantidad'];
    $sheet->getStyle("A$row:B$row")->applyFromArray($estiloTabla);
    
    if ($row % 2 == 0) {
        $sheet->getStyle("A$row:B$row")->applyFromArray($estiloFilaAlternada);
    }
    $row++;
}
$sheet->setCellValue("A$row", 'Total');
$sheet->setCellValue("B$row", $totalReportes);
$sheet->getStyle("A$row:B$row")->applyFromArray($estiloTabla);

//Sección 5: Reportes de Usuarios
$row += 2;
$sheet->setCellValue("A$row", '5. Reportes de Usuarios');
$sheet->getStyle("A$row")->applyFromArray(['font' => ['bold' => true, 'size' => 14,],]);

$row++;
$sheet->setCellValue("A$row", 'ID')
    ->setCellValue("B$row", 'Título')
    ->setCellValue("C$row", 'Descripción')
    ->setCellValue("D$row", 'Tipo')
    ->setCellValue("E$row", 'Fecha de Creación');
$sheet->getStyle("A$row:E$row")->applyFromArray($estiloEncabezado);

$row++;
foreach ($reportesUsuarios as $reporte) {
    $sheet->setCellValue("A$row", $reporte['id']);
    $sheet->setCellValue("B$row", $reporte['titulo']);
    $sheet->setCellValue("C$row", $reporte['descripcion']);
    $sheet->setCellValue("D$row", $reporte['tipo']);
    $sheet->setCellValue("E$row", $reporte['created_at']);
    $sheet->getStyle("A$row:E$row")->applyFromArray($estiloTabla);
    
    if ($row % 2 == 0) {
        $sheet->getStyle("A$row:E$row")->applyFromArray($estiloFilaAlternada);
    }
    $row++;
}

//Descargar el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'reporte_dashboard_' . date('d/m/Y') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;

function obtenerNombreMes($numeroMes) {
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
        7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    return $meses[$numeroMes];
}
?>