<?php 

$enlace = mysqli_connect("localhost:3308", "root", "", "seguridadbcp");

if(!$enlace){
    die("No pudo conectarse a la base de datos " . mysqli_connect_error());
}
//echo "Conexión exitosa";

