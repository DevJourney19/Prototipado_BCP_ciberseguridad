<?php
#Definir zona horaria
date_default_timezone_set("America/Lima");
#Propiedades de la base de datos
// const HOST = "localhost";
// const USER = "root";
// const PASS = "";
// const DATABASE = "seguridadbcp";
// const PORT = "3308";


//require_once __DIR__ . '/../vendor/autoload.php';

//use Dotenv\Dotenv;

// # Cargar variables de entorno
// $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
// $dotenv->load();

$DB_HOST = $_ENV["DB_HOST"];
$DB_USER = $_ENV["DB_USER"];
$DB_PASSWORD = $_ENV["DB_PASSWORD"];
$DB_NAME = $_ENV["DB_NAME"];
$DB_PORT = $_ENV["DB_PORT"];
$db = mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_PORT");

?>