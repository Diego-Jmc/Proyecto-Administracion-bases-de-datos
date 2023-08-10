-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-08-2023 a las 02:06:31
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

-- Drop and recreate the database
DROP DATABASE IF EXISTS `proyecto_abd`;
CREATE DATABASE `proyecto_abd`;
USE `proyecto_abd`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_abd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

DROP TABLE IF EXISTS `Contenidos`;
CREATE TABLE IF NOT EXISTS `Contenidos` (
    `id` int NOT NULL AUTO_INCREMENT,
    `numero` int NOT NULL,
    `descripcion` VARCHAR(500),
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `contenido`;
CREATE TABLE IF NOT EXISTS `contenido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `resultado` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario`
--

DROP TABLE IF EXISTS `cuestionario`;
CREATE TABLE IF NOT EXISTS `cuestionario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `objetivo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cuestionario`
--

INSERT INTO `cuestionario` (`id`, `objetivo`) VALUES
(1, 'AI1 Identificar Soluciones Automatizadas '),
(2, 'AI2 Adquirir y Mantener Software Aplicativo');

INSERT INTO `cuestionario` (`id`, `objetivo`) VALUES
(3, 'AI3 ¿Define objetivos de control para asegurar la integridad y seguridad de las bases de datos? '),
(4, 'AI4 ¿Sugiere prácticas y controles para garantizar la disponibilidad de la información en las bases de datos?');

INSERT INTO `cuestionario` (`id`, `objetivo`) VALUES
(5, 'AI5 ¿Se ha definido un marco de políticas y procedimientos para guiar la toma de decisiones y el cumplimiento de las regulaciones en TI?'),
(6, 'AI6 ¿Se realizan revisiones periódicas de los niveles de servicio acordados y se toman medidas correctivas en caso de incumplimientos?');


INSERT INTO `cuestionario` (`id`, `objetivo`) VALUES
(7, ' ¿El manual de organización de la unidad administrativa está actualizado y correspondes con la estructura organizacional autorizada? '),
(8, ' ¿Promueve la observancia del Código de Ética?');

INSERT INTO `Contenidos` (`numero`, `descripcion`) VALUES (1,'El "Control Interno en los Sistemas Gestores de Bases de Datos" se refiere al conjunto de medidas y procedimientos diseñados para garantizar la seguridad, confiabilidad y eficiencia de los sistemas que administran y almacenan bases de datos. Estas medidas buscan asegurar que la información almacenada en la base de datos esté protegida contra accesos no autorizados, pérdida de datos y garantizar la precisión de los registros.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
