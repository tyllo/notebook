<?php

/*
 * здесь все неободмые манипуляции с контактом
 * в рамках задания
 */

class Controller_Contact extends Controller{

    // шаблом по умолчанию
    public $layout = 'layouts/clean.php';

    public function action_creat(){
        $contact = $this->model->getPostContact();
        if( !$contact['name'] ):
            $e = New Exception404('Хацкер не добавил имя');
            $e->start();
        endif;
        // создадим новую запись в базе
        $result = $this->model->creat($contact);
        // если ошибка создания записи
        if ( $result === FALSE ):
            $e = new Exception404('Ошибка записи контакта');
            $e->start();
        endif;
        header("Location: http://".$_SERVER['HTTP_HOST']."/");
    }
    public function action_read(){
        // получим id запрошенного контакта
        $id = (int)Router::get('id');
        $result = $this->model->read($id);
        if ( $result === FALSE ):
            $e = new Exception404('Ошибка чтения контакта');
            $e->start();
        endif;

        $this->view->content = View::View('read-user.php', $result);
    }
    public function action_update(){
        // получим id запрошенного контакта
        $id = (int)Router::get('id');
        $result = $this->model->read($id);
        if ( $result === FALSE ):
            $e = new Exception404('Ошибка чтения контакта');
            $e->start();
        endif;

        $this->view->content = View::View('update-user.php', $result);
    }
    public function action_delete(){
        // получим id удаляемого контакта
        $id = (int)Router::get('id');
        $result = $this->model->delete($id);
        if ( $result === FALSE ):
            $e = new Exception404('Ошибка записи контакта');
            $e->start();
        endif;
        header("Location: http://".$_SERVER['HTTP_HOST']."/");
    }
}