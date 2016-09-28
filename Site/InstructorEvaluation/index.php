<?php  
/**
* Project: IT Instructor Evaluations
* File: index.php
* Authors: James Staab and Craig Koch 
* Date: 03/31/2016
*
* This is just a landing page
*/
require('assets/php_frameworks/fat_free_framework/lib/base.php');

$router = \Base::instance();
$router->set('DEBUG', 3);
$router->config('InstructorEvaluation.cfg');
require($router->get('dbPath').'/db.php');
setDbParameter($router); 

$router->set('title', 'Green River IT Instructor Evaluation');
$router->set('description', 'This is a tool for the Green River IT Program staff to recieve feedback from their students anonymously');
$router->set('header', 'views/navbar.htm');
$router->set('footer', 'views/footer.htm');
$router->set('AUTOLOAD', 'controllers/;models/;assets/classes/');

$router->route('GET /', function($router)
{
	$controller = new EvaluationController($router);
	$controller->getEvaluationCode();
});

$router->route('POST /', function($router)
{
	$controller = new EvaluationController($router);
	$evaluationCode = $router->get('POST.evaluationCode');
	$controller->checkEvaluationCode($evaluationCode);
});

$router->route('POST|GET /evaluation/@code', function($router, $params)
{
	$controller = new EvaluationController($router);
	$inProgress = $controller->isEvaluationInProgress();
	if($inProgress)
	{
		$controller->validateEvaluation();
	}
	else
	{
		
		$controller->startEvaluation($params['code']);
	}
});

$router->route('GET @thanks: /thanks', function($router)
{
	$router->clear("SESSION.evalSheet");
	$router->set('bodyContent', 'views/endEvaluation.htm');
	echo \Template::instance()->render('views/layout.php');
});

$router->route('GET /makeEvaluation', function($router)
{
	if(!$router->get('SESSION.permissions.1'))
	{
		$router->reroute('/NotAuthorized');
	}
	else
	{
		$controller = new MakeTestController($router);
		$controller->renderView();
	}
});

$router->route('POST /makeEvaluation', function($router)
{
	if(!$router->get('SESSION.permissions.1'))
	{
		$router->reroute('/Login');
	}
	else
	{
		$controller = new MakeTestController($router);
		$controller->validateCreateEvaluationForm();
	}
});

$router->route('GET|POST  /reports', function($router)
{
	if(!$router->get('SESSION.permissions.1'))
	{
		$router->reroute('/NotAuthorized');
	}
	else
	{
		$controller = new ReportController($router);
		$controller->getAllEvaluations();
	}
});

$router->route('GET|POST  /report/@evaluationID', function($router, $params)
{
	if(!$router->get('SESSION.permissions.1'))
	{
		$router->reroute('/NotAuthorized');
	}
	else
	{
		$controller = new ReportController($router);
		$controller->getEvaluationDetails($params['evaluationID']);
	}
});

$router->route('GET|POST  /Login', function($router)
{
	$controller = new LoginController($router);
	$controller->login();
});

$router->route('GET|POST  /Logout', function($router)
{
	$controller = new LoginController($router);
	$controller->logout();
});

$router->route('GET|POST  /PasswordReset', function($router)
{
	$controller = new LoginController($router);
	$controller->renderPasswordResetPage();
});

$router->route('GET|POST  /ChangePassword/@urlkey', function($router, $params)
{
	$controller = new LoginController($router);
	$controller->changePasswordFromKey($params['urlkey']);
});

$router->route('GET /Logout', function($router)
{
	$router->clear("SESSION");
	$router->reroute('/Login');
});

$router->route('GET|POST  /Instructor/CreateUser', function($router)
{
	$controller = new AdministratorController($router);
	$controller->createUser();
});

$router->route('GET|POST  /Instructor/UserManagement', function($router)
{
	$controller = new AdministratorController($router);
	$controller->getUsers();
});


$router->route('GET|POST /NotAuthorized', function($router)
{
	$router->set('bodyContent', 'views/notAuthorized.htm');
	echo \Template::instance()->render('views/layout.php');
});

// $router->set('ONERROR',
//     function($router) {
//         // custom error handler code goes here
//         // use this if you want to display errors in a
//         // format consistent with your site's theme
//         echo $router->get('ERROR.code');
//         echo "<br>";
//         echo $router->get('ERROR.status');
//     }
// );

$router->run();

?>
