<?php

//include_once 'dao/DaoUsuario.php';
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
session_start();

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Habilita depuración
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'f4r3ver@gmail.com'; // Tu dirección de correo
    $mail->Password = 'pufr jhto bpyy drux'; // Contraseña o contraseña de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('f4r3ver@gmail.com', 'Banca en Linea BCP');
    $mail->addAddress('f4r3ver@gmail.com'); // Cambia esto por un correo válido

    $mail->Subject = 'Prueba de envío';
    $mail->Body = 'Este es un mensaje de prueba';

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'Correo enviado']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage(), 'debug' => $mail->ErrorInfo]);
}