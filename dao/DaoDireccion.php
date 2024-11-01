<?php

include_once '../config/Connection.php';
include_once '../model/Direccion.php';
include_once '../dao/DaoInterfaceDireccion.php';

class DaoDireccion implements DaoInterfaceDireccion {
    private $connection;

    public function __construct() {
        $this->connection = new Connection();
    }

    public function registrarDireccion($id_seguridad, $direccion_exacta, $rango_gps, $fecha_configuracion, $hora_configuracion) {
        $query = "INSERT INTO direccion (id_seguridad, direccion_exacta, rango_gps, fecha_configuracion, hora_configuracion) 
                  VALUES (?, ?, ?, ?, ?)";
        $this->connection->ejecutar($query, [$id_seguridad, $direccion_exacta, $rango_gps, $fecha_configuracion, $hora_configuracion]);
    }

    public function obtenerTodasDirecciones() {
        $query = "SELECT * FROM direccion";
        return $this->connection->consultar($query);
    }

    public function modificarDireccion($id, $direccion_exacta, $rango_gps) {
        $query = "UPDATE direccion SET direccion_exacta = ?, rango_gps = ? WHERE id = ?";
        $this->connection->ejecutar($query, [$direccion_exacta, $rango_gps, $id]);
    }

    public function eliminarDireccion($id) {
        $query = "DELETE FROM direccion WHERE id = ?";
        $this->connection->ejecutar($query, [$id]);
    }
}
?>