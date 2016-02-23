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
	protected $models;
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
	}
	public function checkToken($formName,$f){
		if ( empty( $_POST['CSRFToken'] ) ) {
			$f();
			return false;
		}else{
			if( $_POST['CSRFToken'] === $this->generateToken( $formName ) ){
				return true;
			}else{
				$f();
				return false;
			}
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
	protected function render($view_name, $mesaje=null, $type=null, $vars=null, $template=null){
		if (!is_null($vars)) {
			foreach($vars as $var => $value) {
    			$this->view->set($var,$value);
			}
		}
		if(!is_null($mesaje)){
			if (is_null($type)){
				$this->view->set_alert($mesaje);
			}else{
				$this->view->set_alert($mesaje,$type);
			}
		}

		if (is_null($template)){
			$this->view->render($view_name);
		}else{
			$this->view->render($view_name,$template);
		}
	}
	/**
	 * Wrapper para mostara alertas
	 * @param  string $mesaje Mensaje a mostrar
	 * @param  string $type   Tipo de alerta
	 */
	protected function alert($mesaje,$type='info'){
		$this->view->set_alert($mesaje,$type);
	}
	/**
	 * Wrapper para poner variables en la vista
	 * @param string $var   nombre de la variable
	 * @param object $value valor
	 */
	protected function set($var,$value){
		$this->view->set($var,$value);
	}

	public function addcss($csss){
		foreach ($csss as $js) {
			$this->view->css[]=$css;
		}
	}
	public function addjs($jss){
		foreach ($jss as $js) {
			$this->view->js[]=$js;
		}
	}

}