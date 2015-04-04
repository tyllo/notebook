<?php

// добавим пути для поиска include
set_include_path(get_include_path()
    . PATH_SEPARATOR . __DIR__ . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR
    . PATH_SEPARATOR . __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR
    . PATH_SEPARATOR . __DIR__ . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR
    . PATH_SEPARATOR . __DIR__ . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR
);

// подгрузим всопомательный класс синглтон
include ('Help.php');

// добавим ключи в Help чтобы
// // потом можно было с ними работать
// Help::set{$Key} - set значение
// Help::get{$Key} - get значение
Help::setKey(['head','content','end','start','EndScripts']);

// регестрируем link для head
Help::setHead(<<<EOF
<link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="css/foundation.css">
<link rel="stylesheet" href="css/jquery.datetimepicker.css">
<link rel="stylesheet" href="css/cropper.css">
<link rel="stylesheet" href="css/app.css" />
<script src="js/modernizr.js"></script>
EOF
);

// добавим <SCRIPTS> в конец body
Help::setEndScripts(<<<EOF
<script src="js/jquery.min.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/jquery.datetimepicker.js"></script>
<script src="js/cropper.js"></script>
<script src="js/app.js"></script>
EOF
);

// буферизируем Help::getView(files) и
// добавим модальные окна в конец body
Help::setEnd(
	Help::getView('modal-show-user.php').
	Help::getView('modal-add-user.php')
);

// здесь у нас основой контент страницы
Help::setContent(
	Help::getView('navigation.php').
	Help::getView('content.php')
);

include ('view' . DIRECTORY_SEPARATOR . 'index.php');

