<?php

namespace qoo\controller;

class RouterException  extends \qoo\core\Exception
{
}

/**
 * 
 *	Default Router Implementation. It uses Routes to route the request: 
 *	a route is a pair (pattern,parameters) where pattern is a piece of uri
 *	and parameters is an array of parameters (mostly controller and action).
 *	
 *	If the pattern is matched, then, the router sets the corresponding parameters
 *	into the request.
 *
 *	Example:
 *	
 *	$router->addRoute('/article/%article_id%/', array('controller' => 'ArticleController', 'action' => 'showArticle') );
 *	$route->route($request);
 *
 *	Accessing the application with http://host.com/article/23/
 *	will set into the request three parameters:
 *
 *	- controller => ArticleController
 *	- action => showArticle
 *	- article_id => 23
 *
 *
 *
 *	
*
*
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class Router extends \qoo\core\Object implements RouterInterface
{

	
	/**
	*
	*	@var The array containing user defined routes
	*
	**/
	protected $_Routes = array();
	
	/**
	*
	*	@var Array containing parameters that every route need
	*
	**/
	protected $_GlobalParameters = array();
	
	/**
	*
	*	Adds a route to the router.	
	*
	*	@param $pattern Uri pattern
	*	@param $routes	Parameters to be set by the router into the request when $pattern is matched
	**/
	public function addRoute($route_name,\qoo\controller\Route $route)
	{
		$this->_Routes[$route_name] = $route;
	}
	
	public function getRoute($route_name)
	{
		if (isset($this->_Routes[$route_name]))
			return $this->_Routes[$route_name];
		
		return null;
	}
	
	public function getRoutes()
	{
		return $this->_Routes;
	}
	
	
	public function createRoute($route_name)
	{
		$this->_Routes[$route_name] = new Route();
		return $this->_Routes[$route_name];
	}
	
	public function setGlobalParameter($param_name,$param_value)
	{
		$this->_GlobalParameters[$param_name] = $param_value;
	}
	
	public function getGlobalParameter($route_name)
	{
			if (isset($this->_GlobalParameters[$route_name]))
			return $this->_GlobalParameters[$route_name];
		
		return null;
	}
	
	public function getGlobalParameters()
	{
			
		return $this->_GlobalParameters;
	}
	
	
	/**
	*	Applies routing rules matched by the current URI by adding parameters
	*	to the Request object given as parameter. 
	*
	*	@param $request RequestInterface The request you want to route.
	*	@return $request The request object with new parameters.
	*
	**/
	public function route($request)
	{
		
		
		
		$request_uri = $request->getRequestUri();
		$script_name = $request->getScriptName();
		
		/**
		*	An internal uri is the uri used to decide which parameters are passed to the application
		**/
		$internal_uri = str_replace($script_name,'',$request_uri);
		/*	FIXME Se nell'url non c'è nomefile.php si ha che request uri è più piccolo di script name
		*	quindi da questa sostituzione ho che internal uri è un path del tipo /path/to/
		*
		*/
		
		
		if (substr($internal_uri,-1) !== "/")
			$internal_uri = $internal_uri.'/';
		
				
		
	$matched = false; //This prevent the router to apply multiple routes
	//The first route matching the pattern is applied to the request
	foreach ($this->_Routes as $route)
	{
		if ($route->match($internal_uri) && $matched === false)
		{
			$matched = true;
			foreach($route->getParams() as $name => $value)
			{
				$request->setParam($name,$value);
			}
			
			foreach($this->getGlobalParameters() as $name => $value)
			{
				$request->setParam($name,$value);
			}
			
			$request->setParam('__Routed',true);
			
		}
		
	}//end foreach
	
	/**
	*
	*	404
	**/
	if ($matched === false)
	{
		$request->setActionName('_404');
		$request->setControllerName('ErrorController');
	}
	
	return $request;
	}//end method
	
	
	
	
	
}
