<?php

include_once '../config/Connection.php';
include_once './interfaces/DaoInterfaceHorario.php';

class DaoHorario implements DaoInterfaceHorario {
    private $db;

    public function __construct() {
        $this->db = new Connection();
    }

    public function registrarHorario($idSeguridad, $horaInicio, $horaFin, $fecha) {
        try {
            $query = "INSERT INTO horarios (id_seguridad, hora_inicio, hora_fin, created_at, updated_at) VALUES (:idSeguridad, :horaInicio, :horaFin, NOW(), NOW())";
            return $this->db->ejecutar($query, [
                'idSeguridad' => $idSeguridad,
                'horaInicio' => $horaInicio,
                'horaFin' => $horaFin
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerHorariosRestringidos() {
        try {
            $query = "SELECT * FROM horas_restringidas WHERE DATE(created_at) = CURDATE()";
            return $this->db->consultar($query);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function obtenerTodosLosHorarios() {
        try {
            $query = "SELECT * FROM horarios";
            return $this->db->consultar($query);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function modificarHorario($id, $idSeguridad, $horaInicio, $horaFin, $fecha) {
        try {
            $query = "UPDATE horarios SET id_seguridad = :idSeguridad, hora_inicio = :horaInicio, hora_fin = :horaFin, updated_at = NOW() WHERE id = :id";
            return $this->db->ejecutar($query, [
                'id' => $id,
                'idSeguridad' => $idSeguridad,
                'horaInicio' => $horaInicio,
                'horaFin' => $horaFin
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function eliminarHorario($id) {
        try {
            $query = "DELETE FROM horarios WHERE id = :id";
            return $this->db->ejecutar($query, ['id' => $id]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>