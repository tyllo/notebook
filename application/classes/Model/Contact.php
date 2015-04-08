<?php

class Model_Contact extends Model{

    // подсоединяемся к database
    protected $db;
    public function __construct(){
        $this->db = Db::getInstance();
    }
    // создать контакт
    public function creat($contact){
        $query =
            "INSERT INTO contact
                (contact_name, contact_surname, contact_patronymic, avatar, contact_date, street_id)
            VALUES (
                '$contact[name]',
                '$contact[surname]',
                '$contact[patronymic]',
                '$contact[avatar]',
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
    // обновить инфу о контакте
    public function update($id){}
    // get info контакте
    public function read($id){
        $query  = "SELECT * FROM contact  AS table1 INNER JOIN street USING (street_id)";
        $query  = "SELECT * FROM ($query) AS table2 INNER JOIN city   USING (city_id)";
        $query  = "$query WHERE contact_id='$id'";
        $result = $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;
        // результат это одна строка
        $arr = $result->fetch_assoc();

        // отдельным запросом получим phone
        $query  = "SELECT phone_number FROM phone WHERE contact_id='$id'";
        $result = $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;
        $phoneArr = [];
        while( $line = $result->fetch_assoc() )
            $phoneArr[] = $line['phone_number'];
        $arr['phoneArr'] = $phoneArr;
        return $arr;
    }
    // удалить контакт
    public function delete($id){
        // удалим все телефоны контакта $id
        $query =" DELETE FROM phone WHERE contact_id = '$id';";
        $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;
        // удалим контакт $id
        $query =" DELETE FROM contact WHERE contact_id = '$id';";
        $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;
        return TRUE;
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
		// return $_POST
    public function getPostContact(){
        // formate date
        // $date = $this->getPost('date');
        // $arr  = explode('/',$date);
        // $date = (count($arr) ==3)
        // ? (int)$arr[2].'-'.(int)$arr[1].'-'.(int)$arr[0]
        // : NULL;

        return [
           'name'       => $this->getPost('name'),
           'surname'    => $this->getPost('surname'),
           'patronymic' => $this->getPost('patronymic'),
           'avatar'     => $this->getPost('avatar'),
           'phone'      => $this->getPost('phone'),
           'city'       => (int)$this->getPost('city'),
           'street'     => (int)$this->getPost('street'),
           'date'       => $this->getPost('date'),
        ];
    }
}
