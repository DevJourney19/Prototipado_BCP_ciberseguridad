<?php
// utilizar el modelo en el controlador
class Horario {
    private $id;
    private $idSeguridad;
    private $horaInicio;
    private $horaFin;
    private $createdAt;
    private $updatedAt;

    public function __construct($id, $idSeguridad, $horaInicio, $horaFin, $createdAt = null, $updatedAt = null) {
        $this->id = $id;
        $this->idSeguridad = $idSeguridad;
        $this->horaInicio = $horaInicio;
        $this->horaFin = $horaFin;
        // Inicializa las fechas con la hora actual si no se proporcionan
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
        $this->updatedAt = $updatedAt ?? date('Y-m-d H:i:s');
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
        // Validación básica para la hora de inicio
        if ($this->validateTime($horaInicio)) {
            $this->horaInicio = $horaInicio;
        } else {
            throw new InvalidArgumentException("Hora de inicio inválida.");
        }
    }

    public function setHoraFin($horaFin) {
        // Validación básica para la hora de fin
        if ($this->validateTime($horaFin)) {
            $this->horaFin = $horaFin;
        } else {
            throw new InvalidArgumentException("Hora de fin inválida.");
        }
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    private function validateTime($time) {
        // Validación simple para el formato de hora
        return preg_match("/^(?:[01]\d|2[0-3]):(?:[0-5]\d)$/", $time) === 1;
    }

    public function __toString() {
        return "Horario{id: $this->id, idSeguridad: $this->idSeguridad, horaInicio: $this->horaInicio, horaFin: $this->horaFin, createdAt: $this->createdAt, updatedAt: $this->updatedAt}";
    }
}