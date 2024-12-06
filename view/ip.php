<?php
include_once '../controller/envio_mensaje.php';
// Ejemplo de uso
session_start();
$_SESSION['id_seguridad'] = '16';
$info = ['city' => 'Lima'];
$dir_ip = '192.168.1.1';
$hora = date("H:i:s");

$mensaje = new EnvioMensaje();
$mensaje->envioCorreo($info['city'], $dir_ip, $hora);
$mensaje->envioSms($info['city'], $dir_ip, $hora);
