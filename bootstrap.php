<?php

// константа - корень приложения
define('APP', __DIR__ . DIRECTORY_SEPARATOR . 'application');

// Подгрузим роутер с автоподгрузкой классов
// еще он разбирает uri и сопоставляет валидному роуту
// controller->action(), согласно ::set()
include (
	  APP . DIRECTORY_SEPARATOR
	. 'system' . DIRECTORY_SEPARATOR
	. 'Router.php'
);

// добавим пути для поиска include
set_include_path(get_include_path()
    . PATH_SEPARATOR . APP
    . DIRECTORY_SEPARATOR . 'view'
    . DIRECTORY_SEPARATOR
);

// регистрируем route для основной страницы
Router::set('home', '', [
    'controller' => 'Home',
    'action'     => 'index',
]);
// манипуляции с contact
Router::set('contact', 'contact/(creat|read/([0-9]+)|update/([0-9]+)|delete/([0-9]+))', [
    'action'     => 'read',
    'pattern'    => 'controller/action/id'
]);
// обрабатывает запросы форм, пока что только city
Router::set('form/get', 'form/get/city/([0-9]+)', [
    'pattern'    => 'controller/action/var/id'
]);

Router::start();
