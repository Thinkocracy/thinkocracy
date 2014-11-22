<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/hello/{name}', function ($name) use ($app) {
  return 'Hello '.$app->escape($name);
});

$app->get('/', function() use ($app){
	return '<body>The main Thinkocracy page!</body>';
});

// Let's get some api stuff working up in here
$app->get('/api/{call}/{data}', function($call, $data) use ($app){
	$response = 'Call to a api type of '.$call.' with data '.$data;

	return $response; // This will be a json response shortly.
});


$app->run();