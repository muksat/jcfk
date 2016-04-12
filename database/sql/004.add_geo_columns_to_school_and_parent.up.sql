ALTER TABLE school
ADD COLUMN city_id int(10) unsigned NOT NULL,
ADD FOREIGN KEY fk_school_1(city_id) REFERENCES cities (city_id);

ALTER TABLE school
ADD COLUMN region char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
ADD FOREIGN KEY fk_school_2(region) REFERENCES regions (`code`);
