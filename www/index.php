<?php
require_once realpath(__DIR__.'/../').'/vendor/autoload.php'; // Auto loads the dependencies, e.g. the whole of silex

// Instantiate the app
$app = new Silex\Application();

require_once realpath(__DIR__.'/../').'/config.php';
require_once ROOT.'core/core.php'; // Main includes that are used everywhere.

// Translate json appropriately.
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
//use App\ideas; // Use the shortcut for the idea class.
//use App\ideas\IdeaFactory as IdeaFactory; // Use the shortcut for the ideafactory class.

// This checks if a request is sending json, and decodes the json if possible
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true); // Turn request into array.
        $request->request->replace(is_array($data) ? $data : array()); // Ensure it's an array, empty if nothing else.
    }
});


// The standard simple hello world example
$app->get('/hello/{name}', function ($name) use ($app) {
  return 'Hello '.$app->escape($name);
});

// An even simpler display of the main page, complete with html in the php, ew!
$app->get('/', function() use ($app){
	return '
	<head>
	</head>
	<body>
		<h1>The main Thinkocracy page!</h2>
		<img src="images/cat.jpg">
	</body>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script src="js/to.js"></script>
	<script>
	$(function(){
		pullIdeas(); // Pull ideas from the api!
		pullIdeaById(1, function(data){ // Pull the first idea and execute some callback upon it
			console.log(data, data.phrase); // Just console log it for now.
		}); 
	});
	</script>';
});

$app->get('/api/ideas/search/{term}', function($term) use ($app){
	$filtered_ideas = IdeaFactory::search($term);
	return $app->json($filtered_ideas);
});

$app->get('/api/ideas/{id}', function($id) use ($app){
	$id = (int) $id;
	if(!$id){
		return $app->json(array('success'=>'false','error'=>'No valid idea id specified'), 400);// Bad request.
	}
	$idea = IdeaFactory::idea($id);
	if(!$idea instanceof Idea){
		return $app->json(array('success'=>'false','error'=>'No idea found for that id'), 404);// Idea not found.
	}
	return $app->json($idea);
});

$app->get('/api/ideas', function() use ($app){
	$ideas = IdeaFactory::all();
	return $app->json($ideas);
});

$app->get('/api/test', function() use ($app){
	$success = array('success'=>true);
	return $app->json($success);
});

// Manually test with curl:
//curl http://localhost:9999/api/ideas -d '{"idea":"Hello World!"}' -H 'Content-Type: application/json'

$app->post('/api/ideas', function(Request $request) use ($app){
    $post = array(
        'idea' => $request->request->get('idea'),
    );
    $idea = new Idea($post['idea']);
    $idea = IdeaFactory::saveIdea($idea);
    $success = '{"success":true}';
    return $app->json($post, 201);
});

$app->get('/api/ideas', function() use ($app){
	return 'All ideas';
});

// Let's get some api call & response working up in here
$app->get('/api/{call}/{data}', function($call, $data) use ($app){
	// We can actually just pass json data encoded for the url to {data} soon.
	$response = 'Call to a api type of '.$call.' with data '.$data;

	return $response; // This will be a json response shortly.
});

// Aw yeah, run dat app
$app->run();