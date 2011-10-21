<?php

namespace qoo\core;

/**
*
*
*
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class ParametersHolder
{
	protected $_Params;
	
	public function __construct($array = array())
	{
		$this->setParams($array);
	}
	
	
	public function getParam($param_name) {
		return $this->_Params[$param_name];
	}
	
	
	public function setParam($param_name, $param_value)
	{
		$this->_Params[$param_name] = $param_value;
	}
	
	public function getParams()
	{
		return $this->_Params;
	}
	
	public function setParams($params)
	{
		if ($params !== null)
			$this->_Params = $params;
		else 
			$this->_Params = array();
	}
	
	
	/**
	*	Returns true if there is a not null parameter named $param_name
	*	@param string $param_name The name of the parameter
	*	@return bool
	**/
	public function hasParam($param_name)
	{
		return isset($this->_Params[$param_name] );
	}
}