<?php

//**************************************************
//                     settings
//**************************************************

// константа - корень приложения
define('APP', realpath(__DIR__ . '/../../application'));

// Подгрузим роутер с автоподгрузкой классов
// еще он разбирает uri и сопоставляет валидному роуту
// controller->action(), согласно ::set()
include (
	  APP . DIRECTORY_SEPARATOR
	. 'system' . DIRECTORY_SEPARATOR
	. 'Router.php'
);

//**************************************************
//                      begin
//**************************************************

$config = require (APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php');
$db = new mysqli($config['host'], $config['username'], $config['password']);

if ($db->connect_errno)
	die("Не удалось подключиться: {$db->connect_error}\n");


// создадим database
echo "Create database '$config[database]'.. ";
$db->query("CREATE DATABASE IF NOT EXISTS `$config[database]`;");
echo $db->error."\n";


echo "Select database '$config[database]'\n";
$db->select_db($config['database']);
echo $db->error."\n";


// создадим таблицу city
echo "Create table 'city'.. ";
$db->query("
CREATE TABLE city (
	`city_id`                 SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`city_name`               VARCHAR(50)         NOT NULL,

	PRIMARY KEY (city_id)
) ENGINE=InnoDB CHARACTER SET=UTF8;"
);
echo $db->error."\n";

// создадим таблицу street
echo "Create table 'street'.. ";
$db->query("
CREATE TABLE street (
	`street_id`               SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`street_name`             VARCHAR(100)        NOT NULL,
	`city_id`                 SMALLINT UNSIGNED   NOT NULL,

	PRIMARY KEY (street_id),
	FOREIGN KEY (city_id) REFERENCES city (city_id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;"
);
echo $db->error."\n";

// создадим таблицу contact
echo "Create table 'contact'.. ";
$db->query("
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
) ENGINE=InnoDB CHARACTER SET=UTF8;"
);
echo $db->error."\n";

// создадим таблицу phone
echo "Create table 'phone'.. ";
$db->query("
CREATE TABLE phone (
	`phone_id`                SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`phone_number`            VARCHAR(50),
	`contact_id`              SMALLINT UNSIGNED   NOT NULL,

	PRIMARY KEY (phone_id),
	FOREIGN KEY (contact_id) REFERENCES contact (contact_id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;"
);
echo $db->error."\n";

// закончим работать с базой
$db->close();
