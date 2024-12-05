<?php

class Reporte {
    private $id_seguridad;
    private $titulo;
    private $descripcion;
    private $tipo;

    // Constructor
    public function __construct($id_seguridad = null, $titulo = null, $descripcion = null, $tipo = null) {
        $this->id_seguridad = $id_seguridad;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
    }

    // Getters
    public function getIdSeguridad() {
        return $this->id_seguridad;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getTipo() {
        return $this->tipo;
    }

    // Setters
    public function setIdSeguridad($id_seguridad) {
        $this->id_seguridad = $id_seguridad;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}

