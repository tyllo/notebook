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
        $this->view->before  = View::View('navigation.php',[ 'topBare' => '']);
        $this->view->content = View::View('install.php');
    }
    public function action_creat(){
        $str =<<<EOF
<?php

// настройки для соединения с базой данных

return [
    'base'      => 'mysql',
    'username'  => '$_POST[username]',
    'password'  => '$_POST[password]',
    'host'      => '$_POST[host]',
    'database'  => '$_POST[database]',
];
EOF;
        $file = APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'db.php';
        file_put_contents($file, $str);

        $config = require ($file);

        $db = @mysqli_connect($config['host'], $config['username'], $config['password']);

        if (mysqli_connect_errno()):
            $error = "Не удалось подключиться, непраильные настройки, error:". mysqli_connect_errno();
            // выведим страницу с ошибкой и повторным вводом конфига
            $this->view->before  = View::View('navigation.php',[ 'topBare' => '']);
            $this->view->content = View::View('install.php');
            $this->view->before  = "<div class=\"row\"><div class=\"small-8 medium-6 small-centered columns\">
            <div data-alert class=\"alert-box alert radius\">
            $error<a href=\"#\" class=\"close\">&times;</a></div></div></div>";
        else:
            // все ок, нужно добавить таблицы и данные
            include (APP. DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'creatDB.php');
            //$this->view->content = View::View('install.php');

            $this->view->before  = View::View('navigation.php',[ 'topBare' => '']);
            $this->view->before  = "<div class=\"row\"><div class=\"small-8 medium-6 small-centered columns\">
            <div data-alert class=\"alert-box success radius\">
            config корректный!!<br>Теперь удалите или переименуйте фаил из корня
            'install.php' и <a href=\"/\">обновите страницу</a><a href=\"#\" class=\"close\">&times;</a></div></div></div>";
        endif;
    }
}
