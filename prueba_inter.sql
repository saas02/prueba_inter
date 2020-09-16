-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-09-2020 a las 10:26:03
-- Versión del servidor: 5.7.14
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_inter`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `identificacion` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci COMMENT='Tabla de estudiantes';

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `nombres`, `apellidos`, `identificacion`, `contrasena`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Yeimi Paola', 'Lancheros', '1030529496', '1030529496', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(2, 'Milena', 'Serrano Diaz', '1030587698', '1030587698', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(3, 'Antonio', 'Guasca Lancheros', '1000258796', '1000258796', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(4, 'Juan Camilo', 'Leon', '80556985', '80556985', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(5, 'David Santiago', 'Parra', '1019987077', '1019987077', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes_materias_profesores`
--

CREATE TABLE `estudiantes_materias_profesores` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci COMMENT='Tabla de relacion entre estudiantes, profesores, materias';

--
-- Volcado de datos para la tabla `estudiantes_materias_profesores`
--

INSERT INTO `estudiantes_materias_profesores` (`id`, `id_estudiante`, `id_materia`, `id_profesor`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, '2020-09-16 14:54:06', '2020-09-16 14:54:06'),
(3, 1, 2, 3, 1, '2020-09-16 15:09:22', '2020-09-16 15:09:22'),
(8, 1, 3, 4, 1, '2020-09-16 15:50:10', '2020-09-16 15:50:10'),
(9, 3, 1, 2, 1, '2020-09-16 16:13:15', '2020-09-16 16:13:15'),
(10, 4, 1, 3, 1, '2020-09-16 16:18:16', '2020-09-16 16:18:16'),
(12, 5, 1, 2, 1, '2020-09-16 16:36:35', '2020-09-16 16:36:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci COMMENT='Tabla de materias';

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Matematicas', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(2, 'Español', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(3, 'Sociales', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(4, 'Religion', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(5, 'Ingles', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `nombres` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `identificacion` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci COMMENT='Tabla de profesores';

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombres`, `apellidos`, `identificacion`, `contrasena`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Marcial', 'Ramirez', '1030529491', '1030529491', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(3, 'Adolfo', 'Rivas', '1030529492', '1030529492', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(4, 'Rene', 'Amaya', '51615550', '51615550', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(5, 'Luis Hernando', 'Perez', '1030529493', '1030529493', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00'),
(6, 'Carmenza', 'Diaz Salamanca', '51615550', '51615550', 1, '2020-09-15 05:00:00', '2020-09-15 05:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rules`
--

CREATE TABLE `rules` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf16_spanish_ci NOT NULL,
  `value` json NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci COMMENT='Tabla de Reglas';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudiantes_materias_profesores`
--
ALTER TABLE `estudiantes_materias_profesores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estudiante_idx` (`id_estudiante`),
  ADD KEY `id_profesor_idx` (`id_profesor`),
  ADD KEY `id_materia_idx` (`id_materia`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `estudiantes_materias_profesores`
--
ALTER TABLE `estudiantes_materias_profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `estudiantes_materias_profesores`
--
ALTER TABLE `estudiantes_materias_profesores`
  ADD CONSTRAINT `id_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_profesor` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
