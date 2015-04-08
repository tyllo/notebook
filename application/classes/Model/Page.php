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
        $query  = "SELECT cid AS id, cname AS name FROM city;";
        $result = $this->db->query($query);
        $citys = [];
        while( $line = $result->fetch_assoc() )
            $citys[] = $line;
        $result->free();
        // TODO нужно закешировать результат
        return $citys;
    }
    // return список улиц по id города
    public function getStreet($id){
        // запрашиваем улицы где город равен $id
        $query  = "SELECT sid AS id, sname AS name
                    FROM street WHERE cid=$id;";
        $result = $this->db->query($query);
        if ($this->db->error()) return FALSE;

        $streets = [];
        while( $line = $result->fetch_assoc() ):
            $streets[]=$line;
        endwhile;
        $result->free();
        // TODO нужно закешировать результат
        return json_encode($streets);
    }
    // return список контактов
    public function getContacts(){
        // запрашиваем всю таблицу city
        $query  = "SELECT id, name, surname, avatar FROM contact;";
        $result = $this->db->query($query);
        $contacts = [];
        while( $line = $result->fetch_assoc() )
            $contacts[] = $line;
        $result->free();
        // TODO нужно закешировать результат
        return $contacts;
    }
}
