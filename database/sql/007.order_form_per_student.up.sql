ALTER TABLE `order` DROP FOREIGN KEY `fk_order_student1`;
ALTER TABLE `order` DROP COLUMN steudent_id;

CREATE INDEX old_pk_unique ON `order`  (`order_id`);
ALTER TABLE `order` DROP PRIMARY KEY;
ALTER TABLE `order` DROP FOREIGN KEY `fk_order_order_form1`;
ALTER TABLE `order` DROP COLUMN order_form_id;
ALTER TABLE `order` ADD PRIMARY KEY (`order_id`);
DROP INDEX  old_pk_unique ON `order`;

CREATE TABLE IF NOT EXISTS `jcfk`.`order_cart` (
  `order_cart_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `order_form_id` INT(11) NOT NULL,
  `student_id` INT(10) UNSIGNED NOT NULL,
  INDEX `fk_student_order_form_order_form1_idx` (`order_form_id` ASC),
  INDEX `fk_student_order_form_student1_idx` (`student_id` ASC),
  PRIMARY KEY (`order_cart_id`),
  CONSTRAINT `fk_student_order_form_order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `jcfk`.`order` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_order_form_order_form1`
    FOREIGN KEY (`order_form_id`)
    REFERENCES `jcfk`.`order_form` (`order_form_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_order_form_student1`
    FOREIGN KEY (`student_id`)
    REFERENCES `jcfk`.`student` (`student_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX old_pk_unique ON `order_items` (`date`);
ALTER TABLE `order_items` DROP FOREIGN KEY `fk_order_items_order`;
ALTER TABLE `order_items` DROP PRIMARY KEY;

ALTER TABLE order_items
ADD COLUMN order_cart_id int(11) unsigned NOT NULL,
ADD FOREIGN KEY fk_order_items_order_2(order_cart_id) REFERENCES order_cart (order_cart_id);

ALTER TABLE `order_items` ADD PRIMARY KEY (`order_cart_id`, `date`);
DROP INDEX  old_pk_unique ON `order_items`;