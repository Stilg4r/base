<?php
load_conf('db');
class CustomModel extends Model{
	protected $purifier;
	private $errors;
	protected $_columns = false;
	function __construct()
	{
		$this->purifier = null;
		// if (isset($_SESSION[get_class($this)])) {
		// 	$this->_columns = $_SESSION[get_class($this)];
		// }else{
		// 	$columns = $this->columns()->findArray();
		// 	$this->_columns = array_column($columns,'COLUMN_NAME');
		// 	$_SESSION[get_class($this)] = $columns;
		// }
	}
	protected static function returnNull($value='')
	{
		if (empty($value)) {
			return null;
		}else{
			return $value;
		}
	}
	protected static function noEmpty($arr){
		return !(in_array("", $arr));
	}
	protected function unique($attr){
		$val=$this->get($attr);
		$result = ORM::for_table($this->_get_table_name(get_class($this)))->where($attr,$val)->asArray();
		if ( $result ) {
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
		$table = $this::_get_table_name(get_class($this));
        switch(ORM::get_db()->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'sqlsrv': return ORM::for_table('')->rawQuery("select COLUMN_NAME from information_schema.columns where table_name = '".$table."'");
            case 'dblib':
            case 'mssql':
        }
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
		return $this->purifier->purify($this->returnNull($value));
	}
	public function __set($property, $value) {
		if ($this->_columns) {
			if (in_array($property,$this->_columns)) {
				return parent::__set($property,$this->purify($property,$value));
			}
		}else {
			return parent::__set($property,$this->purify($property,$value));
		}
	}
	public function set($key, $value = null) {
		if ($this->_columns) {
			if (in_array($key,$this->_columns)) {
				return parent::set($key,$this->purify($key,$value));
			}
		}else {
			return parent::set($key,$this->purify($key,$value));
		}
	}
	public function rawSet($key, $value = null)
	{
		return parent::set($key,$value);
	}
	public static function validateEmail($value){
		$dns=explode("@",$value);
		if (filter_var($value, FILTER_VALIDATE_EMAIL) and checkdnsrr(array_pop($dns),"MX") ) {
			return TRUE;
		}else{
			return FASE;
		}
	}
	protected function setError($error) {
		$this->errors=$error;
	}
	public function getErrors(){
		return $this->errors;
	}
	public function getColumns()
	{
		return $this->_columns;
	}
}