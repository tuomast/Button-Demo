<?php

$routes->get('/', function() {
  DefaultController::index();
});

$routes->get('/offset', function() {
  DefaultController::offset();
});

$routes->get('/login', function() {
  AccountController::login();
});

$routes->get('/test', function() {
  AccountController::list();
});