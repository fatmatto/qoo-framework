<?php
namespace qoo\controller;

/**
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
*	@package	qoo
**/
class RouterSimple extends qoo\core\Object implements RouterInterface
{
	//TODO Testme
	protected $_Keys;
	protected $_UseModules;
	
	public function __construct()
	{
	}
	
	/**
	*
	*
	*
	**/
	public function setUseModules($flag)
	{
		if (!is_bool($flag) )
			throw new RouterException('setUseModules accepts only bool values for $flag');
		$this->_UseModules = $flag;
	}
	
	/**
	*
	*
	*
	**/
	public function setKeyIndex($key_name, $key_index)
	{
		$this->_Keys[$key_name] = $key_index;
	}
	
	/**
	*
	*
	*
	**/
	public function getKeyIndex($key_name)
	{
		return $this->_Keys[$key_name];
	}
	
	/**
	*
	*	Apply routing rules to the current Request object.
	*	Please, note that when you call route() previous keys indexes of controller action and module will be overwritten
	*	If you want to manually set those indexes you must not call route(), or call it before setting your indexes (last edit will be permanent)
	*
	**/
	public function route()
	{
	if ($this->_UseModules === true)
		{
			$this->_Keys['module'] = 0;
			$this->_Keys['controller'] = 1;
			$this->_Keys['action'] = 2;
		}
		else
		{
			$this->_Keys['controller'] = 0;
			$this->_Keys['action'] = 1;
		}
	
	
		if (null === $this->_Request)
			throw new RouterException("You must specify a Request object before calling system routing");
		
		$request_uri = $this->_Request->getRequestUri();
		$script_name = $this->_Request->getScriptName();
		
		
		$internal_uri = str_replace($script_name,'',$request_uri);
		
		$items = explode('/',$internal_uri);
		array_shift($items);
		
		foreach ($this->_Keys as $key=>$index)
		{
			$this->_Request->setParam($key,$items[$index]);
		}
		
		
		
		
		
		
	}
	
	
}

?>