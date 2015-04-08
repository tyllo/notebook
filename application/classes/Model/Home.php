<?php

class Model_Home extends Model{

    // подсоединяемся к database
    protected $db;
    public function __construct(){
        $this->db = Db::getInstance();
    }
    // return список городов
    public function getCity(){
        // запрашиваем всю таблицу city
        $query  = "SELECT city_id AS id, city_name AS name FROM city;";
        $result = $this->db->query($query);
        $cityArr = [];
        while( $line = $result->fetch_assoc() )
            $cityArr[] = $line;
        $result->free();
        // TODO нужно закешировать результат
        return $cityArr;
    }
    // return список контактов
    public function getContacts(){
        // запрашиваем всю таблицу city
        $query  = "SELECT
                        contact_id AS id,
                        contact_name AS name,
                        avatar AS avatar,
                        contact_surname AS surname
                   FROM contact;";
        $result = $this->db->query($query);
        $ContactArr = [];
        while( $line = $result->fetch_assoc() )
            $ContactArr[] = $line;
        $result->free();
        // TODO нужно закешировать результат
        return $ContactArr;
    }
}
