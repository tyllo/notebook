<?php

class Controller_Install extends Controller{

    // основной шаблон, куда будут рендериться переменные из view
    public $layout = 'layouts/default.php';
    public function before(){
        parent::before();

        // Зарегестрируем keys
        Help::register([
            'head',            // для вставки в шапку page
            'before',          // для вставки перед контентом
            'content',         // для вставки котента
            'after',           // для вставки после контента
            'end'              // для вставки в самый конец body
        ]);
        // добавим стили и скрипты на страницу

        // по умолчанию в head для page
        Help::set()->head('<link rel="stylesheet" href="/css/font-awesome.min.css">');
        Help::set()->head('<script src="/js/modernizr.min.js"></script>');
        //jQuery
        Help::set()->end('<script src="/js/jquery.min.js"></script>');
        // for foundation
        //Help::set()->head('<link rel="stylesheet" href="/css/foundation.css">');
        Help::set()->end('<script src="/js/foundation.min.js"></script>');
        // мои скрипты и стили
        Help::set()->head('<link rel="stylesheet" href="/css/app.min.css" />');
        Help::set()->end('<script>$(document).foundation();</script>');
    }
    public function action_index(){
        // не будем показывать topBare - кнопка добавить
        $topBare = [ 'topBare' => ''];
        $this->view->before  = View::View('navigation.php', $topBare);
        $this->view->content = View::View('install.php');
    }
    public function action_creat(){
        // создадим фаил настроек для соединнения с db
        $this->model->putConfig();
        // если подсоединились и создали таблицы без ошибок
        if( $this->model->creat()):
            rename(
                APP . DIRECTORY_SEPARATOR .'install.php',
                APP . DIRECTORY_SEPARATOR . '_install.php'
            );
            // редирект на корень
            header("Location: http://".$_SERVER['HTTP_HOST']."/");
        else:
            // если ошибка выведим страницу с ошибкой и повторно запросим
            $this->view->before   = View::View('navigation.php',['topBare' => '']);
            $this->view->content  = View::View('error.php',['error' => $this->model->error]);
            $this->view->content .= View::View('install.php');
        endif;
    }
}
