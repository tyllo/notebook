<?php

class Model_Form extends Model{

    // подсоединяемся к database
    protected $db;
    public function __construct(){
        $this->db = Db::getInstance();
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
}
