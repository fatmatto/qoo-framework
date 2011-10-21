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
	*	TODO TUTTO CIò NON HA SENSO! ho implementato un setHandler() non statico, significa che gli
	*	handler li setto nel catch() non capisco che cosa volessi fare :S
	
	*	sarebbe più sensato qualcosa del tipo
	*	class e1 extends qoo/core/Exception
	*	{
			protected $_Handlers = array( array('Class1','method1'), 'global_function_name', array('class2','m2') );
	*	}
	*	così a priori so cosa fare con questa exception e get handlers mi da _Handlers
	*
	*	mi evita di scrivere mille mila catch bla bla bla
	*/
	$handler = new \qoo\core\ExceptionHandler();
	$handler->printHtmlReport($e);
}
echo QOO_VERSION;
?>
