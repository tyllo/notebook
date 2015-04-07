<?php

// настройки для соединения с базой данных

return [
	'base'      => 'mysql',
	'username'  => 'test',
	'password'  => '1014',
	'host'      => '127.0.0.1',
	'database'  => 'notebook',
];

/*
/////////////////////////////////////////////////////////////////////////////
CREATE DATABASE IF NOT EXISTS `notebook`;

CREATE TABLE city (
	`city_id`                 SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`city_name`               VARCHAR(50)         NOT NULL,

	PRIMARY KEY (city_id)
) ENGINE=InnoDB CHARACTER SET=UTF8;
/////////////////////////////////////////////////////////////////////////////
CREATE TABLE street (
	`street_id`               SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`street_name`             VARCHAR(100)        NOT NULL,
	`city_id`                 SMALLINT UNSIGNED   NOT NULL,

	PRIMARY KEY (street_id),
	FOREIGN KEY (city_id) REFERENCES city (city_id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;
/////////////////////////////////////////////////////////////////////////////
CREATE TABLE contact (
	`contact_id`              SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`contact_name`            VARCHAR(50)         NOT NULL,
	`contact_surname`         VARCHAR(50)         NOT NULL,
	`contact_patronymic`      VARCHAR(50)         NOT NULL,
	`contact_date`            DATE                DEFAULT NULL,
	`street_id`               SMALLINT UNSIGNED   NOT NULL,

	PRIMARY KEY (contact_id),
	FOREIGN KEY (street_id) REFERENCES street (street_id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;
/////////////////////////////////////////////////////////////////////////////
CREATE TABLE phone (
	`phone_id`                SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`phone_number`            VARCHAR(50),
	`contact_id`              SMALLINT UNSIGNED   NOT NULL,

	PRIMARY KEY (phone_id),
	FOREIGN KEY (contact_id) REFERENCES contact (contact_id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;
/////////////////////////////////////////////////////////////////////////////

*/