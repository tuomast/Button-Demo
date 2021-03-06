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

$routes->get('/logout', function() {
  AccountController::logout();
});

$routes->get('/signup', function() {
  AccountController::signup();
});

$routes->post('/signup', function() {
  AccountController::store();
});

$routes->post('/offset/complete', function() {
  DefaultController::offset_complete();
});

$routes->get('/user/profile', function() {
  AccountController::profile();
});

