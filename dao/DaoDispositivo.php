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
    function createDevice($estado)
    {
        try {
            $id_seguridad = $_SESSION['id_seguridad'];
            $ip_usuario = getPublicIp();
            $resultado = obtener_info_ip($ip_usuario);
            $dispositivo = obtener_dispositivo();
            $fecha_registro = date('Y-m-d H:i:s');

            $query = "INSERT INTO dispositivo (id_seguridad, tipo_dispositivo, direccion_ip, 
    pais, ciudad, fecha_registro, estado_dispositivo, ultima_conexion) VALUES ('$id_seguridad', '$dispositivo', '$ip_usuario', 
    '{$resultado['country']}', '{$resultado['city']}', '$fecha_registro', '$estado', NOW())";
            $response = $this->db->ejecutar($query);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $response;
    }
    function delete($id_dispositivo)
    {
        $sql = "delete from dispositivo where id_dispositivo = '$id_dispositivo'";
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
            }
            $reponse = $this->db->ejecutar($sql);
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