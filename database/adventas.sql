/*
Navicat MySQL Data Transfer

Source Server         : ConexionXammp
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : adventas

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-31 09:21:04
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
  `stok` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `imagen` varchar(50) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idarticulo`),
  KEY `idcategoria` (`idcategoria`),
  CONSTRAINT `articulo_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of detalle_ingreso
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_venta
-- ----------------------------
DROP TABLE IF EXISTS `detalle_venta`;
CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ingreso
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of persona
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of venta
-- ----------------------------
