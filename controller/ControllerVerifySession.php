<?php

session_start();
if (isset($_SESSION['security'])) {
    $response = [
        'id' => $_SESSION['id'],
        'security' => $_SESSION['security'],
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
