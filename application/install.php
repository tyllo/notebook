<?php

if (!strripos($_SERVER['REQUEST_URI'], 'install')):
	header("Location: http://".$_SERVER['HTTP_HOST']."/install/");
	die();
endif;

// регистрируем route для установки database
Router::set('install', 'install(/creat|)', [
	'controller' => 'Install',
	'pattern'    => 'null/action',
]);

Router::start();

die();