<?php
class Controller extends Application {
    protected $controller;
   	protected $action;
	protected $view;
	protected $template;
	public function __construct($controller, $action) {
		parent::__construct();
		$this->controller = $controller;
		$this->action = $action;
		$this->view = new View();
		$this->template = DEFAULT_TEMPLATE;
	}
	public function getModel(){
        if (property_exists($this->controller, '_model')) {
			$properties = get_class_vars($this->controller);
			return $properties['model'];
        }else{
        		return $this->controller.'Model';
        }
	}
	protected function getView() {
		return $this->view;
	}
	protected function checkToken($Token,$formName,$f){
		if( $Token === $this->generateToken( $formName ) ){
			return true;
		}else{
			$f();
			return false;
		}
	}
	protected function setTemplate($template) {
		$this->template=$template;
	}
	protected function addHelper($helper=null) {
		if (!isset($helper)) {
			$helper = $this->controller;
		}
		$path=ROOT.DS.'application'.DS.'controllers'.DS.'helpers'.DS.strtolower($helper).'.php';
		if (file_exists($path)){
        	require_once($path);
    	}else{
    		$trace = debug_backtrace();
			trigger_error('no existe helper ' . $path  .' '. $trace[0]['file'] .' en la línea ' . $trace[0]['line'],E_USER_ERROR);
    	}
	}
	protected function renderView($view_name=null){
		if (!isset($view_name)) {
			$view_name = strtolower($this->controller).'/'.$this->action;
		}
		$this->view->render($view_name,$this->template);
	}
	protected function setVars($vars){
		foreach($vars as $var => $value) {
			$this->view->set($var,$value);
		}
	}
	protected function setVar($var,$value){
		$this->view->set($var,$value);
	}
	protected function addCss($csss=null){
		if (!isset($csss)) {
			$csss=[strtolower($this->controller).'/'.$this->action];
		}
		$this->view->addCss($csss);
	}
	protected function addJs($jss=null){
		if (!isset($jss)) {
			$jss=[strtolower($this->controller).'/'.$this->action];
		}		
		$this->view->addJs($jss);
	}
}