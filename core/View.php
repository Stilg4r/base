<?php
/**
 * Clase de la vista
 */

/**
 * Clase que renderiza la vista 
 */
class View extends Application{
	
	protected $variables = array();
	protected $css=[];
	protected $js=[];

	function __construct(){}

	function tokenForm($formname){
		echo '<input type="hidden" name="CSRFToken" value="'.$this->generateToken($formname).'">';
	}

	/**
	 * Pasa las variable del controlador a la visota
	 * @param string $name  nombre de la variable
	 * @param object $value valor de la variable
	 */
	function set($name,$value) {
		$this->variables[$name] = $value;
	}
	/**
	 * renderiza una vista
	 * @param  string $view_name nombre de la vista
	 * @param  string $snippet   nombre de la plantilla
	 */
	function render($view_name,$snippet = DEFAULT_TEMPLATE) {
		extract($this->variables);
		
		if( file_exists(ROOT . DS .'application' . DS . 'views' . DS . $snippet . '.php') ) {
			include (ROOT . DS .'application' . DS . 'views' . DS . $snippet . '.php');
		} else {
			echo "No existe la plantilla ".$snippet."\n" ;
		}		
	}
	/**
	 * Renderiza un contenido parcial
	 * @param  strig $render_partial nombre de la vista parcial
	 */
	function render_partial($render_partial){
		
		extract($this->variables);

		if( file_exists(ROOT . DS .'application' . DS . 'views' . DS . $render_partial . '.php') ) {
			include (ROOT . DS .'application' . DS . 'views' . DS . $render_partial . '.php');
		} else {			
			echo "No existe la vista parcial ".$render_partial."\n" ;
		}	
	}
	protected function css(){
	 	foreach ($this->css as $css) {
	 		echo '<link rel="stylesheet" href="'.PATH.'/css/'.$css.'.css">';
	 		echo "\r\n";
	 	}
	}
	protected function js(){
		foreach ($this->js as $js) {
			echo '<script type="text/javascript" src="'.PATH.'/js/'.$js.'.js"></script>';
			echo "\r\n";
		}
	}

	public function addCss($csss){
		$this->css=$this->css+$csss;
	}
	
	public function addJs($jss){
		$this->js=$this->js+$jss;
	}

}