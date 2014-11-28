<?php

// Environment specific configuration

define('ROOT', __DIR__.'/'); // The directory of thinkocracy, whereever you're keeping it.
define('BASE_URL', ('http://'.(isset($_SERVER['HTTP_HOST'])? $_SERVER['HTTP_HOST'] : 'localhost:9999').'/')); // The domain url of thinkocracy, e.g. http://localhost:9999/ during dev

$app['debug'] = true; // For debugging, in development only.
ini_set('display_errors', 1);
