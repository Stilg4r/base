<?php
class Fn {
    private function __construct() {}
    private function __wakeup() {}
    private function __clone() {}

    public static function __callStatic($fn, $arg) {
        if (!function_exists($fn)) {
        	$path = ROOT . DS . 'application' . DS . 'helpers' . DS . $fn . '.php';
        	if (file_exists($path)){
        		require_once($path);
    		}else{
   				$trace = debug_backtrace();
				trigger_error('Missing function file '.$path.' '.$trace[0]['file'].' in line '.$trace[0]['line'],E_USER_ERROR);
    		}
        }
        return call_user_func_array($fn, $arg);
    }
}