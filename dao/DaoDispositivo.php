<?php
include_once '../model/Dispositivo.php';
include_once '../config/Connection.php';
include_once 'interfaces/DaoInterfaceDispositivo.php';

class DaoDispositivo implements DaoInterfaceDispositivo
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }
    function createDevice($modelo_dispositivo)
    {
        $response = false;
        try {
            $id_seguridad = $modelo_dispositivo->getIdSeguridad();
            $ip_usuario = $modelo_dispositivo->getDireccionIp();
            $pais = $modelo_dispositivo->getPais();
            $ciudad = $modelo_dispositivo->getCiudad();
            $dispositivo = $modelo_dispositivo->getTipoDispositivo();
            $estado = $modelo_dispositivo->getEstadoDispositivo();
            $latitud = $modelo_dispositivo->getLatitud();
            $longitud = $modelo_dispositivo->getLongitud();
            $fecha_registro = date('Y-m-d');
            $ult_conexion = date('Y-m-d');
            $query = "INSERT INTO dispositivo (id_seguridad, tipo_dispositivo, direccion_ip, pais, ciudad, latitud, longitud, fecha_registro, estado_dispositivo, ultima_conexion) VALUES ('$id_seguridad', '$dispositivo', '$ip_usuario', '$pais', '$ciudad', '$latitud', '$longitud', '$fecha_registro', '$estado', '$ult_conexion')";
            $response = $this->db->ejecutar($query);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $response;
    }
    function updateDate($id_dispositivo)
    {
        try {
            $ult_conexion = date('Y-m-d');
            $sql = "UPDATE dispositivo SET ultima_conexion = '$ult_conexion' WHERE id_dispositivo='$id_dispositivo'";
            $this->db->ejecutar($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    function delete($id_dispositivo)
    {
        $sql = "DELETE FROM dispositivo WHERE id_dispositivo = '$id_dispositivo'";
        $this->db->ejecutar($sql);
    }

    function updateDeviceStatus($accion, $id_dispositivo)
    {
        try {
            $response = false;
            if ($accion === 'permitir') {
                $sql = "UPDATE dispositivo SET estado_dispositivo='seguro' where id_dispositivo ='$id_dispositivo'";
            } else if ($accion === 'bloquear') {
                $sql = "UPDATE dispositivo SET estado_dispositivo='bloqueado' where id_dispositivo ='$id_dispositivo'";
            } else if ($accion === 'eliminar') {
                $sql = "delete from dispositivo where id_dispositivo = '$id_dispositivo'";
            } else if ($accion === 'activar') {
                $sql = "UPDATE dispositivo SET estado_dispositivo='activado' where id_dispositivo ='$id_dispositivo'";
            }
            $response = $this->db->ejecutar($sql);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
        return $response;
    }

    function readById($id)
    {
        try {
            $query = "SELECT * FROM dispositivo where id_dispositivo='$id'";
            return $this->db->consultar($query);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public function readDispoByUserSecurity($id_seguridad)
    {
        try {
            $sql = "SELECT * FROM dispositivo WHERE id_seguridad='$id_seguridad'";
            return $this->db->consultar($sql);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function enterAccess($id_seguridad, $dir_ip)
    {
        try {
            $query = "SELECT * FROM dispositivo WHERE id_seguridad = '$id_seguridad' AND (estado_dispositivo='activado' || estado_dispositivo='seguro') AND direccion_ip='$dir_ip'";
            return $this->db->consultar($query);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}