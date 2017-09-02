<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('BASE_PATH', '');

if(session_id() == '') {
	session_start();
}

header('Content-Type: text/html; charset=utf-8');

require '../button/vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);

$routes = new \Slim\App($c);

$routes->get('/tietokantayhteys', function(){
	DB::test_connection();
});

require 'config/routes.php';

$routes->run();
