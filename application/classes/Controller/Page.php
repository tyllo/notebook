<?php

class Controller_Page extends Controller{

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
        Help::set()->head('<link rel="stylesheet" href="/css/font-awesome.css">');
        Help::set()->head('<script src="/js/modernizr.js"></script>');
        //jQuery
        Help::set()->end('<script src="/js/jquery.min.js"></script>');
        // for foundation
        //Help::set()->head('<link rel="stylesheet" href="/css/foundation.css">');
        Help::set()->end('<script src="/js/foundation.min.js"></script>');
        // for datetimepicker
        Help::set()->head('<link rel="stylesheet" href="/css/jquery.datetimepicker.css">');
        Help::set()->end('<script src="/js/jquery.datetimepicker.js"></script>');
        // for croper
        //Help::set()->head('<link rel="stylesheet" href="/css/cropper.min.css">');
        //Help::set()->end('<script src="/js/cropper.min.js"></script>');
        // мои скрипты и стили
        Help::set()->head('<link rel="stylesheet" href="/css/app.css" />');
        Help::set()->end('<script src="/js/app.js"></script>');
    }
    public function action_index(){
        // здесь у нас все что до основного контента
        $this->view->before = View::View('navigation.php');

        // получим список всех юзеров
        $contacts = $this->model->getContacts();
        // здесь у нас основой контент страницы
        $this->view->content = View::View('contacts.php', [ 'contacts' => $contacts]);

        // добавим модальные окна в конец body
        $this->view->after  = View::View('modal-read-user.php');
        // получим список городов
        $citys = $this->model->getCity();
        $this->view->after .= View::View('modal-creat-user.php', ['citys' => $citys]);
    }
    function action_getStreet(){
        // установим пустой шаблон
        $this->layout = 'layouts/clean.php';
        // получим id запрашиваемого города
        $id = (int)Router::get('id');
        // получим список улиц
        $streetsJSON = $this->model->getStreet($id);
        // если id не соответсвует ни один город
        if($streetsJSON === false):
            $e = new Exception404();
            $e->start($id);
        endif;
        $this->view->content = $streetsJSON;
    }
}
