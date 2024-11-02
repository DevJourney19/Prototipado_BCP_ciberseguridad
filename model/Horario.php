<?php

class Horario {
    private $id;
    private $idSeguridad;
    private $horaInicio;
    private $horaFin;
    private $createdAt;
    private $updatedAt;

    public function __construct($id, $idSeguridad, $horaInicio, $horaFin, $createdAt, $updatedAt) {
        $this->id = $id;
        $this->idSeguridad = $idSeguridad;
        $this->horaInicio = $horaInicio;
        $this->horaFin = $horaFin;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdSeguridad() {
        return $this->idSeguridad;
    }

    public function getHoraInicio() {
        return $this->horaInicio;
    }

    public function getHoraFin() {
        return $this->horaFin;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setIdSeguridad($idSeguridad) {
        $this->idSeguridad = $idSeguridad;
    }

    public function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    public function setHoraFin($horaFin) {
        $this->horaFin = $horaFin;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }
}
?>