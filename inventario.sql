-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2022 a las 20:15:01
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  `activo` tinyint(4) NOT NULL DEFAULT 1,
  `arrendado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`idarticulo`, `idcategoria`, `idempresa`, `codigo`, `nombre`, `imagen`, `condicion`, `activo`, `arrendado`) VALUES
(1, 1, 1, '565656', 'Computador Lenovo', 'https://c1.neweggimages.com/ProductImage/AA0S_1_20180328482037085.jpg', 0, 1, 1),
(2, 3, 1, '554433', 'Xiaomi poco', '', 0, 1, 1),
(3, 1, 1, '95598', 'Lenovo escritorio 01', NULL, 1, 0, 0),
(4, 3, 1, '54565', 'IPhone 12 pro max', NULL, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributos`
--

CREATE TABLE `atributos` (
  `idatributos` int(11) NOT NULL,
  `idcaracteristica` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `valor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `atributos`
--

INSERT INTO `atributos` (`idatributos`, `idcaracteristica`, `idarticulo`, `valor`) VALUES
(1, 1, 1, '8 GB'),
(6, 2, 2, 'Qualcom Snapdragon 860'),
(7, 2, 1, 'Intel Core i5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristica`
--

CREATE TABLE `caracteristica` (
  `idcaracteristica` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `caracteristica`
--

INSERT INTO `caracteristica` (`idcaracteristica`, `nombre`) VALUES
(1, 'ram'),
(2, 'proce');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `propiedades` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `propiedades`) VALUES
(1, 'PC', 'equipos computacionales'),
(3, 'Celulares', 'Equipos moviles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE `contrato` (
  `idcontrato` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `idusuariofinal` int(11) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechatermino` date DEFAULT NULL,
  `valorarticulo` int(11) DEFAULT NULL,
  `vigente` tinyint(4) NOT NULL DEFAULT 1,
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contrato`
--

INSERT INTO `contrato` (`idcontrato`, `idarticulo`, `idusuariofinal`, `fechainicio`, `fechatermino`, `valorarticulo`, `vigente`, `idempresa`) VALUES
(2, 1, 1, '2022-03-29', '2022-05-12', 750000, 1, 1),
(5, 2, 3, '2022-01-04', '2022-05-12', 555000, 1, 1),
(6, 2, 3, '2022-05-09', '2022-05-09', 350000, 0, 3),
(7, 4, 3, '2022-05-12', '2022-05-12', 450000, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idempresa` int(11) NOT NULL,
  `razonsocial` varchar(100) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `patrimonio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `razonsocial`, `rut`, `patrimonio`) VALUES
(1, 'Kamaleon LTDA', '2223', 0),
(2, 'Constructora SUARIAS', '12121', 0),
(3, 'INDEMAX', '54545', 0),
(4, 'Acerental', '85946', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `correo` varchar(70) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1,
  `esadmin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `idempresa`, `nombre`, `apellido`, `correo`, `pass`, `activo`, `esadmin`) VALUES
(1, 1, 'Jose', 'Tapia', 'joset@hotmail.com', '698d51a19d8a121ce581499d7b701668', 1, 1),
(2, 1, 'usuario', 'prueba', 'usuario@prueba.cl', '698d51a19d8a121ce581499d7b701668', 0, 0),
(3, 2, 'Yerko', 'Muñoz', 'yerko@gmail.com', '698d51a19d8a121ce581499d7b701668', 1, 0),
(4, 4, 'Matias', 'Aravena', 'matiita@hotmail.com', '698d51a19d8a121ce581499d7b701668', 1, 0),
(10, 1, 'Cesar', 'Carrion', 'ccarrion@kamaleon.cl', '698d51a19d8a121ce581499d7b701668', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariofinal`
--

CREATE TABLE `usuariofinal` (
  `idusuariofinal` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1,
  `correo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuariofinal`
--

INSERT INTO `usuariofinal` (`idusuariofinal`, `idempresa`, `rut`, `nombre`, `apellido`, `activo`, `correo`) VALUES
(1, 1, '343434', 'juanito', 'perez', 1, 'juanito@perez.cl'),
(2, 1, '5555', 'Trabajo', 'tapia', 0, 'jose@tapia.cl'),
(3, 4, '54555', 'Flavio', 'Ortiz', 1, 'flavio@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD KEY `fk_articulo_empresa1_idx` (`idempresa`),
  ADD KEY `fk_articulo_categoria1_idx` (`idcategoria`);

--
-- Indices de la tabla `atributos`
--
ALTER TABLE `atributos`
  ADD PRIMARY KEY (`idatributos`),
  ADD KEY `fk_atributos_caracteristica1_idx` (`idcaracteristica`),
  ADD KEY `fk_atributos_articulo1_idx` (`idarticulo`);

--
-- Indices de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  ADD PRIMARY KEY (`idcaracteristica`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`idcontrato`),
  ADD KEY `fk_contrato_articulo1_idx` (`idarticulo`),
  ADD KEY `fk_contrato_usuariofinal1_idx` (`idusuariofinal`),
  ADD KEY `fk_contrato_empresa` (`idempresa`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `fk_usuario_empresa_idx` (`idempresa`);

--
-- Indices de la tabla `usuariofinal`
--
ALTER TABLE `usuariofinal`
  ADD PRIMARY KEY (`idusuariofinal`),
  ADD KEY `fk_usuariofinal_empresa1_idx` (`idempresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `atributos`
--
ALTER TABLE `atributos`
  MODIFY `idatributos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  MODIFY `idcaracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contrato`
--
ALTER TABLE `contrato`
  MODIFY `idcontrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuariofinal`
--
ALTER TABLE `usuariofinal`
  MODIFY `idusuariofinal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_articulo_categoria1` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_articulo_empresa1` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `atributos`
--
ALTER TABLE `atributos`
  ADD CONSTRAINT `fk_atributos_articulo1` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_atributos_caracteristica1` FOREIGN KEY (`idcaracteristica`) REFERENCES `caracteristica` (`idcaracteristica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `fk_contrato_articulo1` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrato_empresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`),
  ADD CONSTRAINT `fk_contrato_usuariofinal1` FOREIGN KEY (`idusuariofinal`) REFERENCES `usuariofinal` (`idusuariofinal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuariofinal`
--
ALTER TABLE `usuariofinal`
  ADD CONSTRAINT `fk_usuariofinal_empresa1` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `desactivarcontratos` ON SCHEDULE EVERY 1 DAY STARTS '2022-05-03 00:00:10' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE contrato set vigente = 0 where day(fechatermino) = day(SYSDATE()) AND month(fechatermino) = month(SYSDATE()) AND year(fechatermino) = year(SYSDATE())$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
