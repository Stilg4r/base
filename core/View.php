<?php
class View extends Application{
	protected $variables = array();
	protected $css=[];
	protected $js=[];
	function __construct(){}
	function tokenForm($formname){
		echo '<input type="hidden" name="CSRFToken" value="'.$this->generateToken($formname).'">';
	}
	function set($name,$value) {
		$this->variables[$name] = $value;
	}
	function render($view_name,$snippet = DEFAULT_TEMPLATE) {
		extract($this->variables);
		$path=ROOT . DS .'application' . DS . 'views' . DS . $snippet . '.php';
		if( file_exists($path) ) {
			include ($path);
		} else {
    		$trace = debug_backtrace();
			trigger_error('no existe plantilla '.$path.' '.$trace[0]['file'].' en la linea '.$trace[0]['line'],E_USER_ERROR);
		}
	}
	function render_partial($render_partial){
		extract($this->variables);
		$path=ROOT . DS .'application' . DS . 'views' . DS . $render_partial . '.php';
		if( file_exists($path) ) {
			include ($path);
		} else {			
    		$trace = debug_backtrace();
			trigger_error('no existe contenido parcial '.$path.' '.$trace[0]['file'].' en la linea '.$trace[0]['line'],E_USER_ERROR);
		}
	}
	protected function css(){
		require_once(ROOT.DS.'config'.DS.'css_alias.php');
	 	foreach ($this->css as $css) {
	 		if (file_exists(ROOT.'/css/'.$css.'.css')) {
	 			echo '<link rel="stylesheet" href="'.PATH.'/css/'.$css.'.css">';
	 		}elseif (file_exists(ROOT.'/bower_components/'.$css.'.css')) {
	 			echo '<link rel="stylesheet" href="'.PATH.'/bower_components/'.$css.'.css">';
	 		}elseif (isset($alias[$css]) and file_exists(ROOT.$alias[$css])) {
	 			echo '<link rel="stylesheet" href="'.PATH.$alias[$css].'">';
	 		}elseif (preg_match('/^htt(ps|p):\/\/.*\.css$/', $css)) {
	 			echo '<link rel="stylesheet" href="'.$css.'">';
	 		}else{
	 			echo "<!-- No existe el archivo css -->";
	 		}
	 		echo "\r\n";
	 	}
	}
	protected function js(){
		require_once(ROOT.DS.'config'.DS.'js_alias.php');
		foreach ($this->js as $js) {
	 		if (file_exists(ROOT.'/js/'.$js.'.js')) {
	 			echo '<script type="text/javascript" src="'.PATH.'/js/'.$js.'.js"></script>';
	 		}elseif (file_exists(ROOT.'/bower_components/'.$js.'.js')) {
	 			echo '<script type="text/javascript" src="'.PATH.'/bower_components/'.$js.'.js"></script>';
	 		}elseif (isset($alias[$js]) and file_exists(ROOT.$alias[$js])) {
	 			echo '<script type="text/javascript" src="'.PATH.$alias[$js].'"></script>';
	 		}elseif (preg_match('/^htt(ps|p):\/\/.*\.js$/', $js)) {
	 			echo '<script type="text/javascript" src="'.$js.'"></script>';
	 		}else{
	 			echo "<!-- No existe el archivo js -->";
	 		}
	 		echo "\r\n";
		}
	}
	private function add2array(&$array,$item) {
		if (is_array($item)) {
			$array=$array+$item;
		}elseif (is_string($item)) {
			$array[]=$item;
		}
	}
	public function addCss($csss){
		$this->add2array($this->css,$csss);
	}
	public function addJs($jss){
		$this->add2array($this->js,$jss);
	}
}