<?php

class Controller_Home extends Controller_Page{

    // основной шаблон, куда будут рендериться переменные из view
    public $layout = 'layouts/default.php';

    public function action_index(){
        // получим список всех юзеров
        $contactArr = $this->model->getContacts();
        // здесь у нас основой контент страницы
        $this->view->content = View::View('content.php', [ 'contactArr' => $contactArr]);
        // добавим модальные окна в конец body
        $this->view->after  = View::View('modal-read-user.php');
        // получим список городов
        $cityArr = $this->model->getCity();
        $this->view->after .= View::View('modal-creat-user.php', ['cityArr' => $cityArr]);
    }
}
