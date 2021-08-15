-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-08-2021 a las 06:27:10
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `test_users`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `ctype` varchar(25) NOT NULL DEFAULT 'vendedor',
  `username` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(55) NOT NULL,
  `address` varchar(75) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `passwd` varchar(700) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `ctype`, `username`, `fullname`, `email`, `address`, `phone`, `passwd`) VALUES
(1, 'admin', 'admuser', 'administrator', 'admin@admin.com', '2766 Kovacek Springs Apt. 528', '+999 999 999 99 99', 'ddbe44a2536cfe5450864a557e49e9c4cda408e8f317223fc4ca079c2798787b982c93f7238f3f2536da63513e65fcc932d341779aa617188d3a5f40ac38b0fb'),
(2, 'seller', 'felix04', 'Felix Noah', 'felix@examplemail.com', 'Texas', '+1 370 555 85 82', '0f5e437d25591e2d4dbe4bd0326758df8669047463252d186014d72350d75197f68724155f073e79cd2f0c46ee975a26ea91dad2a8ce215451ef2c1762b5b519'),
(3, 'seller', 'Jose1203', 'Juan Jose Granja Londoño', 'josej@examplemail.com', 'Colombia', '+57 312 322 16 96', '715328803dc02992a46aafc6bfec9cd32e9c65f00fdd061c990f2232ebca9187da3235e2075b827d08e2e519074d6f3abcb7a67398d94999a70d8e94ad8e42f6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `User` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
