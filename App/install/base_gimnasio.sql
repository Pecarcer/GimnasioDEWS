

drop table tramo_usuario;
drop table tramos;
DROP TABLE actividades;
drop table usuarios;

-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2020 a las 17:05:21
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `onasio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `aforo` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `tramos`
--
CREATE TABLE `tramos` (
  `id` int(11) NOT NULL,
  `dia` varchar(15) NOT NULL,
  `hora_inicio` time NOT NULL DEFAULT current_timestamp(),
  `hora_fin` time DEFAULT NULL,
  `actividad_id` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramo_usuario`
--

CREATE TABLE `tramo_usuario` (
  `id` int(100) NOT NULL,
  `tramo_id` int(100) NOT NULL,
  `usuario_id` int(4) NOT NULL,
  `fecha_actividad` date NOT NULL,
  `fecha_reserva` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(4) NOT NULL,
  `nif` varchar(9) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(20) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `login` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `rol_id` int(1) NOT NULL,
  `activado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nif`, `nombre`, `apellidos`, `imagen`, `login`, `password`, `email`, `telefono`, `direccion`, `rol_id`,`activado`) VALUES
(1, '12345678A', 'Bartolo', 'Bartolez Bartolin', 'usera1.jpg', 'bartolofit', '1234', 'bartolo@bartolez.com', 123456789, 'Calle falsa 123', 1, 1),
(2, '87654321Z', 'Juan', 'Juanito Juanez', 'usera2.jpg', 'tirillas', '1234', 'juan@tirillas.com', 987654321, 'Calle también falsa 123', 0, 1),
(3, '12345678Z', 'Pepe', 'Uno Dos', 'usera3.jpg', 'admin', '1234', 'pp@admin.com', 959959959, 'Calle broma 123', 1, 1),
(4, '12354678Z', 'Juanita', 'Apellidez Apellidin', 'usera4.jpg', 'admin2', '1234', 'juanita@admin.com', 959232323, 'Calle inexistente 123', 1, 1),
(5, '45157248z', 'Julian', 'Julianez', '1609871678-fgfg.JPG', 'Papafrita', '81dc9bdb52d04dc20036dbd8313ed055', 'papa@frita.com', 601031343, 'Calle julianes', 0, 1),
(6, '123123123', 'a', 'a', '1609986940-18194187_1333125380056137_6509438857597975114_n.jpg', 'a', '0cc175b9c0f1b6a831c399e269772661', 'a@a.com', 123232323, 'calle a', 0, 1),
(7, '12121212b', 'b', 'b', '1609988577-1557577951029.png', 'b', '92eb5ffee6ae2fec3ad71c777531578f', 'b@b.com', 123121212, 'calle b 123', 0, 1),
(8, '45157248z', 'c', 'c', '1609994002-59646003_1278695388959193_2285537572069310464_n.jpg', 'c', '4a8a08f09d37b73795649038408b5f33', 'c@c.com', 601031344, 'calle c', 0, 1),
(9, '45157248z', 'd', 'd', '1609994155-D3F6FQUWwAA-nmD.jpg', 'd', '8277e0910d750195b448797616e091ad', 'd@d.com', 601031344, 'calle d', 0, 1),
(10, 'e', 'e', 'e', '1609994535-D5gRox5UwAA-zTF.jpg', 'e', 'e1671797c52e15f763380b45e841ec32', 'e@e.com', 601031344, 'calle e', 0, 1),
(11, 'f', 'f', 'f', '1609994737-L_VNbIeT_400x400.jpg', 'f', 'e1671797c52e15f763380b45e841ec32', 'f@f.com', 601031344, 'calle f', 0, 1);

UPDATE `usuarios` SET password = MD5(password);
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);


--
-- Indices de la tabla `tramos`
--
ALTER TABLE `tramos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actividad_id` (`actividad_id`);

--
-- Indices de la tabla `tramo_usuario`
--
ALTER TABLE `tramo_usuario`
  ADD KEY `tramo_id` (`tramo_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Restricciones para tablas volcadas--

--


ALTER TABLE `actividades`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--
-- Filtros para la tabla `tramos`
--
ALTER TABLE `tramos`
  ADD CONSTRAINT `tramos_ibfk_1` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`);

