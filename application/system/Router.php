<?php
/*
 * ::construct - разбирает запрошенный $uri от пользоателя
 * ::setAutoloader($path) - регестрирует автозагрузки классов
 *  ::set(name,path,arr) - регестрирует для $uri свой controller и action
 * ::start() - запускает controller->action()
 */
class Router {
    private static $instance = null;
    // массив разобранного роута
    private static $route = [];

    // хранит uri
    private static $uri;

    // запущенные controller и action
    public static $controller;
    public static $action;

    private function __construct(){
        // если CLI
				if ( ! isset($_SERVER['HTTP_HOST']) ) return;
        // Парсим uri
				$arr = parse_url(strtolower("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
        $query = array_key_exists('query', $arr) ? $arr['query'] : NULL;
        $uri = trim($arr['path'],'/');

        // если есть недопустимые символы в uri, то Exception
        if (preg_match ("/([^a-zA-Z0-9\.\/\-\_\#])/", $uri))
            //throw new Exception("Недопустимые символы в $uri");
            die(__CLASS__ . "Недопустимые символы: '$uri'");
        self::$uri = $uri;
    }
    private function __clone(){}
    private function __wakeup(){}
    static public function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new self;
        return self::$instance;
    }
    // автолоадеры классов относительно корня приложения
    public function setAutoloader($path){
        // classes\controller => Classes/Controller
        $path = trim($path,'/');
        $path = trim($path,'\\');
        $path = str_replace('/', ' ' , $path);
        $path = str_replace('\\', ' ' , $path);
        $path = ucwords($path);
        $path = str_replace(' ', DIRECTORY_SEPARATOR , $path);

        spl_autoload_register(function ($className) use($path){
            $className = strtolower($className);
            // Controller_Home => Controller/Home
            $className = str_replace('_', ' ' , $className);
            $className = ucwords($className);
            $className = str_replace(' ', DIRECTORY_SEPARATOR , $className);

            $filename  = APP . DIRECTORY_SEPARATOR . $path .
            DIRECTORY_SEPARATOR . $className . '.php';
            if (file_exists($filename)) include ($filename);
        });
    }
   // здесь сопоставим uri свои controller и action
   static public function set($name, $path, $arr=[]) {
        // 'user/(creat|read)' => '/user\/(creat|read)/i'
        $path = str_replace('/', '\/' , $path);
        preg_match( '/^'.$path.'$/i', self::$uri, $matches);
        // если нет совпадений uri и path то этот роут не подхдит
        if( ! isset($matches[0]) ) return FALSE;

        // роут по умолчанию
        self::$route = [
            'controller' => 'Default',
            'action'     => 'index',
        ];
        self::$route = array_merge(self::$route, $arr);

        // Здесь отпарсим path, согласно ему сопоставим переменные из uri

        // если задали паттерн, разберем его
        if (isset($arr['pattern'])):
            // controller/action/id
            $patternArr = explode('/', $arr['pattern']);
            // contact/read/23
            $uriArr     = explode('/', self::$uri);
            foreach($patternArr as $key => $value)
                if ( isset($uriArr[$key])&&$uriArr[$key] )
                    self::$route[$value] = $uriArr[$key];
        endif;
   }
    // запускает controller->action();
   static public function start() {
        $route = & self::$route;
        // если нет роута
        if ($route==[]):
            $e = new Exception404(self::$uri);
            $e ->start();
        endif;
        // запомним подгруженный controller и action
        self::$controller = self::$route['controller'];
        self::$action     = self::$route['action'];
        // создадим экземпляр controller
        $controllerName = 'Controller_'.$route['controller'];
        $controller = New $controllerName();
        // и запускаем action()
        $actionName = 'action_'.$route['action'];
        if ( ! method_exists($controller, $actionName) ):
            $e = new Exception404(self::$uri);
            $e ->start();
        endif;
        $controller->before();
        $controller->$actionName();
        $controller->after();
   }
   // внешний доступ к свойсвам self::$route
	 // нужно для доступа к таким параметрам из
	 // pattern где рендерятся соответствия 
	 // controller/action/id => [controller, action, id]
   static public function get($key){
        return isset(self::$route[$key])
            ? self::$route[$key] : NULL;
    }
}

// создадим instance класса
Router::getInstance();

// Зарегестрируем пути для поиска классов
Router::setAutoloader('classes');
Router::setAutoloader('classes/exception');
Router::setAutoloader('system');
