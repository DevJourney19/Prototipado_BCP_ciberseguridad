<?php

class Dispositivo
{
private $id_dispositivo;
private $tipo_dispositivo;
private $direccion_ip;
private $pais;
private $ciudad;
private $estado_dispositivo;
private $fecha_registro;
private $ultima_conexion;

public function getIdDispositivo()
    {
        return $this->id_dispositivo;
    }

    public function setIdDispositivo($id_dispositivo)
    {
        $this->id_dispositivo = $id_dispositivo;
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

}