<?php
include_once '../php/util/validar_entradas.php';
include_once '../php/util/connection.php';
include_once 'direccion_ip.php';

validar_entrada('index.php');


header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['token_validado'])) {
    $_SESSION['token_validado'] = $data['token_validado'];
    try {

        $id_usuario_no_permitido = $_SESSION["id_usuario"];

        $id_seguridad = $_SESSION['id_seguridad'];

        $ip_usuario = getPublicIp();
        $resultado = obtener_info_ip($ip_usuario);
        //----------------------------------------
        $dispositivo = obtener_dispositivo();

        $fecha_registro = date('Y-m-d H:i:s');

        //Agregamos los equipos no deseados a la base de datos
        conectar();
        if (
            ejecutar("INSERT INTO dispositivos (dispositivo_seguro, tipo_dispositivo, direccion_ip, 
    pais, ciudad, fecha_registro, id_seguridad, verificado) VALUES (0, '$dispositivo', '$ip_usuario', 
    '{$resultado['country']}', '{$resultado['city']}', '$fecha_registro', '$id_seguridad', 1)")
        ) {
        } else {
            echo "Error al insertar datos: " . mysqli_error($conexion); // Cambia $conexion por tu variable de conexión
        }
        desconectar();

    } catch (Exception $error) {
        echo $error->getMessage();
    }

}

echo json_encode(['status' => 'success']);