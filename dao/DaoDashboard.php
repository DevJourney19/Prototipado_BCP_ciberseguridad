<?php

include_once '../config/Connection.php';
include_once 'interfaces/DaoInterfaceDashboard.php';

class DaoDashboard implements DaoInterfaceDashboard
{
  private $conn;

  public function __construct()
  {
    $this->conn = new Connection();
  }

  public function obtenerSatisfaccionPorMesYAnio($mes, $anio)
  {
    //retornar un array con Muy Instatisfecho, Insatisfecho, Neutral, Satisfecho, Muy Satisfecho
    $query = "SELECT COUNT(*) as cantidad, estado FROM encuesta WHERE MONTH(created_at) = :mes AND YEAR(created_at) = :anio GROUP BY estado";
    $result = $this->conn->consultar($query, ['mes' => $mes, 'anio' => $anio]);
    return $result;
  }

  public function obtenerNumeroRegistros()
  {
    // retornar un array con la cantidad de registros por cada mes
    $query = "SELECT COUNT(*) as cantidad, MONTH(created_at) as mes FROM seguridad WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY mes";
    $result = $this->conn->consultar($query);
    return $result;
  }

  public function obtenerGanaciasPorMesYAnio($mes, $anio)
  {
    // retornar un numero de ganancias por mes y año
    $query = "SELECT COUNT(*) as cantidad from seguridad WHERE MONTH(created_at) = $mes AND YEAR(created_at) = $anio";
    $result = $this->conn->consultar($query);
    return $result;
  }

  public function obtenerReportesAtaques($anio)
  {
    // retornar un array con la cantidad de reportes de ataques comparado anio actual con anio anterior
    $query = "SELECT COUNT(*) as cantidad, MONTH(created_at) as mes FROM reporte WHERE YEAR(created_at) = :anio GROUP BY mes";
    $result = $this->conn->consultar($query, ['anio' => $anio]);
    return $result;
  }
}
