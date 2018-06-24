
CREATE TABLE IF NOT EXISTS `mydb`.`usuarios` (
  `idusuarios` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `tipo` VARCHAR(10) NULL,
  PRIMARY KEY (`idusuarios`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cines`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`cines` (
  `idcines` INT NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` INT NOT NULL,
  `nombreCine` VARCHAR(45) NOT NULL,
  `descripcionCine` VARCHAR(45) NULL,
  `horarioCine` VARCHAR(45) NULL,
  `logoCine` VARCHAR(45) NULL,
  `salasCine` INT NULL,
  `direccionCine` VARCHAR(45) NULL,
  `latitudCine` VARCHAR(45) NULL,
  `longitudCine` VARCHAR(45) NULL,
  `telefonoCine` VARCHAR(45) NULL,
  PRIMARY KEY (`idcines`, `usuarios_idusuarios`, `nombreCine`),
  INDEX `fk_cines_usuarios_idx` (`usuarios_idusuarios` ASC),
  UNIQUE INDEX `nombreCine_UNIQUE` (`nombreCine` ASC),
  UNIQUE INDEX `telefonoCine_UNIQUE` (`telefonoCine` ASC),
  CONSTRAINT `fk_cines_usuarios`
    FOREIGN KEY (`usuarios_idusuarios`)
    REFERENCES `mydb`.`usuarios` (`idusuarios`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`peliculas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`peliculas` (
  `idpeliculas` INT NOT NULL AUTO_INCREMENT,
  `cines_idcines` INT NOT NULL,
  `nombrePelicula` VARCHAR(45) NULL,
  `descripcionPelicula` VARCHAR(45) NULL,
  `anyoPelicula` INT NULL,
  `duracionPelicula` INT NULL,
  `imagenPelicula` VARCHAR(255) NULL,
  PRIMARY KEY (`idpeliculas`, `cines_idcines`),
  INDEX `fk_peliculas_cines1_idx` (`cines_idcines` ASC),
  UNIQUE INDEX `nombrePelicula_UNIQUE` (`nombrePelicula` ASC),
  UNIQUE INDEX `imagenPelicula_UNIQUE` (`imagenPelicula` ASC),
  CONSTRAINT `fk_peliculas_cines1`
    FOREIGN KEY (`cines_idcines`)
    REFERENCES `mydb`.`cines` (`idcines`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`directores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`directores` (
  `iddirectores` INT NOT NULL AUTO_INCREMENT,
  `nombreDirectores` VARCHAR(45) NULL,
  PRIMARY KEY (`iddirectores`),
  UNIQUE INDEX `nombreDirectores_UNIQUE` (`nombreDirectores` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`generos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`generos` (
  `idgeneros` INT NOT NULL AUTO_INCREMENT,
  `nombreGeneros` VARCHAR(45) NULL,
  PRIMARY KEY (`idgeneros`),
  UNIQUE INDEX `nombreGeneros_UNIQUE` (`nombreGeneros` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`generos_has_peliculas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`generos_has_peliculas` (
  `generos_idgeneros` INT NOT NULL,
  `peliculas_idpeliculas` INT NOT NULL,
  PRIMARY KEY (`generos_idgeneros`, `peliculas_idpeliculas`),
  INDEX `fk_generos_has_peliculas_peliculas1_idx` (`peliculas_idpeliculas` ASC),
  INDEX `fk_generos_has_peliculas_generos1_idx` (`generos_idgeneros` ASC),
  CONSTRAINT `fk_generos_has_peliculas_generos1`
    FOREIGN KEY (`generos_idgeneros`)
    REFERENCES `mydb`.`generos` (`idgeneros`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_generos_has_peliculas_peliculas1`
    FOREIGN KEY (`peliculas_idpeliculas`)
    REFERENCES `mydb`.`peliculas` (`idpeliculas`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`directores_has_peliculas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`directores_has_peliculas` (
  `directores_iddirectores` INT NOT NULL,
  `peliculas_idpeliculas` INT NOT NULL,
  PRIMARY KEY (`directores_iddirectores`, `peliculas_idpeliculas`),
  INDEX `fk_directores_has_peliculas_peliculas1_idx` (`peliculas_idpeliculas` ASC),
  INDEX `fk_directores_has_peliculas_directores1_idx` (`directores_iddirectores` ASC),
  CONSTRAINT `fk_directores_has_peliculas_directores1`
    FOREIGN KEY (`directores_iddirectores`)
    REFERENCES `mydb`.`directores` (`iddirectores`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_directores_has_peliculas_peliculas1`
    FOREIGN KEY (`peliculas_idpeliculas`)
    REFERENCES `mydb`.`peliculas` (`idpeliculas`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`actores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`actores` (
  `idactores` INT NOT NULL AUTO_INCREMENT,
  `nombreActor` VARCHAR(45) NULL,
  PRIMARY KEY (`idactores`),
  UNIQUE INDEX `nombreActor_UNIQUE` (`nombreActor` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`actores_has_peliculas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`actores_has_peliculas` (
  `actores_idactores` INT NOT NULL,
  `peliculas_idpeliculas` INT NOT NULL,
  `actores_has_peliculascol` VARCHAR(45) NULL,
  PRIMARY KEY (`actores_idactores`, `peliculas_idpeliculas`),
  INDEX `fk_actores_has_peliculas_peliculas1_idx` (`peliculas_idpeliculas` ASC),
  INDEX `fk_actores_has_peliculas_actores1_idx` (`actores_idactores` ASC),
  CONSTRAINT `fk_actores_has_peliculas_actores1`
    FOREIGN KEY (`actores_idactores`)
    REFERENCES `mydb`.`actores` (`idactores`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_actores_has_peliculas_peliculas1`
    FOREIGN KEY (`peliculas_idpeliculas`)
    REFERENCES `mydb`.`peliculas` (`idpeliculas`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



