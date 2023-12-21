-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:33085
-- Tiempo de generación: 21-12-2023 a las 02:58:05
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbhoteles`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `calcular_dias_intersectados` (IN `fecha_inicio_principal` DATE, IN `fecha_fin_principal` DATE)  BEGIN
    SELECT 
        fecha_ingreso, 
        fecha_salida, 
        DATEDIFF( 
            LEAST(fecha_salida, fecha_fin_principal), 
            GREATEST(fecha_ingreso, fecha_inicio_principal)
        ) AS dias_intersectados,
        dias_reserva,
        costo_reserva,
        costo_reserva / dias_reserva AS precio
    FROM registro_huesped 
    WHERE fecha_ingreso < fecha_fin_principal AND fecha_salida > fecha_inicio_principal;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `calcular_dias_intersectados_estrellas` (IN `fecha_inicio_principal` DATE, IN `fecha_fin_principal` DATE, IN `estrellas` INT)  BEGIN
    SELECT 
        RH.fecha_ingreso, 
        RH.fecha_salida, 
        DATEDIFF(
            LEAST(RH.fecha_salida, fecha_fin_principal),
            GREATEST(RH.fecha_ingreso, fecha_inicio_principal)
        ) AS dias_intersectados,
        RH.dias_reserva,
        RH.costo_reserva,
        RH.costo_reserva / RH.dias_reserva AS precio
    FROM registro_huesped RH
    JOIN hotel H ON RH.idhotel = H.idhotel
    WHERE RH.fecha_ingreso < fecha_fin_principal 
        AND RH.fecha_salida > fecha_inicio_principal
        AND H.estrellas = estrellas;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `calcular_dias_intersectados_totales` (IN `fecha_inicio_principal` DATE, IN `fecha_fin_principal` DATE)  BEGIN   
    DECLARE resultado DECIMAL(10, 2);
    SELECT DATEDIFF(fecha_fin_principal, fecha_inicio_principal)*(SELECT SUM(tot_habitaciones) FROM hotel) INTO resultado;

    SELECT 
    (SUM(
        DATEDIFF(
            LEAST(fecha_salida, fecha_fin_principal),
            GREATEST(fecha_ingreso, fecha_inicio_principal)
        )
    )/resultado)*100 AS ocupacion,
    AVG(costo_reserva / dias_reserva) AS tarifa
    FROM registro_huesped 
    WHERE fecha_ingreso < fecha_fin_principal AND fecha_salida > fecha_inicio_principal;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `calcular_dias_intersectados_totales_estrellas` (IN `fecha_inicio_principal` DATE, IN `fecha_fin_principal` DATE, IN `estrellasVal` INT)  BEGIN   
    DECLARE resultado DECIMAL(10, 2);
    SELECT DATEDIFF(fecha_fin_principal, fecha_inicio_principal) * (SELECT SUM(tot_habitaciones) FROM HOTEL WHERE estrellas = estrellasVal) INTO resultado;

    SELECT 
        (SUM(
            DATEDIFF(
                LEAST(RH.fecha_salida, fecha_fin_principal),
                GREATEST(RH.fecha_ingreso, fecha_inicio_principal)
            )
        ) / resultado) * 100 AS ocupacion,
        AVG(RH.costo_reserva / RH.dias_reserva) AS tarifa
    FROM registro_huesped RH
    JOIN hotel H ON RH.idhotel = H.idhotel
    WHERE RH.fecha_ingreso < fecha_fin_principal
        AND RH.fecha_salida > fecha_inicio_principal
        AND H.estrellas = estrellasVal;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `calcular_dias_intersectados_totales_hotel` (IN `fecha_inicio_principal` DATE, IN `fecha_fin_principal` DATE, IN `hotel` INT)  BEGIN   
    DECLARE resultado DECIMAL(10, 2);
    SELECT DATEDIFF(fecha_fin_principal, fecha_inicio_principal)*(SELECT SUM(tot_habitaciones) FROM hotel WHERE idhotel=hotel) INTO resultado;

    SELECT 
    (SUM(
        DATEDIFF(
            LEAST(fecha_salida, fecha_fin_principal),
            GREATEST(fecha_ingreso, fecha_inicio_principal)
        )
    )/resultado)*100 AS ocupacion,
    AVG(costo_reserva / dias_reserva) AS tarifa
    FROM registro_huesped 
    WHERE fecha_ingreso < fecha_fin_principal AND fecha_salida > fecha_inicio_principal AND idhotel =  hotel;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `calcular_dias_intersectados_totales_pruebas` (IN `fecha_inicio_principal` DATE, IN `fecha_fin_principal` DATE)  BEGIN   
    DECLARE resultado DECIMAL(10, 2);
    SELECT DATEDIFF(fecha_fin_principal, fecha_inicio_principal)*(SELECT SUM(tot_habitaciones) FROM hotel) INTO resultado;

    SELECT 
    DATEDIFF(fecha_fin_principal, fecha_inicio_principal)AS diasRango, 
    (SELECT SUM(tot_habitaciones) FROM hotel) AS tot_habitaciones,
    resultado as resultado,
    SUM(
        DATEDIFF(
            LEAST(fecha_salida, fecha_fin_principal),
            GREATEST(fecha_ingreso, fecha_inicio_principal)
        )
    ) AS diasNetos,
    (SUM(
        DATEDIFF(
            LEAST(fecha_salida, fecha_fin_principal),
            GREATEST(fecha_ingreso, fecha_inicio_principal)
        )
    )/resultado)*100 AS promedio,
    AVG(costo_reserva / dias_reserva) AS tarifa
    FROM registro_huesped 
    WHERE fecha_ingreso < fecha_fin_principal AND fecha_salida > fecha_inicio_principal;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `calcular_dias_intersectados_totales_pruebas_hotel` (IN `fecha_inicio_principal` DATE, IN `fecha_fin_principal` DATE, IN `hotel` INT)  BEGIN   
    DECLARE resultado DECIMAL(10, 2);
    SELECT DATEDIFF(fecha_fin_principal, fecha_inicio_principal)*(SELECT SUM(tot_habitaciones) FROM hotel WHERE idhotel=hotel) INTO resultado;

    SELECT 
    DATEDIFF(fecha_fin_principal, fecha_inicio_principal)AS diasRango, 
    (SELECT SUM(tot_habitaciones) FROM hotel WHERE idhotel=hotel) AS tot_habitaciones,
    resultado as resultado,
    SUM(
        DATEDIFF(
            LEAST(fecha_salida, fecha_fin_principal),
            GREATEST(fecha_ingreso, fecha_inicio_principal)
        )
    ) AS diasNetos,
    (SUM(
        DATEDIFF(
            LEAST(fecha_salida, fecha_fin_principal),
            GREATEST(fecha_ingreso, fecha_inicio_principal)
        )
    )/resultado)*100 AS ocupacion,
    AVG(costo_reserva / dias_reserva) AS tarifa
    FROM registro_huesped 
    WHERE fecha_ingreso < fecha_fin_principal AND fecha_salida > fecha_inicio_principal AND idhotel =  hotel;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `idestado` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`idestado`, `nombre`) VALUES
(1, 'Aguascalientes'),
(2, 'Baja California'),
(3, 'Baja California Sur'),
(4, 'Campeche'),
(5, 'Chiapas'),
(6, 'Chihuahua'),
(7, 'Coahuila'),
(8, 'Colima'),
(9, 'Durango'),
(10, 'Guanajuato'),
(11, 'Guerrero'),
(12, 'Hidalgo'),
(13, 'Jalisco'),
(14, 'Mexico'),
(15, 'Michoacan'),
(16, 'Morelos'),
(17, 'Nayarit'),
(18, 'Nuevo Leon'),
(19, 'Oaxaca'),
(20, 'Puebla'),
(21, 'Queretaro'),
(22, 'Quintana Roo'),
(23, 'San Luis Potosi'),
(24, 'Sinaloa'),
(25, 'Sonora'),
(26, 'Tabasco'),
(27, 'Tamaulipas'),
(28, 'Tlaxcala'),
(29, 'Veracruz'),
(30, 'Yucatan'),
(31, 'Zacatecas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `idhabitacion` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `personas` int(11) NOT NULL,
  `tarifa_dia` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  `idhotel` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`idhabitacion`, `tipo`, `personas`, `tarifa_dia`, `cantidad`, `condicion`, `idhotel`, `idusuario`) VALUES
(1, 'EMPRESARIAL', 10, '999.99', 4, 1, 1, 1),
(2, 'BASICA', 2, '200.00', 80, 1, 2, 1),
(3, 'PAREJA', 2, '400.00', 30, 1, 2, 1),
(4, 'EMPRESARIAL', 10, '999.99', 20, 1, 2, 1),
(5, 'CLASE MEDIA', 4, '999.99', 23, 1, 3, 1),
(6, 'INDUSTRIAL', 15, '300.00', 20, 1, 3, 49),
(7, 'TURISTA', 1, '999.99', 23, 1, 3, 1),
(8, 'empresarial', 15, '500.00', 2, 1, 4, 52),
(9, 'basica', 3, '300.00', 20, 1, 4, 52),
(10, 'super', 3, '234.00', 33, 1, 4, 52),
(11, 'suit', 4, '456.00', 23, 1, 4, 52),
(12, 'PANOCHA', 23, '45.00', 34, 1, 5, 55),
(13, 'basica', 4, '300.00', 200, 1, 6, 57),
(14, 'empresarial', 15, '11000.00', 50, 1, 6, 57),
(15, 'SUPER BASICA', 1, '200.00', 40, 1, 6, 57),
(16, 'basica', 1, '200.00', 20, 1, 8, 75),
(17, 'PAREJA', 2, '400.00', 20, 1, 8, 75),
(18, 'cuadruple', 4, '600.00', 40, 1, 8, 75),
(19, 'master', 6, '567.00', 34, 1, 8, 75),
(20, 'suite', 2, '800.00', 10, 1, 9, 80),
(21, 'suite imperial', 4, '1000.00', 5, 1, 9, 80),
(22, 'suite lite', 4, '500.00', 10, 1, 9, 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel`
--

