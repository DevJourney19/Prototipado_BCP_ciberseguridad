<?php

interface DaoInterfaceHorario {
    public function registrarHorario($idSeguridad, $horaInicio, $horaFin);
    
    // Cambiar la declaración del método para incluir el parámetro
    public function obtenerHorariosRestringidos($idSeguridad);

    public function obtenerTodosLosHorarios();

    public function modificarHorario($id, $idSeguridad, $horaInicio, $horaFin, $fecha);

    public function eliminarHorario($id);
}