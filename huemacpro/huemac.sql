-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2024 a las 04:02:59
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `huemac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brazalete`
--

CREATE TABLE `brazalete` (
  `id_brazalete` int(11) NOT NULL,
  `codigo_Qr` int(40) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `id_tipo_brazalete` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `brazalete`
--

INSERT INTO `brazalete` (`id_brazalete`, `codigo_Qr`, `estado`, `id_tipo_brazalete`, `id_cliente`) VALUES
(39, 22082105, 'Vendido', 1, 96),
(41, 22261209, 'disponible', 1, NULL),
(42, 28292226, 'disponible', 1, NULL),
(43, 8052914, 'disponible', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido_pat` varchar(30) DEFAULT NULL,
  `Apellido_mat` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `Nombre`, `Apellido_pat`, `Apellido_mat`) VALUES
(56, 'emmanuel', 'ere', 'fdf'),
(57, 'emmanuel', 'ere', 'fdf'),
(58, 'emmanuel', 'ere', 'fdf'),
(59, 'emmanuel', 'ere', 'fdf'),
(60, 'emmanuel', 'ere', 'fdf'),
(63, 'emmanuel', 'ere', 'fdf'),
(64, 'emmanuel', 'ere', 'fdf'),
(65, 'emmanuel', 'ere', 'fdf'),
(66, 'emmanuel', 'ere', 'fdf'),
(69, 'paracetamol', 'ere', 'fdf'),
(70, 'emmanuel', 'ere', 'fdf'),
(72, 'paracetamol', 'ere', 'fdf'),
(74, 'Jolett', 'Rios', 'Jimenez'),
(76, 'saion', 'ortega', 'romero'),
(78, 'carlos', 'aguilar', 'mendoza'),
(85, 'emmanuel', 'ere', 'fdf'),
(86, 'emmanuel', 'ere', 'fdf'),
(87, 'emmanuel', 'ere', 'fdf'),
(90, 'aspirina', 'hernandez', 'mendoza'),
(92, 'paracetamol', 'aguilar', 'fdf'),
(95, 'jared', 'aguilar', 'cruz'),
(96, 'Maricela', 'hernandez', 'Moreno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_venta`
--

CREATE TABLE `detalles_venta` (
  `id_detalles_venta` int(11) NOT NULL,
  `fecha_venta` date DEFAULT NULL,
  `total_venta` decimal(10,2) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalles_venta`
--

INSERT INTO `detalles_venta` (`id_detalles_venta`, `fecha_venta`, `total_venta`, `id_cliente`, `id_empleado`) VALUES
(76, '2023-12-03', '120.00', 85, 1),
(87, '2023-12-04', '70.00', 96, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido_pat` varchar(30) DEFAULT NULL,
  `Apellido_mat` varchar(30) DEFAULT NULL,
  `cargo` varchar(30) DEFAULT NULL,
  `nombreUsuario` varchar(30) DEFAULT NULL,
  `contraseña` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `Nombre`, `Apellido_pat`, `Apellido_mat`, `cargo`, `nombreUsuario`, `contraseña`) VALUES
(1, 'Emmanuel', 'Rosas', 'Zuñiga', 'jefe', 'Emma', '12345678'),
(4, 'alexis', 'sanchez', 'hernandez', 'empleado', 'alex1234', '1245'),
(5, 'Raul', 'hernandez', 'sanchez', 'empleado', 'raul23', '5678'),
(6, 'jared', 'aguilar ', 'cruz', 'empleado', NULL, '$2y$10$Chmbx1n0n1ZTKEuloPGBFO8HzeQvXjFjaLXu1TnYtDPOcMKJyzwp.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_brazalete`
--

CREATE TABLE `tipo_brazalete` (
  `id_tipo_brazalete` int(11) NOT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_brazalete`
--

INSERT INTO `tipo_brazalete` (`id_tipo_brazalete`, `tipo`, `stock`, `precio`) VALUES
(1, 'niño', 55, '70.00'),
(2, 'adulto', 115, '120.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_ventas` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `id_brazalete` int(11) DEFAULT NULL,
  `id_detalles_venta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_ventas`, `cantidad`, `precio_unitario`, `subtotal`, `id_brazalete`, `id_detalles_venta`) VALUES
(60, 1, '70.00', '70.00', 39, 87);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `brazalete`
--
ALTER TABLE `brazalete`
  ADD PRIMARY KEY (`id_brazalete`),
  ADD KEY `FK_tipo_brazalete` (`id_tipo_brazalete`),
  ADD KEY `FK_brazalete_cliente` (`id_cliente`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD PRIMARY KEY (`id_detalles_venta`),
  ADD KEY `FK_id_cliente` (`id_cliente`),
  ADD KEY `FK_id_empleado` (`id_empleado`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `tipo_brazalete`
--
ALTER TABLE `tipo_brazalete`
  ADD PRIMARY KEY (`id_tipo_brazalete`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_ventas`),
  ADD KEY `FK_ventas_brazalete` (`id_brazalete`),
  ADD KEY `FK_ventas_detalles_venta` (`id_detalles_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `brazalete`
--
ALTER TABLE `brazalete`
  MODIFY `id_brazalete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
  MODIFY `id_detalles_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_brazalete`
--
ALTER TABLE `tipo_brazalete`
  MODIFY `id_tipo_brazalete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `brazalete`
--
ALTER TABLE `brazalete`
  ADD CONSTRAINT `FK_brazalete_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tipo_brazalete` FOREIGN KEY (`id_tipo_brazalete`) REFERENCES `tipo_brazalete` (`id_tipo_brazalete`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD CONSTRAINT `FK_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `FK_ventas_brazalete` FOREIGN KEY (`id_brazalete`) REFERENCES `brazalete` (`id_brazalete`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ventas_detalles_venta` FOREIGN KEY (`id_detalles_venta`) REFERENCES `detalles_venta` (`id_detalles_venta`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
