<?php

namespace qoo\controller;

class FrontControllerException extends \qoo\core\Exception
{}

/**
*	Standard FrontController class.
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class FrontController extends \qoo\core\ConstructorInjectableAuto implements \qoo\controller\FrontControllerInterface
{
	protected $_Dependencies = array(	'request' => '\qoo\controller\Request',
										'router' => '\qoo\controller\Router',
										'response' => '\qoo\controller\Response',
										'dispatcher' => '\qoo\controller\Dispatcher'
										);
	
	
	/**
	*
	*	@override
	*
	**/
	protected function __preDispatch()
	{
	}
	/**
	*
	*
	*	@override
	*
	**/
	protected function __postDispatch()
	{
	}
	
	
	/**
	*
	*	Sets the array of parameters that will be attached to the action controller
	*
	*
	**/
	public function setControllerParameters( $params )
	{
		$this->dispatcher->setControllerParameters($params);
	}
	
	/**
	*
	*	( Wraps Dispatcher::getControllerParameters() )
	*	Returns the array of parameters that will be attached to the action controller
	*
	*
	**/
	public function getControllerParameters()
	{
		return $this->dispatcher->getControllerParameters();
	}
	
	
	/**
	*
	*	Executes the dispatching chain, initializing the response
	*	and calling the dispatcher 
	*
	*
	**/
	public function dispatch()
	{
		if (!isset($this->dispatcher) )
			throw new FrontControllerException('Call to FrontController::dispatch() without a Dispatcher object');
		
		
		$this->__preDispatch();
		
		
		if (isset($this->router) )
			$this->router->route($this->request);
			
		//The dispatch() call
		$this->response = $this->dispatcher->dispatch($this->request, $this->response);
		
		$this->__postDispatch();
	
		$this->response->send();
	}
	
}


?>
