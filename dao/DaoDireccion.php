<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include_once '../config/Connection.php';
include_once 'interfaces/DaoInterfaceDireccion.php';

class DaoDireccion implements DaoInterfaceDireccion
{
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function registrarDireccion($id_seguridad, $direccion_exacta, $longitud, $latitud, $rango_gps, $fecha_configuracion, $hora_configuracion)
    {
        $query = "INSERT INTO direccion (id_seguridad, direccion_exacta, longitud, latitud, rango_gps, fecha_configuracion, hora_configuracion) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->connection->ejecutar($query, [$id_seguridad, $direccion_exacta, $longitud, $latitud, $rango_gps, $fecha_configuracion, $hora_configuracion]);
    }

    public function obtenerTodasDirecciones($id)
    {
        $query = "SELECT * FROM direccion where id_seguridad = :id";
        return $this->connection->consultar($query, ['id' => $id]);
    }

    public function modificarDireccion($id_direccion, $direccion_exacta, $longitud, $latitud, $rango_gps)
    {
        $sql = "UPDATE direccion SET direccion_exacta = ?, longitud = ?, latitud = ?, rango_gps = ? WHERE id_direccion = ?";

        return $this->connection->ejecutar($sql, [$direccion_exacta, $longitud, $latitud, $rango_gps, $id_direccion]);
    }

    public function eliminarDireccion($id)
    {
        $query = "DELETE FROM direccion WHERE id_direccion = ?";
        $this->connection->ejecutar($query, [$id]);
    }
}