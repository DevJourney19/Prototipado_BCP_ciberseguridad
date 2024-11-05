<?php

include_once '../model/Seguridad.php';
include_once '../config/Connection.php';
include_once 'interfaces/DaoInterfaceSeguridad.php';

class DaoSeguridad implements DaoInterfaceSeguridad
{
  private $db;

  public function __construct()
  {
    $this->db = new Connection();
  }
  function mostrarDispositivos(){
    
  }
  public function read($idSeguridad)
  {
    try {
      $query = "SELECT * FROM seguridad WHERE id_seguridad = :idSeguridad";
      $result = $this->db->consultar($query, ['idSeguridad' => $idSeguridad]);
      if (count($result) > 0) {
        return $result[0];
      } else {
        return null;
      }
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      return null;
    }
  }

  public function editarEstadoFuncionalidad($funcion, $estado, $seguridad)
  {
    try {
      $response = false;
      if ($funcion != "activacion_seguridad") {
        $query = "UPDATE seguridad SET $funcion = :estado WHERE id_seguridad = :seguridad";
        $response = $this->db->ejecutar($query, ['estado' => $estado, 'seguridad' => $seguridad]);
      } else {
        $query = "UPDATE seguridad SET activacion_seguridad = :estado1 , estado_hora_direccion = :estado2 , estado_yape = :estado3 WHERE id_seguridad = :seguridad";
        $response = $this->db->ejecutar($query, ['estado1' => $estado, 'estado2' => $estado, 'estado3' => $estado, 'seguridad' => $seguridad]);
      }
      return $response;
    } catch (Exception $e) {
      throw new Exception("Error: " . $e->getMessage());
    }
  }

  public function readByUser($idUsuario)
  {
    try {
      $query = "SELECT * FROM seguridad WHERE id_usuario = :idUsuario";
      return $this->db->consultar($query, ['idUsuario' => $idUsuario]);
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      return null;
    }
  }

  public function readActiveSecurity($idUsuario)
  {
    try {
      $sql = "SELECT * FROM seguridad WHERE id_usuario = :idUsuario AND activacion_seguridad = 1";
      $result = $this->db->consultar($sql, ['idUsuario' => $idUsuario]);
      return $result;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      return null;
    }
  }

  public function verificarActivaciones($idUsuario)
  {
    try {
      $resultadoVerificacion = $this->readByUser($idUsuario);
      if ($resultadoVerificacion) {
        $query = "UPDATE seguridad set activacion_seguridad  = '1' where id_usuario= :idUsuario";
      } else {
        $query = "INSERT INTO seguridad(id_usuario) VALUES(:idUsuario)";
      }
      $response = $this->db->ejecutar($query, ['idUsuario' => $idUsuario]);
      if ($response) {
        return true;
      } else {
        return false;
      }
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      return false;
    }
  }
  public function existeSeguridad($id_seguridad) {
    try {
        $query = "SELECT COUNT(*) FROM seguridad WHERE id_seguridad = :idSeguridad"; 
        $result = $this->db->consultar($query, ['idSeguridad' => $id_seguridad]);
        return $result[0]['COUNT(*)'] > 0; 
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
  public function obtenerIdUsuarioPorSeguridad($idSeguridad) {
    try {
        $query = "SELECT id_usuario FROM seguridad WHERE id_seguridad = :idSeguridad";
        return $this->db->consultar($query, ['idSeguridad' => $idSeguridad]);
    } catch (Exception $e) {
        echo "Error al obtener id_usuario por id_seguridad: " . $e->getMessage();
        return null;
    }
}

}
