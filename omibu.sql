-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2019 a las 15:40:44
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
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID_cliente` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID_cliente`, `Nombre`) VALUES
(1, 'Ómibu'),
(2, 'Sitamon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `ID_tarea` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Prioridad` int(1) NOT NULL,
  `Trabajador` bigint(20) NOT NULL,
  `Cliente` bigint(20) NOT NULL,
  `Finalizado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`ID_tarea`, `Nombre`, `Descripcion`, `Fecha`, `Prioridad`, `Trabajador`, `Cliente`, `Finalizado`) VALUES
(1, 'Ejemplo de tarea', 'Ejemplo de descripción de una tarea de prioridad alta', '2019-05-15', 2, 2, 1, 1),
(2, 'Ejemplo de tarea', 'Ejemplo de descripción de una tarea de prioridad media', '2019-05-22', 2, 2, 2, 0),
(3, 'Ejemplo de tarea', 'Ejemplo de descripción de una tarea de prioridad baja', '2019-05-13', 3, 2, 1, 0),
(10, 'Titulo de tarea', 'Esto es la descripción', '2020-01-01', 1, 2, 1, 0),
(11, 'Tarea 1', 'Tarea ejemplo para Sitamon', '2021-01-01', 2, 2, 2, 0),
(12, 'Tarea ejemplo', 'oakkdsad', '2023-03-02', 3, 2, 2, 0),
(13, 'asdf', 'asdfasdf', '2019-05-23', 2, 2, 2, 0),
(14, 'Ejemplo de tare', 'Ejemplo de descripción de una tarea de prioridad alta', '2019-05-15', 1, 2, 0, 0),
(15, 'Ejemplo de tarea', 'Ejemplo de descripción\r\n una tarea de prioridad alta', '2019-05-15', 1, 2, 0, 0),
(16, 'Ejemplo de tareaaaa', 'Ejemplo de descripción de una tarea de prioridad alta', '2019-05-15', 1, 2, 0, 0),
(17, 'Ejemplo de tarea', 'Ejemplo de descripción de una tarea de prioridad media', '2019-05-22', 1, 2, 0, 0),
(18, 'Titulo de tarea', 'Esto es la descripción', '2020-01-01', 2, 2, 0, 0);

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
(1, 'Tarea ejemplo', 'Esto es un ejemplo de tarea ', '2019-05-22', 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `ID_trabajador` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Apellidos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Direccion` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `Puesto` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Password` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `Telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`ID_trabajador`, `Nombre`, `Apellidos`, `Direccion`, `Puesto`, `Email`, `Password`, `Telefono`) VALUES
(1, 'Administrador', 'Omibu', 'Calle Cedrán, 4', 'Administrador', 'admin@omibu.com', 'admin', ''),
(2, 'Nicolás', 'Figueras Parras', 'C\\ Javier Tortosa 10', 'Empleado en prácticas', 'nicolas@omibu.com', 'mAK0Lusaqa', '639941992');

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
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD UNIQUE KEY `client_ID` (`client_ID`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_cliente`),
  ADD UNIQUE KEY `ID_cliente` (`ID_cliente`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`ID_tarea`),
  ADD UNIQUE KEY `ID_tarea` (`ID_tarea`);

--
-- Indices de la tabla `task`
--
ALTER TABLE `task`
  ADD UNIQUE KEY `task_ID` (`task_ID`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`ID_trabajador`),
  ADD UNIQUE KEY `ID_trabajador` (`ID_trabajador`);

--
-- Indices de la tabla `worker`
--
ALTER TABLE `worker`
  ADD UNIQUE KEY `worker_ID` (`worker_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `client_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_cliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `ID_tarea` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `task_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `ID_trabajador` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `worker`
--
ALTER TABLE `worker`
  MODIFY `worker_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
