<?php

namespace qoo\controller;

use \qoo\core\ParametersHolder;

/**
*
*
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class RequestExcetpion extends \qoo\core\Exception
{}

/**
*
*	Default Request implementation, it uses Uri class to represent user
*	defined URIs.

*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
*/
class Request extends \qoo\core\Object implements \qoo\controller\RequestInterface
{

	public $get = null;
	public $post = null;
	public $env = null;
	public $server = null;
	public $cookies = null;
	public $files = null;
	
	
	
	protected $_QueryString = null;
	protected $_RequestUri = null;
	protected $_PathInfo = null;
	protected $_ScriptName = null;
	
	
	
	
	/**
	*
	*
	*
	*	@param array $POST
	*	@param array $GET
	*	@param array $COOKIES
	*	@param array $SERVER
	*	@param array $ENV
	*	@param array $FILES
	*
	*	@return Request
	**/
	public function __construct($POST = array(), $GET = array(), $COOKIES = array(), $SERVER = array(), $ENV = array() , $FILES = array() )
	{
			$this->get = 		new ParametersHolder($GET);
			$this->post = 		new ParametersHolder($POST);
			$this->server = 	new ParametersHolder($SERVER);
			$this->cookies = 	new ParametersHolder($COOKIES);
			$this->files = 		new ParametersHolder($FILES);
			$this->env = 		new ParametersHolder($ENV);
			
			$this->_QueryString = $_SERVER['QUERY_STRING'];
			$this->_RequestUri = $_SERVER['REQUEST_URI'];
			$this->_ScriptName = $_SERVER['SCRIPT_NAME'];
			
			if (key_exists('PATH_INFO',$_SERVER) )
				$this->_PathInfo = $_SERVER['PATH_INFO'];
			else
				$this->_PathInfo = '';
			
			
	}
	
	/**
	*
	*	Uses the globals to inject values inside of the request object.
	*	This is basically a shortcut to new Request($_POST, $_GET, $_COOKIE, $_SERVER, $_ENV, $FILES);
	*
	*	This method works with Request Subclasses that don't alter the constructor signature.
	*
	*	@return Request
	**/
	public static function createWithGlobals()
	{
		$class_name = get_called_class();
		return new $class_name($_POST, $_GET, $_COOKIE, $_SERVER, $_ENV, $FILES);
	}
	
	/**
	*
	*	Stores specified global arrays into Request's properties
	*
	*	@param array $globals_to_use An array in which you can specify which global variables
	*	you want inside your Request object:
		$req->useGlobals( array('GET' , 'POST') );
	*	Stores into the request only $_GET and $_POST.
	*
	*	Calling useGLobals() with no arguments is equivalent to 
	*	$req->useGlobals( array('GET' , 'POST', 'COOKIES', 'FILES', 'SERVER', 'ENV') );
	**/
	public function useGlobals($globals_to_use = array('GET','POST','COOKIES','SERVER','ENV','FILES'))
	{
		foreach($globals_to_use as $global)
		{
			switch ($global)
			{
				case 'GET':
					$this->get->setParams($_GET);
				break;
				case 'POST':
					$this->post->setParams($_POST);
				break;
				case 'SERVER':
					$this->server->setParams($_SERVER);
				break;
				case 'COOKIES':
					$this->cookies->setParams($_COOKIE);
				break;
				case 'ENV':
					$this->env->setParams($_ENV);
				break;
				case 'FILES':
					$this->files->setParams($_FILES);
				break;
				default:
					throw new RequestExcetpion('Cannot handle global '.$global);
				break;
			}
		}
	}
	
	
	
	
	
	
	
	/**
	*
	*	@return string The name of the requested controller
	**/
	public function getControllerName()
	{
		//If a route has setted the controller name the the Request assumes it as controller name
		if ( $this->hasParam('controller') )
			return $this->getParam('controller');
		else
		return null;
	}
	
	/**
	*
	*	Sets the name of the controller into the request
	*	@param $controller_name 
	**/
	public function setControllerName($controller_name)
	{
		$this->setParam('controller',$controller_name);
	}

	/**
	*
	*	@return The name of the requested action
	**/
	public function getActionName()
	{
		if ( $this->hasParam('action') )
			return $this->getParam('action');
		else
		return null;
	}

	/**
	*
	*	@param $action_name String
	*
	**/
	public function setActionName($action_name)
	{
		$this->setParam('action',$action_name);
	}
	
	/**
	*
	*	@return string The $_SERVER['REQUEST_URI']
	**/
	public function getRequestUri()
	{
		return $this->_RequestUri;
	}
	
	/**
	*
	*	@param $request_uri string The new request uri
	**/
	public function setRequestUri($request_uri)
	{
		$this->_RequestUri = $request_uri;
	}
	
	/**
	*
	*	@return string The $_SERVER['QUERY_STRING']
	**/
	public function getQueryString()
	{
		return $this->_QueryString;
	}
	
	/**
	*
	*	@param $query_string string The new query string
	**/
	public function setQueryString($query_string)
	{
		$this->_QueryString = $query_string;
	}
	
	
	/**
	*
	*	@return string The $_SERVER['PATH_INFO']
	**/
	public function getPathInfo()
	{
		return $this->_PathInfo;
	}
	
	/**
	*
	*	@param $path_info The wanted PATH_INFO
	*/
	public function setPathInfo($path_info)
	{
		$this->_PathInfo = $path_info;
	}
	
	
	/**
	*
	*	@return string The $_SERVER['SCRIPT_NAME']
	**/
	public function getScriptName()
	{
		return $this->_ScriptName;
	}
	
	/**
	*
	*	@param $script_name The wanted SCRIPT_NAME
	*/
	public function setScriptName($script_name)
	{
		$this->_ScriptName = $script_name;
	}
	
	
	public function getMethod()
	{
		if ($this->server->hasParam('REQUEST_METHOD'))
			return $this->server->getParam('REQUEST_METHOD');
		
		$this->server->setParam('REQUEST_METHOD',$_SERVER['REQUEST_METHOD']);
		return	$_SERVER['REQUEST_METHOD'];
	}
	
	/**
	*
	*	Sets the HTTP Request method
	*	@param string $method The method
	*
	**/
	public function setMethod($method)
	{
		if (!is_string($method) )
			throw new RequestExcetpion('$method must be string');
		$this->server->setParam('REQUEST_METHOD',$method);
	}
	
	
	
	
	
}
