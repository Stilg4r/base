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

if ($_SESSION['canary']['birth'] < time() - 300) {
	session_regenerate_id(true);
	$_SESSION['canary']['birth'] = time();
}

require_once('core' . DS . 'bootstrap.php');