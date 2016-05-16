<?php
/**
 * Clase personalizada para el modelo
 */
load_lib('idiorm');
load_lib('paris');
load_conf('db');
/**
 * Clase personalizada para el modelo, se agregan validadores 
 */
class CustomModel extends Model{
	protected function null($var) {
		return ($var=="")?null:$var;
	}

	/**
	 * Valida que el array no contenga valores vacios
	 * @param  array $arr arreglo de valores
	 * @return boolean false si no encuentra valores vacios
	 */
	protected function noempty($arr){
		if (in_array("", $arr )){
			return false;
		}else{
			return true;
		}
	}
	/**
	 * valida que sea unico 
	 * @param  string $attr atributo a validar 
	 * @param  string $val  valor
	 * @return boolean      false si lo enconto
	 */
	protected function unique($attr,$val){
		if ( ORM::for_table($this->_get_table_name(get_class($this)))->where($attr,$val)->find_many() ) {
			return false;
		}else{
			return true;
		}
	}
	/**
	 * Valida la existencia de elemento del modelo, si no lo encuenta ejecuta una funcion
	 * @param integer 	$id Id del a buscar 
	 * @param function 	$f 	acciones a ejecutar si no lo encuentra 
	 */
	public static function ifExist($id,$f){
		if ($modelobj=self::findOne($id)) {
			return $modelobj;
		}else{
			$f();
		}
		
	}
	public function columns() {
		return ORM::for_table('')->rawQuery('SHOW COLUMNS FROM '.$this->_get_table_name(get_class($this)));
	}

	public function __set($property, $value) {
		load_lib('HTMLPurifier/HTMLPurifier.auto');
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Core.Encoding', 'UTF-8');
		$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); 
		$config->set('HTML.AllowedElements', '');  
		$config->set('Attr.AllowedClasses', '');  
		$config->set('HTML.AllowedAttributes', '');  
		$config->set('AutoFormat.RemoveEmpty', true);  
		$purifier = new HTMLPurifier($config);

		$value=$purifier->purify($value);
		$value=$this->null($value);

		parent::__set($property,$value);
	}

}