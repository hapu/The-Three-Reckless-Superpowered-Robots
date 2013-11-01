SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `CFE` ;
CREATE SCHEMA IF NOT EXISTS `CFE` DEFAULT CHARACTER SET latin1 ;
SHOW WARNINGS;
USE `CFE` ;

-- -----------------------------------------------------
-- Table `CFE`.`Empleado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Empleado` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `CFE`.`Empleado` (
  `emp_id` VARCHAR(5) NOT NULL COMMENT 'Clave del Empleado' ,
  `emp_nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre del Empleado' ,
  `Puesto_pst_id` INT(11) NULL ,
  PRIMARY KEY (`emp_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `CFE`.`Puesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Puesto` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `CFE`.`Puesto` (
  `pst_id` INT(11) NOT NULL COMMENT 'Clave del Puesto' ,
  `pst_nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre del Puesto' ,
  PRIMARY KEY (`pst_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `CFE`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Usuario` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `CFE`.`Usuario` (
  `usu_id` INT NOT NULL ,
  `usu_nombre` VARCHAR(30) NOT NULL ,
  `usu_password` VARCHAR(30) NOT NULL ,
  `usu_empleado` VARCHAR(5) NOT NULL ,
  PRIMARY KEY (`usu_id`) ,
  CONSTRAINT `fk_Usuario_Empleado`
    FOREIGN KEY (`usu_empleado` )
    REFERENCES `CFE`.`Empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_Usuario_Empleado` ON `CFE`.`Usuario` (`usu_empleado` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `CFE`.`Incidencia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Incidencia` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `CFE`.`Incidencia` (
  `inci_id` INT NOT NULL COMMENT 'Identificador de la Ausencia' ,
  `inci_inicio` DATE NOT NULL COMMENT 'Inicio de Ausencia' ,
  `inci_fin` DATE NOT NULL COMMENT 'Fin de la Ausencia' ,
  `inci_concepto` VARCHAR(45) NOT NULL ,
  `inci_empleado` VARCHAR(5) NOT NULL ,
  `inci_usuario` INT NOT NULL ,
  PRIMARY KEY (`inci_id`) ,
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

SHOW WARNINGS;
CREATE INDEX `fk_Insidencia_Empleado` ON `CFE`.`Incidencia` (`inci_empleado` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_Incidencia_Usuario` ON `CFE`.`Incidencia` (`inci_usuario` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `CFE`.`Capacidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CFE`.`Capacidad` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `CFE`.`Capacidad` (
  `cap_id` INT(11) NOT NULL ,
  `cap_nombre` VARCHAR(45) NULL ,
  `cap_puesto` INT(11) NOT NULL ,
  `cap_empleado` VARCHAR(5) NOT NULL ,
  PRIMARY KEY (`cap_id`) ,
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

SHOW WARNINGS;
CREATE INDEX `fk_Capacidad_Puesto` ON `CFE`.`Capacidad` (`cap_puesto` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_Capacidad_Empleado` ON `CFE`.`Capacidad` (`cap_empleado` ASC) ;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
