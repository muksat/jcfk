DROP TABLE IF EXISTS school_meal;
ALTER TABLE menu_items MODIFY `item_id` INT(10) UNSIGNED NOT NULL;
CREATE INDEX old_pk_unique ON order_items (`order_id`, `item_id`);
ALTER TABLE order_items DROP PRIMARY KEY;
ALTER TABLE order_items DROP FOREIGN KEY `fk_order_items_day_meal1`;
ALTER TABLE order_items DROP COLUMN item_id;
ALTER TABLE order_items
    ADD COLUMN `date` DATE NOT NULL AFTER order_id,
    ADD COLUMN `meal_id` INT UNSIGNED NOT NULL AFTER `date`;
ALTER TABLE order_items ADD PRIMARY KEY (`order_id`, `date`);
DROP INDEX  old_pk_unique ON order_items;
ALTER TABLE menu_items DROP PRIMARY KEY;
ALTER TABLE menu_items DROP COLUMN item_id;
ALTER TABLE menu_items ADD PRIMARY KEY (`order_form_id`, `date`, `meal_id`);
DROP INDEX `date` ON menu_items;
ALTER TABLE school ADD COLUMN meal_price decimal(7,2) NOT NULL;
