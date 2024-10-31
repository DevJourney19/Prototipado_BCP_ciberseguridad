<?php

require_once '../controllers/ControllerEntradas.php';

$controller = new ControllerEntradas();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $location = $_GET['location'] ?? '/';

    if ($action === 'entrada') {
        $controller->validarEntrada($location);
    } elseif ($action === 'servicio') {
        $controller->validarServicio($location);
    } else {
        echo "Acción no válida";
    }
} else {
    echo "No se especificó ninguna acción";
}