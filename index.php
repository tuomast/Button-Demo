<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('BASE_PATH', '');

if(session_id() == '') {
	session_start();
}

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

$routes = new \Slim\App();
$routes->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);

$routes->get('/tietokantayhteys', function(){
	DB::test_connection();
});

require 'config/routes.php';

$routes->run();
