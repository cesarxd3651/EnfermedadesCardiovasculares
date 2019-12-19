-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2019 a las 00:46:04
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `AdminDNI` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminNombre` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminApellido` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminTelefono` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminDireccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `AdminDNI`, `AdminNombre`, `AdminApellido`, `AdminTelefono`, `AdminDireccion`, `CuentaCodigo`) VALUES
(1, '7233563', 'rogger reyson', 'mendo', '12133', 'jr moquegua', 'AC12345678'),
(2, '73323223', 'nombres', 'vbaac', '923', 'cesarxd', 'AC36843613'),
(3, '3333333', 'cesar', 'baca', '3244243234234', 'cadsdasads', 'AC25830534'),
(4, '33333333', 'rogger', 'castillo', '32312', 'hsdb@gmail.com', 'AC65792345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(10) NOT NULL,
  `BitacoraCodigo` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `BitacoraFecha` date NOT NULL,
  `BitacoraHoraInicio` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `BitacoraHoraFinal` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `BitacoraTipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `BitacoraYear` int(4) NOT NULL,
  `CuentaCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `BitacoraCodigo`, `BitacoraFecha`, `BitacoraHoraInicio`, `BitacoraHoraFinal`, `BitacoraTipo`, `BitacoraYear`, `CuentaCodigo`) VALUES
(1, 'CB70127481', '2019-11-14', '05:58:51 pm', 'sin registro', 'Administrador', 2019, 'AC65792345'),
(2, 'CB54045972', '2019-11-14', '05:59:08 pm', 'sin registro', 'Administrador', 2019, 'AC65792345'),
(3, 'CB94285103', '2019-11-14', '06:00:20 pm', 'sin registro', 'Administrador', 2019, 'AC65792345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(10) NOT NULL,
  `CategoriaCodigo` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `CategoriaNombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(10) NOT NULL,
  `ClienteDNI` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `ClienteNombre` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `ClienteApellido` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `ClienteTelefono` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `ClienteOcupacion` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `ClienteDireccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `ClienteDNI`, `ClienteNombre`, `ClienteApellido`, `ClienteTelefono`, `ClienteOcupacion`, `ClienteDireccion`, `CuentaCodigo`) VALUES
(3, '2323232', 'dcd', 'deccd', '23323', 'ceq', 'sdcd', 'CC90260422'),
(4, '131231', 'ee', 'csdc', '1323', 'huevo', 'r23r32r32', 'CC60034146'),
(5, '6127162', 'PROBAR LISTA', 'EFER', '121212', 'HUEVIN', 'SECTOR 1', 'CC02610747');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(10) NOT NULL,
  `CuentaCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPrivilegio` int(1) NOT NULL,
  `CuentaUsuario` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaClave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaEmail` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaEstado` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaTipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaGenero` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaFoto` varchar(535) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id`, `CuentaCodigo`, `CuentaPrivilegio`, `CuentaUsuario`, `CuentaClave`, `CuentaEmail`, `CuentaEstado`, `CuentaTipo`, `CuentaGenero`, `CuentaFoto`) VALUES
(1, 'AC12345678', 1, 'Administrador', 'Administrador', 'email@gmail.com', 'Activo', 'Administrador', 'Masculino', 'AdminMaleAvatar.png'),
(3, 'CC90260422', 4, 'ceas', 'UTAvQXRKdnUxemxUUGdUSUdpQjJZZz09', 'cesar@gmail.com', 'Activo', 'Cliente', 'Masculino', 'Male2Avatar.png'),
(4, 'AC36843613', 1, 'cesar', 'UTAvQXRKdnUxemxUUGdUSUdpQjJZZz09', 'cesarxd2345@gmail.com', 'Activo', 'Administrador', 'Masculino', 'usarAvatar.png'),
(5, 'AC25830534', 3, 'cesarxd25443', 'TysreHRyY2lFbkZ6aEs1aVNBeGkxQT09', 'cesarxd212@gmail.com', 'Activo', 'Administrador', 'Masculino', 'usarAvatar.png'),
(6, 'AC65792345', 1, 'rogger', 'M2UvcEIwNGtkeHZUS0g5YnNkdVY3QT09', '', 'Activo', 'Administrador', 'Masculino', 'usarAvatar.png'),
(7, 'CC60034146', 4, 'r23r32', 'L3JLVm5OZXVEU3dxTDB5QzNrUytqUT09', 'frf4@gmail.com', 'Activo', 'Cliente', 'Masculino', 'Male2Avatar.png'),
(8, 'CC02610747', 4, '2e12e', 'TlJzckxzUC94ZVRiRXByU0wwaEM5UT09', 'df@gmail.com', 'Activo', 'Cliente', 'Masculino', 'Male2Avatar.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(10) NOT NULL,
  `EmpresaCodigo` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaNombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaTelefono` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaEmail` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaDireccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaDirector` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaMoneda` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaYear` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id` int(10) NOT NULL,
  `LibroCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `LibroTitulo` varchar(170) COLLATE utf8_spanish2_ci NOT NULL,
  `LibroAutor` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `LibroPais` int(50) NOT NULL,
  `LibroYear` int(4) NOT NULL,
  `LibroEditorial` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `LibroEdicion` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `LibroPrecio` decimal(30,2) NOT NULL,
  `LibroStock` int(5) NOT NULL,
  `LibroUbicacion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `LibroResumen` text COLLATE utf8_spanish2_ci NOT NULL,
  `LibroImagen` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `LibroPDF` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `LibroDescarga` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `CategoriaCodigo` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `ProveedorCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaCodigo` varchar(40) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(10) NOT NULL,
  `ProveedorCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `ProveedorNombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ProveedorResponsable` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ProveedorTelefono` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `ProveedorEmail` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `ProveedorDireccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CuentaCodigo` (`CuentaCodigo`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CuentaCodigo` (`CuentaCodigo`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CategoriaCodigo` (`CategoriaCodigo`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CuentaCodigo` (`CuentaCodigo`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CuentaCodigo` (`CuentaCodigo`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `EmpresaCodigo` (`EmpresaCodigo`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `LibroCodigo` (`LibroCodigo`),
  ADD KEY `CategoriaCodigo` (`CategoriaCodigo`),
  ADD KEY `ProveedorCodigo` (`ProveedorCodigo`),
  ADD KEY `EmpresaCodigo` (`EmpresaCodigo`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ProveedorCodigo` (`ProveedorCodigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`CuentaCodigo`) REFERENCES `cuenta` (`CuentaCodigo`);

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`CuentaCodigo`) REFERENCES `cuenta` (`CuentaCodigo`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`CuentaCodigo`) REFERENCES `cuenta` (`CuentaCodigo`);

--
-- Filtros para la tabla `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`CategoriaCodigo`) REFERENCES `categoria` (`CategoriaCodigo`),
  ADD CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`ProveedorCodigo`) REFERENCES `proveedor` (`ProveedorCodigo`),
  ADD CONSTRAINT `libro_ibfk_3` FOREIGN KEY (`EmpresaCodigo`) REFERENCES `empresa` (`EmpresaCodigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
