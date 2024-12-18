<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once '/app/config/Connection.php';
include_once '/app/dao/interfaces/DaoInterfaceHorario.php';

class DaoHorario implements DaoInterfaceHorario
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function registrarHorario($idSeguridad, $horaInicio, $horaFin)
    {
        try {
            $query = "INSERT INTO hora_restringida (id_seguridad, hora_inicio, hora_final, created_at, updated_at) 
                      VALUES (:idSeguridad, :horaInicio, :horaFin, NOW(), NOW())";
            return $this->db->ejecutar($query, [
                'idSeguridad' => $idSeguridad,
                'horaInicio' => $horaInicio,
                'horaFin' => $horaFin
            ]);
        } catch (Exception $e) {
            // Mejorar el manejo de errores registrando en un log
            echo "Error al registrar horario: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerHorariosRestringidos($idSeguridad)
    {
        try {
            $query = "SELECT * FROM hora_restringida WHERE id_seguridad = :idSeguridad AND DATE(CREATED_AT) = CURDATE()";
            return $this->db->consultar($query, ['idSeguridad' => $idSeguridad]);
        } catch (Exception $e) {
            echo "Error al obtener horarios restringidos: " . $e->getMessage();
            return [];
        }
    }
    public function obtenerTodosLosHorarios()
    {
        try {
            $query = "SELECT * FROM hora_restringida";
            return $this->db->consultar($query);
        } catch (Exception $e) {
            echo "Error al obtener todos los horarios: " . $e->getMessage();
            return [];
        }
    }

    public function modificarHorario($id, $idSeguridad, $horaInicio, $horaFin, $fecha)
    {
        try {
            $query = "UPDATE hora_restringida SET id_seguridad = :idSeguridad, hora_inicio = :horaInicio, 
                      hora_final = :horaFin, updated_at = NOW() WHERE id_hora = :id";
            return $this->db->ejecutar($query, [
                'id' => $id,
                'idSeguridad' => $idSeguridad,
                'horaInicio' => $horaInicio,
                'horaFin' => $horaFin
            ]);
        } catch (Exception $e) {
            echo "Error al modificar horario: " . $e->getMessage();
            return false;
        }
    }

    public function eliminarHorario($id)
    {
        try {
            $query = "DELETE FROM hora_restringida WHERE id_hora = :id";
            return $this->db->ejecutar($query, ['id' => $id]);
        } catch (Exception $e) {
            echo "Error al eliminar horario: " . $e->getMessage();
            return false;
        }
    }
}
