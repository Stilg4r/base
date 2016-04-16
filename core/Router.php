<?php
/**
 * Clase router
 */

/**
 * Clase que enruta las peticiones
 */
class Router {
	/**
	 * Redirige al controlador y metodo
	 * @param  string $url url de solicitud
	 */
	public function route($url) {

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
			$controller='404';
		}
		
		$controller_name = $controller;
		$controller = ucwords($controller);
				
		if (class_exists($controller) and method_exists($controller, $action)) {
			$dispatch = new $controller($controller_name,$action);
		 	call_user_func_array([$dispatch,$action],$query_string);
		}elseif(file_exists(ROOT . DS .'static' . DS . $controller . '.php')) {
		  	include (ROOT . DS .'static' . DS . $controller . '.php');
		}else{
		   	header('Location: /404');	
		}	    
	}
}