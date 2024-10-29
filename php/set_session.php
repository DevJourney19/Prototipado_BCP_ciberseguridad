<?php
include_once '../php/util/validar_entradas.php';
include_once '../php/util/connection.php';
include_once 'direccion_ip.php';

validar_entrada('index.php');


header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);


if (isset($data['token_validado'])) {
    $_SESSION['token_validado'] = $data['token_validado'];
    $verificado = $data['token_validado'] === true ? 1 : 0;
    registrar_dispositivo($verificado);
}

function registrar_dispositivo($verificado)
{
    global $conexion;
    try {
        $id_seguridad = $_SESSION['id_seguridad'];
        $ip_usuario = getPublicIp();
        $resultado = obtener_info_ip($ip_usuario);
        $dispositivo = obtener_dispositivo();
        $fecha_registro = date('Y-m-d H:i:s');

        $query = "INSERT INTO dispositivos (dispositivo_seguro, tipo_dispositivo, direccion_ip, 
    pais, ciudad, fecha_registro, id_seguridad, verificado) VALUES (0, '$dispositivo', '$ip_usuario', 
    '{$resultado['country']}', '{$resultado['city']}', '$fecha_registro', '$id_seguridad', $verificado)";

        //Agregamos los equipos no deseados a la base de datos
        conectar();
        if (!ejecutar($query)) {
            throw new Exception("Error al insertar datos: " . mysqli_error($conexion));
        }
        desconectar();
    } catch (Exception $e) {
        desconectar();
        throw new Exception('Error en registrar dispositivo: ' . $e->getMessage());
    }
}

echo json_encode(['status' => 'success']);