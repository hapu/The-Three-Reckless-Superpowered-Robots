SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `CFE`.`Empleado` (
  `idEmpleado` INT(11) NOT NULL COMMENT 'Clave del Empleado' ,
  `NombreEmpleado` VARCHAR(45) NOT NULL COMMENT 'Nombre del Empleado' ,
  `Puesto_idPuesto` INT(11) NOT NULL ,
  PRIMARY KEY (`idEmpleado`) ,
  INDEX `fk_Empleado_Puesto1` (`Puesto_idPuesto` ASC) ,
  CONSTRAINT `fk_Empleado_Puesto1`
    FOREIGN KEY (`Puesto_idPuesto` )
    REFERENCES `CFE`.`Puesto` (`idPuesto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `CFE`.`Puesto` (
  `idPuesto` INT(11) NOT NULL COMMENT 'Clave del Puesto' ,
  `NombrePuesto` VARCHAR(45) NOT NULL COMMENT 'Nombre del Puesto' ,
  PRIMARY KEY (`idPuesto`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `CFE`.`Insidencia` (
  `idInsidencia` INT(11) NOT NULL COMMENT 'Identificador de la Ausencia' ,
  `Inicio` DATE NOT NULL COMMENT 'Inicio de Ausencia' ,
  `Fin` DATE NOT NULL COMMENT 'Fin de la Ausencia' ,
  `Concepto` VARCHAR(45) NOT NULL ,
  `Empleado_idEmpleado` INT(11) NOT NULL ,
  PRIMARY KEY (`idInsidencia`) ,
  INDEX `fk_Insidencia_Empleado1_idx` (`Empleado_idEmpleado` ASC) ,
  CONSTRAINT `fk_Insidencia_Empleado1`
    FOREIGN KEY (`Empleado_idEmpleado` )
    REFERENCES `CFE`.`Empleado` (`idEmpleado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `CFE`.`Capacidad` (
  `idCapacidad` INT(11) NOT NULL ,
  `NombreCapacidad` VARCHAR(45) NOT NULL ,
  `Puesto_idPuesto` INT(11) NOT NULL ,
  `Empleado_idEmpleado` INT(11) NOT NULL ,
  PRIMARY KEY (`idCapacidad`) ,
  INDEX `fk_Capacidad_Puesto1` (`Puesto_idPuesto` ASC) ,
  INDEX `fk_Capacidad_Empleado1` (`Empleado_idEmpleado` ASC) ,
  CONSTRAINT `fk_Capacidad_Puesto1`
    FOREIGN KEY (`Puesto_idPuesto` )
    REFERENCES `CFE`.`Puesto` (`idPuesto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Capacidad_Empleado1`
    FOREIGN KEY (`Empleado_idEmpleado` )
    REFERENCES `CFE`.`Empleado` (`idEmpleado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `CFE`.`Usuario` (
  `idUsuario` INT(11) NOT NULL ,
  `Nombre` VARCHAR(30) NOT NULL ,
  `Contraseña` VARCHAR(30) NOT NULL ,
  `Empleado_idEmpleado` INT(11) NOT NULL ,
  `Insidencia_idInsidencia` INT(11) NOT NULL ,
  PRIMARY KEY (`idUsuario`) ,
  INDEX `fk_Usuario_Empleado1_idx` (`Empleado_idEmpleado` ASC) ,
  INDEX `fk_Usuario_Insidencia1` (`Insidencia_idInsidencia` ASC) ,
  CONSTRAINT `fk_Usuario_Empleado1`
    FOREIGN KEY (`Empleado_idEmpleado` )
    REFERENCES `CFE`.`Empleado` (`idEmpleado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_Insidencia1`
    FOREIGN KEY (`Insidencia_idInsidencia` )
    REFERENCES `CFE`.`Insidencia` (`idInsidencia` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

DROP TABLE IF EXISTS `CFE`.`Empleados` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
