<?php
namespace qoo\core;
/**
*
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class Object
{
	protected $_Params;
	
	/**
	*	Returns a parameter given its name
	*
	*	@param string $param_name The name of the parameter
	*	@throws qoo\core\Exception
	*
	*
	**/
	public function getParam($param_name) {
	
		if (isset($this->_Params[$param_name]))
			return $this->_Params[$param_name];
		else {
			throw new qoo\core\Exception('There is no parameter named '.$param_name.' '.get_called_class());
		}
	}
	
	/**
	*
	*
	*
	*
	*
	**/
	public function hasParam($param_name)
	{
		return isset($this->_Params[$param_name]);
	}
	
	
	/**
	*
	*
	*
	*
	*
	**/
	public function setParam($param_name, $param_value)
	{
		$this->_Params[$param_name] = $param_value;
	}
	
	/**
	*
	*
	*
	*	@return array The array of parameters
	*
	**/
	public function getParams()
	{
		return $this->_Params;
	}
	
	
	/**
	*
	*
	*
	*
	*
	**/
	public function setParams($params)
	{
		if (!is_array($params) )
			throw new Exception("setParams: \$params must be array");
		$this->_Params = $params;
	}
	
}

?>
