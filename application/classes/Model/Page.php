<?php

class Model_Page extends Model{

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
    // return список улиц по id города
    public function getStreet($id){
        // запрашиваем улицы где город равен $id
        $query  = "SELECT street_id AS id, street_name AS name
                    FROM street WHERE city_id=$id;";
        $result = $this->db->query($query);
        if ($this->db->error()) return FALSE;

        $streetArr = [];
        while( $line = $result->fetch_assoc() ):
            $streetArr[]=$line;
        endwhile;
        $result->free();
        // TODO нужно закешировать результат
        return json_encode($streetArr);
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
