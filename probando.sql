-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3308
-- Tiempo de generación: 26-10-2024 a las 07:06:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


create database seguridadbcp;
use seguridadbcp;


CREATE TABLE `alertas` (
  `id_alerta` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `mensaje_alerta` text NOT NULL,
  `fecha_alerta` date NOT NULL,
  `hora_alerta` time NOT NULL,
  `motivo_alerta` varchar(255) DEFAULT NULL,
  `estado_alerta` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `direccion_exacta` varchar(255) NOT NULL,
  `rango_gps` decimal(10,5) DEFAULT NULL,
  `fecha_configuracion` date NOT NULL,
  `hora_configuracion` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `id_seguridad`, `direccion_exacta`, `rango_gps`, `fecha_configuracion`, `hora_configuracion`) VALUES
(2, 1, 'asddddd', 30.00000, '2024-10-25', '23:52:09'),
(3, 1, 'sdfsdf', 20.00000, '2024-10-25', '23:59:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

CREATE TABLE `dispositivos` (
  `id_dispositivo` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `tipo_dispositivo` varchar(100) NOT NULL,
  `direccion_ip` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `latitud` varchar(100) NOT NULL,
  `dispositivo_seguro` tinyint(1) DEFAULT 0,
  `dispositivo_principal` tinyint(1) DEFAULT 0,
  `fecha_registro` date NOT NULL,
    `verificado` TINYINT(1) DEFAULT 0,
  `ultima_conexion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id_encuesta` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas_restringidas`
--

CREATE TABLE `horas_restringidas` (
  `id_hora` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_final` time DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horas_restringidas`
--

INSERT INTO `horas_restringidas` (`id_hora`, `id_seguridad`, `hora_inicio`, `hora_final`, `created_at`, `updated_at`) VALUES
(10, 1, '04:08:00', '03:08:00', '2024-10-25 01:08:19', '2024-10-25 01:08:19'),
(12, 1, '05:15:00', '04:15:00', '2024-10-25 01:15:58', '2024-10-25 01:15:58'),
(13, 1, '11:49:00', '12:46:00', '2024-10-25 11:46:07', '2024-10-25 11:46:07'),
(15, 1, '12:31:00', '12:32:00', '2024-10-25 12:30:03', '2024-10-25 12:30:03'),
(16, 1, '20:49:00', '21:49:00', '2024-10-25 19:49:41', '2024-10-25 19:49:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_yape`
--

CREATE TABLE `pagos_yape` (
  `id_pago` int(11) NOT NULL,
  `id_seguridad_origen` int(11) NOT NULL,
  `id_usuario_destino` int(11) NOT NULL,
  `monto_pago` decimal(10,2) NOT NULL,
  `codigo_verificacion_pago` varchar(100) DEFAULT NULL,
  `fecha_pago` date NOT NULL,
  `hora_pago` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad`
--

CREATE TABLE `seguridad` (
  `id_seguridad` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `activacion_seguridad` tinyint(1) NOT NULL DEFAULT 0,
  `estado_horas_direcciones` tinyint(1) NOT NULL DEFAULT 0,
  `estado_yape` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguridad`
--

INSERT INTO `seguridad` (`id_seguridad`, `id_usuario`, `activacion_seguridad`, `estado_horas_direcciones`, `estado_yape`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 0, 0, 0),
(3, 1, 0, 0, 0),
(4, 1, 0, 0, 0),
(5, 1, 0, 0, 0),
(6, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `password` blob NOT NULL,
  `dni` varchar(100) NOT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `numero_tarjeta` varchar(255) DEFAULT NULL,
  `ip_principal` varchar(20) DEFAULT NULL,
  `clave_internet` blob NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `password`, `dni`, `telefono`, `correo`, `numero_tarjeta`, `clave_internet`, `created_at`) VALUES
(1, 'Jose Balcazar', 0x7d8497535b0db29bf50f6c3b20d39c58, '12345678', '987654321', 'jose@gmail.com', '1234567891234567', '179.6.168.48', 0xd6f6721a0967fea2ad0a5b8378a2110f,'2024-10-21 17:50:43'),
(2, 'Yoshua Castañeda', 0xc4a413b0134675de9b5ea2e1654cd06b, '12345679', '876543210', 'yoshua@gmail.com', '1234567891234568', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-10-21 17:50:43'),
(3, 'Elena Suarez', 0xb4d931e55b1dba0b85ab3971ae65eccb, '12345680', '765432109', 'elena@gmail.com', '1234567891234569',0x2096738160590e4bbd0227f7d4a352f5, '2024-10-21 17:50:43'),
(4, 'Daniela Suarez', 0xb4d931e55b1dba0b85ab3971ae65eccb, '12345681', '654321098', 'daniela@gmail.com', '1234567891234570', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-10-21 17:50:43'),
(5, 'Jorge Flores', 0xaf7b3a4c86643325a86dfba967b73abd, '12345682', '543210987', 'jorge@gmail.com', '1234567891234571', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-10-21 17:50:43'),
(6, 'Cesar Angeles', 0x817824677fafd50629777e79c095c1be, '12345683', '432109876', 'cesar@gmail.com', '1234567891234572', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-10-21 17:50:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`id_alerta`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`id_dispositivo`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `horas_restringidas`
--
ALTER TABLE `horas_restringidas`
  ADD PRIMARY KEY (`id_hora`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `pagos_yape`
--
ALTER TABLE `pagos_yape`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_seguridad_origen` (`id_seguridad_origen`);

--
-- Indices de la tabla `seguridad`
--
ALTER TABLE `seguridad`
  ADD PRIMARY KEY (`id_seguridad`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `numero_tarjeta` (`numero_tarjeta`),
  ADD UNIQUE KEY `ip_principal` (`ip_principal`) ;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas`
--
ALTER TABLE `alertas`
  MODIFY `id_alerta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  MODIFY `id_dispositivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horas_restringidas`
--
ALTER TABLE `horas_restringidas`
  MODIFY `id_hora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `pagos_yape`
--
ALTER TABLE `pagos_yape`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seguridad`
--
ALTER TABLE `seguridad`
  MODIFY `id_seguridad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD CONSTRAINT `dispositivos_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `encuestas_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `horas_restringidas`
--
ALTER TABLE `horas_restringidas`
  ADD CONSTRAINT `horas_restringidas_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `pagos_yape`
--
ALTER TABLE `pagos_yape`
  ADD CONSTRAINT `pagos_yape_ibfk_1` FOREIGN KEY (`id_seguridad_origen`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `seguridad`
--
ALTER TABLE `seguridad`
  ADD CONSTRAINT `seguridad_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
