<?php
/**
 * Index recive todas las peticiones y maneja las seciones 
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

session_start();

if (isset($_REQUEST['url'])) {
	$url=$_REQUEST['url'];
}else {
	$url="";
}

if (!isset($_SESSION['user'])) {
	$url = 'login';
}

if (isset($_SESSION['keep']) and $_SESSION['keep'] ) {
	#nada
}else{
	// Make sure we have a canary set
	if (!isset($_SESSION['canary'])) {
		session_regenerate_id(true);
		$_SESSION['canary'] = ['birth' => time(),'IP' => $_SERVER['REMOTE_ADDR']];
	}

	if ($_SESSION['canary']['IP'] !== $_SERVER['REMOTE_ADDR']) {
		session_regenerate_id(true);
		$_SESSION=array();
		$_SESSION['canary'] = ['birth' => time(),'IP' => $_SERVER['REMOTE_ADDR']];
	}

	if ($_SESSION['canary']['birth'] < time() - 10000) {
		session_regenerate_id(true);
		$_SESSION['canary']['birth'] = time();
	}
}


require_once('core' . DS . 'bootstrap.php');