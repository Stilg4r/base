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
	    // Split the URL into parts
	    $url_array = array();
	    $url_array = explode("/",$url);
        // The first part of the URL is the controller name
	    $controller = isset($url_array[0]) ? $url_array[0] : '';
	    array_shift($url_array);
        // The second part is the method name
	    $action = isset($url_array[0]) ? $url_array[0] : '';
	    array_shift($url_array);
		// The third part are the parameters
	    $query_string = $url_array;
	    // if controller is empty, redirect to default controller
	   if(empty($controller)) {
	       $controller = DEFAULT_CONTROLLER;
        }
	    // if action is empty, redirect to index page
	    if(empty($action)) {
	        $action = DEFAULT_ACTION;
	    }
	    $controller_name = $controller;
	    $controller = ucwords($controller);

	    $prefix=strtolower($_SERVER['REQUEST_METHOD']);

	    if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
	    	$prefix=$prefix."Ajax";
	    }

	    $action=$prefix.$action;
	    	    
	    if (class_exists($controller) and method_exists($controller, $action)) {
	    	$dispatch = new $controller($controller_name,$action);
	    	call_user_func_array([$dispatch,$action],$query_string);
	    }elseif(file_exists(ROOT . DS .'static' . DS . $controller . '.php')) {
	    	include (ROOT . DS .'static' . DS . $controller . '.php');
	    }else{
	     	header('Location: '.PATH.'/404');	
	    }	    
	}
}