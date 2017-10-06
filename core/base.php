<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd().DS);
define('APPLICATION', ROOT.'application'.DS);
define('CLASSTEMPLATES', ROOT.'core'.DS.'ClassTemplates'.DS);

$help=<<<EOT
Usage
	base controller <controler name> 	#Crea un controlador
	base model <model name>	 		#Crea un modelo
	base mvc <name>					#Crea un modelo controlar y directorio de vistas

EOT;

function save($class,$template,$msg){
	if (!file_exists($class)) {
		$newFile = fopen($class, 'w');
		fwrite($newFile, $template);
		fclose($newFile);
		chmod($class,0644);
	}else{
		echo $msg;
	}
}

function controller($name){
	$class = ucwords($name);
	$template = file_get_contents(CLASSTEMPLATES.'Controller.txt');
	$template = str_replace("#ClassName#", $class, $template);
	$class=APPLICATION.'controllers'.DS.$class.'.php';
	echo 'Controlador en '.$class."\n";
	save($class,$template,'Controlador ya existe');
}

function model($model){
	$class = ucwords($model).'Model';
	$template = file_get_contents(CLASSTEMPLATES.DS.'Model.txt');
	$template = str_replace("#ClassName#",$class, $template);
	$template = str_replace("#ModelName#",$model, $template);
	$class=APPLICATION.'models'.DS.$class.'.php';
	echo 'Modelo en '.$class."\n";
	save($class,$template,'Modelo ya existe');
}
function view($class, $method = '')
{
	$method = (empty($method))?'index':$method;
	$class = strtolower($class);
	$view_dir = APPLICATION.'views'.DS.$class;
	if (!is_dir($view_dir)) {
		if (mkdir($view_dir,0755)) {
			echo 'Directorio de vista en '.$view_dir."\n";
		}else{
			echo 'No se pudo crear path de la vista';
			return fale;
		}
	}
	$template = file_get_contents(CLASSTEMPLATES.DS.'View.txt');
	$template = str_replace("#View#",$class.'/'.$method, $template);
	$view=$view_dir.DS.$method.'.php';
	echo 'vista vista en '.$view."\n";
	save($view,$template,'Modelo ya existe');
}

if (isset($argv[2])) {
	switch ($argv[1]) {
		case 'controller':
			controller($argv[2]);
			break;
		case 'model':
			model($argv[2]);
			break;
		case 'view':
			view($argv[2],$argv[3]);
			break;
		case 'mvc':
			controller($argv[2]);
			model($argv[2]);
			view($argv[2]);
			break;
		default:
			echo $help;
			break;
	}
}else{
	echo $help;
}