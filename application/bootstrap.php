<?php

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

// файл-флаг, в нем роут для инсталяции базы данных
// после установки его нужно удалить или переименовать
$file = __DIR__ . DIRECTORY_SEPARATOR . 'install.php';
if (file_exists($file)) include ($file);


// регистрируем route для основной страницы
Router::set('Page', '', [
    'controller' => 'Page',
    'action'     => 'index',
]);

// обрабатывает запрос по id выдает street
Router::set('get/street', 'get/street/([0-9]+)', [
    'controller' => 'Page',
    'action'     => 'getStreet',
    'pattern'    => 'null/null/id',
]);

// манипуляции с contact
Router::set('contact', 'contact/(creat|read/([0-9]+)|update/([0-9]+)|delete/([0-9]+))', [
    'action'     => 'read',
    'pattern'    => 'controller/action/id'
]);

Router::start();