CREATE TABLE `hotel` (
  `idhotel` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `categoria` varchar(40) NOT NULL,
  `tot_habitaciones` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `estrellas` int(11) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  `idestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `hotel`
--

INSERT INTO `hotel` (`idhotel`, `nombre`, `categoria`, `tot_habitaciones`, `direccion`, `telefono`, `email`, `estrellas`, `imagen`, `condicion`, `idestado`) VALUES
(1, 'LAS PALOMAS', 'Boutique', 400, 'AV.INSURGENTES CENTRO', '3111930366', 'palomit@gmail.com', 5, '1680772006.png', 1, 12),
(2, 'NEKIE', 'Negocios', 200, '2 de agosto', '323234234', 'nekie@gmail.com', 4, '1680772383.png', 1, 17),
(3, 'LAS PALOMAS', 'Todo Incluido', 600, 'AV.INSURGENTES CENTRO', '3111930366', 'palomit@gmail.com', 4, '1680850478.png', 1, 17),
(4, 'Casa Mañana', 'Resort', 50, 'AV.INSURGENTES CENTRO', '3111930326', 'pollo_ruiz2011@hotmail.com', 3, '1681848955.png', 1, 17),
(5, 'hotel Rosario', 'Negocios', 1, '2 de agosto', '3111930326', 'pfr2102@gmail.com', 2, '1684806469.png', 1, 2),
(6, 'Marival', 'Resort', 700, '2 de agosto', '3111930326', 'marival@gmail.com', 5, '1683877461.jpg', 1, 13),
(7, 'Hotel Del Sol', 'Turismo', 18, '2 DE AGOSTO', '3112264704', 'jcamposcasillas@gmail.com', 5, '1684806483.jpg', 1, 17),
(8, 'Hotel Alica', 'Negocios', 33, 'AV.INSURGENTES CENTRO', '3111930456', 'pollo_ruiz2011@hotmail.com', 4, '', 1, 1),
(9, 'Hotel Rivera', 'Todo Incluido', 100, '3 de agosto', '3112766365', 'hoteljose@hotel.com', 3, '1684823151.jpeg', 1, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'General'),
(2, 'Hoteles'),
(3, 'Tipos Habitaciones'),
(4, 'Acceso Asociacion'),
(5, 'Acceso Hotel'),
(6, 'Captura'),
(7, 'Datos Asociacion'),
(8, 'Datos Hotel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_huesped`
--

CREATE TABLE `registro_huesped` (
  `idregistro_huesped` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `costo_reserva` decimal(10,2) NOT NULL,
  `dias_reserva` int(11) DEFAULT NULL,
  `motivo` varchar(25) DEFAULT NULL,
  `fecha_registro` date NOT NULL DEFAULT curdate(),
  `idhotel` int(11) NOT NULL,
  `idestado` int(11) NOT NULL,
  `idhabitacion` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `registro_huesped`
--

INSERT INTO `registro_huesped` (`idregistro_huesped`, `fecha_ingreso`, `fecha_salida`, `costo_reserva`, `dias_reserva`, `motivo`, `fecha_registro`, `idhotel`, `idestado`, `idhabitacion`, `idusuario`) VALUES
(1, '2022-03-01', '2022-03-19', '550.00', 18, 'PLACER', '2023-04-05', 1, 1, 1, 1),
(2, '2022-02-28', '2022-03-09', '220.00', 9, 'PLACER', '2023-04-05', 1, 1, 1, 1),
(3, '2022-03-14', '2022-03-22', '100.00', 8, 'PLACER', '2023-04-05', 1, 1, 1, 1),
(4, '2022-04-01', '2022-04-10', '500.00', 9, 'TRABAJO', '2023-04-05', 1, 1, 1, 1),
(5, '2022-03-05', '2022-03-15', '700.00', 10, 'PLACER', '2023-04-05', 1, 1, 1, 1),
(6, '2022-03-11', '2022-03-17', '800.00', 6, 'TRABAJO', '2023-04-05', 1, 1, 1, 1),
(7, '2022-03-17', '2022-04-14', '150.00', 28, 'PLACER', '2023-04-05', 1, 1, 1, 1),
(13, '2023-04-11', '2023-05-04', '457.00', 6, 'TRABAJO', '2023-04-12', 2, 1, 2, 1),
(17, '2023-04-09', '2023-04-23', '223.00', 14, 'PLACER', '2023-04-12', 2, 12, 3, 1),
(18, '2023-03-27', '2023-04-24', '32.00', 28, 'PLACER', '2023-04-12', 2, 11, 2, 1),
(19, '2023-04-16', '2023-04-27', '987.00', 11, 'TRABAJO', '2023-04-12', 2, 1, 2, 43),
(20, '2023-03-20', '2023-04-26', '999.99', 37, 'TRABAJO', '2023-04-12', 2, 11, 3, 43),
(21, '2023-04-28', '2023-04-29', '456.00', 1, 'TRABAJO', '2023-04-12', 2, 12, 2, 43),
(22, '2023-04-09', '2023-04-28', '25.00', 19, 'PLACER', '2023-04-12', 2, 12, 4, 47),
(23, '2023-04-21', '2023-05-03', '456.00', 12, 'TRABAJO', '2023-04-12', 2, 11, 4, 47),
(24, '2023-04-03', '2023-05-04', '57.00', 31, 'PLACER', '2023-04-12', 3, 10, 5, 46),
(25, '2023-04-19', '2023-04-28', '289.00', 9, 'PLACER', '2023-04-13', 3, 13, 6, 46),
(26, '2023-04-05', '2023-04-14', '55.00', 9, 'PLACER', '2023-04-13', 3, 12, 6, 45),
(27, '2023-04-12', '2023-04-27', '450.00', 15, 'PLACER', '2023-04-18', 4, 13, 8, 53),
(28, '2023-03-29', '2023-04-20', '600.00', 22, 'TRABAJO', '2023-04-18', 4, 20, 9, 53),
(29, '2023-04-10', '2023-05-05', '345.00', 25, 'PLACER', '2023-04-18', 4, 12, 8, 54),
(30, '2023-04-04', '2023-04-29', '999.99', 25, 'PLACER', '2023-04-29', 3, 13, 6, 1),
(31, '2023-05-09', '2023-06-03', '10000.00', 25, 'TRABAJO', '2023-05-05', 3, 1, 5, 1),
(32, '2023-04-25', '2023-05-04', '3000.00', 9, 'PLACER', '2023-05-12', 6, 7, 15, 58),
(33, '2023-02-28', '2023-05-02', '5667.00', 63, 'TRABAJO', '2023-05-12', 6, 15, 14, 58),
(34, '2023-03-27', '2023-05-12', '5678.00', 46, 'TRABAJO', '2023-05-12', 6, 1, 14, 58),
(35, '2023-03-15', '2023-05-03', '6789.00', 49, 'TRABAJO', '2023-05-12', 6, 12, 13, 58),
(36, '2023-03-07', '2023-04-20', '500.00', 44, 'TRABAJO', '2023-05-12', 6, 1, 13, 60),
(37, '2023-03-13', '2023-04-20', '388.00', 38, 'TRABAJO', '2023-05-12', 6, 12, 14, 60),
(38, '2023-03-09', '2023-05-11', '3425.00', 63, 'TRABAJO', '2023-05-12', 6, 7, 15, 60),
(39, '2023-05-02', '2023-05-17', '165000.00', 15, 'PLACER', '2023-05-16', 6, 10, 14, 60),
(40, '2023-05-01', '2023-05-12', '3300.00', 11, 'TRABAJO', '2023-05-16', 6, 12, 13, 60),
(41, '2023-05-24', '2023-05-31', '77000.00', 7, 'PLACER', '2023-05-17', 6, 9, 14, 60),
(42, '2023-05-01', '2023-05-11', '2000.00', 10, 'PLACER', '2023-05-17', 6, 11, 15, 60),
(44, '2023-05-08', '2023-05-18', '6000.00', 10, 'PLACER', '2023-05-17', 8, 14, 18, 76),
(45, '2023-05-09', '2023-05-12', '600.00', 3, 'PLACER', '2023-05-17', 8, 1, 16, 76),
(46, '2023-05-01', '2023-05-13', '4800.00', 12, 'PLACER', '2023-05-17', 8, 10, 17, 76),
(47, '2023-05-01', '2023-05-22', '8400.00', 21, 'PLACER', '2023-05-22', 8, 14, 17, 78),
(48, '2023-04-04', '2023-05-22', '27216.00', 48, 'TRABAJO', '2023-05-22', 8, 11, 19, 78),
(49, '2023-03-09', '2023-05-04', '56000.00', 56, 'TRABAJO', '2023-05-23', 9, 14, 21, 81),
(50, '2023-03-02', '2023-05-04', '50400.00', 63, 'TRABAJO', '2023-05-23', 9, 1, 20, 81),
(51, '2023-03-03', '2023-05-11', '55200.00', 69, 'PLACER', '2023-05-23', 9, 20, 20, 81),
(52, '2023-03-02', '2023-05-09', '68000.00', 68, 'TRABAJO', '2023-05-23', 9, 1, 21, 81),
(53, '2023-05-01', '2023-05-23', '22000.00', 22, 'PLACER', '2023-05-23', 9, 13, 21, 82);

--
-- Disparadores `registro_huesped`
--
DELIMITER $$
CREATE TRIGGER `calcular_dias_reserva_actualizar` BEFORE UPDATE ON `registro_huesped` FOR EACH ROW BEGIN
  SET NEW.dias_reserva = DATEDIFF(NEW.fecha_salida, NEW.fecha_ingreso);
  SET NEW.costo_reserva = NEW.dias_reserva * (SELECT h.tarifa_dia FROM habitacion h WHERE h.idhabitacion = NEW.idhabitacion);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcular_dias_reserva_insertar` BEFORE INSERT ON `registro_huesped` FOR EACH ROW BEGIN
  SET NEW.dias_reserva = DATEDIFF(NEW.fecha_salida, NEW.fecha_ingreso);
  SET NEW.costo_reserva = NEW.dias_reserva * (SELECT h.tarifa_dia FROM habitacion h WHERE h.idhabitacion = NEW.idhabitacion);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `rol` varchar(15) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  `idhotel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `rol`, `imagen`, `condicion`, `idhotel`) VALUES
(1, 'PEDRO FIGUEROA RUIZ', 'RFC', '32EMKL23', '2 DE AGOSTO', '3111930326', 'PFR@GMAIL.COM', 'super admin', 'Pedrin36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'PERSONALIZADO', '1680823662.png', 1, 3),
(29, 'PEDRO CASAS', 'RFC', 'DSD', '4 DE AGOSTO', '3111930326', 'pollo_ruiz2011@hotmail.com', 'DIRECTOR', 'pedrocasas', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'DIRECTOR', '1680856027.jpg', 1, 2),
(31, 'LOURDES RUIZ ESTRADA', 'CURP', '23EDEFRTREFFFFF', '2 de agosto', '3111930326', 'loyurdes@gmail.com', '', 'lulu', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'GERENTE', '1682802763.png', 1, 2),
(43, 'ANA HERRERA HERNANDEZ', 'RFC', '23ED', 'AV.INSURGENTES CENTRO', '3111930326', 'loyurdes@gmail.com', 'BARRE PISO', 'ana', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 2),
(44, 'Fernando Hernandez', 'RFC', '23ED', 'AV.INSURGENTES CENTRO', '3111930326', 'pfr2102@gmail.com', 'gerente administrado', 'fer36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'GERENTE', 'user2.png', 1, 3),
(45, 'josefa', 'RFC', '2e23', '2 de agosto', '3111930326', '', 'BARRE PISO', 'josefa', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 3),
(46, 'alan', 'RFC', '23ED', 'AV.INSURGENTES CENTRO', '3111930326', 'PFR@GMAIL.COM', 'RECEPTCION', 'alan36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 3),
(47, 'german garmendia', 'CURP', '23ED', 'AV.INSURGENTES CENTRO', '3111930326', 'PFR@GMAIL.COM', 'BARRE PISO', 'german03', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 2),
(48, 'personal', 'CURP', '2e23', '2 de agosto', '3111930326', 'PFR@GMAIL.COM', 'BARRE PISO', 'pedro', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'PERSONALIZADO', 'user2.png', 1, 3),
(49, 'PANCHO CASAS', 'CURP', '23ED', '2 de agosto', '3111930326', 'pfr2102@gmail.com', 'BARRE PISO', 'PANCHO', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'GERENTE', 'user2.png', 1, 3),
(50, 'DIRECTOR', 'CURP', '23ED', '2 de agosto', '3111930326', 'pfr2102@gmail.com', 'director', 'DIREC', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'DIRECTOR', 'user2.png', 1, 2),
(51, 'prueba', 'RFC', '23ED', '2 de agosto', '3111930456', 'pfr2102@gmail.com', 'BARRE PISO', 'prueba1', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'GERENTE', 'user2.png', 0, 2),
(52, 'cesar feack', 'RFC', '23ED', '2 de agosto', '3111930326', 'pfr2102@gmail.com', 'gerente administrado', 'cesar36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'GERENTE', 'user2.png', 1, 4),
(53, 'pedro', 'CURP', '32EMKL23', '2 de agosto', '3111930326', 'pfr2102@gmail.com', 'BARRE PISO', 'pedro2102', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 4),
(54, 'gustavo', 'RFC', '23ED', '2 de agosto', '3111930326', 'pfr2102@gmail.com', 'don chingon', 'gustavo36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 4),
(55, 'mauricio', 'CURP', '23ED', '2 de agosto', '3111930326', 'pfr2102@gmail.com', 'gerente administrado', 'mau36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'GERENTE', 'user2.png', 1, 5),
(56, 'pepe', 'RFC', 'ddd', 'dd', '3111930326', 'pfr2102@gmail.com', '', 'pepe36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 5),
(57, 'MARTIN', 'CURP', '32EMKL23', 'AV.INSURGENTES CENTRO', '3111930456', 'palomit@gmail.com', 'don chingon', 'martin36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'GERENTE', 'user2.png', 1, 6),
(58, 'pedro', 'RFC', '32EMKL23', '2 DE AGOSTO', '3111930326', 'PFR@GMAIL.COM', 'don chingon', 'pe2102', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 6),
(60, 'gustavo', 'CURP', '2e23', 'AV.INSURGENTES CENTRO', '3111930456', 'PFR@GMAIL.COM', 'don chingon', 'gustin36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 6),
(61, 'Juan', 'RFC', '32EMKL23', '2 de agosto', '3111930345', 'juan@hotmail.com', 'RECEPTCION', 'juan36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 6),
(62, 'Juan Pablo', 'RFC', '2e23', '2 DE AGOSTOlkhjbl', '3111930326', 'jcamposcasillas@gmail.com', 'Gerente', 'juanpablo', '7ef758ee9b1cd91d53010a979e5b9fcec3734802d632b9c984e25add58b8d20b', 'GERENTE', 'user2.png', 1, 7),
(63, 'juan', 'RFC', '223342', 'lclcllccl', '3111930345', 'juan@hotmail.com', 'RECEPTCION', 'juan', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'CAPTURISTA', 'user2.png', 1, 7),
(66, 'jose alan', 'CURP', '23ED', '2 de agosto', '3111930326', 'pfr2102@gmail.com', 'RECEPTCION', 'jose36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 6),
(73, 'ddd', 'RFC', '2e23', '2 DE AGOSTO', '3111930326', 'pfr2102@gmail.com', 'BARRE PISO', 'fdfd', 'fc70fc7f2ef7d3f790168c9c2881181b89e8e18915c921167b5cf5c7399f0a73', 'CAPTURISTA', 'user2.png', 1, 2),
(74, 'fff', 'RFC', '2e23', '2 DE AGOSTO', '3111930326', 'pfr2102@gmail.com', 'BARRE PISO', 'ffff', '062bdba5aedfea8cacd3fea8d3341895b8e9f1b0b23c600970769faf26d6ff84', 'CAPTURISTA', 'user2.png', 1, 2),
(75, 'Arlethe', 'RFC', '223342', 'AV.INSURGENTES CENTRO', '3111930345', 'am@gmail.com', 'gerente administrado', 'arlethe', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'GERENTE', 'user2.png', 1, 8),
(76, 'Manuel', 'RFC', '32EMKL23', '4 DE AGOSTO', '3111930456', 'manuel@gmail.com', 'CAPTURISTA', 'manuel', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 8),
(77, 'cesarfeack', 'RFC', '23ED', '2 DE AGOSTO', '3111930326', 'pfr2102@gmail.com', 'BARRE PISO', 'cesarf', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 8),
(78, 'ALAN MAGALLANES', 'RFC', '223342', 'tierra y libertad', '3111930345', 'pfr2102@gmail.com', 'BARRE PISO', 'alan40', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'CAPTURISTA', 'user2.png', 1, 8),
(79, 'maria', 'RFC', '2e23', '2 DE AGOSTO', '3111930326', 'pfr2102@gmail.com', 'RECEPTCION', 'maria36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 2),
(80, 'Jose', 'RFC', '234LKJGLSK35', 'Centro', '311 167 8547', 'jose@hotmail.com', 'Gerente', 'Jose123', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'GERENTE', 'user2.png', 1, 9),
(81, 'José Madero', 'CURP', 'augsagkagn345r2n', '2 de agosto', '31148945648', 'nekie2@gmail.com', 'capturista', 'josem36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 9),
(82, 'antonio', 'RFC', 'augsagkagn345r2n', '2 de agosto', '31148945648', 'nekie@gmail.com', 'recepcionista', 'tony36', 'bcb1ac2aaaf1d367b9fd960eb0cee5709a3fd9d0c99a53b19795a32588353c3b', 'CAPTURISTA', 'user2.png', 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(95, 48, 1),
(96, 48, 2),
(97, 48, 3),
(98, 48, 5),
(99, 48, 6),
(112, 49, 1),
(113, 49, 3),
(114, 49, 5),
(115, 49, 8),
(120, 46, 6),
(121, 45, 6),
(172, 29, 1),
(173, 29, 2),
(174, 29, 4),
(175, 29, 7),
(176, 43, 6),
(177, 50, 1),
(178, 50, 2),
(179, 50, 4),
(180, 50, 7),
(185, 44, 1),
(186, 44, 3),
(187, 44, 5),
(188, 44, 8),
(189, 52, 1),
(190, 52, 3),
(191, 52, 5),
(192, 52, 8),
(193, 53, 6),
(194, 54, 6),
(203, 56, 6),
(204, 1, 1),
(205, 1, 2),
(206, 1, 3),
(207, 1, 4),
(208, 1, 5),
(209, 1, 6),
(210, 1, 7),
(211, 1, 8),
(212, 57, 1),
(213, 57, 3),
(214, 57, 5),
(215, 57, 8),
(216, 58, 6),
(217, 60, 6),
(218, 61, 6),
(223, 62, 1),
(224, 62, 3),
(225, 62, 5),
(226, 62, 8),
(235, 66, 6),
(243, 74, 6),
(245, 63, 6),
(251, 76, 6),
(252, 75, 1),
(253, 75, 3),
(254, 75, 5),
(255, 75, 8),
(256, 77, 6),
(258, 78, 6),
(259, 31, 1),
(260, 31, 3),
(261, 31, 5),
(262, 31, 8),
(263, 79, 6),
(264, 47, 6),
(265, 55, 1),
(266, 55, 3),
(267, 55, 5),
(268, 55, 8),
(275, 81, 6),
(276, 80, 1),
(277, 80, 3),
(278, 80, 5),
(279, 80, 8),
(280, 82, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idestado`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`idhabitacion`),
  ADD KEY `fk_habitacion_hotel_idx` (`idhotel`),
  ADD KEY `fk_habitacion_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`idhotel`),
  ADD KEY `fk_hotel_estado_idx` (`idestado`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `registro_huesped`
--
ALTER TABLE `registro_huesped`
  ADD PRIMARY KEY (`idregistro_huesped`),
  ADD KEY `fk_registro_huesped_hotel_idx` (`idhotel`),
  ADD KEY `fk_registro_huesped_estado_idx` (`idestado`),
  ADD KEY `fk_registro_huesped_habitacion_idx` (`idhabitacion`),
  ADD KEY `fk_registro_huesped_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`),
  ADD KEY `fk_usuario_hotel_idx` (`idhotel`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`idusuario`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `idestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `idhabitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `hotel`
--
ALTER TABLE `hotel`
  MODIFY `idhotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `registro_huesped`
--
ALTER TABLE `registro_huesped`
  MODIFY `idregistro_huesped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `fk_habitacion_hotel` FOREIGN KEY (`idhotel`) REFERENCES `hotel` (`idhotel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_habitacion_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `fk_hotel_estado` FOREIGN KEY (`idestado`) REFERENCES `estado` (`idestado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `registro_huesped`
--
ALTER TABLE `registro_huesped`
  ADD CONSTRAINT `fk_registro_huesped_estado` FOREIGN KEY (`idestado`) REFERENCES `estado` (`idestado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registro_huesped_habitacion` FOREIGN KEY (`idhabitacion`) REFERENCES `habitacion` (`idhabitacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registro_huesped_hotel` FOREIGN KEY (`idhotel`) REFERENCES `hotel` (`idhotel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registro_huesped_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_hotel` FOREIGN KEY (`idhotel`) REFERENCES `hotel` (`idhotel`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_usuario_permiso_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
