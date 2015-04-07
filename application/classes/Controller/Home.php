<?php

class Controller_Home extends Controller_Page{

    // основной шаблон, куда будут рендериться переменные из view
    public $layout = 'layouts/default.php';

    public function action_index(){
        // здесь у нас основой контент страницы
        $this->view->content = View::View('content.php');
        // добавим модальные окна в конец body
        $this->view->after  = View::View('modal-show-user.php');
        // получим список городов
        $cityArr = $this->model->getCity();
        $this->view->after .= View::View('modal-add-user.php', ['cityArr' => $cityArr]);
    }
}
