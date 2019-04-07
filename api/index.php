<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/src/Main.php';


$app = new \App\Main();
// Create Router instance
$router = new \Bramus\Router\Router();

// Activate CORS
function sendCorsHeaders() {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: Authorization");
  header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
}

$router->options('/.*', function() {
    sendCorsHeaders();
});

sendCorsHeaders();

$router->set404(function () {
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	echo '404, route not found!';
});

// Check JWT on private routes
$router->before('GET|POST|PUT|DELETE', '/.*', function() use ($app) {
  $requestHeaders = apache_request_headers();
  if (!isset($requestHeaders['authorization']) && !isset($requestHeaders['Authorization'])) {
    header('HTTP/1.0 401 Unauthorized');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array("message" => "No token provided."));
    exit();
  }

  $authorizationHeader = isset($requestHeaders['authorization']) ? $requestHeaders['authorization'] : $requestHeaders['Authorization'];

  if ($authorizationHeader == null) {
    header('HTTP/1.0 401 Unauthorized');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array("message" => "No authorization header sent."));
    exit();
  }

  $authorizationHeader = str_replace('bearer ', '', $authorizationHeader);
  $token = str_replace('Bearer ', '', $authorizationHeader);

  try {
    $app->setCurrentToken($token);
  }
  catch(\Auth0\SDK\Exception\CoreException $e) {
    header('HTTP/1.0 401 Unauthorized');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array("message" => $e->getMessage()));
    exit();
  }
});

$router->get('/alerts', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->alertsEndpoint();
});

$router->get('/alerts/{id}', function($user_id) use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userAlertsEndpoint($user_id);
});

$router->get('/observations', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->obsEndpoint();
});

$router->get('/observations/{id}', function($user_id) use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userObsEndpoint($user_id);
});

$router->post('/observations', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userAddObsEndpoint();
});

$router->post('/observations_dim/', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userAddObsDimEndpoint();
});

$router->post('/observations_verify/', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userAddObsVerifEndpoint();
});

$router->post('/user', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userAddEndpoint();
});

$router->post('/user/prefs', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userAddPrefsEndpoint();
});

$router->put('/user/{uid}/prefs/{pid}', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userUpdatePrefsEndpoint();
});

$router->get('/user/{uid}/prefs', function($user_id) use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userCheckPrefsEndpoint($user_id);
});

$router->get('/user/{uid}/prefs/{pid}', function($user_id, $pref_id) use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->userGetPrefEndpoint($user_id, $pref_id);
});

$router->get('/agritypes', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->agritypesEndpoint();
});

$router->get('/alerttypes', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->alerttypesEndpoint();
});

$router->get('/nuts2', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->nuts2Endpoint();
});

$router->get('/nuts3/{id}', function($n2) use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->nuts3Endpoint($n2);
});

$router->get('/nuts5/{id}', function($n3) use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo $app->nuts5Endpoint($n3);
});



// Check for read:alerts scope
$router->before('GET', '/private-scoped', function() use ($app) {
  if (!$app->checkScope('read:alerts')){
    header('HTTP/1.0 403 forbidden');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array("message" => "Insufficient scope."));
    exit();
  }
});


$router->get('/private-scoped', function() use ($app){
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($app->privateScopedEndpoint());
});

$router->run();
