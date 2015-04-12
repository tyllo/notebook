<?php

// Вспомогательный класс
// хранит static ::setKey
class Help {
    private static $instance = null;
    // буфиризирует данные для последующего вывода
    // с помощью методов Help::get{$key}
    private static $_data = [];
    // вспомогательный ключь, для того что бы определиться
    // set или get метод мы вызвали для Help::set()->_call()
    private static $method;
    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}
    static public function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new self;
        return self::$instance;
    }
    public static function set($key=NULL){
        self::$method = 'set';
        return self::getInstance();
        //self::$_data[$key] = self::$_data[$key] . "\n" . $str;
    }
    // $prefix - добавить табы перед \n
    public function get($key=NULL){
        self::$method = 'get';
        return self::getInstance();
    }
    public function __call($name, $arguments){
        // если мы не зарегестрировали ключь в $_data
        // print_r(self::$_data);
        if ( ! array_key_exists($name, self::$_data) )
            return __CLASS__ . ": '$name' not exists, maybe ::register($name)";

        if (self::$method == 'set' ):
            self::$_data[$name] .= "$arguments[0]\n";
        elseif (self::$method == 'get' ):
            $prefix = $arguments[0];
            return str_replace("\n", "\n".$prefix, self::$_data[$name]) . "\n";
        endif;
        self::$method = NULL;
    }
    // добавляем ключи в $_data
    public function register($arr){
        $arr = (array)$arr;
        foreach ($arr as $key):
            $key = strtolower($key);
            self::$_data[$key] = isset(self::$_data[$key])
                ? self::$_data[$key] : NULL;
        endforeach;
    }
}

// создадим instance класса
Help::getInstance();
