-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema jcfk
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema jcfk
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `jcfk` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `jcfk` ;

-- -----------------------------------------------------
-- Table `jcfk`.`school`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`school` (
  `school_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(125) NOT NULL,
  `phone` VARCHAR(125) NOT NULL,
  `address` VARCHAR(500) NOT NULL,
  `postalcode` VARCHAR(45) NOT NULL,
  `website` VARCHAR(125) NULL,
  PRIMARY KEY (`school_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`order_form`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`order_form` (
  `order_form_id` INT NOT NULL AUTO_INCREMENT,
  `school_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`order_form_id`),
  INDEX `fk_order_form_school1_idx` (`school_id` ASC),
  CONSTRAINT `fk_order_form_school1`
    FOREIGN KEY (`school_id`)
    REFERENCES `jcfk`.`school` (`school_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`role` (
  `role_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`role_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`user` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(125) NOT NULL,
  `password` VARCHAR(125) NOT NULL,
  `role_id` INT UNSIGNED NOT NULL,
  `is_active` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `remember_token` VARCHAR(255) NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_user_role1_idx` (`role_id` ASC),
  CONSTRAINT `fk_user_role1`
    FOREIGN KEY (`role_id`)
    REFERENCES `jcfk`.`role` (`role_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`parent`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`parent` (
  `user_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `phone` INT NOT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_parent_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_parent_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `jcfk`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`teacher`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`teacher` (
  `teacher_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `school_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `room` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`teacher_id`),
  INDEX `fk_teacher_school1_idx` (`school_id` ASC),
  CONSTRAINT `fk_teacher_school1`
    FOREIGN KEY (`school_id`)
    REFERENCES `jcfk`.`school` (`school_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`student` (
  `student_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `teacher_id` INT UNSIGNED NOT NULL,
  `school_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `room` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`student_id`, `teacher_id`),
  INDEX `fk_student_school1_idx` (`school_id` ASC),
  INDEX `fk_student_parent1_idx` (`user_id` ASC),
  INDEX `fk_student_teacher1_idx` (`teacher_id` ASC),
  CONSTRAINT `fk_student_school1`
    FOREIGN KEY (`school_id`)
    REFERENCES `jcfk`.`school` (`school_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_parent1`
    FOREIGN KEY (`user_id`)
    REFERENCES `jcfk`.`parent` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_teacher1`
    FOREIGN KEY (`teacher_id`)
    REFERENCES `jcfk`.`teacher` (`teacher_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`order` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `order_uuid` CHAR(32) NOT NULL,
  `order_form_id` INT NOT NULL,
  `steudent_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`order_id`, `order_form_id`),
  UNIQUE INDEX `order_uuid_UNIQUE` (`order_uuid` ASC),
  INDEX `fk_order_order_form1_idx` (`order_form_id` ASC),
  INDEX `fk_order_student1_idx` (`steudent_id` ASC),
  CONSTRAINT `fk_order_order_form1`
    FOREIGN KEY (`order_form_id`)
    REFERENCES `jcfk`.`order_form` (`order_form_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_student1`
    FOREIGN KEY (`steudent_id`)
    REFERENCES `jcfk`.`student` (`student_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`meal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`meal` (
  `meal_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `meal_name` VARCHAR(125) NULL,
  PRIMARY KEY (`meal_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`menu_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`menu_items` (
  `item_id` INT UNSIGNED NOT NULL,
  `date` DATE NOT NULL,
  `meal_id` INT UNSIGNED NOT NULL,
  `order_form_id` INT NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY (`date`, `meal_id`, `order_form_id`),
  INDEX `fk_day_menu_order_form1_idx` (`order_form_id` ASC),
  CONSTRAINT `fk_day_menu_order_form1`
    FOREIGN KEY (`order_form_id`)
    REFERENCES `jcfk`.`order_form` (`order_form_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `jcfk`.`order_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`order_items` (
  `order_id` INT NOT NULL,
  `item_id` INT UNSIGNED NOT NULL,
  `price` DECIMAL(7,2) NOT NULL,
  PRIMARY KEY (`order_id`, `item_id`),
  CONSTRAINT `fk_order_items_order`
    FOREIGN KEY (`order_id`)
    REFERENCES `jcfk`.`order` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_items_day_meal1`
    FOREIGN KEY (`item_id`)
    REFERENCES `jcfk`.`menu_items` (`item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jcfk`.`school_meal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jcfk`.`school_meal` (
  `school_id` INT UNSIGNED NOT NULL,
  `meal_id` INT UNSIGNED NOT NULL,
  `price` DECIMAL(7,2) NOT NULL,
  PRIMARY KEY (`school_id`, `meal_id`),
  INDEX `fk_school_meal_school1_idx` (`school_id` ASC),
  CONSTRAINT `fk_school_meal_meal1`
    FOREIGN KEY (`meal_id`)
    REFERENCES `jcfk`.`meal` (`meal_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_school_meal_school1`
    FOREIGN KEY (`school_id`)
    REFERENCES `jcfk`.`school` (`school_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
