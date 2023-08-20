-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2023 a las 19:04:03
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gameloot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `idCarrito` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(100) NOT NULL,
  `precio` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(100) NOT NULL,
  `precio` float NOT NULL,
  `identificador` int(11) NOT NULL,
  `fechaPedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `idusuario`, `idproducto`, `cantidad`, `precio`, `identificador`, `fechaPedido`) VALUES
(150, 20, 38, 1, 42, 308007059, '2023-06-11 14:59:09'),
(151, 20, 37, 2, 60.54, 308007059, '2023-06-11 14:59:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `precio` float NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `cantidad` int(100) NOT NULL DEFAULT 1,
  `fechaProducto` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria`, `cantidad`, `fechaProducto`) VALUES
(12, 'Halosss', 'juegos', 12, '647b62426b775_caja-reach-halo_u3my.png', 'videojuego', 1, '2023-05-06 10:05:29'),
(13, 'The Last Of Us', 'juegos', 12, '64691ce4d78e2_The-Last-of-Us-Box-Art.jpg', 'videojuego', 1, '2023-05-06 10:06:18'),
(14, 'Inmortal Fenix', 'juego', 12, '645626b5f1788_immortals-fenyx-rising-3.jpg', 'videojuego', 1, '2023-05-06 10:06:45'),
(15, 'Destiny', 'juego', 13, '645626ca8e7c9_destiny.jpg', 'videojuego', 1, '2023-05-06 10:07:06'),
(16, 'BloodBorne', 'juego', 20, '645626e419575_bloodborne.jpg', 'videojuego', 1, '2023-05-06 10:07:32'),
(17, 'GTA V', 'juego', 21, '645626f4c26f2_gta.jpg', 'videojuego', 1, '2023-05-06 10:07:48'),
(23, 'Animal Crossing', 'juego para ni&ntilde;os ', 23, '646b9ed4837c2_animalCrossing.jpg', 'videojuego', 1, '2023-05-22 16:56:52'),
(24, 'Zelda', 'juego', 12, '647b4bd01658a_81zlBoheYhL._AC_UF1000,1000_QL80_.jpg', 'videojuego', 1, '2023-05-22 16:58:14'),
(25, 'Halo 2', 'juego', 14, '646b9f3deaecf_Portada_Halo_2-715x1024.png', 'videojuego', 1, '2023-05-22 16:58:37'),
(26, 'Toad', 'juego', 13, '646b9f4b6d49b_815zIDdpGML._SL1500_-1-1.jpg', 'videojuego', 1, '2023-05-22 16:58:51'),
(27, 'Mario Galaxy', 'juego wii', 38, '646b9f6e5f072_12.jpg', 'videojuego', 1, '2023-05-22 16:59:26'),
(28, 'The Long Dark', 'juego supervivencia', 20.99, '6471c817600fc_The-Long-Dark-PS4-EU.jpg', 'videojuego', 1, '2023-05-27 09:06:31'),
(30, 'Skyrim', 'juego', 34, '6471c89bbc93b_250px-skyrim-cover_x2fv.jpg', 'videojuego', 1, '2023-05-27 09:08:43'),
(31, 'Resident Evil 3 Remake', 'juego', 12, '6471c8bc29d8f_RE3-Remake-XBO-EU.jpg', 'videojuego', 1, '2023-05-27 09:09:16'),
(32, 'Gears Of War', 'juego', 29, '6471c8ed9845e_35.jpg', 'videojuego', 1, '2023-05-27 09:10:05'),
(33, 'Jump Force', 'juego', 23, '6471c907b0b44_DqXC5WZWkAAUA4H.jpg', 'videojuego', 1, '2023-05-27 09:10:31'),
(34, 'Metal Gear Solid 3', 'juego', 12, '6471c92952950_60225-metal-gear-solid-3-subsistence-playstation-2_umwf.jpg', 'videojuego', 1, '2023-05-27 09:11:05'),
(35, 'Call Of Duty Advanced Warfare', 'juego', 13, '6471ca1b6a85c_call-of-duty-advanced-warfare-201453174715_1.jpg', 'videojuego', 1, '2023-05-27 09:15:07'),
(36, 'Call Of Duty Modern Warfare', 'juego', 11, '6471ca64ad31c_cod4.jpg', 'videojuego', 1, '2023-05-27 09:16:20'),
(37, 'God Of War Ragnarok', 'juego', 60.54, '6471caa52ac07_god-of-war-ragnarok-ps4-portada.png', 'videojuego', 1, '2023-05-27 09:17:25'),
(38, 'Elden Ring', 'juego mundo Abierto', 42, '6471e04b960f9_elden-ring-20216121316990_1.jpg', 'videojuego', 1, '2023-05-27 10:49:47'),
(39, 'Far Cry 6', 'juego', 23, '6471e0692288b_xbox_scarlett-5207432.jpg', 'videojuego', 1, '2023-05-27 10:50:17'),
(40, 'Mario Odyssey', 'juego', 23, '6471e0982dd40_portada23082.jpeg', 'videojuego', 1, '2023-05-27 10:51:04'),
(41, 'HomeFront', 'juego', 34, '6471e0b5a1e21_homefront_u95f.jpg', 'videojuego', 1, '2023-05-27 10:51:33'),
(42, 'Dishonored', 'juego de acci&oacute;n', 21, '647b3fc55ad5e_1485351716_274887_1485351949_sumario_normal.jpg', 'videojuego', 1, '2023-05-27 10:52:12'),
(46, 'Godfall', 'juego de supervivencia', 23.67, '6481b81e9098d_godfall.jpg', 'videojuego', 1, '2023-06-03 15:56:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombreCompleto` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombreCompleto`, `email`, `password`, `role`) VALUES
(1, 'Usuario administrador', 'admin@gmail.com', '$2y$10$teP0SA87aRTJ4afMCYhcxOzCp/gBHRaLb7owXWY4cTbZXe54rpxSu', 'admin'),
(6, 'Sergio Del Pozo', 'sergio@gmail.com', '$2y$10$c3ZbYceuRdP2sMx8GeQlxONGsw8waSIZ2zx.4AB2J45M1/bJqdyR6', 'user'),
(20, 'test', 'test@gmail.com', '$2y$10$Mwj2C/VIDYiRp16ig8j5j.nxQO3lwwW7B9YjQjW0c7/zM9KH6CE/e', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`idCarrito`),
  ADD KEY `fk_producto` (`idproducto`),
  ADD KEY `fk_usuario` (`idusuario`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_id` (`idproducto`),
  ADD KEY `fk_usuario_id` (`idusuario`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `fk_idproducto` (`idproducto`),
  ADD KEY `fk_idusuarop` (`idusuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritos`
--
ALTER TABLE `carritos`
  MODIFY `idCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `fk_producto_id` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idusuarop` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
