```sql
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3308
-- Tiempo de generación: 11-12-2024 a las 22:16:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `seguridadbcp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `direccion_exacta` varchar(255) NOT NULL,
  `latitud` decimal(20,5) DEFAULT NULL,
  `longitud` decimal(20,5) DEFAULT NULL,
  `rango_gps` decimal(10,5) DEFAULT NULL,
  `fecha_configuracion` date NOT NULL,
  `hora_configuracion` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id_direccion`, `id_seguridad`, `direccion_exacta`, `latitud`, `longitud`, `rango_gps`, `fecha_configuracion`, `hora_configuracion`) VALUES
(5, 11, 'Las Esmeraldas, Agrupación Nueva Esperanza, San Juan de Lurigancho, Lima, Lima Metropolitana, Lima, 15419, Perú', NULL, NULL, 10.00000, '2024-11-26', '18:59:07'),
(6, 1, 'Lima, Avenida Lima, Chacarilla de Otero, San Juan de Lurigancho, Lima, Lima Metropolitana, Lima, 15404, Perú', 0.00000, 0.00000, 200.00000, '2024-12-07', '06:21:13'),
(7, 1, '4, Corporate Place, Piscataway, Middlesex, Nueva Jersey, 08854, Estados Unidos', 40.55460, -74.45820, 100.00000, '2024-12-08', '23:31:57'),
(8, 12, 'Centro Histórico de Lima, Jirón Quilca, Urbanización Cercado de Lima, Lima, Lima Metropolitana, Lima, 15001, Perú', -12.04320, -77.02820, 50.00000, '2024-12-09', '00:01:52'),
(9, 1, 'Centro Histórico de Lima, Jirón Quilca, Urbanización Cercado de Lima, Lima, Lima Metropolitana, Lima, 15001, Perú', -12.04320, -77.02820, 50.00000, '2024-12-09', '00:01:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivo`
--

