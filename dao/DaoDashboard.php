<?php

include_once '/app/config/Connection.php';
include_once '/app/dao/interfaces/DaoInterfaceDashboard.php';

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
 public function obtenerGananciasPorAnio($anio)
{
    // Consulta para obtener el número de registros por mes en un año específico y multiplicarlos por 10
    $query = "SELECT MONTH(created_at) as mes, COUNT(*) * 10 as total
              FROM seguridad
              WHERE YEAR(created_at) = ?
              GROUP BY MONTH(created_at)";
    
    $result = $this->conn->consultar($query, [$anio]); 
    return $result;
}
public function SatisfaccionPorAnio($anio)
{
    // La consulta SQL para obtener la cantidad de encuestas por estado en el año especificado
    $query = "SELECT estado, COUNT(*) as cantidad 
              FROM encuesta 
              WHERE YEAR(created_at) = :anio 
              GROUP BY estado";

    // Llamamos al método consultar, pasándole la consulta y el parámetro de año
    $result = $this->conn->consultar($query, ['anio' => $anio]);
    return $result ?: [];
}
public function obtenerReportes()
{
    $query = "SELECT id, id_seguridad, titulo, descripcion, tipo, created_at FROM reporte";
    $result = $this->conn->consultar($query);

    return $result ?: [];
}
}
