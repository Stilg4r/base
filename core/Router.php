<?php
class Router {
	public static function route($url) {
		$url_array = array();
   		$url_array = explode("/",$url);
		if(file_exists(ROOT . DS .'static' . DS . $url_array[0] . '.php') and sizeof($url_array)==1 )  {
		   	include (ROOT . DS .'static' . DS . $url_array[0] . '.php');
		   	exit();
		}
		require_once(ROOT.DS.'config'.DS.'routes.php');
		$url=$_SERVER['REQUEST_METHOD'].'/'.$url;
		foreach ($routes as $route => $destination) {
			if (preg_match($route, $url)) {
				$controller=$destination['controller'];
				$action=$destination['action'];
				$query_string=[];
				foreach ($destination['vars'] as $varpos) {
					$vars=explode("/", $url);
					$query_string[]=$vars[$varpos];
				}
				break;
			}
		}
		if (!isset($controller)) {
			if (DEBUG) {error_log("No existe el ".$url." en las rutas");}
			header('Location: '.PATH.'/404');
			exit();
		}
		$controller_name = $controller;
		$controller = ucwords($controller);
		if (class_exists($controller) and method_exists($controller, $action)) {
			if (DEBUG) {
				$action=(isset($action))?$action:'';
				error_log($url.'=>'.$controller_name.'/'.$action);
			}
			$dispatch = new $controller($controller_name,$action);
		 	call_user_func_array([$dispatch,$action],$query_string);
		}else{
			if (DEBUG) {error_log("No existe la ".$action." en ".$controller_name);}
		   	header('Location: '.PATH.'/404');
		   	exit();
		}
	}
}