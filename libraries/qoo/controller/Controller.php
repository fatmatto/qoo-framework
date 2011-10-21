<?php

namespace qoo\controller;

use qoo\core;

/**
*
*
*
*
*
**/
abstract class Controller extends \qoo\core\ConstructorInjectable
{

	//Basic dependencies
	protected $_Dependencies = array(	'request' => 'qoo\controller\Request',
										'response' => 'qoo\controller\Response',
										'dispatcher' => 'qoo\controller\Dispatcher',
										 );
	

	/**
	*
	*	Standard constructor, it calls the constructor from its parent class ConstructorInjectable
	*	@see
	*
	*
	**/
	public function __construct($dependencies= array())
	{
		parent::__construct($dependencies);
		
		if (!isset($this->view) )
			$this->view = new View();
		
		$this->__init();
	}
	
	
	
	
	
	
	
	
	
	/**
	*
	*	Override this method instead of the constructor, your code will be executed
	*	right before the dependency management inside the constructor
	*
	*
	*
	**/
	protected function __init()
	{}
	
	
	
	
	
	
	
	
	
	/**
	*
	*	Shortcut for $this->dispatcher->dispatch()
	*
	*	@param $request Request The request to dispatch
	*	@return mixed
	**/
	protected function __dispatch($request,$response, $params = array())
	{
		
			return $this->dispatcher->dispatch($request, $this->response, $params);
															
	}
	
	
	
	
	
	
	
	/**
	*
	*	Forwards the current request to another action defined in another (or the same) controller
	*
	*
	*	$params by default contains $params['request'] do not overwrite it.
	*	//TODO check this
	*
	**/
	protected function __forward($action,$controller = null,$params = array())
	{
		
		//Trick
		$new_request = new \qoo\controller\Request();
		if ($controller === null)
			$controller = get_class($this);
		$new_request->setParam('controller',$controller);
		$new_request->setParam('action',$action);
		$params['request'] = $this->request;
		//In this way, the dispatcher will dispatch the controller and the action found in $new_request
		// but the request object instance stored in $params will overwrite $new_request
		// The forwarded controller and the previous controller have the <b>same</b> request instance.
		
		
		$forwarded_action_response = $this->dispatcher->dispatch($new_request,new Response(),$params);
		
		//The response from the lower level action is returned
		return $forwarded_action_response;
	}
	
	
	
	
	
	/**
	*	Calls an action from the ErrorController
	*	
	*
	*
	**/
	protected function __error($error_handler = 'index',$params= array())
	{
		
		//The response is cleaned in order to display only the error output
		$this->response->clear();
		
		
		//Execution is moved to the error controller
		$this->response = $this->__forward($error_handler,'ErrorController',$params);
	}
	
	/**
	*
	*	Handy redirect to the error controller's action to mimic 404 behaviour
	*	Dispatcher will call this action when it can't call a certain action from a controller
	*
	*
	*
	*/
	public function _404()
	{
		$this->__error('_404');
	}
	
	
	/**
	*	Sets an item inside the container
	*
	**/
	public function set($name, $value)
	{
		$this->container->set($name,$value);
	}
	
	/**
	*	Gets an item from the container
	*
	**/
	public function get($name)
	{
		return $this->container->get($name);
	}
	
	
	/**
	*
	*	wraps get()
	**/
	public function __get($name)
	{
		return $this->container->get($name);
	}
	

	
}





?>
