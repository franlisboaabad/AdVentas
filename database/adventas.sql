/*
Navicat MySQL Data Transfer

Source Server         : ConexionXammp
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : adventas

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-11-04 14:05:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for articulo
-- ----------------------------
DROP TABLE IF EXISTS `articulo`;
CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idarticulo`),
  KEY `idcategoria` (`idcategoria`),
  CONSTRAINT `articulo_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of articulo
-- ----------------------------

-- ----------------------------
-- Table structure for categoria
-- ----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of categoria
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_ingreso
-- ----------------------------
DROP TABLE IF EXISTS `detalle_ingreso`;
CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `idingreso` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(8,2) NOT NULL,
  `precio_venta` decimal(8,2) NOT NULL,
  PRIMARY KEY (`iddetalle_ingreso`),
  KEY `idarticulo` (`idarticulo`),
  KEY `idingreso` (`idingreso`),
  CONSTRAINT `detalle_ingreso_ibfk_1` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `detalle_ingreso_ibfk_2` FOREIGN KEY (`idingreso`) REFERENCES `ingreso` (`idingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Actualizar stock de mi tabla productos | despues de insertar un detalle ingreso';

-- ----------------------------
-- Records of detalle_ingreso
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_venta
-- ----------------------------
DROP TABLE IF EXISTS `detalle_venta`;
CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `idventa` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(8,2) NOT NULL,
  `descuento` decimal(8,2) NOT NULL,
  PRIMARY KEY (`iddetalle_venta`),
  KEY `idventa` (`idventa`),
  KEY `idarticulo` (`idarticulo`),
  CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of detalle_venta
-- ----------------------------

-- ----------------------------
-- Table structure for ingreso
-- ----------------------------
DROP TABLE IF EXISTS `ingreso`;
CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL AUTO_INCREMENT,
  `idproveedor` int(11) DEFAULT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(8,2) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idingreso`),
  KEY `idproveedor` (`idproveedor`),
  CONSTRAINT `ingreso_ibfk_1` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ingreso
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------

-- ----------------------------
-- Table structure for persona
-- ----------------------------
DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_persona` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo_documento` varchar(50) DEFAULT NULL,
  `num_documento` varchar(15) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of persona
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Frank Lisboa Abad', 'franklisboaabad@gmail.com', '$2y$10$dQvRVNmaJA3Jm0CR5iA.3ONSq8t6d9dLs4m8unmDGao4YMIO4r3Jy', null, '2017-11-03 08:53:38', '2017-11-03 08:53:38');
INSERT INTO `users` VALUES ('2', 'fransis', 'ideassoftwarepiura@gmail.com', '$2y$10$UJZRc4Fu1MK80X7EinFS7OxkOLoBxhPaEsgWGrxXRk.e96C/OHFlq', null, '2017-11-03 11:18:45', '2017-11-03 11:18:45');

-- ----------------------------
-- Table structure for venta
-- ----------------------------
DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) NOT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(8,2) NOT NULL,
  `total_venta` decimal(8,2) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idventa`),
  KEY `idusuario` (`idusuario`),
  KEY `idcliente` (`idcliente`),
  CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of venta
-- ----------------------------
DROP TRIGGER IF EXISTS `StockIngreso`;
DELIMITER ;;
CREATE TRIGGER `StockIngreso` BEFORE INSERT ON `detalle_ingreso` FOR EACH ROW UPDATE  articulo SET stock = stock + NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `stockVenta`;
DELIMITER ;;
CREATE TRIGGER `stockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW UPDATE articulo SET stock = stock - NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo
;;
DELIMITER ;
