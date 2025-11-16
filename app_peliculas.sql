-- phpMyAdmin SQL Dump
-- Base de datos: app_peliculas

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

CREATE TABLE `pelicula` (
  `id_pelicula` int(200) NOT NULL,
  `nombre_pelicula` varchar(200) NOT NULL,
  `duracion` int(200) NOT NULL,
  `genero` varchar(200) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `fecha_estreno` date NOT NULL,
  `publico` varchar(300) NOT NULL,
  `img` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`id_pelicula`, `nombre_pelicula`, `duracion`, `genero`, `descripcion`, `fecha_estreno`, `publico`, `img`) VALUES
(1, 'El Padrino', 175, 'Drama', 'La historia de la familia Corleone', '1972-03-24', 'Mayores de 16', 'https://ejemplo.com/padrino.jpg'),
(2, 'Inception', 148, 'Ciencia Ficción', 'Un ladrón que roba secretos corporativos', '2010-07-16', 'Mayores de 13', 'https://ejemplo.com/inception.jpg'),
(3, 'Toy Story', 81, 'Animación', 'La vida secreta de los juguetes', '1995-11-22', 'Todo público', 'https://ejemplo.com/toystory.jpg'),
(4, 'El Caballero de la Noche', 152, 'Acción', 'Batman enfrenta al Joker', '2008-07-18', 'Mayores de 13', 'https://ejemplo.com/batman.jpg'),
(5, 'Pulp Fiction', 154, 'Crimen', 'Historias entrelazadas del crimen', '1994-10-14', 'Mayores de 18', 'https://ejemplo.com/pulpfiction.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actor`
--

CREATE TABLE `actor` (
  `id_actor` int(200) NOT NULL,
  `nombre_actor` varchar(200) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` int(200) NOT NULL,
  `nacionalidad` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actor`
--

INSERT INTO `actor` (`id_actor`, `nombre_actor`, `fecha_nacimiento`, `edad`, `nacionalidad`) VALUES
(1, 'Marlon Brando', '1924-04-03', 80, 'Estadounidense'),
(2, 'Leonardo DiCaprio', '1974-11-11', 50, 'Estadounidense'),
(3, 'Tom Hanks', '1956-07-09', 68, 'Estadounidense'),
(4, 'Christian Bale', '1974-01-30', 50, 'Británico'),
(5, 'John Travolta', '1954-02-18', 70, 'Estadounidense'),
(6, 'Al Pacino', '1940-04-25', 84, 'Estadounidense');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
-- Usuario: webadmin
-- Password: admin
--

INSERT INTO `usuario` (`id`, `email`, `password`) VALUES
(1, 'webadmin', '$2y$10$bXZsPIE6J3stQGqZl0cVduVzfaZsu63BK5rOIeMXnykb/UaE9sQf2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`id_pelicula`);

--
-- Indices de la tabla `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`id_actor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  MODIFY `id_pelicula` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `actor`
--
ALTER TABLE `actor`
  MODIFY `id_actor` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;