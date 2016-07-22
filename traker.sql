-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-07-2016 a las 13:11:11
-- Versión del servidor: 5.5.47-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `traker`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dat_device`
--

CREATE TABLE `dat_device` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(20) UNSIGNED NOT NULL,
  `code` varchar(256) NOT NULL,
  `registration` varchar(256) DEFAULT NULL,
  `brand` varchar(256) DEFAULT NULL,
  `model` varchar(256) DEFAULT NULL,
  `active` varchar(45) DEFAULT NULL,
  `lat` varchar(256) DEFAULT NULL,
  `lon` varchar(256) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dat_device`
--

INSERT INTO `dat_device` (`id`, `id_user`, `code`, `registration`, `brand`, `model`, `active`, `lat`, `lon`, `created_at`, `updated_at`, `time`) VALUES
(5, 3, '95560976', 'AKER', 'VWssss', 'GOL 1.6', '1', '-34.89115621', '-56.19462421', '1469056771', '1469056771', '2016-07-22_09:08:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dat_user`
--

CREATE TABLE `dat_user` (
  `id` int(20) UNSIGNED NOT NULL,
  `username` varchar(256) NOT NULL,
  `names` varchar(256) DEFAULT NULL,
  `lastname` varchar(256) DEFAULT NULL,
  `sex` varchar(256) DEFAULT NULL,
  `password_hash` varchar(256) NOT NULL,
  `password_reset_token` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `auth_key` varchar(256) NOT NULL,
  `role` varchar(256) DEFAULT NULL,
  `status` varchar(256) DEFAULT NULL,
  `created_at` varchar(256) DEFAULT NULL,
  `updated_at` varchar(256) DEFAULT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dat_user`
--

INSERT INTO `dat_user` (`id`, `username`, `names`, `lastname`, `sex`, `password_hash`, `password_reset_token`, `email`, `auth_key`, `role`, `status`, `created_at`, `updated_at`, `active`) VALUES
(3, 'alberto', NULL, NULL, NULL, '926e27eecdbc7a18858b3798ba99bddd', NULL, NULL, 'VlqgPFzvLGZKyYWdJhsw1Yc5MPYx6uG-', NULL, '10', '1469030795', '1469043111', 0),
(10, 'pepe', NULL, NULL, NULL, '926e27eecdbc7a18858b3798ba99bddd', NULL, NULL, 'j7ZxuB7uJFmoySiJQTnwCJNl-nYFHA5I', NULL, '10', '1469038888', '1469038888', 1),
(11, 'aaferral', NULL, NULL, NULL, '926e27eecdbc7a18858b3798ba99bddd', NULL, 'aaferral@rbayamo.icrt.cu', 'Ak_VWI0jDDJDZiUcCFt6bu1o3SsGsqHW', 'usuario', '10', '1469058418', '1469058418', 0),
(12, 'jjrosales', NULL, NULL, NULL, '0aa1ea9a5a04b78d4581dd6d17742627', NULL, 'jjrosales@gmail.com', '1jHlitXIcElJPda0Q3yVdx47NR1-BME0', 'usuario', NULL, '1469148714', '1469148714', 0),
(13, 'asd', NULL, NULL, NULL, '7815696ecbf1c96e6894b779456d330e', NULL, 'asd@aa', 'zzay9aWC_d-3UF_McL1T07kGZ5iBL-JO', 'usuario', NULL, '1469150354', '1469150354', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dat_device`
--
ALTER TABLE `dat_device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `dat_user`
--
ALTER TABLE `dat_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dat_device`
--
ALTER TABLE `dat_device`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `dat_user`
--
ALTER TABLE `dat_user`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dat_device`
--
ALTER TABLE `dat_device`
  ADD CONSTRAINT `dat_device_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `dat_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
