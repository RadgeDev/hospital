-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2017 a las 08:02:26
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_bodega`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bincard`
--

CREATE TABLE `bincard` (
  `idbincard` int(11) NOT NULL,
  `cod_producto` varchar(8) DEFAULT NULL,
  `seccion` varchar(60) NOT NULL,
  `entrada` int(11) DEFAULT NULL,
  `salida` int(11) DEFAULT NULL,
  `saldo` int(11) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `cod_compra` int(11) DEFAULT NULL,
  `cod_salida` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodegas`
--

CREATE TABLE `bodegas` (
  `cod_bodegas` varchar(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `correlativo` longtext NOT NULL,
  `ultimo_codigo` int(11) NOT NULL,
  `horario_recepcion` longtext NOT NULL,
  `horario_entrega` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `cod_compra` int(11) NOT NULL,
  `tipo_documento` varchar(12) DEFAULT NULL,
  `numero_documento` varchar(100) DEFAULT NULL,
  `tipo_compra` int(11) DEFAULT NULL,
  `tipo_compra_nombre` varchar(100) NOT NULL,
  `rut_proveedor` varchar(11) DEFAULT NULL,
  `nombre_proveedor` varchar(100) NOT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `neto` float NOT NULL,
  `iva` float NOT NULL,
  `total_compra` float DEFAULT NULL,
  `descuento` float DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `comentarios` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depto`
--

CREATE TABLE `depto` (
  `cod_depto` int(11) NOT NULL,
  `nombre_depto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `detalle_compra` int(11) NOT NULL,
  `cod_compra` int(11) DEFAULT NULL,
  `cod_producto` varchar(100) DEFAULT NULL,
  `cod_barra` longtext NOT NULL,
  `nombre_prod` varchar(100) NOT NULL,
  `numero_lote` varchar(50) DEFAULT NULL,
  `fecha_vencimiento` varchar(25) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `cod_detalle` int(11) NOT NULL,
  `folio` int(11) NOT NULL,
  `cod_producto` varchar(50) NOT NULL,
  `cod_barra` varchar(50) NOT NULL,
  `nombre_prod` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_salida`
--

CREATE TABLE `detalle_salida` (
  `cod_detalle` int(11) NOT NULL,
  `cod_salida` int(11) DEFAULT NULL,
  `cod_producto` varchar(8) DEFAULT NULL,
  `cantidad` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eliminar_compra`
--

CREATE TABLE `eliminar_compra` (
  `ideliminar_compra` int(11) NOT NULL,
  `cod_compra` int(11) DEFAULT NULL,
  `tipo_documento` varchar(12) DEFAULT NULL,
  `numero_documento` int(15) DEFAULT NULL,
  `tipo_compra` int(11) DEFAULT NULL,
  `rut_proveedor` varchar(11) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `total_compra` int(10) DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL,
  `rut_eliminar` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eliminar_salida`
--

CREATE TABLE `eliminar_salida` (
  `idnew_table` int(11) NOT NULL,
  `cod_salida` int(11) DEFAULT NULL,
  `cod_depto` int(11) DEFAULT NULL,
  `nombre_depto` varchar(50) DEFAULT NULL,
  `num_pedido` int(11) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL,
  `rut_eliminar` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `folio` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(50) NOT NULL,
  `cod_depto` int(11) NOT NULL,
  `depto` varchar(50) NOT NULL,
  `cod_tipo_pedido` int(11) NOT NULL,
  `tipo_pedido` varchar(50) NOT NULL,
  `tiempo_pedido` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `cod_interno_prod` varchar(8) NOT NULL,
  `codigo_barra` varchar(100) NOT NULL,
  `cod_bodega` varchar(11) DEFAULT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` varchar(9) DEFAULT NULL,
  `unidad_medida` varchar(20) DEFAULT NULL,
  `stock_critico` int(11) NOT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `stock_maximo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `rut_proveedor` varchar(11) NOT NULL,
  `nombre_proveedor` varchar(50) DEFAULT NULL,
  `razon_social` varchar(80) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `idregistro` int(11) NOT NULL,
  `rut_usuario` varchar(11) DEFAULT NULL,
  `actividad` varchar(100) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `accion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `cod_salida` int(11) NOT NULL,
  `cod_depto` int(11) DEFAULT NULL,
  `nombre_depto` varchar(50) DEFAULT NULL,
  `num_pedido` int(11) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_compra`
--

CREATE TABLE `tipo_compra` (
  `cod_tipocompra` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ingreso`
--

CREATE TABLE `tipo_ingreso` (
  `cod_ingreso` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `rut` varchar(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `login` varchar(25) DEFAULT NULL,
  `password` longtext,
  `tipo_usuario` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bincard`
--
ALTER TABLE `bincard`
  ADD PRIMARY KEY (`idbincard`),
  ADD KEY `bincard_producto` (`cod_producto`);

--
-- Indices de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  ADD PRIMARY KEY (`cod_bodegas`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`cod_compra`),
  ADD KEY `compra_usuario` (`usuario`),
  ADD KEY `compra_proveedor` (`rut_proveedor`),
  ADD KEY `compra_tipocompra` (`tipo_compra`);

--
-- Indices de la tabla `depto`
--
ALTER TABLE `depto`
  ADD PRIMARY KEY (`cod_depto`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`detalle_compra`),
  ADD KEY `detallecompra_compra` (`cod_compra`),
  ADD KEY `detallecompra_prod` (`cod_producto`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`cod_detalle`);

--
-- Indices de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  ADD PRIMARY KEY (`cod_detalle`),
  ADD KEY `detallesalida_salida` (`cod_salida`),
  ADD KEY `detallesalida_prod` (`cod_producto`);

--
-- Indices de la tabla `eliminar_compra`
--
ALTER TABLE `eliminar_compra`
  ADD PRIMARY KEY (`ideliminar_compra`);

--
-- Indices de la tabla `eliminar_salida`
--
ALTER TABLE `eliminar_salida`
  ADD PRIMARY KEY (`idnew_table`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`folio`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`cod_interno_prod`),
  ADD KEY `producto_bodega` (`cod_bodega`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`rut_proveedor`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`idregistro`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`cod_salida`),
  ADD KEY `salida_depto` (`cod_depto`),
  ADD KEY `salida_user` (`usuario`);

--
-- Indices de la tabla `tipo_compra`
--
ALTER TABLE `tipo_compra`
  ADD PRIMARY KEY (`cod_tipocompra`);

--
-- Indices de la tabla `tipo_ingreso`
--
ALTER TABLE `tipo_ingreso`
  ADD PRIMARY KEY (`cod_ingreso`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`rut`),
  ADD KEY `usuario_salida` (`rut`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bincard`
--
ALTER TABLE `bincard`
  MODIFY `idbincard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45354;
--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `detalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `cod_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  MODIFY `cod_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36208;
--
-- AUTO_INCREMENT de la tabla `eliminar_compra`
--
ALTER TABLE `eliminar_compra`
  MODIFY `ideliminar_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `eliminar_salida`
--
ALTER TABLE `eliminar_salida`
  MODIFY `idnew_table` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `idregistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5977;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bincard`
--
ALTER TABLE `bincard`
  ADD CONSTRAINT `bincard_producto` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_interno_prod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_proveedor` FOREIGN KEY (`rut_proveedor`) REFERENCES `proveedor` (`rut_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_tipocompra` FOREIGN KEY (`tipo_compra`) REFERENCES `tipo_compra` (`cod_tipocompra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`rut`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detallecompra_compra` FOREIGN KEY (`cod_compra`) REFERENCES `compra` (`cod_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallecompra_prod` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_interno_prod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  ADD CONSTRAINT `detallesalida_prod` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_interno_prod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallesalida_salida` FOREIGN KEY (`cod_salida`) REFERENCES `salidas` (`cod_salida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_bodega` FOREIGN KEY (`cod_bodega`) REFERENCES `bodegas` (`cod_bodegas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD CONSTRAINT `salida_depto` FOREIGN KEY (`cod_depto`) REFERENCES `depto` (`cod_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salida_user` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`rut`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
