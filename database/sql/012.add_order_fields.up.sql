CREATE TABLE IF NOT EXISTS payment_method (
  `payment_method_id` TINYINT UNSIGNED NOT NULL,
  `payment_method` VARCHAR(125) NOT NULL,
  PRIMARY KEY (`payment_method_id`))
ENGINE = InnoDB;

INSERT INTO payment_method (payment_method_id, payment_method)
  VALUES
  (1, 'Credit card'),
  (2, 'Cash / Check');


CREATE TABLE IF NOT EXISTS order_status (
  `order_status_id` TINYINT UNSIGNED NOT NULL,
  `order_status` VARCHAR(125) NOT NULL,
  PRIMARY KEY (`order_status_id`))
ENGINE = InnoDB;

INSERT INTO order_status (order_status_id, order_status)
  VALUES
  (1, 'Initial'),
  (2, 'Pending'),
  (3, 'Failed'),
  (4, 'Successful');


ALTER TABLE `order`
ADD COLUMN payment_method_id TINYINT UNSIGNED NOT NULL,
ADD FOREIGN KEY fk_order_1(payment_method_id) REFERENCES payment_method (payment_method_id);

ALTER TABLE `order`
ADD COLUMN order_status_id TINYINT UNSIGNED NOT NULL,
ADD FOREIGN KEY fk_order_2(order_status_id) REFERENCES order_status (order_status_id);

ALTER TABLE `order`
ADD COLUMN total decimal(7,2) NOT NULL,
ADD COLUMN created_at DATETIME NOT NULL,
ADD COLUMN updated_at DATETIME NOT NULL;

ALTER TABLE `order`
DROP COLUMN order_uuid;

CREATE TABLE IF NOT EXISTS processor_transaction (
  `order_id` INT NOT NULL,
  `processor_transaction_id` VARCHAR(255) NOT NULL,
  `response_code` VARCHAR(125) NOT NULL,
  PRIMARY KEY (`order_id`),
  CONSTRAINT `fk_processor_transaction1`
  FOREIGN KEY (`order_id`)
  REFERENCES `order` (`order_id`))
ENGINE = InnoDB;
