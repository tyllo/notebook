<?php

/*
 * класс парсит url, и в зависимости от
 * query return JSON with street или
 * добавит нового user в database
*/
class Router{
	// true, если запрос ajax
	public function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	// обрабатывает запрос ?get=street&city=$key
	function getStreet($key){
		// если запрос не ajax, то 404
		if ( !$this->is_ajax()):
			header('HTTP/1.1 404 Not Found');
			header('Content-type: text/plain; charset=UTF-8');
			// нужно выдать страницу 404
			die('access deny');
		endif;

		header('HTTP/1.1 200 OK');
		header('Content-type: text/plain; charset=UTF-8');
		
		// нужно в базе найти все улицы $_POST['city']
		$streets = file_get_contents($key);
		$data = explode("\n", $streets);

		foreach($data as $key => $value)
			$dataJSON[] = ['id' => $key, 'name' => $value]; 

			unset($streets,$data);

		// если такой город есть в базе - 
		// возвращаем список городов в формате json
		echo json_encode($dataJSON);		
	}
	// parse url и вызывает соответствующий метод
	public function __construct(){

	// parse query
	if( isset($_POST['get']) ):
		// вообще перед присваиванием нужно
		// проверить на корректность запрос
		// можно это отдать на откуп php фреймворку
		$method = $_POST['get'];
		$city   = $_POST['city'];
		
		$this->getStreet('vladivostok.txt');
	elseif ( isset($_POST['set']) ):
		$user = $_POST['set'];
		$this->setUser($user);
/* 	else:
		//здесь throw
		$this ->getStreet('vladivostok.txt');*/
	endif;
	}
	
}

$router = New Router();

