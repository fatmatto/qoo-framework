<?php
namespace qoo\controller;
/**
 * 
 * Default Router interface
 * @author Mattia Alfieri
 * 
 */
interface RouterInterface
{

	/**
	*
	*	Apply routing rules to the request
	*
	*	@param $request Request 
	*	@return Request
	*
	**/
	public function route($request);
	
	/**
	*
	*	A global parameter is a parameter shared among every route
	*
	*/
	public function setGlobalParameter($param_name, $param_value);
	
	/*
	*	Creates and store a new Route
	*
	*	@param string $route_name The name of the route
	*	@return Route
	*/
	public function createRoute($route_name);
	
	/*
	*
	*	Store a route
	*
	*
	*/
	public function addRoute($route_name, \qoo\controller\Route $route);

	
	
}