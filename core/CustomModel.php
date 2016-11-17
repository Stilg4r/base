<?php
load_conf('db');
class CustomModel extends Model{
	private $purifier;
	private $errors;
	function __construct()
	{
		$this->purifier = null;
	}
	protected function noEmpty($arr){
		return !(in_array("", $arr));
	}
	protected function unique($attr){
		$val=$this->get($attr);
		if ( ORM::for_table($this->_get_table_name(get_class($this)))->where($attr,$val)->find_many() ) {
			return false;
		}else{
			return true;
		}
	}
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
	public function purify($property,$value) {
		if (is_null($this->purifier)) {
			$config = HTMLPurifier_Config::createDefault();
			$config->set('Core.Encoding', 'UTF-8');
			$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); 
			$config->set('HTML.AllowedElements', '');  
			$config->set('Attr.AllowedClasses', '');  
			$config->set('HTML.AllowedAttributes', '');  
			$config->set('AutoFormat.RemoveEmpty', true);  
			$this->purifier = new HTMLPurifier($config);			
		}
		return $this->purifier->purify($value);
	}
	public function __set($property, $value) {
		parent::__set($property,$this->purify($property,$value));
	}
	public function set($key, $value = null) {
		parent::set($key,$this->purify($key,$value));
	}
	public function rawSet($key, $value = null)
	{
		parent::set($key,$value);
	}	
	public function validateEmail($value){
		$dns=explode("@",$value);
		if (filter_var($value, FILTER_VALIDATE_EMAIL) and checkdnsrr(array_pop($dns),"MX") ) {
			return TRUE;
		}else{
			return FASE;
		}
	}
	public function setError($error) {
		$this->errors=$error;
	}
	public function getErrors(){
		return $this->errors;
	}
}