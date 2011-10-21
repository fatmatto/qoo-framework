<?php

namespace qoo\controller;

/**
*	Base request interface
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
*	@package qoo
**/
interface RequestInterface
{
	
	/**
	*
	*
	**/
	public function getParam($param_name);
	
	/**
	*
	*
	**/
	public function setParam($param_name,$param_value);
	
	/**
	*	Returns an array containing all class parameters (Not POST /GET/ENV etc)	
	*
	*	@return Array The array of parameters
	**/
	public function getParams();
	
	/**
	*	Returns the name of the requested controller
	*
	*	@return string The name of the requested controller
	**/
	public function getControllerName();
	
	/**
	*	Sets the name of the controller into the request
	*	
	*	@param $controller_name 
	**/
	public function setControllerName($controller_name);
	
	/**
	*
	*	@return The name of the requested action
	**/
	public function getActionName();
	

	/**
	*
	*	@param $action_name String
	*
	**/
	public function setActionName($action_name);
	
	
	
	
}

?>