<?php

// вспомогательный класс для connect db
class DB {

    private $db;
    private $config;

    private static $instance = null;
    private function __clone(){}
    private function __wakeup(){}
    static public function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new self;
        return self::$instance;
    }

    private function __construct(){
        $config = require (APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php');
        $this->config  = & $config;

        $this->db = new mysqli($config['host'], $config['username'], $config['password']);
        if ($this->db->connect_errno):
            printf("Не удалось подключиться: %s\n", $this->db->connect_error);
            die();
        endif;

    // выберем database из settings
    $this->db->select_db($config['database']) or
        die("Database '$config[database]' is not exists. ");

    // кодировка
    $this->db->query("SET NAMES 'utf8';");
  $this->db->query("SET CHARACTER SET 'utf8';");
  $this->db->query("SET SESSION collation_connection = 'utf8_general_ci';");

    }
    public function __destruct(){
        return $this->db->close();
    }
    public function query($query){
        return $this->db->query($query);
    }
    public function error(){
        return $this->db->error;
    }
    public function insert_id(){
        return $this->db->insert_id;
    }
}

// instance class
Db::getInstance();
