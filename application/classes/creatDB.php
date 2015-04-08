<?php

//**************************************************
//                     settings
//**************************************************

// константа - корень приложения
if ( !defined('APP') ):
	define('APP', realpath(__DIR__ . '/../../application'));

	// Подгрузим роутер с автоподгрузкой классов
	// еще он разбирает uri и сопоставляет валидному роуту
	// controller->action(), согласно ::set()
	include (
			APP . DIRECTORY_SEPARATOR
		. 'system' . DIRECTORY_SEPARATOR
		. 'Router.php'
	);
endif;
//**************************************************
//                      begin
//**************************************************

$config = require (APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php');
$db = new mysqli($config['host'], $config['username'], $config['password']);

if ($db->connect_errno)
	die("Не удалось подключиться: {$db->connect_error}\n");


// создадим database
echo "Create database '$config[database]'.. ";
$db->query("CREATE DATABASE IF NOT EXISTS `$config[database]` CHARACTER SET=UTF8;");
echo $db->error."\n";


echo "Select database '$config[database]'\n";
$db->select_db($config['database']);
echo $db->error."\n";

// создадим таблицу city
echo "Create table 'city'.. ";
$db->query("
CREATE TABLE IF NOT EXISTS city (
	`cid`              SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`cname`            VARCHAR(50)        NOT NULL,

	PRIMARY KEY (cid)
) ENGINE=InnoDB CHARACTER SET=UTF8;"
);
echo $db->error."\n";

// создадим таблицу street
echo "Create table 'street'.. ";
$db->query("
CREATE TABLE IF NOT EXISTS street (
	`sid`              SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`sname`           VARCHAR(100)        NOT NULL,
	`cid`         SMALLINT UNSIGNED   NOT NULL,

	PRIMARY KEY (sid),
	FOREIGN KEY (cid) REFERENCES city (cid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;"
);
echo $db->error."\n";

// создадим таблицу contact
echo "Create table 'contact'.. ";
$db->query("
CREATE TABLE IF NOT EXISTS contact (
	`id`              SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`name`            VARCHAR(50)         NOT NULL,
	`surname`         VARCHAR(50)         NOT NULL,
	`patronymic`      VARCHAR(50)         NOT NULL,
	`avatar`          VARCHAR(255)        NOT NULL,
	`bith`            DATE                DEFAULT NULL,
	`sid`             SMALLINT UNSIGNED   NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (sid) REFERENCES street (sid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;"
);
echo $db->error."\n";

// создадим таблицу number
echo "Create table 'number'.. ";
$db->query("
CREATE TABLE IF NOT EXISTS number (
	`nid`             SMALLINT UNSIGNED   NOT NULL        AUTO_INCREMENT,
	`number`          VARCHAR(50),
	`id`              SMALLINT UNSIGNED   NOT NULL,

	PRIMARY KEY (nid),
	FOREIGN KEY (id) REFERENCES contact (id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;"
);
echo $db->error."\n";

// закончим работать с базой
// $db->close();

// теперь добавим данные в таблицы
// street и sity

$argc   = 2;
$argv[] = 'database'; 
include ('grabber.php');


