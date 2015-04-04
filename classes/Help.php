<?php

// Вспомогательный класс
// хранит static ::setKey
class Help {
    static private $instance = null;
    // буфиризирует данные для последующего вывода
    // с помощью методов Help::get{$key}
    static private $_data = [];

    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}
    static public function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new self;
        return self::$instance;
    }
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
        if ( ! array_key_exists($key, self::$_data) )
            return __CLASS__ . ": ($method)'$key' not exists";
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
    // вспомогательная функция
    // буферизация file, return include file
    public static function getView($file, $arr=[]){
        $arr = (array)$arr;
        extract($arr);
        ob_start();
        include ($file);
        return ob_get_clean();
    }
}

// создадим instance класса
Help::getInstance();
