<?php
ini_set('display_errors','On');
ini_set('display_startup_errors','On');

//qoo welcome application

require('init.php');

try {
$fc = new \qoo\controller\FrontController();
$view = new \qoo\controller\View();
$view->setView('default');
$fc->dispatcher->setControllerParameters( array('view' => $view) );


$fc->router->createRoute('index')
				->map('')
				->setParam('controller','DefaultController')
				->setParam('action' , 'index');

$fc->router->createRoute('forced_error')
				->map('/error')
				->setParam('controller','DefaultController')
				->setParam('action' , 'testError');
				
				
$fc->router->createRoute('forward')
				->map('/forward')
				->setParam('controller','DefaultController')
				->setParam('action' , 'testForward');
				
				
$fc->router->createRoute('404')
				->map('/404')
				->setParam('controller','DefaultController')
				->setParam('action' , '_404');				
				
				
$fc->router->createRoute('forced_exception')
				->map('/exception')
				->setParam('controller','DefaultController')
				->setParam('action' , 'testException');							
										
$fc->router->createRoute('parameter_test')
				->map('/hello/{name}/')
				->setParam('controller','DefaultController')
				->setParam('action' , 'testParameter');			
										
$fc->router->createRoute('php_info')
				->map('/phpinfo')
				->setParam('controller','DefaultController')
				->setParam('action' , 'phpInfo');

$fc->dispatcher->useDefaults(true);
$fc->dispatch();



} catch (\qoo\core\Exception   $e)
{
	/* The ExceptionHandler class encapsulates some useful methods that help you
	*	dealing with exceptions.
	*
	*	For each exception you can specify which classes and methods will deal with it.
	*	Let's imagine that our web application has only two kind of exceptions e1 and e2,
	*	and let's say that e1 is critical while e2 is not. You might want to know everytime
	*	e1 occurs by emailing a not to your staff:
	*
	*/
	$handler = new \qoo\core\ExceptionHandler();
	$handler->printHtmlReport($e);
}
echo QOO_VERSION;
?>
