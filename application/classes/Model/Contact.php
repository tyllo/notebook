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
                (name, surname, patronymic, avatar, bith, sid)
            VALUES (
                '$contact[name]',
                '$contact[surname]',
                '$contact[patronymic]',
                '$contact[avatar]',
                '$contact[bith]',
                 $contact[sid]
            );"
        ;
        // добавим запись
        $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;
        // добавим все телефоны контакта в таблицу number
        // последний индефикатор id
        $id = $this->db->insert_id();
        foreach($contact['number'] as $number):
            $query ="INSERT INTO number (number, id)
                     VALUES ('$number','$id')";
            $this->db->query($query);
            if ($this->db->error()) return FALSE;
        endforeach;
        return TRUE;
    }
    // get info контакте
    public function read($id){
        $query  = "SELECT * FROM contact  AS table1 INNER JOIN street USING (sid)";
        $query  = "SELECT * FROM ($query) AS table2 INNER JOIN city   USING (cid)";
        $query  = "$query WHERE id='$id';";
        $result = $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;
        // результат это одна строка
        $arr = $result->fetch_assoc();

        // отдельным запросом получим number
        $query  = "SELECT number FROM number WHERE id='$id'";
        $result = $this->db->query($query);
        // если ошибка, то FALSE

        if ($this->db->error()) return FALSE;
        $numbers = [];
        while( $line = $result->fetch_assoc() )
            $numbers[] = $line['number'];
        $arr['numbers'] = $numbers;
        return $arr;
    }
    // обновить инфу о контакте
    public function update($contact, $id){
        $query =
            "UPDATE contact SET
                name       = '$contact[name]',
                surname    = '$contact[surname]',
                patronymic = '$contact[patronymic]',
                avatar     = '$contact[avatar]',
                bith       = '$contact[bith]',
                sid        = '$contact[sid]'
            WHERE id       = '$id'
            ;"
        ;
        // обновим запись
        $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;
        // сначало удалим все номера конакта id
        $query ="DELETE FROM number WHERE id='$id';";
        $this->db->query($query);
        if ($this->db->error()) return FALSE;
        // обновим все телефоны контакта в таблицу number
        foreach($contact['number'] as $number):
            // если номер пустой, пропускаем
            //if (!$number) break;
            $query ="INSERT INTO number (id, number) VALUES ('$id','$number');";
            $this->db->query($query);
            if ($this->db->error()) return FALSE;
        endforeach;
        return TRUE;
    }
    // удалить контакт
    public function delete($id){
        // удалим все телефоны контакта $id
        $query =" DELETE FROM number WHERE id = '$id';";
        $this->db->query($query);
        // если ошибка, то FALSE
        if ($this->db->error()) return FALSE;
        // удалим контакт $id
        $query =" DELETE FROM contact WHERE id = '$id';";
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
        // аватар по умолчанию
        $avatar = $this->getPost('avatar');
        $avatar = ($avatar)
            ? $avatar
            : htmlspecialchars('/images/avatar/avatar-1.png');
        return [
           'name'       => $this->getPost('name'),
           'surname'    => $this->getPost('surname'),
           'patronymic' => $this->getPost('patronymic'),
           'avatar'     => $this->getPost('avatar'),
           'number'     => $this->getPost('number'),
           'cid'        => (int)$this->getPost('city'),
           'sid'        => (int)$this->getPost('street'),
           'bith'       => $this->getPost('bith'),
        ];
    }
}
