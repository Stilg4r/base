<?php
function load_lib($lib){
	$path=ROOT.DS.'core'.DS.'libs'.DS.$lib.'.php';
	if (file_exists($path)){
        require_once($path);
    }else{
   		$trace = debug_backtrace();
		trigger_error('fallo al cargar la bibiloteca '.$path.' '.$trace[0]['file'].' en la linea '.$trace[0]['line'],E_USER_ERROR);
    }
}
function load_conf($conf){
	$path=ROOT.DS.'config'.DS.$conf.'.php';
	if (file_exists($path)){
        require_once($path);
    }else{
   		$trace = debug_backtrace();
		trigger_error('fallo al cargar la configuracion '.$path.' '.$trace[0]['file'].' en la linea '.$trace[0]['line'],E_USER_ERROR);
    }
}
