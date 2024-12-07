<?php
// utilizar el modelo en el controlador
class Dispositivo
{
    private $id_seguridad;
    private $tipo_dispositivo;
    private $direccion_ip;
    private $longitud;
    private $latitud;
    private $pais;
    private $ciudad;
    private $estado_dispositivo;
    private $fecha_registro;
    private $ultima_conexion;

    public function __construct($id_seguridad = null, $tipo_dispositivo = null, $direccion_ip = null, $longitud = null, $latitud = null, $pais = null, $ciudad = null, $estado_dispositivo = null, $fecha_registro = null, $ultima_conexion = null) {
        $this->id_seguridad = $id_seguridad;
        $this->tipo_dispositivo = $tipo_dispositivo;
        $this->direccion_ip = $direccion_ip;
        $this->longitud = $longitud;
        $this->latitud = $latitud;
        $this->pais = $pais;
        $this->ciudad = $ciudad;
        $this->estado_dispositivo = $estado_dispositivo;
        $this->fecha_registro = $fecha_registro;
        $this->ultima_conexion = $ultima_conexion;
    }

    public function getIdSeguridad()
    {
        return $this->id_seguridad;
    }

    public function setIdSeguridad($id_seguridad)
    {
        $this->id_seguridad = $id_seguridad;
    }

    public function getDireccionIp()
    {
        return $this->direccion_ip;
    }

    public function setDireccionIp($direccion_ip)
    {
        $this->direccion_ip = $direccion_ip;
    }
    
    public function getTipoDispositivo()
    {
        return $this->tipo_dispositivo;
    }

    public function setTipoDispositivo($tipo_dispositivo)
    {
        $this->tipo_dispositivo = $tipo_dispositivo;
    }

    public function getPais()
    {
        return $this->pais;
    }

    public function setPais($pais)
    {
        $this->pais = $pais;
    }


    public function getCiudad()
    {
        return $this->ciudad;
    }

    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }

    public function getEstadoDispositivo()
    {
        return $this->estado_dispositivo;
    }

    public function setEstadoDispositivo($estado_dispositivo)
    {
        $this->estado_dispositivo = $estado_dispositivo;
    }

    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    public function setUltimaConexion($ultima_conexion)
    {
        $this->ultima_conexion = $ultima_conexion;
    }

    public function getUltimaConexion()
    {
        return $this->ultima_conexion;
    }

    public function getLongitud()
    {
        return $this->longitud;
    }

    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
    }

    public function getLatitud()
    {
        return $this->latitud;
    }

    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
    }
}
