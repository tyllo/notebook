<?php
class Exception404 extends Exception {
    public function start(){
        header('HTTP/1.1 404 Not Found');
        header('Content-type: text/html; charset=UTF-8');
        die("<b>404 error</b><br>Page '{$this->message}' 
				Not Found<br><br><a href=\"/\"> перейти в корень приложения</a>");
    }
}