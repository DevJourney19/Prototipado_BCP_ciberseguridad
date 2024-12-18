<?php

include_once '/app/config/Connection.php';
include_once '/app/dao/interfaces/DaoInterfaceEntrada.php';

class DaoEntrada implements DaoInterfaceEntrada
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function verificarServicio($idSeguridad)
    {
        $sql = "SELECT * FROM seguridad WHERE id_seguridad = :idSeguridad AND activacion_seguridad = 1";
        $result = $this->db->consultar($sql, ['idSeguridad' => $idSeguridad]);
        if (count($result) > 0) {
            return $result;
        } else {
            echo "No se encontraron resultados.";
            return null;
        }
    }

    public function verificarYape($idSeguridad)
    {
        $sql = "SELECT * FROM seguridad WHERE id_seguridad = :idSeguridad AND estado_yape = 1";
        $result = $this->db->consultar($sql, ['idSeguridad' => $idSeguridad]);
        if (count($result) > 0) {
            return $result[0];
        } else {
            echo "No se encontraron resultados.";
            return null;
        }
    }
}
