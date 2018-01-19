<?php
require_once('config'. DS . 'config.php');
require_once('core' . DS . 'functions.php');
function autoload($className) {
	if (file_exists(ROOT . DS .'core' . DS . ($className) . '.php')) {
        require_once(ROOT . DS .'core' . DS . ($className) . '.php');
    }else if (file_exists(ROOT . DS .'application' . DS . 'controllers' . DS . ($className) . '.php')) {
        require_once(ROOT . DS .'application' . DS . 'controllers' . DS . ($className) . '.php');
    }else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php');
	}else if (file_exists(ROOT . DS . 'application' . DS . 'helpers' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'helpers' . DS . $className . '.php');
	}
}
require ROOT . '/vendor/autoload.php';
spl_autoload_register('autoload');
Router::route($url);