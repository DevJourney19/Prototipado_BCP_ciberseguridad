<?php
// utilizar el modelo en el controlador
class Direccion {
    private $id;
    private $id_seguridad;
    private $direccion_exacta;
    private $latitud;
    private $longitud;
    private $rango_gps;
    private $fecha_configuracion;
    private $hora_configuracion;

    public function __construct($id = null, $id_seguridad = null, $direccion_exacta = null, $latitud = null, $longitud = null, $rango_gps = null, $fecha_configuracion = null, $hora_configuracion = null) {
        $this->id = $id;
        $this->id_seguridad = $id_seguridad;
        $this->direccion_exacta = $direccion_exacta;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
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
    public function getLatitud() { return $this->latitud; }
    public function getLongitud() { return $this->longitud; }
    
    // Setters
    public function setDireccionExacta($direccion_exacta) { $this->direccion_exacta = $direccion_exacta; }
    public function setRangoGps($rango_gps) { $this->rango_gps = $rango_gps; }
    public function setFechaConfiguracion($fecha_configuracion) { $this->fecha_configuracion = $fecha_configuracion; }
    public function setHoraConfiguracion($hora_configuracion) { $this->hora_configuracion = $hora_configuracion; }
    public function setIdSeguridad($id_seguridad) { $this->id_seguridad = $id_seguridad; }
    public function setLatitud($latitud) { $this->latitud = $latitud; }
    public function setLongitud($longitud) { $this->longitud = $longitud; }
}

