CREATE DATABASE  IF NOT EXISTS `CFE` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `CFE`;
-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: CFE
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Puesto`
--

DROP TABLE IF EXISTS `Puesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Puesto` (
  `pst_id` varchar(8) NOT NULL COMMENT 'Clave del Puesto',
  `pst_nombre` varchar(45) NOT NULL COMMENT 'Nombre del Puesto',
  PRIMARY KEY (`pst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Puesto`
--

LOCK TABLES `Puesto` WRITE;
/*!40000 ALTER TABLE `Puesto` DISABLE KEYS */;
INSERT INTO `Puesto` VALUES ('00000000','Temporal'),('00000001','Puesto 1'),('00000002','Puesto 2'),('00000003','Puesto 3'),('00000004','Puesto 4'),('00000005','Puesto 5'),('00000006','Puesto 6'),('00000007','Puesto 7'),('00000008','Puesto 8'),('00000009','Puesto 9'),('00000010','Puesto 10'),('00000011','Puesto 11'),('00000012','Puesto 12');
/*!40000 ALTER TABLE `Puesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Capacidad`
--

DROP TABLE IF EXISTS `Capacidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Capacidad` (
  `cap_puntuacion` int(11) NOT NULL DEFAULT '0',
  `cap_puesto` varchar(8) NOT NULL,
  `cap_empleado` varchar(5) NOT NULL,
  PRIMARY KEY (`cap_puesto`,`cap_empleado`),
  KEY `fk_Capacidad_Puesto` (`cap_puesto`),
  KEY `fk_Capacidad_Empleado` (`cap_empleado`),
  CONSTRAINT `fk_Capacidad_Empleado` FOREIGN KEY (`cap_empleado`) REFERENCES `Empleado` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Capacidad_Puesto` FOREIGN KEY (`cap_puesto`) REFERENCES `Puesto` (`pst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Capacidad`
--

LOCK TABLES `Capacidad` WRITE;
/*!40000 ALTER TABLE `Capacidad` DISABLE KEYS */;
INSERT INTO `Capacidad` VALUES (0,'00000001','00001'),(0,'00000002','00010'),(0,'00000003','00011'),(0,'00000003','00111'),(0,'00000004','00100'),(0,'00000005','00101'),(0,'00000006','00110'),(0,'00000007','00111'),(0,'00000007','10000'),(0,'00000008','01000');
/*!40000 ALTER TABLE `Capacidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Usuario` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_nombre` varchar(30) NOT NULL,
  `usu_password` varchar(30) NOT NULL,
  `usu_empleado` varchar(5) NOT NULL,
  PRIMARY KEY (`usu_id`),
  KEY `fk_Usuario_Empleado` (`usu_empleado`),
  CONSTRAINT `fk_Usuario_Empleado` FOREIGN KEY (`usu_empleado`) REFERENCES `Empleado` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuario`
--

LOCK TABLES `Usuario` WRITE;
/*!40000 ALTER TABLE `Usuario` DISABLE KEYS */;
INSERT INTO `Usuario` VALUES (1,'hapu','password','10100');
/*!40000 ALTER TABLE `Usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Empleado`
--

DROP TABLE IF EXISTS `Empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Empleado` (
  `emp_id` varchar(5) NOT NULL COMMENT 'Clave del Empleado',
  `emp_nombre` varchar(45) NOT NULL COMMENT 'Nombre del Empleado',
  `emp_puesto` varchar(8) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empleado`
--

LOCK TABLES `Empleado` WRITE;
/*!40000 ALTER TABLE `Empleado` DISABLE KEYS */;
INSERT INTO `Empleado` VALUES ('00001','Sophia Smith','00000001'),('00010','Emma Johnson','00000002'),('00011','Isabella Williams','00000003'),('00100','Jacob Brown','00000004'),('00101','Mason Jones','00000005'),('00110','Ethan Miller','00000006'),('00111','Noah Davis','00000007'),('01000','Olivia Garcia','00000008'),('01001','William Rodriguez','00000009'),('01010','Liam Wilson','00000010'),('01011','Jayden Martinez','00000011'),('01100','Michael Anderson','00000012'),('01101','Ava Taylor','00000013'),('01110','Alexander Thomas','00000014'),('01111','Aiden Hernandez','00000015'),('10000','Daniel Moore','00000000'),('10001','Matthew Martin','00000000'),('10010','Elijah Jackson','00000000'),('10011','Emily Thompson','00000000'),('10100','James White','00000000');
/*!40000 ALTER TABLE `Empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Incidencia`
--

DROP TABLE IF EXISTS `Incidencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Incidencia` (
  `inci_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la Ausencia',
  `inci_inicio` date NOT NULL COMMENT 'Inicio de Ausencia',
  `inci_fin` date NOT NULL COMMENT 'Fin de la Ausencia',
  `inci_concepto` varchar(45) NOT NULL,
  `inci_empleado` varchar(5) NOT NULL,
  `inci_usuario` int(11) NOT NULL,
  PRIMARY KEY (`inci_id`),
  KEY `fk_Insidencia_Empleado` (`inci_empleado`),
  KEY `fk_Incidencia_Usuario` (`inci_usuario`),
  CONSTRAINT `fk_Incidencia_Usuario` FOREIGN KEY (`inci_usuario`) REFERENCES `Usuario` (`usu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Insidencia_Empleado` FOREIGN KEY (`inci_empleado`) REFERENCES `Empleado` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Incidencia`
--

LOCK TABLES `Incidencia` WRITE;
/*!40000 ALTER TABLE `Incidencia` DISABLE KEYS */;
INSERT INTO `Incidencia` VALUES (8,'2014-01-17','2014-01-24','Vacaciones','01110',1),(9,'2014-01-07','2014-01-14','Vacaciones','00001',1),(10,'2014-01-07','2014-01-14','Vacaciones','00010',1),(11,'2014-01-07','2014-01-14','Vacaciones','00011',1),(12,'2014-01-07','2014-01-14','Vacaciones','00100',1),(13,'2014-01-07','2014-01-14','Vacaciones','00101',1),(14,'2014-01-07','2014-01-14','Vacaciones','00110',1),(15,'2014-01-17','2014-01-24','Vacaciones','00001',1),(16,'2014-01-17','2014-01-24','Vacaciones','00010',1),(17,'2014-01-17','2014-01-24','Vacaciones','00011',1),(18,'2014-01-17','2014-01-24','Vacaciones','01100',1),(19,'2014-01-17','2014-01-24','Vacaciones','01101',1),(20,'2014-01-17','2014-01-24','Vacaciones','01110',1);
/*!40000 ALTER TABLE `Incidencia` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-12 11:17:43
