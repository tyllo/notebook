<?php

class Model_Install extends Model{

    // подсоединяемся к database
    protected $db;
    // конфигурация
    protected $config;
    // error
    public $error = '';

    // создадим фаил конфигурации
    public function putConfig(){
        $str = "<?php

            // настройки для соединения с базой данных

            return [
                'base'      => 'mysql',
                'username'  => '$_POST[username]',
                'password'  => '$_POST[password]',
                'host'      => '$_POST[host]',
                'database'  => '$_POST[database]',
            ];
        ";
        $file = APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php';
        file_put_contents($file, $str);
    }
    // пробуем подсоединиться к database
    private function connect(){
        $config = require (
            APP . DIRECTORY_SEPARATOR .
            'config' . DIRECTORY_SEPARATOR .
            'db.php'
        );

        $this->config  = & $config;
        // буферизируем результат подключения
        ob_start();
        $this->db = new mysqli(
            $config['host'],
            $config['username'],
            $config['password']
        );
        $result = ob_get_clean();
        // при ошибке сохраним ошибку и возвратим false
        if($result):
            $this->error = 'Ошибка подключния к базе, проверьте вводимые настройки';
            return false;
        endif;
        // выберем database из settings
        $this->db->select_db($config['database']);
        // при ошибке сохраним ошибку и возвратим false
        if ($this->db->error):
            $this->error = "Не создана database '$config[database]''";
            return false;
        endif;
        // кодировка
        $this->db->query("SET NAMES 'utf8';");
        $this->db->query("SET CHARACTER SET 'utf8';");
        $this->db->query("SET SESSION collation_connection = 'utf8_general_ci';");

        return true;
    }

    public function creat(){

        if ( !$this->connect() ) return false;

        // фаил с таблицами и данными для city и street
        $file =
            APP . DIRECTORY_SEPARATOR .
            'config' . DIRECTORY_SEPARATOR .
            'database.sql';

        if ( !file_exists($file) ):
            $this->error = "Файл конфигурации '$file' отсутствует";
            return false;
        endif;
        // тупо целиком пытаемся запихнуть файл в базу
        // благо размер ее мы знаем
        $sql = file_get_contents($file);
        // разобьем $sql на запросы
        $sql = explode(";", $sql);
        // построчно добавим в db $file.sql
        foreach($sql as $query):
            $query = trim($query);
            if ($query):
                $this->db->query($query);
                // при ошибке сохраним ошибку и возвратим false
                if ($this->db->error):
                    $this->error = $this->db->error;
                    return false;
                endif;
            endif;
        endforeach;
        // все таблицы создали
        return true;
    }
}
