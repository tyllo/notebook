<?php

abstract class Controller{
    protected $model;
    protected $view;

    // шаблон по умолчанию
    public $layout = 'layouts/clean.php';

    // true, если запрос ajax
    public function is_ajax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    function __construct(){
        // создадим экземпляр Modelname
        $modelName = 'Model_'.Router::get('controller');
        $this->model = (class_exists($modelName))
            ? New $modelName() : New Model();
        $this->view = New View();
    }

    // вызывается до action_$action
    public function before(){}

    // вызывается после action_$action
    public function after(){
        // выведим что получилось
        echo $this->view->render($this->layout);
    }
}