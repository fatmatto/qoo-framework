<?php
namespace qoo\controller;

interface DispatcherInterface
{

	public function getDefaultControllerName();
	public function setDefaultControllerName($controller_name);
	public function getDefaultActionName();
	public function setDefaultActionName($action_name);
	
	public function useDefaults($flag = true);
	
	/**
	*	Forces the dispatcher to dispatch the $controller_name controller
	*	This feature is off by default, calling it with a controller name as
	*	parameter will turn it on.
	*
	*	$dispatcher->frontController('stressedController');	
	*
	*	To disable forcing just set it to null:
	*
	*	$dispatcher->forceController(null)
	**/
	public function forceController($controller_name);
	
	/**
	*
	*	Forces the dispatcher to dispatch the $action_name action.
	*
	*	Like forceController() this is off by default, if you want to force
	*	the dispatcher to call an action without regard for the request
	*	just call forceAction('actionToForce').
	*
	*	When you don't want a forced action, call forceAction(null)
	*	
	*
	**/
	public function forceAction($action_name);
	
	/**
	*
	*	Instantiates the controller and invokes the right action
	*
	**/
	public function dispatch($request, $response, $parameters);
	
	/**
	*
	*
	*	Forces the dispatcher to instantiate the $controller controller and to invoke the $action action.
	**/
	public function forceDispatch($controller, $action, $request, $response, $params = array());
	
}
?>