<?php
include_once '../controller/direccion_ip.php';

$ip = getPublicIp();

echo "IP: $ip\n";