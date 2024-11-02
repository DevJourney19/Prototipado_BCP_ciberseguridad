<?php

class Direccion {
    private $id;
    private $id_seguridad;
    private $direccion_exacta;
    private $rango_gps;
    private $fecha_configuracion;
    private $hora_configuracion;

    public function __construct($id, $id_seguridad, $direccion_exacta, $rango_gps, $fecha_configuracion, $hora_configuracion) {
        $this->id = $id;
        $this->id_seguridad = $id_seguridad;
        $this->direccion_exacta = $direccion_exacta;
        $this->rango_gps = $rango_gps;
        $this->fecha_configuracion = $fecha_configuracion;
        $this->hora_configuracion = $hora_configuracion;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getIdSeguridad() { return $this->id_seguridad; }
    public function getDireccionExacta() { return $this->direccion_exacta; }
    public function getRangoGps() { return $this->rango_gps; }
    public function getFechaConfiguracion() { return $this->fecha_configuracion; }
    public function getHoraConfiguracion() { return $this->hora_configuracion; }
    
    // Setters
    public function setDireccionExacta($direccion_exacta) { $this->direccion_exacta = $direccion_exacta; }
    public function setRangoGps($rango_gps) { $this->rango_gps = $rango_gps; }
}

