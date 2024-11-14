
<?php

interface DaoInterfaceDashboard {
    public function obtenerSatisfaccionPorMesYAnio($mes, $anio);
    public function obtenerNumeroRegistros();
    public function obtenerGanaciasPorMesYAnio($mes, $anio);
    public function obtenerReportesAtaques($anio);
}