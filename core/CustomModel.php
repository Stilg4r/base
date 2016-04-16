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
		if ( self::where($attr, $val )->find_one() ) {
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
}