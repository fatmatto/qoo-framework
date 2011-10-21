<?php

namespace qoo\controller;


/**
*	Standard Route object used by thr standard router class to define routes.
*
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
interface RouteInterface
{
	/**
	*	Assign a pattern to the route.
	*
	*	The pattern must be a valid URI like /blog/
	*	You can declare parameters inside of it, using the following syntax:
	*		/foo/%bar%/baz
	*	This means that the uri http://example.com/foo/A_string/baz/
	*	will cause the router to create into the request object a
	*	parameter named bar which value is 'A_string'.
	*
	*
	*
	*	@param string $pattern This is the pattern to attach to the route
	**/
	public function map($pattern);
	
	/*
	*
	*	This will create a param into the route. 
	*	If the URI matches the route in the routing phase
	*	that this param is setted into the request object.
	*
	*	This can be used to create default values for 
	*	uri parameters:
	*
	*	$route->map('/blog/view/%article_id%/')
	*			->setParam('article_id',
	*
	*	@param string $param_name The name of the parameter
	*	@param string $param_value The value of the parameter
	**/
	public function setParam($param_name,$param_value);
	
	
	/**
	*
	*	With this method you assign a type to a parameter
	*	If the uri presents a value for the parameter
	*	which is not the type binded to it, then the route
	*	will be considere unmatched:
	*
	*	Example:
	*		$route->map('/blog/%article_id%/')
	*				->bindParam('article_id','numeric');
	*
	*		This route will be matched by:
	*		http://yoursite.com/blog/11/
	*		http://yoursite.com/blog/0
	*		http://yoursite.com/blog/-1
	*		But NOT by:
	*		http://yoursite.com/blog/eleven/
	*		http://yoursite.com/blog/Zero/
	*		http://yoursite.com/blog/VII/
	*		http://yoursite.com/blog/
	*
	**/
	public function bindParam($param_name,$param_type);
}

?>