--
-- Filtros para la tabla `tramo_usuario`
--
ALTER TABLE `tramo_usuario`
  ADD CONSTRAINT `tramo_usuario_ibfk_1` FOREIGN KEY (`tramo_id`) REFERENCES `tramos` (`id`),
  ADD CONSTRAINT `tramo_usuario_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `actividades` (`id`, `nombre`, `descripcion`, `aforo`) VALUES
(1, 'Spinning', 'Bici estática', 8),
(2, 'Pilates', 'Sesión de gimnasia', 6),
(3, 'Acuagym', 'Ejercicios en piscina', 5),
(4, 'Zumba', 'Ejercicios mezclado con baile', 5),
(5, 'GAP', 'Gluteos, abdomen y piernas', 8),
(6, 'Pesas', 'Levantamiento de pesas', 8),
(7, 'HIIT', 'Entrenamiento de intervalos de alta intensidad', 7),
(8, 'Steps', 'ejercicios aerobicos escalonados', 6),
(9, 'Latino', 'Baile latino', 5),
(10, 'Cardio', 'Ejercicios de resistencia', 9),
(11, 'Yoga', 'Sesión de Yoga', 8),
(12, 'Running', 'Cinta de correr', 4),
(13, 'Natación', 'Ejercicio en piscina', 7),
(14, 'Power Pump', 'Ejercicio de musculación', 8),
(15, 'K1', 'deporte de combate', 10);


INSERT INTO `tramos` (`id`, `dia`, `hora_inicio`, `hora_fin`, `actividad_id`, `fecha_alta`, `fecha_baja`) VALUES
(1, 'Lunes', '07:00:00', '08:00:00', 2, '2020-12-10', NULL),
(2, 'Lunes', '08:00:00', '09:00:00', 3, '2020-12-10', NULL),
(3, 'Lunes', '10:00:00', '11:00:00', 4, '2020-12-10', NULL),
(4, 'Lunes', '11:00:00', '12:00:00', 4, '2020-12-10', NULL),
(5, 'Lunes', '13:00:00', '14:00:00', 5, '2020-12-10', NULL),
(6, 'Lunes', '14:00:00', '15:00:00', 7, '2020-12-10', NULL),
(7, 'Lunes', '15:00:00', '16:00:00', 3, '2020-12-10', NULL),
(8, 'Lunes', '16:00:00', '17:00:00', 4, '2020-12-10', NULL),
(9, 'Lunes', '17:00:00', '18:00:00', 8, '2020-12-10', NULL),
(10, 'Lunes', '18:00:00', '19:00:00', 11, '2020-12-12', NULL),
(11, 'Lunes', '19:00:00', '20:00:00', 10, '2020-12-16', NULL),
(12, 'Lunes', '21:00:00', '22:00:00', 4, '2020-12-16', NULL),
(13, 'Lunes', '22:00:00', '23:00:00', 2, '2020-12-16', NULL),
(14, 'Martes', '07:00:00', '08:00:00', 3, '2020-12-10', NULL),
(15, 'Martes', '08:00:00', '09:00:00', 4, '2020-12-10', NULL),
(16, 'Martes', '10:00:00', '11:00:00', 5, '2020-12-10', NULL),
(17, 'Martes', '11:00:00', '12:00:00', 9, '2020-12-10', NULL),
(18, 'Martes', '13:00:00', '14:00:00', 5, '2020-12-10', NULL),
(19, 'Martes', '14:00:00', '15:00:00', 8, '2020-12-10', NULL),
(20, 'Martes', '15:00:00', '16:00:00', 4, '2020-12-10', NULL),
(21, 'Martes', '16:00:00', '17:00:00', 2, '2020-12-10', NULL),
(22, 'Martes', '17:00:00', '18:00:00', 8, '2020-12-10', NULL),
(23, 'Martes', '18:00:00', '19:00:00', 2, '2020-12-12', NULL),
(24, 'Martes', '19:00:00', '20:00:00', 10, '2020-12-16', NULL),
(25, 'Martes', '21:00:00', '22:00:00', 10, '2020-12-16', NULL),
(26, 'Martes', '22:00:00', '23:00:00', 2, '2020-12-16', NULL),
(27, 'Miercoles', '07:00:00', '08:00:00', 2, '2020-12-10', NULL),
(28, 'Miercoles', '08:00:00', '09:00:00', 4, '2020-12-10', NULL),
(29, 'Miercoles', '10:00:00', '11:00:00', 3, '2020-12-10', NULL),
(30, 'Miercoles', '11:00:00', '12:00:00', 1, '2020-12-10', NULL),
(31, 'Miercoles', '13:00:00', '14:00:00', 1, '2020-12-10', NULL),
(32, 'Miercoles', '14:00:00', '15:00:00', 7, '2020-12-10', NULL),
(33, 'Miercoles', '15:00:00', '16:00:00', 8, '2020-12-10', NULL),
(34, 'Miercoles', '16:00:00', '17:00:00', 9, '2020-12-10', NULL),
(35, 'Miercoles', '17:00:00', '18:00:00', 4, '2020-12-10', NULL),
(36, 'Miercoles', '18:00:00', '19:00:00', 1, '2020-12-12', NULL),
(37, 'Miercoles', '19:00:00', '20:00:00', 10, '2020-12-16', NULL),
(38, 'Miercoles', '21:00:00', '22:00:00', 15, '2020-12-16', NULL),
(39, 'Miercoles', '22:00:00', '23:00:00', 6, '2020-12-16', NULL),
(40, 'Jueves', '07:00:00', '08:00:00', 9, '2020-12-10', NULL),
(41, 'Jueves', '08:00:00', '09:00:00', 12, '2020-12-10', NULL),
(42, 'Jueves', '10:00:00', '11:00:00', 14, '2020-12-10', NULL),
(43, 'Jueves', '11:00:00', '12:00:00', 2, '2020-12-10', NULL),
(44, 'Jueves', '13:00:00', '14:00:00', 10, '2020-12-10', NULL),
(45, 'Jueves', '14:00:00', '15:00:00', 15, '2020-12-10', NULL),
(46, 'Jueves', '15:00:00', '16:00:00', 1, '2020-12-10', NULL),
(47, 'Jueves', '16:00:00', '17:00:00', 2, '2020-12-10', NULL),
(48, 'Jueves', '17:00:00', '18:00:00', 3, '2020-12-10', NULL),
(49, 'Jueves', '18:00:00', '19:00:00', 2, '2020-12-12', NULL),
(50, 'Jueves', '19:00:00', '20:00:00', 10, '2020-12-16', NULL),
(51, 'Jueves', '21:00:00', '22:00:00', 9, '2020-12-16', NULL),
(52, 'Jueves', '22:00:00', '23:00:00', 2, '2020-12-16', NULL),
(53, 'Viernes', '07:00:00', '08:00:00', 3, '2020-12-10', NULL),
(54, 'Viernes', '08:00:00', '09:00:00', 4, '2020-12-10', NULL),
(55, 'Viernes', '10:00:00', '11:00:00', 6, '2020-12-10', NULL),
(56, 'Viernes', '11:00:00', '12:00:00', 8, '2020-12-10', NULL),
(57, 'Viernes', '13:00:00', '14:00:00', 4, '2020-12-10', NULL),
(58, 'Viernes', '14:00:00', '15:00:00', 9, '2020-12-10', NULL),
(59, 'Viernes', '15:00:00', '16:00:00', 5, '2020-12-10', NULL),
(60, 'Viernes', '16:00:00', '17:00:00', 1, '2020-12-10', NULL),
(61, 'Viernes', '17:00:00', '18:00:00', 6, '2020-12-10', NULL),
(62, 'Viernes', '18:00:00', '19:00:00', 8, '2020-12-12', NULL),
(63, 'Viernes', '19:00:00', '20:00:00', 10, '2020-12-16', NULL),
(64, 'Viernes', '21:00:00', '22:00:00', 2, '2020-12-16', NULL),
(65, 'Viernes', '22:00:00', '23:00:00', 6, '2020-12-16', NULL),
(66, 'Sábado', '07:00:00', '08:00:00', 9, '2020-12-10', NULL),
(67, 'Sábado', '08:00:00', '09:00:00', 12, '2020-12-10', NULL),
(68, 'Sábado', '10:00:00', '11:00:00', 13, '2020-12-10', NULL),
(69, 'Sábado', '11:00:00', '12:00:00', 14, '2020-12-10', NULL),
(70, 'Sábado', '13:00:00', '14:00:00', 1, '2020-12-10', NULL),
(71, 'Sábado', '14:00:00', '15:00:00', 5, '2020-12-10', NULL),
(72, 'Sábado', '15:00:00', '16:00:00', 3, '2020-12-10', NULL),
(73, 'Sábado', '16:00:00', '17:00:00', 7, '2020-12-10', NULL),
(74, 'Sábado', '17:00:00', '18:00:00', 5, '2020-12-10', NULL),
(75, 'Sábado', '18:00:00', '19:00:00', 6, '2020-12-12', NULL),
(76, 'Sábado', '19:00:00', '20:00:00', 10, '2020-12-16', NULL),
(77, 'Sábado', '21:00:00', '22:00:00', 12, '2020-12-16', NULL),
(78, 'Sábado', '22:00:00', '23:00:00', 5, '2020-12-16', NULL);

