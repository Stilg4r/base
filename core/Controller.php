<?php
/**
 * Clase base para los controladores
 */

/**
 * Clase base para los controladores
 */
class Controller extends Application {
	
    protected $controller;
   	protected $action;
	protected $model;
	protected $view;
	/**
	 * constructor, carga los helper en automatico
	 * @param string $controller nombre del controlador
	 * @param string $action accion de del controlador
	 */
	public function __construct($controller, $action) {
		parent::__construct();
		$this->controller = $controller;
		$this->action = $action;
		$this->view = new View();
		if (file_exists(ROOT.DS.'application'.DS.'controllers'.DS.'helpers'.DS.strtolower(get_class($this)).'.php')){
        	require_once(ROOT.DS.'application'.DS.'controllers'.DS.'helpers'.DS.strtolower(get_class($this)).'.php');
    	}

        if (property_exists($controller, '_model')) {
			$properties = get_class_vars($controller);
			$this->model=$properties['model'];
        }else{
        	$this->model=$controller.'Model';
        }
	}

	protected function checkToken($Token,$formName,$f){
		if( $Token === $this->generateToken( $formName ) ){
			return true;
		}else{
			$f();
			return false;
		}
	}
	/**
	 * Rentorno una vista
	 * @return view vista del controlador
	 */
	protected function get_view() {
		return $this->view;
	}
	/**
	 * Wrapper para render, renderiza una vista todo en uno 
	 * @param  string $view_name nombre de la vista, la vista tiene que estar en view en general se organiza en carpetas
	 * @param  string $mesaje    mensaje a mostrar
	 * @param  string $type      tipo de mensaje
	 * @param  array  $vars      Array que contenga las variables de la vita 
	 * @param  string $template  Template 
	 */
	protected function render($view_name, $vars=null, $template=null){
		if (!is_null($vars)) {
			foreach($vars as $var => $value) {
    			$this->view->set($var,$value);
			}
		}
		if (is_null($template)){
			$this->view->render($view_name);
		}else{
			$this->view->render($view_name,$template);
		}
	}
	/**
	 * Wrapper para poner variables en la vista
	 * @param string $var   nombre de la variable
	 * @param object $value valor
	 */
	protected function set($var,$value){
		$this->view->set($var,$value);
	}

	protected function addcss($csss){
		foreach ($csss as $css) {
			$this->view->css[]=$css;
		}
	}
	protected function addjs($jss){
		foreach ($jss as $js) {
			$this->view->js[]=$js;
		}
	}

}