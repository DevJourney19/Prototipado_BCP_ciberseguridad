<?php

include_once '../dao/DaoDashboard.php';

class ControllerEstadisticas
{
  private $daoEstadisticas;

  public function __construct()
  {
    $this->daoEstadisticas = new DaoDashboard();
  }

  public function emocion()
  {
    $mes = $_GET['mes'];
    $anio = $_GET['anio'];
    $estadisticas = $this->daoEstadisticas->obtenerSatisfaccionPorMesYAnio($mes, $anio);
    return $estadisticas;
  }

  public function registros()
  {
    $estadisticas = $this->daoEstadisticas->obtenerNumeroRegistros();
    return $estadisticas;
  }

  public function ganancias()
  {
    $mes = $_GET['mes'];
    $anio = $_GET['anio'];
    $estadisticas = $this->daoEstadisticas->obtenerGanaciasPorMesYAnio($mes, $anio);
    return $estadisticas;
  }

  public function reportes()
  {
    $anio = $_GET['anio'];
    $estadisticas = $this->daoEstadisticas->obtenerReportesAtaques($anio);
    return $estadisticas;
  }
}

$controller = new ControllerEstadisticas();
$action = $_GET['action'] ?? null;

if ($action && method_exists($controller, $action)) {
    $resultadoEstadistica = $controller->$action();
    echo json_encode($resultadoEstadistica);

} else {
  // Si la acción no está definida o no existe
  $resultadoEstadistica = null;
}



