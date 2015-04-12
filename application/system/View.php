<?php

Class View{

    protected $_data = [
        // переменные для шаблона по умолчанию
        'before'  => '',
        'content' => '',
        'after'   => ''
    ];

    public function __construct (){}

    // буферизация file, return include file
    public static function View ($file, $arr=[]){
        $arr = (array)$arr;
        extract($arr);
        ob_start();
        include ($file);
        return ob_get_clean();
    }
    public function __set ($name, $value){
        $this->_data[$name] = $value;
    }
    public function __get ($name){
        return isset($this->_data[$name])
            ? $this->_data[$name]: NULL;
    }
    public function render ($file){
        echo View::View($file, $this->_data);
    }
}
