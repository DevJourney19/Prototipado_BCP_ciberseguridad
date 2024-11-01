<?php

interface DaoInterfaceHorario {
    public function registrarHorario($idSeguridad, $horaInicio, $horaFin, $fecha);
    
    // Declaración del nuevo método
    public function obtenerHorariosRestringidos();

    public function obtenerTodosLosHorarios();

    public function modificarHorario($id, $idSeguridad, $horaInicio, $horaFin, $fecha);

    public function eliminarHorario($id);
}
?>