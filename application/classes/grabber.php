<?php

// скрипт парсит города и соответствующие улицы в file.ini
// from http://gorodskaya-spravka.com
// так же он добавляет записи в таблицы city и street
// использую файл file.ini, таблицы должны существовать!!


// console - iconv('UTF-8', 'cp866', $str)
// константа - корень приложения
if ( !defined('APP') ):
	define('APP', realpath(__DIR__ . '/../../application'));

	// Подгрузим роутер с автоподгрузкой классов
	// еще он разбирает uri и сопоставляет валидному роуту
	// controller->action(), согласно ::set()
	include (
				APP . DIRECTORY_SEPARATOR
			. 'system' . DIRECTORY_SEPARATOR
			. 'Router.php'
	);
endif;
//**************************************************
//                 pars settings
//**************************************************
//$argc - количество параметров
//$argv - массив параметров

if ($argc == 1) die(Usage());

////////////////// pars $argv ///////////////////

// for print help results
if ( in_array('help', $argv) ):
    echo Usage();
endif;
//**************************************************
//                  Helpers
//**************************************************

$cityArr   = ['saransk', 'kursk', 'saratov', 'voronej', 'volgograd', 'ekaterinburg', 'samara', 'perm', 'nnovgorod', 'kazan', 'ufa', 'rostovondon', 'penza', 'chelyabinsk', 'krasnoyarsk', 'novosibirsk', 'smolensk', 'cheboksary', 'yaroslavl', 'omsk', 'ryazan', 'orenburg', 'tula', 'vladimir', 'astrahan', 'bryansk', 'ijevsk', 'irkutsk', 'kaluga', 'kemerovo', 'krasnodar', 'petrozavodsk', 'pskov', 'stavropol', 'tambov', 'tver', 'tyumen', 'ulyanovsk', 'vladivostok', 'vologda', 'moscow', 'spb'];
$cityArrRu = ['Саранск', 'Курск', 'Саратов', 'Воронеж', 'Волгоград', 'Екатеринбург', 'Самара', 'Пермь', 'Нижний Новгород', 'Казань', 'Уфа', 'Ростов на Дону', 'Пенза', 'Челябинск', 'Красноярск', 'Новосибирск', 'Смоленск', 'Чебоксары', 'Ярославль', 'Омск', 'Рязань', 'Оренбург', 'Тула', 'Владимир', 'Астрахань', 'Брянск', 'Ижевск', 'Иркутск', 'Калуга', 'Кемерово', 'Краснодар', 'Петрозаводск', 'Псков', 'Ставрополь', 'Тамбов', 'Тверь', 'Тюмень', 'Ульяновск', 'Владивосток', 'Вологда', 'Москва', 'Санкт-Петербург'];

function Usage(){
    $config = APP . '/config/db.php';
    return <<<EOF
  Usage this script:
  parse      - for pars streets from http://gorodskaya-spravka.com
  database   - for create tables, settings:
               $config
  help       - for this help.

EOF;
}
// вспомогательный скрипт, парсит улицы
// со страницы http://gorodskaya-spravka.com
function parsLinks($city){

    $link = 'http://'.$city.'.gorodskaya-spravka.com';

    // ############### get number pages ################
    echo "[ $link ].. ";
    $html = file_get_contents($link.'/street/1.html');
    echo "get page!.. ";
    echo "pars pages.. ";
    //<a href="/street/3.html">
    $pattern = '|\/street\/([0-9]+)\.html|i';
    preg_match_all("$pattern", "$html", $matches);

    $pages = $matches[1][0];
    foreach( $matches[1] as $num)
        $pages = ($pages>$num) ? $pages : $num;
    echo "pages = $pages\n";

    return $pages;
}
function parsStreets($city, $pages){

    $link = 'http://'.$city.'.gorodskaya-spravka.com';

    // ################# get streets ####################
    $page = 1; $streets = [];
    while(true):
        if ($page>$pages) break;
        $parsLink = $link.'/street/'.$page.'.html';
        echo "[ $parsLink ].. ";
        $html = file_get_contents($parsLink);
        $html = iconv('windows-1251', 'utf-8', $html);
        //file_put_contents(__DIR__.'/html.txt',$html);
        //<li><a href="/street/s_37304.html" title="1 Мая улица" target="_blank">1 Мая улица</a></li>
        $pattern = '|title="(.*?)"|iu';
        $pattern = '|<li><a.*?>(.*?)<\/a><\/li>|iu';
        $pattern = '|<li><a.*?title="(.*?)".*?>.*?<\/a><\/li>|iu';
        echo " pars streets!\n";
        preg_match_all("$pattern", "$html", $matches);
        $streets = array_merge($streets, $matches[1]);

        // увеличим счетчик страницы
        $page++;
    endwhile;
    return $streets;
}

//**************************************************
//                      begin
//**************************************************

// если ключ parse
if ( in_array('parse', $argv) ) {
    echo $file = APP . "/config/city.ini";

    foreach ($cityArr as $i => $city):
        $pages      = parsLinks($city);
        $cityRu     = $cityArrRu[$i];
        $arr[$city] = parsStreets($city, $pages);
        echo "[ $city - ready!!!!!!!! ]\n\n";
        $str = "\n[$cityRu]";
        foreach ($arr[$city] as $id => $street):
            $str = "$str\n$id = '$street'";
        endforeach;
        file_put_contents($file, "$str\n", FILE_APPEND);
    endforeach;
}

// если ключ database
if ( in_array('database', $argv) ){
    // если database из конфига нет,
    // то скрипт запросит его создать
    $db = Db::getInstance();

    // в этом файле награбленные улицы и города
    $file = APP . "/config/city.ini";

    if (file_exists($file))
        $ini = parse_ini_file($file,true);
    else
        die("$file - do not exists, parse streets and city use: php ./grabber.php parse");

    $id = 0; echo "\n";
    foreach($ini as $cname => $streets):
        echo "Set city's street ".iconv('UTF-8', 'cp866', $cname).".. ";
				$id++;
        $db->query("INSERT INTO city (cname) VALUES ('$cname');" );
        if( $db->error() ):
					echo "city: ".$db->error()."\n";
				die();
				endif;
        foreach($streets as $sname):
            $db->query(
                "INSERT INTO street (`sname`,  `cid`)
                 VALUES             ('$sname', $id);"
            );
            if( $db->error() ) echo "street: ".$db->error()."\n";
        endforeach;
				echo "ok\n";
    endforeach;
}
