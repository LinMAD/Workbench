SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema test_app
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `test_app` DEFAULT CHARACTER SET utf8 ;
USE `test_app` ;

-- -----------------------------------------------------
-- Table `test_app`.`Customer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_app`.`Customer` ;

CREATE TABLE IF NOT EXISTS `test_app`.`Customer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE UNIQUE INDEX `email_UNIQUE` ON `test_app`.`Customer` (`email` ASC);


-- -----------------------------------------------------
-- Table `test_app`.`Order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_app`.`Order` ;

CREATE TABLE IF NOT EXISTS `test_app`.`Order` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `country` VARCHAR(2) NOT NULL COMMENT 'ISO \"ALPHA-2 Code',
  `device` VARCHAR(255) NOT NULL,
  `Customer_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Order_Customer`
    FOREIGN KEY (`Customer_id`)
    REFERENCES `test_app`.`Customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE INDEX `fk_Order_Customer_idx` ON `test_app`.`Order` (`Customer_id` ASC);

-- -----------------------------------------------------
-- Table `test_app`.`Order_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_app`.`Order_items` ;

CREATE TABLE IF NOT EXISTS `test_app`.`Order_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ean` VARCHAR(255) NOT NULL,
  `quantity` SMALLINT UNSIGNED NOT NULL,
  `price` MEDIUMINT UNSIGNED NOT NULL COMMENT 'Price in minor units',
  `Order_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `Order_id`),
  CONSTRAINT `fk_Order_items_Order1`
    FOREIGN KEY (`Order_id`)
    REFERENCES `test_app`.`Order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE INDEX `fk_Order_items_Order1_idx` ON `test_app`.`Order_items` (`Order_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
