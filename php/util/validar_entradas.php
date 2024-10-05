<?php

function validar_entrada($location) {
    session_start();
    if (!isset($_SESSION['id'])) {
        exit("<script>alert('Inicie Sesion para poder continuar');
            window.location.href = '$location';</script>");
    }
}