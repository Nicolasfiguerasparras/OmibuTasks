-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2019 a las 17:49:01
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `omibu`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar`
--

CREATE TABLE `calendar` (
  `event_ID` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `url` varchar(500) NOT NULL,
  `className` varchar(200) NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `client_ID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `client_ID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`client_ID`, `name`) VALUES
(1, 'Ómibu'),
(2, 'iBaños');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task`
--

CREATE TABLE `task` (
  `task_ID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `limit_date` date NOT NULL,
  `priority` int(1) NOT NULL,
  `worker_ID` int(5) NOT NULL,
  `client_ID` int(5) NOT NULL,
  `done` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `task`
--

INSERT INTO `task` (`task_ID`, `name`, `description`, `limit_date`, `priority`, `worker_ID`, `client_ID`, `done`) VALUES
(1, 'Tarea ejemplo', 'Esto es un ejemplo de tarea ', '2019-05-22', 0, 1, 1, 0),
(2, 'asdasd', 'asdasd', '2020-07-01', 0, 2, 1, 0),
(3, 'informatica', 'aaaaaaaaaaa', '2019-07-09', 0, 2, 2, 0),
(4, 'aaaaaaaa', 'aaaaaaaaaaaa', '2019-07-09', 0, 1, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `worker`
--

CREATE TABLE `worker` (
  `worker_ID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `surname` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `position` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `phone` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `worker`
--

INSERT INTO `worker` (`worker_ID`, `name`, `surname`, `address`, `position`, `email`, `password`, `phone`) VALUES
(1, 'Administrador', 'Ómibu', 'Calle Cedrán, 4', 'Administrador', 'admin@omibu.com', 'admin', 0),
(2, 'Nicolás', 'Figueras Parras', 'Calle Javier Tortosa 10', 'Empleado en prácticas', 'nicolas@omibu.com', 'model1.0', 639941992);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendar`
--
ALTER TABLE `calendar`
  ADD UNIQUE KEY `event_ID` (`event_ID`);

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD UNIQUE KEY `client_ID` (`client_ID`);

--
-- Indices de la tabla `task`
--
ALTER TABLE `task`
  ADD UNIQUE KEY `task_ID` (`task_ID`);

--
-- Indices de la tabla `worker`
--
ALTER TABLE `worker`
  ADD UNIQUE KEY `worker_ID` (`worker_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendar`
--
ALTER TABLE `calendar`
  MODIFY `event_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `client_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `task_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `worker`
--
ALTER TABLE `worker`
  MODIFY `worker_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