CREATE TABLE `dispositivo` (
  `id_dispositivo` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `tipo_dispositivo` varchar(100) NOT NULL,
  `direccion_ip` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `latitud` decimal(20,5) DEFAULT NULL,
  `longitud` decimal(20,5) DEFAULT NULL,
  `estado_dispositivo` enum('activado','seguro','bloqueado','en_proceso_si','en_proceso_no','principal') NOT NULL,
  `fecha_registro` date NOT NULL,
  `ultima_conexion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dispositivo`
--

INSERT INTO `dispositivo` (`id_dispositivo`, `id_seguridad`, `tipo_dispositivo`, `direccion_ip`, `pais`, `ciudad`, `latitud`, `longitud`, `estado_dispositivo`, `fecha_registro`, `ultima_conexion`) VALUES
(1, 1, 'Ordenador de escritorio', '179.6.168.48', 'Peru', 'Lima region', NULL, NULL, 'principal', '2024-11-30', '2024-12-10'),
(20, 1, 'Ordenador de escritorio', '23.227.141.154', 'United States', 'Piscataway', NULL, NULL, 'activado', '2024-12-03', '2024-12-03'),
(31, 12, 'Ordenador de escritorio', '179.6.168.48', 'Peru', 'Lima', NULL, NULL, 'principal', '2024-12-03', '2024-12-03'),
(33, 1, 'Ordenador de escritorio', '23.227.141.154', 'United States', 'Piscataway', 40.55460, -74.45820, 'en_proceso_si', '2024-12-08', '2024-12-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id_encuesta` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`id_encuesta`, `id_seguridad`, `estado`, `created_at`) VALUES
(1, 10, 'Satisfecho', '2024-11-13'),
(2, 1, 'Muy satisfecho', '2024-12-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hora_restringida`
--

CREATE TABLE `hora_restringida` (
  `id_hora` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_final` time DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hora_restringida`
--

INSERT INTO `hora_restringida` (`id_hora`, `id_seguridad`, `hora_inicio`, `hora_final`, `created_at`, `updated_at`) VALUES
(10, 1, '04:08:00', '03:08:00', '2024-10-25 01:08:19', '2024-10-25 01:08:19'),
(12, 1, '05:15:00', '04:15:00', '2024-10-25 01:15:58', '2024-10-25 01:15:58'),
(13, 1, '11:49:00', '12:46:00', '2024-10-25 11:46:07', '2024-10-25 11:46:07'),
(15, 1, '12:31:00', '12:32:00', '2024-10-25 12:30:03', '2024-10-25 12:30:03'),
(16, 1, '20:49:00', '21:49:00', '2024-10-25 19:49:41', '2024-10-25 19:49:41'),
(18, 10, '22:23:00', '05:23:00', '2024-11-08 19:23:36', '2024-11-08 19:27:20'),
(19, 11, '21:39:00', '23:39:00', '2024-11-26 18:39:11', '2024-11-26 18:39:11'),
(20, 1, '05:00:00', '07:00:00', '2024-12-10 00:39:34', '2024-12-10 00:42:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id` int(11) NOT NULL,
  `id_seguridad` int(11) NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `tipo` enum('Ataque','Sospecha','Otro') DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reporte`
--

INSERT INTO `reporte` (`id`, `id_seguridad`, `titulo`, `descripcion`, `tipo`, `created_at`) VALUES
(1, 1, 'Me robaron', 'En la aplicacion salio error', '', '2023-11-13'),
(2, 11, 'Desaparecio Dinero', 'No encuentro mi dinero depositado', '', '2023-11-15'),
(3, 11, 'Me robaron 100 soles', 'No se donde estaban', 'Ataque', '2024-11-30'),
(4, 1, 'sdaD', 'ASDASDA', 'Sospecha', '2024-12-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad`
--

CREATE TABLE `seguridad` (
  `id_seguridad` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `activacion_seguridad` tinyint(1) NOT NULL DEFAULT 1,
  `estado_hora_direccion` tinyint(1) NOT NULL DEFAULT 0,
  `estado_yape` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguridad`
--

INSERT INTO `seguridad` (`id_seguridad`, `id_usuario`, `activacion_seguridad`, `estado_hora_direccion`, `estado_yape`, `created_at`) VALUES
(1, 1, 1, 1, 1, '2024-11-13'),
(10, 5, 1, 0, 0, '2024-11-13'),
(11, 3, 1, 0, 0, '2024-11-26'),
(12, 2, 1, 0, 1, '2024-12-03'),
(13, 4, 1, 0, 0, '2024-12-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

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

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `password`, `dni`, `telefono`, `correo`, `numero_tarjeta`, `clave_internet`, `created_at`) VALUES
(1, 'Jose Balcazar', 0x7d8497535b0db29bf50f6c3b20d39c58, '12345678', '987654321', 'jbalcazar377@gmail.com', '1234567891234567', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-11-02 05:56:45'),
(2, 'Yoshua Castañeda', 0xc4a413b0134675de9b5ea2e1654cd06b, '12345679', '876543210', 'f4r3ver@gmail.com', '1234567891234568', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-11-02 05:56:45'),
(3, 'Elena Suarez', 0xb4d931e55b1dba0b85ab3971ae65eccb, '12345680', '765432109', 'easp0104@gmail.com', '1234567891234569', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-11-02 05:56:45'),
(4, 'Daniela Suarez', 0xb4d931e55b1dba0b85ab3971ae65eccb, '12345681', '654321098', 'danielasuarezfranklin.92@gmail.com', '1234567891234570', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-11-02 05:56:45'),
(5, 'Jorge Flores', 0xaf7b3a4c86643325a86dfba967b73abd, '12345682', '543210987', 'jorgeafa.19@gmail.com', '1234567891234571', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-11-02 05:56:45'),
(6, 'Cesar Angeles', 0x817824677fafd50629777e79c095c1be, '12345683', '432109876', 'bcp83584@gmail.com', '1234567891234572', 0xd6f6721a0967fea2ad0a5b8378a2110f, '2024-11-02 05:56:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `dispositivo`
--
ALTER TABLE `dispositivo`
  ADD PRIMARY KEY (`id_dispositivo`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `hora_restringida`
--
ALTER TABLE `hora_restringida`
  ADD PRIMARY KEY (`id_hora`),
  ADD KEY `id_seguridad` (`id_seguridad`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IdSeguridad` (`id_seguridad`);

--
-- Indices de la tabla `seguridad`
--
ALTER TABLE `seguridad`
  ADD PRIMARY KEY (`id_seguridad`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `numero_tarjeta` (`numero_tarjeta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `dispositivo`
--
ALTER TABLE `dispositivo`
  MODIFY `id_dispositivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `hora_restringida`
--
ALTER TABLE `hora_restringida`
  MODIFY `id_hora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `seguridad`
--
ALTER TABLE `seguridad`
  MODIFY `id_seguridad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `dispositivo`
--
ALTER TABLE `dispositivo`
  ADD CONSTRAINT `dispositivo_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD CONSTRAINT `encuesta_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `hora_restringida`
--
ALTER TABLE `hora_restringida`
  ADD CONSTRAINT `hora_restringida_ibfk_1` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `FK_IdSeguridad` FOREIGN KEY (`id_seguridad`) REFERENCES `seguridad` (`id_seguridad`);

--
-- Filtros para la tabla `seguridad`
--
ALTER TABLE `seguridad`
  ADD CONSTRAINT `seguridad_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```
