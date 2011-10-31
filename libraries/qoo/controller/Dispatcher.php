<?php

namespace qoo\controller;

/**
*
*
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class DispatcherException extends \qoo\core\Exception
{}

/**
 * 
 *	Basic Dispatcher, it istantiate the requested Controller
 *	and fires the right method.
 *	@license BSD
 *	@author Mattia Alfieri <mattia.alfieri@ymail.com>
 *
 */
class Dispatcher extends \qoo\core\Object
{

	/**
	*
	*	@var $_UseDefaults bool Tells the dispatcher wether to use or not default action and controller names when the request has no controller or action parameters
	**/
	protected $_UseDefaults = false;
	
	#FIXME Potrei voler usare una action di default (index), ma non un controller id default
	//Al momento non c'è un obbligo di definire index() nell'interfaccia del controller...
	
	protected $_DefaultActionName = 'index';
	protected $_DefaultControllerName = 'DefaultController';
	
	protected $_ControllerParameters = array();
	
	
	protected $_Force = false;
	protected $_ForcedAction = null;
	protected $_ForcedController = null;
	
	
	/**
	*
	*	@var The directory in which the dispatcher will look for the controller file
	**/
	protected $_ControllerDirectory = null;
	
	
	public function __construct()
	{}
	
	
	/**
	*
	*	@param Array $parameters
	**/
	public function setControllerParameters( $parameters )
	{
		if (!is_array($parameters))
			throw new DispatcherException('Dispatcher::setControllerParameters  $parameters must be array');
		
		$this->_ControllerParameters = $parameters;
	}
	
	
	/**
	*
	*	@return Array
	**/
	public function getControllerParameters()
	{
		return $this->_ControllerParameters;
	}
	
	
	/**
	*
	*	@param $flag bool
	**/
	public function useDefaults($flag = true)
	{
		if (!is_bool($flag) )
			throw new DispatcherException('$flag must be boolean');
		$this->_UseDefaults = $flag;
		
		return $this;
	}
	
	/**
	*
	*
	**/
	public function getDefaultControllerName()
	{
		return $this->_DefaultControllerName;
	}
	
	/**
	*
	*
	**/
	public function setDefaultControllerName($controller_name)
	{
		$this->_DefaultControllerName = $controller_name;
		return $this;
	}
	
	/**
	*
	*
	**/
	public function getDefaultActionName()
	{
		return $this->_DefaultActionName;
	}
	
	/**
	*
	*
	*
	*
	*
	**/
	public function setDefaultActionName($action_name)
	{
		$this->_DefaultActionName = $action_name;
		return $this;
	}
	
	/**
	*	@param string $directory 
	*
	**/
	public function setControllerDirectory($directory)
	{
		$this->_ControllerDirectory = $directory;
		return $this;
	}
	
	/**
	*
	*
	**/
	public function getControllerDirectory()
	{
		return $this->_ControllerDirectory;
	}
	
	
	/**
	*
	*	Retrieves the name of the action to dispatch,
	*	it first looks for it inside the request object,
	*	then into default values.
	*
	*	If it can't find an action name, it chooses 
	*	a _404 action.
	*
	*	@param Request $request the request object
	*
	*	@return String
	*
	**/
	public function getActionName($request)
	{
		$action_name = $request->getActionName();
		if (null === $action_name)
		{
			if ($this->_UseDefaults)
			{
				//Se voglio posso fare in modo che index() sia una action obbligatoria, così da cercarla sempre.
				$action_name = $this->getDefaultActionName();
				$request->setActionName($action_name);
				return $action_name;
			}
			//This will be deleted because it is not dispatcher's job to choose an action
			//$request->setActionName('_404');
		}
		
		return $action_name;
	}
	
	/**
	*
	*	Retrieves the name of the controller to dispatch,
	*	it first looks for it inside the request object,
	*	then into default values.
	*
	*	If it can't find a controller name, it chooses 
	*	a _404 action in the ErrorController
	*
	*	@param Request $request the request object
	*
	*	@return String
	*
	**/
	public function getControllerName($request)
	{
			$controller_name = $request->getControllerName();
			
			
			if (null === $controller_name)
			{
				if ($this->_UseDefaults)
				{
					$controller_name = $this->getDefaultControllerName();
					$request->setControllerName($controller_name);
					return $controller_name;
				}
				//This will be deleted because it is not dispatcher's job to choose an action/controller
				//$controller_name = 'ErrorController';
				//$request->setActionName('_404');
				//$request->setControllerName('ErrorController');
			}

			return $controller_name;
	}

	/**
	*
	*	Instantiates the requested controller and invokes the requested action (method). When the
	*	controller is instantied it receives a dispatching parameters. There you can store items you
	*	want to pass directly to the controller.
	*
	*	If the controller name is not specified inside the request object then the dispatcher
	*	, by default, call the ErrorController and the _404 action.
	*
	*	You can set a default controller to be called when the router
	*	was not able to find a controller name, (the condition is that the request has no 'controller' parameter)
	*	
	*
	*	If the controller name is specified but it does not exist, then the dispatcher throws an exceptions
	*
	*	@throws DispatcherException
	*
	*	@param $request Request
	*	@param $response	Response
	*	@param $controller_params array
	*	
	*	@return Response
	**/
	public function dispatch($request, $response )
	{
		if (! $request instanceof \qoo\controller\RequestInterface)
			throw new DispatcherException('Invalid argument: $request must be a valid Request object');
		
		if (! $response instanceof \qoo\controller\ResponseInterface)
			throw new DispatcherException('Invalid argument: $response must be a valid Response object');
	
	
		

		$controller_name = $this->getControllerName($request);	
		
		$action_name = $this->getActionName($request);	
			
		
		
		//If no controller directories were specified, the system uses APP_ROOT/controller
		if (null === $this->_ControllerDirectory)
			$this->_ControllerDirectory = APP_ROOT.'controller';
		
		
		//We import the class file
		$controller_path = $this->_ControllerDirectory.DIRECTORY_SEPARATOR.$controller_name.'.php';
		if (!file_exists($controller_path) )
			throw new DispatcherException('Impossible to dispatch '.$controller_name.': file '.$controller_path.' does not exist');
		
		require_once($controller_path);
			
		
		$dependencies = array(
								'request' => $request,
								'dispatcher' => $this,
								'response' => $response);
		
		//Controller parameters can overwrite request response and dispatcher
		/**
		*	TODO potrei fare in modo che in fase di config delle dependencies, il
		*	client possa specificare di caricare certe	dep. solo
		*	per certi controller!
		*
		*	Esempio $disp->setControllerParameters($array1,"NomeController1");
		*	Esempio $disp->setControllerParameters($array2,"NomeController2");
		*
		*	Da valutare
		**/
		$dependencies = $this->getControllerParameters() + $dependencies;
		
		//Controller object creation
		$controller = new $controller_name( $dependencies );
		
		if(!$controller instanceof \qoo\controller\Controller)
			throw new DispatcherException("Controller $controller_name is not an instance of \qoo\controller\Controller ");
		
		if (!method_exists($controller, $action_name))
			throw new DispatcherException("Dispatcher Exception: The requested method ($controller_name :: $action_name) does not exists ");
		
	
		
		try
		{
			$controller->{$action_name}(); //action call
		}
		catch (\qoo\core\Exception $e)
		{
			$controller->response->clear();
			throw $e;
		}
		return $controller->response;
		
		
		
	}
	

	
}
