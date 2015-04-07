<?php

class Model{

    // подсоединяемся к database
    protected $db;
    public function __construct(){
        $this->db = Db::getInstance();
    }
    protected function getPost($key){
        $result = isset($_POST[$key]) ? $_POST[$key] : NULL;
        if (is_array($result)):
            foreach ($result as & $res):
                $res = trim($res);
                $res = htmlspecialchars($res);
                $res =  mysql_escape_string($res);
            endforeach;
        else:
            $result = trim($result);
            $result = htmlspecialchars($result);
            $result =  mysql_escape_string($result);
        endif;
        return $result;
    }
    public function creatContact($contact){
        $query =
            "INSERT INTO contact
                (contact_name, contact_surname, contact_patronymic, contact_date, street_id)
            VALUES (
                '$contact[name]',
                '$contact[surname]',
                '$contact[patronymic]',
                '$contact[date]',
                 $contact[street]
            );"
        ;
        // добавим запись
        $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;

        // добавим все телефоны контакта в таблицу phone
        // последний индефикатор id
        $contact_id = $this->db->insert_id();
        foreach($contact['phone'] as $phone):
            $query ="INSERT INTO phone (phone_number, contact_id)
                     VALUES ('$phone','$contact_id')";
            $this->db->query($query);
            if ($this->db->error()) return FALSE;
        endforeach;
        return TRUE;
    }
    public function getPostContact(){
        // formate date
        $date = $this->getPost('date');
        $arr  = explode('/',$date);
        $date = (count($arr) ==3)
        ? (int)$arr[2].'-'.(int)$arr[1].'-'.(int)$arr[0]
        : NULL;

        return [
           'name'       => $this->getPost('name'),
           'surname'    => $this->getPost('surname'),
           'patronymic' => $this->getPost('patronymic'),
           'phone'      => $this->getPost('phone'),
           'city'       => (int)$this->getPost('city'),
           'street'     => (int)$this->getPost('street'),
           'date'       => $date,
        ];
    }

    // список улиц по id города
    public function getStreet($id){
        // запрашиваем улицы где город равен $id
        $query  = "
            SELECT `street_id`, `street_name`
            FROM `street`
            WHERE city_id=$id;";
        $result = $this->db->query($query);
        if ($this->db->error()) return FALSE;

        $streetArr = [];
        while( $line = $result->fetch_assoc() ):
            $streetArr[$line['street_id']] = $line['street_name'];
        endwhile;
        $result->free();
        // TODO нужно закешировать результат
        return json_encode($streetArr);
    }
    // список городов
    public function getCity(){
        // запрашиваем всю таблицу city
        $query  = "SELECT * FROM city;";
        $result = $this->db->query($query);
        $cityArr = [];
        while( $line = $result->fetch_assoc() ):
            $cityArr[$line['city_id']] = $line['city_name'];
        endwhile;
        $result->free();
        // TODO нужно закешировать результат
        return $cityArr;
    }
}
