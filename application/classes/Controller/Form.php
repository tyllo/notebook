<?php

/*
 * класс парсит url, и в зависимости от
 * query return JSON with street или
 * добавит нового user в database
 * обрабатывает запросы форм
*/
class Controller_Form extends Controller{

	//public $layout = 'layouts/clean.php';

	public function before(){
		parent::before();
		// если запрос не ajax, то 401
		if ( ! $this->is_ajax() ):
			header('HTTP/1.1 401 Access Denied');
			header('Content-type: text/plain; charset=UTF-8');
			die('401 - Access Denied');
		endif;

		header('HTTP/1.1 200 OK');
		header('Content-type: text/plain; charset=UTF-8');
	}
	function action_get(){
        // получим id запрашиваемого города
        $id = (int)Router::get('id');
        // получим список улиц
        $streetJSON = $this->model->getStreet($id);
        // если id не соответсвует ни один город
        if($streetJSON === false):
			$e = new Exception404();
			$e->start($id);
        endif;
        $this->view->content = $streetJSON;
	}
}
