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

$routes->post('/login', function() {
  AccountController::handle_login();
});

$routes->get('/signup', function() {
  AccountController::signup();
});

$routes->post('/signup', function() {
  AccountController::store();
});

