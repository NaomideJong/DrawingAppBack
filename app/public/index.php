<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

// routes for the drawings endpoint
$router->get('/drawings', 'DrawingController@getAll');
$router->get('/drawings/(\d+)', 'DrawingController@getOne');
$router->get('/drawings/user/([\w-]+)', 'DrawingController@getByUser');
$router->post('/drawings', 'DrawingController@create');
$router->put('/drawings/(\d+)', 'DrawingController@update');
$router->delete('/drawings/(\d+)', 'DrawingController@delete');

// routes for the users endpoint
$router->post('/users/login', 'UserController@login');
$router->post('/users/register', 'UserController@register');

$router->run();