SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `CFE` ;
CREATE SCHEMA IF NOT EXISTS `CFE` DEFAULT CHARACTER SET utf8 ;
USE `CFE` ;

-- -----------------------------------------------------
-- Table `CFE`.`Empleado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Empleado` ;

CREATE  TABLE IF NOT EXISTS `CFE`.`Empleado` (
  `emp_id` VARCHAR(5) NOT NULL COMMENT 'Clave del Empleado' ,
  `emp_nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre del Empleado' ,
  `emp_puesto` VARCHAR(8) NOT NULL ,
  PRIMARY KEY (`emp_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CFE`.`Puesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Puesto` ;

CREATE  TABLE IF NOT EXISTS `CFE`.`Puesto` (
  `pst_id` VARCHAR(8) NOT NULL COMMENT 'Clave del Puesto' ,
  `pst_nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre del Puesto' ,
  PRIMARY KEY (`pst_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CFE`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Usuario` ;

CREATE  TABLE IF NOT EXISTS `CFE`.`Usuario` (
  `usu_id` INT NOT NULL AUTO_INCREMENT ,
  `usu_nombre` VARCHAR(30) NOT NULL ,
  `usu_password` VARCHAR(30) NOT NULL ,
  `usu_empleado` VARCHAR(5) NOT NULL ,
  PRIMARY KEY (`usu_id`) ,
  INDEX `fk_Usuario_Empleado` (`usu_empleado` ASC) ,
  CONSTRAINT `fk_Usuario_Empleado`
    FOREIGN KEY (`usu_empleado` )
    REFERENCES `CFE`.`Empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CFE`.`Incidencia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Incidencia` ;

CREATE  TABLE IF NOT EXISTS `CFE`.`Incidencia` (
  `inci_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la Ausencia' ,
  `inci_inicio` DATE NOT NULL COMMENT 'Inicio de Ausencia' ,
  `inci_fin` DATE NOT NULL COMMENT 'Fin de la Ausencia' ,
  `inci_concepto` VARCHAR(45) NOT NULL ,
  `inci_empleado` VARCHAR(5) NOT NULL ,
  `inci_usuario` INT NOT NULL ,
  PRIMARY KEY (`inci_id`) ,
  INDEX `fk_Insidencia_Empleado` (`inci_empleado` ASC) ,
  INDEX `fk_Incidencia_Usuario` (`inci_usuario` ASC) ,
  CONSTRAINT `fk_Insidencia_Empleado`
    FOREIGN KEY (`inci_empleado` )
    REFERENCES `CFE`.`Empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Incidencia_Usuario`
    FOREIGN KEY (`inci_usuario` )
    REFERENCES `CFE`.`Usuario` (`usu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CFE`.`Capacidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Capacidad` ;

CREATE  TABLE IF NOT EXISTS `CFE`.`Capacidad` (
  `cap_puntuacion` INT NOT NULL DEFAULT 0 ,
  `cap_puesto` VARCHAR(8) NOT NULL ,
  `cap_empleado` VARCHAR(5) NOT NULL ,
  INDEX `fk_Capacidad_Puesto` (`cap_puesto` ASC) ,
  INDEX `fk_Capacidad_Empleado` (`cap_empleado` ASC) ,
  PRIMARY KEY (`cap_puesto`, `cap_empleado`) ,
  CONSTRAINT `fk_Capacidad_Puesto`
    FOREIGN KEY (`cap_puesto` )
    REFERENCES `CFE`.`Puesto` (`pst_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Capacidad_Empleado`
    FOREIGN KEY (`cap_empleado` )
    REFERENCES `CFE`.`Empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
