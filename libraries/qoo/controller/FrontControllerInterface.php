<?php
namespace qoo\controller;
/**
*
*	Standard interface for front controller which has to wrap
*	the initialization of the dispatching process.
*
*	By default, it creates a Request a Response a Dispatcher and a Container
*	and these are passed to the action controller
*
**/
interface FrontControllerInterface
{
	public function setControllerParameters($params );
	public function getControllerParameters();
	
	public function dispatch();
	
	
}

?>