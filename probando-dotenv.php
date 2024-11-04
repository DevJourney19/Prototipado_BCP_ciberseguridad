<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    echo "Variables de entorno cargadas correctamente.";
} catch (Exception $e) {
    echo "Error al cargar Dotenv: " . $e->getMessage();
}
