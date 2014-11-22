<?php
require_once __DIR__.'/../vendor/autoload.php'; // Auto loads the dependencies, e.g. the whole of silex

// Instantiate the app
$app = new Silex\Application();


// The standard simple hello world example
$app->get('/hello/{name}', function ($name) use ($app) {
  return 'Hello '.$app->escape($name);
});

// An even simpler display of the main page, complete with html in the php, ew!
$app->get('/', function() use ($app){
	return '<body>The main Thinkocracy page!</body>';
});

// Let's get some api call & response working up in here
$app->get('/api/{call}/{data}', function($call, $data) use ($app){
	// We can actually just pass json data encoded for the url to {data} soon.
	$response = 'Call to a api type of '.$call.' with data '.$data;

	return $response; // This will be a json response shortly.
});

// Aw yeah, run dat app
$app->run();