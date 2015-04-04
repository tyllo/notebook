<?php

// Вспомогательный класс
// хранит static ::setKey
class Assests {
	private static $_data = [];
	private static function set($key, $str=NULL){
		self::$_data[$key] = self::$_data[$key] . "\n" . $str;
	}
	private static function get($key, $str=NULL){
		return str_replace("\n", "\n".$str, self::$_data[$key]) . "\n";
	}
	# $prefix - добавить табы перед \n
	public static function __callStatic($name, $arguments){
		// pars name
		$key    = strtolower(substr($name, 3));
		$method = strtolower(substr($name, 0, 3));
		if ( ! array_key_exists($key, self::$_data) ) return __CLASS__ . ": ($method)'$key' not exists";
		if($method == 'set') return self::set($key, $arguments[0]);
		if($method == 'get') return self::get($key, $arguments[0]);
	}
	// добавляем ключи в $_data
	public static function setKey($arr){
		$arr = (array)$arr;

		foreach ($arr as $key):
			$key = strtolower($key);
			self::$_data[$key] = isset(self::$_data[$key])
				? self::$_data[$key] : NULL;
		endforeach;
	}
}

// добавим ключи в Assests что бы потом можно было с ними работать
Assests::setKey(['head','content','end','start','EndScripts']);

Assests::setHead(<<<EOF
<link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="css/foundation.css">
<link rel="stylesheet" href="css/jquery.datetimepicker.css">
<link rel="stylesheet" href="css/cropper.css">
<link rel="stylesheet" href="css/app.css" />
<script src="js/modernizr.js"></script>
EOF
);

Assests::setEndScripts(<<<EOF
<script src="js/jquery.min.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/jquery.datetimepicker.js"></script>
<script src="js/cropper.js"></script>
<script src="js/app.js"></script>
EOF
);

// буферизация file, return include
function getView($file, $arr=[]){
	$arr = (array)$arr;
	extract($arr);
	ob_start();
	include ('view' . DIRECTORY_SEPARATOR . $file);
	return ob_get_clean();
}

// добавим модальные окна в конец body
$str  = getView('modal-show-user.php');
$str .= getView('modal-add-user.php');
Assests::setEnd($str);

// добавим <SCRIPTS> в конец body
$str  = getView('navigation.php');
$str .= getView('content.php');
Assests::setContent($str);
