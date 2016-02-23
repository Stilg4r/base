<?php
/**
 * Clase de la vista
 */

/**
 * Clase que renderiza la vista 
 */
class View extends Application{
	
	protected $variables = array();
	public $css=[];
	public $js=[];

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
	public function css(){
	 	foreach ($this->css as $css) {
	 		echo '<link rel="stylesheet" href="/css/'.$css.'.css">';
	 	}
	}
	public function js(){
		foreach ($this->js as $js) {
			echo '<script src="/js/'.$js.'.js"></script>';
		}
	}
}