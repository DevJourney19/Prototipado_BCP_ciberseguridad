<?php

session_start();
if (isset($_SESSION['id_usuario'])) {
    $response = [
        'id' => $_SESSION['id_usuario'],
        'status' => true
    ];
} else {
    $response = [
        'status' => false
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
