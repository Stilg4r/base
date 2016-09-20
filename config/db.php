<?php
ORM::configure(ADAPTER.':host='.HOST.';dbname='.DBNAME);
ORM::configure('username', USER);
ORM::configure('password', PASS);
ORM::configure('caching', true);
if (DEBUG) {
	ORM::configure('logging', true);
	ORM::configure('logger', function($log_string, $query_time) {
    	error_log(print_r($log_string . ' in ' . $query_time, TRUE)); 
	});
}