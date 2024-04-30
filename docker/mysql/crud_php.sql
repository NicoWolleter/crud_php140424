-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2024 a las 04:52:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crud_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE DATABASE IF NOT EXISTS `crud_php` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `crud_php`;

CREATE TABLE `lotes` (
  `id_lote` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `fecha_caducidad` date DEFAULT NULL,
  `cantidad_inicial` int(11) DEFAULT NULL,
  `cantidad_actual` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`id_lote`, `id_producto`, `fecha_caducidad`, `cantidad_inicial`, `cantidad_actual`, `fecha_ingreso`) VALUES
(1, 24, '2024-04-27', 12, 12, '2024-04-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `proveedor` varchar(50) NOT NULL,
  `precio_adq` int(20) NOT NULL,
  `precio_venta` int(20) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `cantidad` int(20) NOT NULL,
  `codigo_barra` varchar(100) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `productos_vendidos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `producto`, `proveedor`, `precio_adq`, `precio_venta`, `fecha_ingreso`, `fecha_caducidad`, `categoria`, `cantidad`, `codigo_barra`, `precio_unitario`, `productos_vendidos`) VALUES
(1, 'Coca-Cola', 'CocaCola company', 1000, 1500, '2024-04-01', '2025-04-01', 'bebida', 23, '7801610001622', NULL, 3),
(4, 'torta amor', 'pasteleria', 2000, 3500, '2024-04-10', '2024-04-12', 'pasteles', 1, '13213533115', NULL, 0),
(5, 'fanta', 'CocaCola company', 1000, 1500, '2024-04-10', '2025-04-10', 'bebida', 32, '16565651198', NULL, 12),
(11, 'full', 'Arcor', 200, 500, '2024-04-10', '2025-04-16', 'caramelos', 48, '65456465465', NULL, 2),
(14, 'super 8', 'costa', 100, 200, '2024-04-11', '2025-04-11', 'golosinas', 90, NULL, NULL, 0),
(15, 'torta selva negra', 'pasteleria', 2000, 3500, '2024-04-11', '2024-04-13', 'pasteles', 5, NULL, NULL, 0),
(19, 'pepsi', 'pepsi co', 1000, 1500, '2024-04-15', '2025-04-15', 'bebida', 50, NULL, NULL, 0),
(21, 'papas fritas lays', 'pepsi co', 800, 1200, '2024-04-15', '2025-04-15', 'snacks', 50, NULL, NULL, 0),
(23, 'golpe', 'costa', 100, 250, '2024-04-16', '2025-04-16', 'golosinas', 98, '0', NULL, 0),
(24, 'pan con queso', 'panaderia', 300, 800, '2024-04-26', '2024-04-27', 'panaderia', 12, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(50) NOT NULL,
  `contacto_proveedor` varchar(50) NOT NULL,
  `info_facturacion` varchar(1000) NOT NULL,
  `info_envio` varchar(1000) NOT NULL,
  `categoria_proveedor` varchar(50) NOT NULL,
  `fecha_registro` date NOT NULL,
  `estado_proveedor` varchar(50) NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `contacto_proveedor`, `info_facturacion`, `info_envio`, `categoria_proveedor`, `fecha_registro`, `estado_proveedor`) VALUES
(1, 'Coca cola company', 'contacto@cocacola.com', 'collao 1800', 'bb', 'bebidas', '2024-04-17', 'activo'),
(2, 'ccu', 'contacto@ccu.cl', 'aaaaa', 'aaaaa', 'bebidas', '2024-04-17', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `rol_usuario` varchar(100) NOT NULL,
  `password_usuario` varchar(100) NOT NULL,
  `fecha_registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `rol_usuario`, `password_usuario`, `fecha_registro`) VALUES
(1, 'Wolleter', 'nsanhueza2009@gmail.com', 'administrador', 'Qwerty12345.', '2024-04-17'),
(2, 'prueba', 'prueba@gmail.com', 'operario', '*MY]JqA;+EvdEi8', '2024-04-17'),
(3, 'juanito perez', 'juan@gmail.com', 'operario', 'Asdf1234.', '2024-04-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `codigo_barra` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento_tipo` enum('porcentaje','valor') NOT NULL,
  `descuento_valor` decimal(10,2) NOT NULL,
  `tipo_pago` enum('efectivo','redcompra','junaeb') NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `total_venta` decimal(10,2) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','completada') DEFAULT 'pendiente',
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `codigo_barra`, `cantidad`, `descuento_tipo`, `descuento_valor`, `tipo_pago`, `usuario`, `total_venta`, `fecha_hora`, `estado`, `id_producto`) VALUES
(1, '7801610001622', 2, 'porcentaje', 0.00, 'efectivo', '0', 0.00, '2024-04-25 07:45:28', 'pendiente', NULL),
(2, '7801610001622', 2, 'porcentaje', 0.00, 'efectivo', '0', 0.00, '2024-04-25 07:48:36', 'pendiente', NULL),
(3, '7801610001622', 2, 'porcentaje', 0.00, 'efectivo', '0', 0.00, '2024-04-25 08:05:36', 'pendiente', NULL),
(4, '7801610001622', 2, 'porcentaje', 0.00, 'efectivo', '0', 0.00, '2024-04-25 08:46:40', 'pendiente', NULL),
(5, '13213533115', 1, 'porcentaje', 0.00, 'efectivo', '0', 0.00, '2024-04-26 02:49:33', 'pendiente', NULL),
(6, '7801610001622', 2, 'porcentaje', 0.00, 'efectivo', '0', 3000.00, '2024-04-26 04:40:18', 'pendiente', NULL),
(7, '16565651198', 3, 'porcentaje', 0.00, 'efectivo', '0', 4500.00, '2024-04-26 06:18:31', 'pendiente', NULL),
(8, '65456465465', 2, 'porcentaje', 0.00, 'efectivo', '0', 1000.00, '2024-04-26 06:18:31', 'pendiente', NULL),
(9, '7801610001622', 1, 'porcentaje', 0.00, 'efectivo', '0', 1500.00, '2024-04-26 09:16:07', 'pendiente', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `lotes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
