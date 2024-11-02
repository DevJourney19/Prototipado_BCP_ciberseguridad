-- phpMyAdmin SQL Dump -- version 5.2.1 -- https://www.phpmyadmin.net/ -- -- Servidor: localhost:3308 -- Tiempo de generación: 26-10-2024 a las 07:06:10 -- Versión del servidor: 10.4.32-MariaDB -- Versión de PHP: 8.2.12 
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"; 
START TRANSACTION; 
SET time_zone = "+00:00"; 
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */; 
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS 
*/; 
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION 
*/; 
/*!40101 SET NAMES utf8mb4 */; 
create database seguridadbcp; 
use seguridadbcp; 
CREATE TABLE `alerta` ( 
`id_alerta` int(11) NOT NULL, 
`id_seguridad` int(11) NOT NULL, 
`mensaje_alerta` text NOT NULL, 
`fecha_alerta` date NOT NULL, 
`hora_alerta` time NOT NULL, 
`motivo_alerta` varchar(255) DEFAULT NULL, 
`estado_alerta` varchar(50) DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; -- -------------------------------------------------------- -- -- Estructura de tabla para la tabla `direccion` 
-- 
CREATE TABLE `direccion` ( 
`id_direccion` int(11) NOT NULL, 
`id_seguridad` int(11) NOT NULL, 
`direccion_exacta` varchar(255) NOT NULL, 
`rango_gps` decimal(10,5) DEFAULT NULL, 
`fecha_configuracion` date NOT NULL, 
`hora_configuracion` time NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; -- -- Volcado de datos para la tabla `direccion` -- 
INSERT INTO `direccion` (`id_direccion`, `id_seguridad`, `direccion_exacta`, 
`rango_gps`, `fecha_configuracion`, `hora_configuracion`) VALUES 
(2, 1, 'asddddd', 30.00000, '2024-10-25', '23:52:09'), 
(3, 1, 'sdfsdf', 20.00000, '2024-10-25', '23:59:27'); -- -------------------------------------------------------- -- -- Estructura de tabla para la tabla `dispositivo` -- 
CREATE TABLE `dispositivo` ( 
`id_dispositivo` int(11) NOT NULL, 
`id_seguridad` int(11) NOT NULL, 
`tipo_dispositivo` varchar(100) NOT NULL, 
`direccion_ip` varchar(100) NOT NULL, 
`pais` varchar(100) NOT NULL, 
`ciudad` varchar(50) NOT NULL, 
`estado_dispositivo` ENUM('activado','seguro','bloqueado','en_proceso_si','en_proceso_no') NOT NULL,
`fecha_registro` date NOT NULL, 
`ultima_conexion` date DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 
-- INSERT Dispositivo
INSERT INTO dispositivo VALUE (1, 1, 'Ordenador de escritorio', '179.6.168.48', 'Perú','Lima','activado', '2024-10-30', '2024-10-30' );
-- -------------------------------------------------------- 
-- -- Estructura de tabla para la tabla `encuestas` -- 
CREATE TABLE `encuesta` ( 
`id_encuesta` int(11) NOT NULL, 
`id_seguridad` int(11) NOT NULL, 
`estado` varchar(50) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 
-- -------------------------------------------------------- -- -- Estructura de tabla para la tabla `horas_restringidas` -- 
CREATE TABLE `hora_restringida` ( 
`id_hora` int(11) NOT NULL, 
`id_seguridad` int(11) NOT NULL, 
`hora_inicio` time DEFAULT NULL, 
`hora_final` time DEFAULT NULL, 
`created_at` datetime DEFAULT NULL, 
`updated_at` datetime DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; -- 
-- Volcado de datos para la tabla `horas_restringidas` -- 
INSERT INTO `hora_restringida` (`id_hora`, `id_seguridad`, `hora_inicio`, 
`hora_final`, `created_at`, `updated_at`) VALUES 
(10, 1, '04:08:00', '03:08:00', '2024-10-25 01:08:19', '2024-10-25 01:08:19'), 
(12, 1, '05:15:00', '04:15:00', '2024-10-25 01:15:58', '2024-10-25 01:15:58'), 
(13, 1, '11:49:00', '12:46:00', '2024-10-25 11:46:07', '2024-10-25 11:46:07'), 
(15, 1, '12:31:00', '12:32:00', '2024-10-25 12:30:03', '2024-10-25 12:30:03'), 
(16, 1, '20:49:00', '21:49:00', '2024-10-25 19:49:41', '2024-10-25 19:49:41'); 
-- -------------------------------------------------------- -- 
-- Estructura de tabla para la tabla `pagos_yape` -- 
CREATE TABLE `pago_yape` ( 
`id_pago` int(11) NOT NULL, 
`id_seguridad_origen` int(11) NOT NULL, 
`id_usuario_destino` int(11) NOT NULL, 
`monto_pago` decimal(10,2) NOT NULL, 
`codigo_verificacion_pago` varchar(100) DEFAULT NULL, 
`fecha_pago` date NOT NULL, 
`hora_pago` time NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 
-- -------------------------------------------------------- 
-- -- Estructura de tabla para la tabla `seguridad` -- 
CREATE TABLE `seguridad` ( 
`id_seguridad` int(11) NOT NULL, 
`id_usuario` int(11) NOT NULL, 
`activacion_seguridad` tinyint(1) NOT NULL DEFAULT 0, 
`estado_hora_direccion` tinyint(1) NOT NULL DEFAULT 0, 
`estado_yape` tinyint(1) NOT NULL DEFAULT 0 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 
-- -- Volcado de datos para la tabla `seguridad` -- 
INSERT INTO `seguridad` (`id_seguridad`, `id_usuario`, `activacion_seguridad`, 
`estado_hora_direccion`, `estado_yape`) VALUES 
(1, 1, 1, 1, 1), 
(2, 1, 0, 0, 0), 
(3, 1, 0, 0, 0), 
(4, 1, 0, 0, 0), 
(5, 1, 0, 0, 0), 
(6, 1, 0, 0, 0); 

-- -------------------------------------------------------- -- -- Estructura de tabla para la tabla `usuario` -- 
CREATE TABLE `usuario` ( 
`id_usuario` int(11) NOT NULL, 
`nombre` varchar(100) NOT NULL, 
`password` blob NOT NULL, 
`dni` varchar(100) NOT NULL, 
`telefono` varchar(100) DEFAULT NULL, 
`correo` varchar(100) DEFAULT NULL, 
`numero_tarjeta` varchar(255) DEFAULT NULL, 
`clave_internet` blob NOT NULL, 
`created_at` datetime DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 
-- -- Volcado de datos para la tabla `usuario` -- 
INSERT INTO `Usuario` (id_usuario, nombre, password, dni, telefono, correo, numero_tarjeta, clave_internet, created_at) VALUES
(1,'Jose Balcazar', AES_ENCRYPT('balcazar', 'D9u#F5h8*Z3kB9!nL7^mQ4'), '12345678', '987654321', 'jose@gmail.com', '1234567891234567', AES_ENCRYPT('123456', 'D9u#F5h8*Z3kB9!nL7^mQ4'), NOW()),
(2,'Yoshua Castañeda', AES_ENCRYPT('castañeda', 'D9u#F5h8*Z3kB9!nL7^mQ4'), '12345679', '876543210', 'yoshua@gmail.com', '1234567891234568', AES_ENCRYPT('123456', 'D9u#F5h8*Z3kB9!nL7^mQ4'), NOW()),
(3,'Elena Suarez', AES_ENCRYPT('suarez', 'D9u#F5h8*Z3kB9!nL7^mQ4'), '12345680', '765432109', 'elena@gmail.com', '1234567891234569', AES_ENCRYPT('123456', 'D9u#F5h8*Z3kB9!nL7^mQ4'), NOW()),
(4,'Daniela Suarez', AES_ENCRYPT('suarez', 'D9u#F5h8*Z3kB9!nL7^mQ4'), '12345681', '654321098', 'daniela@gmail.com', '1234567891234570', AES_ENCRYPT('123456', 'D9u#F5h8*Z3kB9!nL7^mQ4'), NOW()),
(5,'Jorge Flores', AES_ENCRYPT('flores', 'D9u#F5h8*Z3kB9!nL7^mQ4'), '12345682', '543210987', 'jorge@gmail.com', '1234567891234571', AES_ENCRYPT('123456', 'D9u#F5h8*Z3kB9!nL7^mQ4'), NOW()),
(6,'Cesar Angeles', AES_ENCRYPT('angeles', 'D9u#F5h8*Z3kB9!nL7^mQ4'), '12345683', '432109876', 'cesar@gmail.com', '1234567891234572', AES_ENCRYPT('123456', 'D9u#F5h8*Z3kB9!nL7^mQ4'), NOW());
-- -- Índices para tablas volcadas -- -- 
-- Indices de la tabla `alerta` -- 
ALTER TABLE `alerta` 
ADD PRIMARY KEY (`id_alerta`), 
ADD KEY `id_seguridad` (`id_seguridad`); 
-- -- Indices de la tabla `direccion` -- 
ALTER TABLE `direccion` 
ADD PRIMARY KEY (`id_direccion`), 
ADD KEY `id_seguridad` (`id_seguridad`); 
-- -- Indices de la tabla `dispositivo` -- 
ALTER TABLE `dispositivo` 
ADD PRIMARY KEY (`id_dispositivo`), 
ADD KEY `id_seguridad` (`id_seguridad`); 
-- -- Indices de la tabla `encuestas` -- 
ALTER TABLE `encuesta` 
ADD PRIMARY KEY (`id_encuesta`), 
ADD KEY `id_seguridad` (`id_seguridad`); 
-- -- Indices de la tabla `horas_restringidas` -- 
ALTER TABLE `hora_restringida` 
ADD PRIMARY KEY (`id_hora`), 
ADD KEY `id_seguridad` (`id_seguridad`); 
-- -- Indices de la tabla `pagos_yape` -- 
ALTER TABLE `pago_yape` 
ADD PRIMARY KEY (`id_pago`), 
ADD KEY `id_seguridad_origen` (`id_seguridad_origen`); 
-- -- Indices de la tabla `seguridad` -- 
ALTER TABLE `seguridad` 
ADD PRIMARY KEY (`id_seguridad`), 
ADD KEY `id_usuario` (`id_usuario`); -- 
-- Indices de la tabla `usuario` -- 
ALTER TABLE `usuario` 
ADD PRIMARY KEY (`id_usuario`), 
ADD UNIQUE KEY `dni` (`dni`), 
ADD UNIQUE KEY `telefono` (`telefono`), 
ADD UNIQUE KEY `correo` (`correo`), 
ADD UNIQUE KEY `numero_tarjeta` (`numero_tarjeta`);
-- -- AUTO_INCREMENT de las tablas volcadas 
-- -- -- AUTO_INCREMENT de la tabla `alerta` -- 
ALTER TABLE `alerta` 
MODIFY `id_alerta` int(11) NOT NULL AUTO_INCREMENT; 
-- -- AUTO_INCREMENT de la tabla `direccion` -- 
ALTER TABLE `direccion` 
MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT; 
-- -- AUTO_INCREMENT de la tabla `dispositivo` -- 
ALTER TABLE `dispositivo` 
MODIFY `id_dispositivo` int(11) NOT NULL AUTO_INCREMENT; 
-- -- AUTO_INCREMENT de la tabla `encuestas` -- 
ALTER TABLE `encuesta` 
MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT; 
-- -- AUTO_INCREMENT de la tabla `horas_restringidas` -- 
ALTER TABLE `hora_restringida` 
MODIFY `id_hora` int(11) NOT NULL AUTO_INCREMENT; -- -- AUTO_INCREMENT de la tabla `pagos_yape` -- 
ALTER TABLE `pago_yape` 
MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT; -- -- AUTO_INCREMENT de la tabla `seguridad` -- 
ALTER TABLE `seguridad` 
MODIFY `id_seguridad` int(11) NOT NULL AUTO_INCREMENT; -- -- AUTO_INCREMENT de la tabla `usuario` -- 
ALTER TABLE `usuario` 
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT; -- -- Restricciones para tablas volcadas -- -- -- Filtros para la tabla `alerta` -- 
ALTER TABLE `alerta` 
ADD CONSTRAINT `alerta_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES 
`seguridad` (`id_seguridad`); -- 
-- Filtros para la tabla `direccion` -- 
ALTER TABLE `direccion` 
ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`id_seguridad`) 
REFERENCES `seguridad` (`id_seguridad`); -- -- Filtros para la tabla `dispositivo` -- 
ALTER TABLE `dispositivo` 
ADD CONSTRAINT `dispositivo_ibfk_1` FOREIGN KEY (`id_seguridad`) 
REFERENCES `seguridad` (`id_seguridad`); -- -- Filtros para la tabla `encuestas` -- 
ALTER TABLE `encuesta` 
ADD CONSTRAINT `encuesta_ibfk_1` FOREIGN KEY (`id_seguridad`) 
REFERENCES `seguridad` (`id_seguridad`); -- -- Filtros para la tabla `horas_restringidas` -- 
ALTER TABLE `hora_restringida` 
ADD CONSTRAINT `hora_restringida_ibfk_1` FOREIGN KEY (`id_seguridad`) 
REFERENCES `seguridad` (`id_seguridad`); -- -- Filtros para la tabla `pagos_yape` -- 
ALTER TABLE `pago_yape` 
ADD CONSTRAINT `pago_yape_ibfk_1` FOREIGN KEY (`id_seguridad_origen`) 
REFERENCES `seguridad` (`id_seguridad`); -- -- Filtros para la tabla `seguridad` 
-- 
ALTER TABLE `seguridad` 
ADD CONSTRAINT `seguridad_ibfk_1` FOREIGN KEY (`id_usuario`) 
REFERENCES `usuario` (`id_usuario`); 
COMMIT; 


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */; 
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */; 
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; 