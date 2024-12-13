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

# Propiedades de la base de datos usando variables de entorno
define('HOST', 'localhost:3306');
define('USER', 'root');
define('PASS', '');
define('DATABASE', 'seguridadbcp');